<?php

namespace App\Http\Livewire\Orders;

use App\Http\Resources\ProductResource;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class CreateOrder extends ModalComponent
{
    public string $type = 'incoming';
    public string $search_company = '';
    public string $search_product = '';
    public Company $company;
    public array $movements;
    public int $raws = 0;
    public bool $modal = false;

    public array $rules = [
        'company.name' => 'required',
        'company.country' => 'required',
        'company.address' => 'required',
        'company.vat_number' => 'nullable',
        'company.phone' => 'required',
        'company.email' => 'required',

        'movements.*.id' => 'required',
        'movements.*.name' => 'required|string',
        'movements.*.price' => 'required|integer',
        'movements.*.vat' => 'required|integer',
        'movements.*.quantity' => 'required|integer',
        'movements.*.total' => 'required|float'

    ];

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render(): View
    {

        return view('livewire.orders.create-order-form')->with([
            'filtered_companies' => $this->search_companies(),
            'filtered_products' => $this->search_products(),
        ]);
    }

    public function search_companies(): Collection
    {
        if ($this->search_company == '') {
            return Collection::empty();
        } else {
            return Company::query()
                ->where('name', 'like', "%$this->search_company%")
                ->get();
        }
    }

    public function search_products($button = null): Collection|\Illuminate\Support\Collection
    {
        if ($this->search_product == '') {
            return Collection::empty();
        } else {
            if ($button == null) {
                if ($this->type == 'incoming') {
                    return $this->search_products_by_company();
                } else {
                    return $this->search_products_with_available_stock();
                }
            } else {
                return $this->search_products_with_available_stock();
            }
        }
    }


    public function select_company(Company $selected)
    {
        $this->company = $selected;
        $this->search_company = '';
    }

    public function select_product(Product $selected)
    {
        $this->movements[$this->raws] = $selected;
        $this->search_product = '';
        $this->modal = false;
        $this->raws++;

    }


    public function remove_row($index)
    {
        unset($this->movements[$index]);
    }

    public function open_modal()
    {
        $this->modal = true;
    }

    public function close_modal()
    {
        $this->modal = false;
    }

    public function search_products_with_available_stock(): Collection|\Illuminate\Support\Collection
    {

        $available_product_ids = Product::query()
            ->leftJoin('order_product', fn(JoinClause $join) => $join->on('products.id', '=', 'order_product.product_id'))
            ->where('name', 'like', "%$this->search_product%")
            ->groupBy('products.id')
            ->havingRaw('SUM(order_product.quantity) > 0')
            ->pluck('products.id');

        if ($available_product_ids->isEmpty()) {
            return Collection::empty();
        }

        return Product::whereIn('id', $available_product_ids)->get();

    }

    public function search_products_by_company(): Collection|\Illuminate\Support\Collection
    {
        $orders_id = Order::where('company_id', '=', $this->company->id)
            ->get()->map(fn(Order $order) => $order->id);
        if ($orders_id->count() == 0) {
            return Collection::empty();
        } else {
            $products_id = OrderProduct::where('order_id', '=', $orders_id)
                ->get()->map(fn(OrderProduct $movement) => $movement->product_id);

            /** @var Product[] $products */
            $products = Product::where('name', 'like', "%$this->search_company%")
                ->findMany($products_id)->all();

            return collect($products);
        }
    }

    public function set_total($table_index): void
    {
        $no_vat_total = ($this->movements[$table_index]['price'] * 100) * $this->movements[$table_index]['quantity'];
        $vat_total = round(($no_vat_total * $this->movements[$table_index]['vat']) / 100);
        $this->movements[$table_index]['total'] = round((($no_vat_total + $vat_total) / 100), 2);
    }
}

