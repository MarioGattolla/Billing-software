<?php

namespace App\Http\Livewire\Companies;

use App\Enums\CompanyType;
use App\Enums\Role;
use App\Http\Concerns\Companies\SearchesCompanies;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use SearchesCompanies;

    use WithPagination;

    public Collection $filter_options;

    public string $type_filter = '';
    public string $search_by_email = '';
    public string $search_by_phone = '';
    public string $search_by_country = '';
    public string $search_by_vat_number = '';
    public string $search_by_address = '';

    public function render(): View
    {
        return view('livewire.companies.index')->with(['companies' => $this->filter_companies()]);
    }

    public function mount()
    {
        $this->filter_options = Collection::empty();
        $this->filter_options->push([
            'types' => CompanyType::get_cases_values(),
        ]);
    }

    public function filter_companies(): LengthAwarePaginator
    {
        return Company::where('type', 'like', "%$this->type_filter%")
            ->where(function (Builder $query) {
                $query->where('name', 'like', "%$this->search_company%");
            })
            ->where(function (Builder $query) {
                $query->where('email', 'like', "%$this->search_by_email%");
            })
            ->where(function (Builder $query) {
                $query->where('phone', 'like', "%$this->search_by_phone%");
            })
            ->where(function (Builder $query) {
                $query->where('address', 'like', "%$this->search_by_address%");
            })
            ->where(function (Builder $query) {
                $query->where('country', 'like', "%$this->search_by_country%");
            })
            ->where(function (Builder $query) {
                $query->whereNotNull('vat_number')
                    ->where(function (Builder $query) {
                        $query->where('vat_number', 'like', "%$this->search_by_vat_number%");
                    });

            })
            ->paginate();
    }

    public function clear()
    {
        $this->type_filter = '';
        $this->search_company = '';
        $this->search_by_email = '';
        $this->search_by_phone = '';
        $this->search_by_country = '';
        $this->search_by_vat_number = '';
        $this->search_by_address = '';
    }
}
