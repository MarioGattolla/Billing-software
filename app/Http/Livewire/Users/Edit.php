<?php

namespace App\Http\Livewire\Users;

use App\Http\Concerns\Users\savesUsers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use savesUsers;

    use AuthorizesRequests;

    protected $listeners = [
        'userSaved' => 'return_edit'
    ];

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render(): View
    {
        return view('livewire.users.edit');
    }

    public function return_edit()
    {
        $this->closeModalWithEvents([
            Show::getName() => ['user_modified', [$this->user->id]],
        ]);
    }

    public function check_authorize()
    {

    }

}
