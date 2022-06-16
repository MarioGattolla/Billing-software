<?php

namespace App\Http\Livewire\Users;

use App\Enums\Role;
use App\Http\Concerns\Users\SearchesUsers;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use SearchesUsers;

    use WithPagination;

    public Collection $filter_options;

    public string $role_filter = '';

    public string $search_by_email = '';

    public function mount()
    {
        $this->filter_options = Collection::empty();
        $this->filter_options->push([
            'roles' => Role::get_roles_cases_values(),
        ]);
    }

    public function render(): View
    {
        return view('livewire.users.index')->with(['users' => $this->filter_users()]);
    }

    public function filter_users(): LengthAwarePaginator
    {
        return User::role($this->role_filter ?: Role::get_roles_cases_values())
            ->where('name', 'like', "%$this->search_user%")
            ->where(function (Builder $query) {
                $query->where('email', 'like', "%$this->search_by_email%");
            })
            ->paginate();
    }

    public function clear()
    {
        $this->role_filter = '';

        $this->search_user = '';

        $this->search_by_email = '';
    }
}
