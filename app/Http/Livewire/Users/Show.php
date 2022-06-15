<?php

namespace App\Http\Livewire\Users;

use App\Models\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class Show extends ModalComponent
{
    use AuthorizesRequests;

    public User $user;

    protected $listeners = [
        'delete',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render()
    {
        return view('livewire.users.show');
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(): RedirectResponse|Redirector
    {
        match ($this->user->getRoleNames()->implode(',')) {
            'Admin' => $this->authorize('deleteAdmin', $this->user),
            'Super Admin' => $this->authorize('deleteSuperAdmin', $this->user),
            default  => $this->authorize('deleteUser', $this->user),
        };

        $this->user->delete();
        return redirect()->to(route('users.index'));
    }
}
