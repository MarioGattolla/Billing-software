@props(['raws', 'movements'])
<?php
use Illuminate\Database\Eloquent\Collection;
/** @var array $movements */
/** @var  array $movement */
?>

<p class="mt-2">Select the Products</p>
<div class="row">
    <div class="mt-4">
        <table
            class="table-fixed w-full  bg-white table-bordered rounded-md
                align-items-center table-sm border-gray-400 border">
            <thead class="bg-green-200 h-10 ">
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Vat</th>
                <th>Quantity</th>
                <th>Total</th>
                <th class="w-1/12 "></th>
            </tr>
            </thead>
            <tbody>
            @if($movements != null)
                @foreach($movements as $movement )
                    <tr>
                        <?php $index = array_search($movement, $movements) ?>
                        <td class="">
                            <div type="text" class="w-full border-gray-400">{{$movement['name']}}</div>
                        </td>

                        <td class="">
                            <div type="text" class="w-full border-gray-400">{{$movement['price']}}</div>
                        </td>

                        <td class="">
                            <div type="number" class="w-full border-gray-400">{{$movement['vat']}}</div>
                        </td>

                        <td>
                            <label>
                                <input wire:model="movements.{{$index}}.quantity"
                                       type="number" min="1"
                                       wire:change="set_total({{$index}})"
                                       class="w-full border-gray-400"/>
                            </label>
                        </td>
                        <td class="">
                            <label>
                                <input wire:model="movements.{{$index}}.total"
                                       type="number"
                                       class=" w-full border-gray-400" step="0.01"/>
                            </label>
                        </td>
                        <td class="text-center">
                            <div class="w-full cursor-pointer"
                                 wire:click="remove_row({{$index}})">
                                &times;
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-left h-10">
                    <button type="button" class=" bg-green-200 p-1 border hover:cursor-pointer  border-green-300
                    rounded-md hover:bg-green-400  m-2" wire:click="open_modal">
                        Add Row
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
