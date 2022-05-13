<?php ?>

<p class="mt-2">Select the Products</p>
<div class="row">
    <div class="mt-4">
        <table
            class="table-fixed w-full  bg-white table-bordered rounded-md
                align-items-center table-sm border-gray-400 border">
            <thead class="bg-green-200 h-10 ">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th class="w-1/12">Price</th>
                <th class="w-1/12">Vat</th>
                <th class="w-1/12">Quantity</th>
                <th class="w-1/12">Total</th>
                <th class="w-10"></th>
            </tr>
            </thead>
            <tbody>
            <template x-for="(field, index) in fields" :key="index">

                <tr class=" ">


                    <td class="" hidden><label>
                            <input x-model="field.id" type="number" name="id[]"
                                    min="1" hidden/>
                        </label></td>

                    <td class=""><label>
                            <input x-model="field.name" type="text" name="name[]"
                                   class="w-full border-gray-400" min="1"/>
                        </label></td>
                    <td class=""><label>
                            <input x-model="field.description" type="text"
                                   name="description[]"
                                   class="w-full border-gray-400"/>
                        </label></td>
                    <td class=""><label>
                            <input x-model="field.price" type="number" name="price[]"
                                   class="w-full border-gray-400" step="0.01"/>
                        </label></td>
                    <td class=""><label>
                            <input x-model="field.vat" type="number" name="vat[]"
                                   class="w-full border-gray-400" min="1"/>
                        </label></td>
                    <td><label>
                            <input x-model="field.quantity" type="number"
                                   name="quantity[]" min="1"
                                   x-on:input="set_total(index)"
                                   class="w-full border-gray-400"/>
                        </label></td>
                    <td><label>
                            <input x-model="field.total" type="number" name="total[]"
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
                    rounded-md hover:bg-green-400  m-2" x-on:click="modal = true">
                        Add Row
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
