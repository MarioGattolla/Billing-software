<?php

use App\Models\Company;
use App\Models\Product;
use App\Models\User;

/** @var Product[] $products */
$products = Product::orderBy('name')->paginate(18);
?>

<script xmlns:x-on="http://www.w3.org/1999/xhtml">


</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden  shadow-sm sm:rounded-lg ">
                <div class="flex ml-10 mt-3 p-2">

                    <div class="m-7 ">
                        <a href="{{route('products.create')}}"
                           class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm">Add a new Product</a>
                    </div>
                </div>


                <livewire:products.index/>
            </div>
        </div>
    </div>
</x-app-layout>
