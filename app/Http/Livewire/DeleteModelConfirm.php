<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Users\Show;
use LivewireUI\Modal\ModalComponent;

class DeleteModelConfirm extends ModalComponent
{
    public string $type = '';

    public function mount($type)
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.delete-model-confirm');
    }

    public function delete()
    {
        $this->closeModalWithEvents([
            Show::getName() => 'delete',
        ]);
    }


}
