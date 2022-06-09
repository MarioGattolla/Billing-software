<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Orders\CreateOrder;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use LivewireUI\Modal\ModalComponent;

class ProductsSearchModal extends ModalComponent
{
    public string $search_product = '';

    protected $listeners = ['selected' => 'select_product'];

    public function render(): View
    {
        return view('livewire.products-search-modal', [
            'filtered_products' => $this->search_products(),
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function search_products(): Collection|\Illuminate\Support\Collection
    {
        if ($this->search_product == '') {
            return Collection::empty();
        } else {
            return $this->search_products_with_available_stock();
        }
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

    public function select_product($selected)
    {
        $this->search_product = '';
        $this->closeModalWithEvents([CreateOrder::getName() => ['order.product.selected', [$selected]]]);

    }

}
