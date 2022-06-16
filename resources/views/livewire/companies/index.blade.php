<?php
/** @var Company $company */

use App\Models\Company;

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
                    <input type="radio" wire:model="type_filter" value="{{$type}}"/>
                    <div class="ml-1">{{$type}}</div>
                </label>
            @endforeach
        </div>

        <div class="m-3">
            <div>Search By Name</div>
            <label>
                <input class="m-3" type="search" wire:model="search_company"/>
            </label>
        </div>


        <div class="m-3">
            <div>Search By Email</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_email"/>
            </label>
        </div>


        <div class="m-3">
            <div>Search By Address</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_address"/>
            </label>
        </div>

        <div class="m-3">
            <div>Search By Country</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_country"/>
            </label>
        </div>

        <div class="m-3">
            <div>Search By Phone</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_phone"/>
            </label>
        </div>

        <div class="m-3">
            <div>Search By Vat</div>
            <label>
                <input class="m-3" type="search" wire:model="search_by_vat_number"/>
            </label>
        </div>

    </div>


    <div class="col-span-2 m-3">
        <div class=" grid grid-cols-3">
            @foreach($companies as $company)
                <button class="bg-green-200 rounded hover:bg-green-400 cursor-pointer p-3 m-3"
                        wire:click="$emit('openModal', 'companies.show', {{ json_encode([$company->id]) }})">
                    <div> {{$company->name}}</div>
                    <div> {{$company->email}}</div>
                    <div>{{$company->type}}</div>
                </button>
            @endforeach
        </div>
        <div>{{$companies->links()}}</div>
    </div>

</div>
