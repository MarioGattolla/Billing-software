<?php
/** @var Collection $filter_options */

/** @var Collection $filters */

/** @var Order $order */

use App\Models\Order;
use Illuminate\Support\Collection;

?>
<div class="m-3 grid grid-cols-3 bg-gray-100">

    <div class="col-span-1 m-3">

        <div class="m-3">
            <div class="flex">
                <div class="m-3">Type</div>
                <x-elements.button wire:click="clear">Clear</x-elements.button>
            </div>

            @foreach($filter_options->value('types') as $type)
                <label class="flex m-3 ">
                    <input type="checkbox" wire:model="type_filter" value="{{$type}}"/>
                    <div class="ml-1">{{$type}}</div>
                </label>
            @endforeach
        </div>

        <div class="m-3">
            <div>Search By Company</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_company"/>
            </label>
        </div>


        <div class="m-3">
            <div>Search By Product</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_product"/>
            </label>
        </div>


        <div class="m-3">
            <div>Search By Date</div>
            <label>
                <input class="m-3" type="date" wire:model="date_filter"/>
            </label>
        </div>
    </div>

    <div class="col-span-2 m-3">
        <div class=" grid grid-cols-3">
            @foreach($orders as $order)
                <a class="bg-green-200 rounded hover:bg-green-400 cursor-pointer p-3 m-3"
                     href="{{route('orders.show', $order)}}">
                    <div>Progressive : {{$order->id}}</div>
                    <div>Date : {{$order->date->format('d-m-Y')}}</div>

                </a>
            @endforeach
        </div>
        <div>{{$orders->links()}}</div>
    </div>

</div>
