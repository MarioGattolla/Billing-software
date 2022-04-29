<?php

/** @var Category $category */

use App\Models\Category;

?>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl ">
                    Edit Category : {{$category->name }}
                </div>
                <div class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" action="/categories/{{$category->id}}" name="categories_update_form">
                        @csrf
                        @method('PUT')

                        <div class="pt-2">
                            <p>Category Name</p>
                            <label for="name">
                                <input class="rounded-md " value="{{$category->name}}"  name="name" type="text" id="name"/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Category Description</p>
                            <label for="description">
                                <input class="rounded-md" value="{{$category-> description}}" type="text" id="description"
                                       name="description"/>
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