<?php ?>
<div>
    <div>
        <div class="m-3">
            <div>
                Search for the product
            </div>
        </div>

        <div class=" rounded-md  flex-col  p-2 ">
            <label for="searchProduct"></label>
            <input class="w-full flex-col"
                   autocomplete="off"
                   type="search"
                   id="searchProduct"
                   placeholder="Search for Product"
                   wire:model="search_product"
            />


            <div class="overflow-y-auto bg-white  h-1/2">
                @foreach($filtered_products as $product)
                    <div wire:click="$emit('selected', {{$product->id}})"
                         class="text-center hover:bg-gray-100 p-1 cursor-pointer">
                        {{$product->name}}
                    </div>
                @endforeach
            </div>


        </div>

        <div class="col-span-1  ">
            <div class="p-3 text-center border center hover:cursor-pointer  rounded-md border-green-400 hover:bg-green-400
               bg-green-200 text-sm" wire:click="$emit('closeModal')">
                Return Back
            </div>
        </div>
    </div>
</div>
