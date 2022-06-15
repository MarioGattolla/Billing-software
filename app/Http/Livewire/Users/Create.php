<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use AuthorizesRequests;

    protected $listeners = [
        'create'
    ];

    public User $user;

    public string $password = '';

    public string $role = 'Operator';

    public array $rules = [
        'user.name' => 'required|string',
        'user.email' => 'required|email',
        'password' => 'required|string',
        'role' => 'required|string',

    ];

    protected $messages = [
        'user.name.required' => 'The name field is required',
        'user.name.string' => 'The name field must be a string',
        'user.email.required' => 'The email field is required',
        'user.email.email' => 'The email field must be an email',
        'password.required' => 'The password field is required',
        'password.string' => 'The password field must be a string',
    ];

    public function mount()
    {
        $this->user = new User();
    }

    public function render()
    {
        return view('livewire.users.create');
    }

    /**
     * @throws AuthorizationException
     */
    public function save(): RedirectResponse|Redirector
    {

        match ($this->role) {
            'Admin' => $this->authorize('createAdmin', User::class),
            'Super Admin' => $this->authorize('createSuperAdmin', User::class),
            default => $this->authorize('createUser', User::class),
        };

        $this->validate();

        $this->user->password = $this->password;
        $this->user->save();

        return redirect()->to(route('users.index'))->with('success', 'User created !!');
    }
}
