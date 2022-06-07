<?php

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

/** @var Collection<int,Company> $filtered_companies */
/** @var Company $filtered_company */
?>

<div class="bg-gray-100 p-10 max-w border rounded-md">

    <div class="m-3">
        <p>Type</p>
        <select wire:model="type" name="type" id="radio">
            @foreach(\App\Enums\OrderType::cases() as $type)
                <label for="radio">
                    <option value="{{$type->value}}"> {{ucfirst($type->value)}}</option>
                </label>
            @endforeach
        </select>
    </div>

    <div class="m-3">
        <p>Search Company</p>
        <label>
            <input wire:model="search_company" type="search" placeholder="search for company"/>
        </label>

        <div class="overflow-y-auto bg-white w-1/3 h-1/2 ">
            @foreach($filtered_companies as $filtered_company)
                <option wire:click="select_company({{$filtered_company->id}})"
                        class="hover:bg-gray-100 p-1 cursor-pointer">
                    {{$filtered_company->name}}
                </option>
            @endforeach
        </div>
    </div>

    <x-companies.company-main-data/>

    <x-orders.create.order-product-table :raws="$raws"/>

    @if($modal === true)
        <x-orders.create.product-search-with-modal :products="$filtered_products"/>
    @endif

    <x-elements.button type="submit" class="w-20 bg-green-200 mt-3 h-10 rounded-md
                                  border border-green-400 hover:bg-green-400 ">
        Submit
    </x-elements.button>
</div>
