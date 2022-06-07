@props(['products'])
<?php ?>
<div class="fixed top-0 right-0 left-0 w-full h-full bg-gray-100 bg-opacity-75 flex items-center">
    <div class="  bg-white rounded-md border m-auto w-1/3 text-center
                               rounded-md border-2 p-3  ">
        <div class="m-3">
            <div>
                Search for the product
            </div>
        </div>

        <div class=" rounded-md  flex-col  p-2 ">
            <input class="w-full flex-col"
                   autocomplete="off"
                   type="search"
                   id="searchProduct"
                   placeholder="Search for Product"
                   wire:model="search_product"
            />


            <div class="overflow-y-auto bg-white  h-1/2">
                @foreach($products as $product)
                    <div wire:click=""
                         class="hover:bg-gray-100 p-1 cursor-pointer">
                        {{$product->name}}
                    </div>
                @endforeach
            </div>

            <div class=" p-2 rounded-md hover:bg-indigo-100 hover:cursor-pointer ">
                Check on all product
            </div>

        </div>

        <div class="col-span-1 items-center ">
            <div class="p-3  border center hover:cursor-pointer  rounded-md border-green-400 hover:bg-green-400
               bg-green-200 text-sm" wire:click="close_modal">
                Return Back
            </div>
        </div>
    </div>
</div>
