<?php

namespace App\Http\Concerns\Users;

use App\Http\Livewire\Users\Show;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;

/**
 * @mixin Show
 */
trait deletesUsers
{
    use AuthorizesRequests;

    public function delete(): RedirectResponse|Redirector
    {
        match ($this->user->getRoleNames()->implode(',')) {
            'Admin' => $this->authorize('deleteAdmin', $this->user),
            'Super Admin' => $this->authorize('deleteSuperAdmin', $this->user),
            default => $this->authorize('deleteUser', $this->user),
        };

        $this->user->delete();
        return redirect()->to(route('users.index'))->with('success', 'User deleted !!');
    }
}
