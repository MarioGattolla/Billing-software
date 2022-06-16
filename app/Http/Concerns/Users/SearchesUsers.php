<?php

namespace App\Http\Concerns\Users;

use App\Http\Livewire\Users\Index;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * @mixin Index
 */
trait SearchesUsers
{
    public string $search_user = '';

    public User $user;

    public function allow_new_user(): bool
    {
        return false;
    }

    public function search_users(): Collection
    {
        if ($this->search_user == '') {
            return Collection::empty();
        } else {
            return User::query()
                ->where('name', 'like', "%$this->search_user%")
                ->get();
        }
    }


    public function select_user(User $selected): void
    {
        $this->user = $selected;
        $this->search_user = '';
    }

    public function use_new_user(): void
    {
        $this->user = new User();
        $this->search_user = '';
    }
}
