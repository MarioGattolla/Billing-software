<?php

namespace App\Http\Livewire\Orders;

use App\Http\Resources\ProductResource;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class CreateOrder extends ModalComponent
{
    public string $type = '';
    public string $search_company = '';
    public string $search_product = '';
    public Company $company;
    public int $raws = 2;
    public bool $modal = false;

    public array $rules = [
        'company.name' => 'required',
        'company.country' => 'required',
        'company.address' => 'required',
        'company.vat_number' => 'nullable',
        'company.phone' => 'required',
        'company.email' => 'required',
    ];

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function updated()
    {
    }

    public function render(): View
    {
        return view('livewire.orders.create-order-form')->with([
            'filtered_companies' => $this->search_companies(),
            'filtered_products' => $this->search_products(),
            'company',
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

    public function search_products()
    {
        if ($this->search_product == '') {
            return Collection::empty();
        } else {
            if ($this->type === 'incoming') {

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

    public function increase_row(): int
    {
        return $this->raws++;
    }

    public function descrease_row(): int
    {
        return $this->raws--;
    }

    public function open_modal(): bool
    {
        return $this->modal = true;
    }

    public function close_modal(): bool
    {
        return $this->modal = false;
    }

    private function search_products_with_available_stock(): Collection|\Illuminate\Support\Collection
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
}
