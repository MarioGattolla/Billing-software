<?php

use App\Models\User;

/** @var User $user */
$user = Auth::user();

?>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-elements.validation-errors :errors="$errors"/>

                <div class=" ml-20 mt-10 bg-white  text-xl ">
                    Here you can create a new Category/Subcategory
                </div>
                <div x-data="radioFilter()" class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" action="{{route('categories.store')}}" name="categories_create_form">
                        @csrf

                        <x-categories.main-data :category="$category"/>

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
