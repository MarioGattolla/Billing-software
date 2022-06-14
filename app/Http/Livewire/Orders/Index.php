<?php

namespace App\Http\Livewire\Orders;

use App\Enums\CompanyType;
use App\Enums\OrderType;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search_by_product = '';

    public string $search_by_company = '';

    public Collection $filter_options;

    public array $type_filter = array();

    public string $date_filter = '';

    public function mount()
    {

        $this->filter_options = Collection::empty();
        $this->filter_options->push([
            'types' => OrderType::get_cases_values(),
        ]);
    }

    public function render(): View
    {
        return view('livewire.orders.index')->with([
            'orders' => $this->filter_orders(),
        ]);
    }

    public function filter_orders(): LengthAwarePaginator
    {
        return Order::whereRelation('company', 'name', 'like', "%$this->search_by_company%")
            ->where(function (Builder $query) {
                if ($this->date_filter == '') {
                    return;
                }
                $query->where('date', 'like', "%$this->date_filter%");
            })
            ->where(function (Builder $query) {
                if (empty($this->type_filter)) {
                    return;
                }
                $query->whereIn('type', $this->type_filter);
            })
            ->where(function (Builder $query) {
                $query->whereRelation('products', 'name', 'like', "%$this->search_by_product%");
            })->paginate();

    }

    public function clear()
    {
        $this->type_filter = array();
        $this->search_by_product = '';
        $this->search_by_company = '';
        $this->date_filter = '';
    }

}
