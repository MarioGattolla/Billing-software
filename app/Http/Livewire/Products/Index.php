<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function mount(): void
    {

    }

    public function render(): View
    {
        return view('livewire.products.index')->with('products', $this->paginator());
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    private function paginator(): LengthAwarePaginator
    {
        return Product::query()
            ->where('name', 'like', "%$this->search%")
            ->paginate(12);
    }


}
