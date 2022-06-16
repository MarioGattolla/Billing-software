<?php

namespace App\Http\Concerns\Users;

use App\Http\Livewire\Users\Create;
use App\Http\Livewire\Users\Edit;
use App\Models\User;
use Livewire\Event;

/**
 * @mixin Edit
 * @mixin Create
 */
trait savesUsers
{
    public User $user;

    public string $password;

    public string $role;

    public array $rules = [
        'user.name' => 'required|string',
        'user.email' => 'required|email',
        'password' => 'required|string',
        'role' => 'required|string',

    ];

    protected array $messages = [
        'user.name.required' => 'The name field is required',
        'user.name.string' => 'The name field must be a string',
        'user.email.required' => 'The email field is required',
        'user.email.email' => 'The email field must be an email',
        'password.required' => 'The password field is required',
        'password.string' => 'The password field must be a string',
    ];

    public function mount(User $user)
    {
        $this->user = $user->exists
            ? $user
            : new User();
        $this->role = $user->getRoleNames()->implode(',') ?: 'Operator';
        $this->password = $user->password ?: '';
    }

    public function save(): Event
    {
        $this->user->id == null
            ? match ($this->role) {
            'Admin' => $this->authorize('createAdmin', $this->user),
            'Super Admin' => $this->authorize('createSuperAdmin', $this->user),
            default => $this->authorize('createUser', $this->user)
        }
            : match ($this->role) {
            'Admin' => $this->authorize('editAdmin', $this->user),
            'Super Admin' => $this->authorize('editSuperAdmin', $this->user),
            default => $this->authorize('editUser', $this->user),
        };

        $this->validate();

        $this->user->password = $this->password;

        $this->user->roles->isEmpty()
            ?: $this->user->removeRole($this->user->getRoleNames()->implode(','));

        $this->user->assignRole($this->role);

        $this->user->save();

        return $this->emit('userSaved');
    }
}
