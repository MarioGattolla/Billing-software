<?php ?>

<p class="mt-2">Add DDT Raws</p>
<div class="row">
    <div class="mt-4">
        <table
            class="table-fixed w-full  bg-white table-bordered rounded-md
                align-items-center table-sm border-gray-400 border">
            <thead class="bg-green-200 h-10 ">
            <tr>
                <th>Order N</th>
                <th>Description</th>
                <th class="w-2/12">Date</th>
                <th class="w-2/12">Quantity</th>
                <th class="w-10"></th>
            </tr>
            </thead>
            <tbody>
            <template x-for="(movement, index) in movements" :key="index">

                <tr>
                    <td class="" hidden><label>
                            <input x-model="movement.id" type="number" x-bind:name="'movements'+'['+index+']'+'[id]'"
                                   min="1" hidden/>
                        </label></td>

                    <td class=""><label>
                            <input x-model="movement.description" type="text"
                                   x-bind:name="'movements'+'['+index+']'+'[description]'"
                                   class="w-full border-gray-400" min="1"/>
                        </label></td>
                    <td class=""><label>
                            <input x-model="product.date" type="date"
                                   x-bind:name="'movements'+'['+index+']'+'[date]'"
                                   class="w-full border-gray-400"/>
                        </label></td>
                    <td class=""><label>
                            <input x-model="movement.quantity" type="number"
                                   x-bind:name="'movements'+'['+index+']'+'[quantity]'"
                                   class="w-full border-gray-400" step="0.01"/>
                        </label></td>

                    <td class="text-center">
                        <button type="button" class="w-full"
                                @click="removeField(index)">
                            &times;
                        </button>
                    </td>
                </tr>
            </template>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-left h-10">
                    <button type="button" class=" bg-green-200 p-1 border hover:cursor-pointer  border-green-300
                    rounded-md hover:bg-green-400  m-2" x-on:click="set_order()">
                        Add Row
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
