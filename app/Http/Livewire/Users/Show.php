<?php

namespace App\Http\Livewire\Users;

use App\Http\Concerns\Users\deletesUsers;
use App\Models\User;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class Show extends ModalComponent
{
    use deletesUsers;

    public User $user;

    protected $listeners = [
        'delete',
        'user_modified',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function render(): View
    {
        $this->authorize('view', $this->user);

        return view('livewire.users.show');
    }

    public function user_modified(User $user)
    {
        $this->user = $user;
    }


}
