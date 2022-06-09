<?php

namespace App\Http\Concerns;


use App\Http\Livewire\Orders\CreateOrder;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

/**
 * @mixin CreateOrder
 */
trait SearchesCompanies
{
    public string $search_company = '';

    public Company $company;

    public function allow_new_company(): bool
    {
        return false;
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


    public function select_company(Company $selected)
    {
        $this->company = $selected;
        $this->search_company = '';
    }

    public function use_new_company(): void
    {
        $this->company = new Company();
        $this->search_company = '';
    }
}
