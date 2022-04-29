<?php

/** @var Product $product */

use App\Models\Product;

?>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl ">
                    Edit Product : {{$product->name }}
                </div>
                <div class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" action="/products/{{$product->id}}" name="products_update_form">
                        @csrf
                        @method('PUT')

                        <div class="pt-2">
                            <p>Product Name</p>
                            <label for="name">
                                <input class="rounded-md " value="{{$product->name}}"  name="name" type="text" id="name"/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Product Description</p>
                            <label for="description">
                                <input class="rounded-md" value="{{$product-> description}}" type="text" id="description"
                                       name="description"/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Product Minimum Stock</p>
                            <label for="min_stock">
                                <input class="rounded-md " value="{{$product->min_stock}}" type="number" id="min_stock" name="min_stock" required/>
                            </label>
                        </div>

                        <button
                            class="w-1/5 bg-green-200 mt-3 h-10 rounded-md border border-green-400 hover:bg-green-400 type="
                            type="submit">
                            Submit
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
