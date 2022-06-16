<div class="m-3 text-center">
    <div>
        You are trying to cancel the current {{$type}}.

    </div>
    <div>
        By clicking "DELETE" , {{$type}} will be permanently deleted. Are you sure?

    </div>
</div>
<div class="text-center">
    <x-elements.button type="submit" wire:click="$emit('delete')"> Delete {{$type}}</x-elements.button>

    <x-elements.button wire:click="$emit('closeModal')"> Return Back</x-elements.button>
</div>

