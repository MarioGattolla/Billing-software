<?php

namespace App\Http\Livewire\Users;

use App\Http\Concerns\Users\savesUsers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use savesUsers;

    use AuthorizesRequests;

    protected $listeners = [
        'userSaved' => 'return_create'
    ];

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render(): View
    {
        return view('livewire.users.create');
    }

    public function return_create(): RedirectResponse|Redirector
    {
        return redirect()->to(route('users.index'))->with('success', 'User Saved !!');
    }

}
