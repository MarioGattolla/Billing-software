<?php

use App\Models\User;

/** @var User $user */
$user = Auth::user();

?>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl ">
                    Here you can add a new Product
                </div>
                <div class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" action="{{route('products.store')}}" name="products_create_form">
                        @csrf

                        <div class="pt-2">
                            <p>Product Name</p>
                            <label for="name">
                                <input class="rounded-md " name="name" type="text" id="name" required/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Product Description</p>
                                <label for="description">
                                <input class="rounded-md" type="text" id="description" name="description" required/>
                            </label>
                        </div>


                        <div class="pt-2">
                            <p>Product Minimum Stock</p>
                            <label for="min_stock">
                                <input class="rounded-md " type="number" id="min_stock" name="min_stock" required/>
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
