<?php

use App\Models\Category;
use App\Models\User;

/** @var User $user */
$user = Auth::user();

/** @var Category[] $child_categories */
$child_categories = Category::where('parent_id','!=', null)->get();
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

                        <x-products.main-data :product="$product"/>

                        <div>
                            <p> Category</p>
                            <select name="category_id"> @foreach($child_categories as $category)
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
