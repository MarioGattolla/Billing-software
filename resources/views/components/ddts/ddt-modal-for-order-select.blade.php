<?php ?>

<div class="  bg-white rounded-md border m-auto w-1/3 text-center
                            rounded-md border-2 p-3  ">
    <div class="m-3">
        <div>
            Select the Order
        </div>
    </div>

    <div class=" rounded-md  flex-col  p-2 ">
        <label for="selectOrder"></label>
        <select class="w-full flex-col"
                autocomplete="off"
                id="selectOrder"
                x-on:change="set_movements($event.target.value)"

        >
            <option selected>Select The Order</option>
            <template x-for="(order, index) in filteredOrders">
                <option class=" hover:cursor-pointer  p-2   rounded-md hover:bg-indigo-100"
                        x-text="'ddt n : ' + order.id + '-  date : ' + order.date"
                        x-bind:value="order"
                        :class="{'bg-indigo-100': index===selectedOrderIndex}">
                </option>


            </template>
        </select>


    </div>

    <div class="col-span-1 items-center ">
        <div class="p-3  border center hover:cursor-pointer  rounded-md border-green-400 hover:bg-green-400
               bg-green-200 text-sm" x-on:click="modal = false">
            Return Back
        </div>
    </div>
</div>
