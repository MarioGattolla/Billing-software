<?php
/** @var Collection $filter_options */

/** @var Collection $filters */

/** @var User $user */

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;

?>
<div class="m-3 grid grid-cols-3 bg-gray-100">

    <div class="col-span-1 m-3">

        <div class="m-3">
            <div class="flex">
                <div class="m-3">Role</div>
                <x-elements.button wire:click="clear">Clear</x-elements.button>
            </div>

            @foreach($filter_options->value('roles') as $role)
                <label class="flex m-3 ">
                    <input type="radio" wire:model="role_filter" value="{{$role}}"/>
                    <div class="ml-1">{{$role}}</div>
                </label>
            @endforeach
        </div>

        <div class="m-3">
            <div>Search By Name</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_name"/>
            </label>
        </div>


        <div class="m-3">
            <div>Search By Email</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_email"/>
            </label>
        </div>

    </div>

    <div class="col-span-2 m-3">
        <div class=" grid grid-cols-3">
            @foreach($users as $user)
                <div class="bg-green-200 rounded hover:bg-green-400 cursor-pointer p-3 m-3"
                     href="{{route('users.show', $user)}}">
                    <div> {{$user->name}}</div>
                    <div> {{$user->email}}</div>
                    <div>{{$user->getRoleNames()->implode(',')}}</div>
                </div>
            @endforeach
        </div>
        <div>{{$users->links()}}</div>
    </div>

</div>
