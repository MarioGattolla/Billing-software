<?php

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

/** @var Collection<int,Company> $filtered_companies */
/** @var Company $filtered_company */
?>

<div class="bg-gray-100 p-10 max-w border rounded-md">

    <div class="m-3">
        <p>Type</p>
        <select wire:model="order.type" name="order[type]" id="order_type">
            @foreach(\App\Enums\OrderType::cases() as $type)
                <label for="order_type">
                    <option value="{{$type->value}}"> {{ucfirst($type->value)}}</option>
                </label>
            @endforeach
        </select>
    </div>

    <div>
        <x-orders.create.company-search :companies="$filtered_companies"/>

    </div>
    @if($company != null )
        <x-companies.company-main-data/>
        <x-orders.create.order-product-table :rows="$order_products"/>
    @endif

    <div class="m-3">
        <label>
            <input type="date" wire:model="date">
        </label>
    </div>

    <x-elements.button type="submit" class="m-3"
                       wire:click="save">
        Submit
    </x-elements.button>
</div>
