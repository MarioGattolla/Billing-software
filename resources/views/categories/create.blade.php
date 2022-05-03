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
                    Here you can create a new Category/Subcategory
                </div>
                <div x-data="radioFilter()" class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" action="{{route('categories.store')}}" name="categories_create_form">
                        @csrf


                        <div class="pt-2">
                            <p>Name</p>
                            <label for="name">
                                <input class="rounded-md " name="name" type="text" id="name" required/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Description</p>
                            <label for="description">
                                <input class="rounded-md" type="text" id="description" name="description"/>
                            </label>
                        </div>

                        <div class="pt-2">
                            <p>Parent Category</p>
                            <label>
                                <select name="parent_id">
                                    <option selected value="{{null}}">-- Root --</option>
                                    @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                        <option value="{{$category->id}}">{{$category->name }}</option>
                                    @endforeach
                                </select>
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
