<?php

/** @var Product $product */

use App\Models\Category;
use App\Models\Product;

/** @var Category[] $child_categories */
$child_categories = Category::where('parent_id', '!=', null)->get()->except($product->category->id );
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

                        <x-products.main-data :product="$product"/>

                        <div>
                            <p> Category</p>
                            <select name="category_id">
                                <option value="{{$product->category->id}}">{{$product->category->name}}</option>
                                @foreach($child_categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
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
