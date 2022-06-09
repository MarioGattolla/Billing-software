@props(['rows'])
<?php
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Collection;
/** @var Collection<int, OrderProduct> $rows */
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

                @foreach($rows as $index => $row )
                    <?php /** @var OrderProduct $row */ ?>
                    <tr>
                        <td class="">
                            <div type="text" class="w-full border-gray-400">{{$row->product->name}}</div>
                        </td>

                        <td class="">
                            <div type="text" class="w-full border-gray-400">{{$row->price}}</div>
                        </td>

                        <td class="">
                            <div type="number" class="w-full border-gray-400">{{$row->vat}}</div>
                        </td>

                        <td>
                            <label>
                                <input wire:model="order_products.{{$index}}.quantity"
                                       type="number" min="1"
                                       class="w-full border-gray-400"/>
                            </label>
                        </td>
                        <td class="">
                            <label>
                                <?php
                                $no_vat_total = ($row->price * 100) * $row->quantity;
                                $vat_total = round($no_vat_total * $row->vat / 100);
                                $total = round((($no_vat_total + $vat_total) / 100), 2);
                                ?>
                                <div type="number" class="w-full border-gray-400">{{$total}}</div>
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

            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-left h-10">
                    <button type="button" class=" bg-green-200 p-1 border hover:cursor-pointer  border-green-300
                    rounded-md hover:bg-green-400  m-2"
                            wire:click='$emit("openModal", "products-search-modal")'>
                        Add Row
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
