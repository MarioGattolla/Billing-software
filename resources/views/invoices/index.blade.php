<?php

use App\Models\Category;


/** @var Category[] $categories */
$categories = Category::orderBy('name')->paginate(18);
?>

<script xmlns:x-on="http://www.w3.org/1999/xhtml">


</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden  shadow-sm sm:rounded-lg ">
                <div class="flex ml-10 mt-3 p-2">

                    <div class="m-7 ">
                        <a href="{{route('categories.create')}}"
                           class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm">Add a new Category/Subcategory</a>
                    </div>
                </div>


                <div class="  p-3 ml-10 mr-10  mb-10">
                    <div class="bg-gray-100 p-3 border rounded-md">
                        <div class="ml-10 mr-10  mt-3 text-center mb-3 p-3 border w rounded-md
                        border-green-400 bg-green-200 text-sm">
                            Categories
                        </div>
                        <div class=" ml-10 mr-10 flex grid grid-cols-6">
                            @foreach($categories as $category)
                                <a class=" hover:bg-blue-50 p-3 m-2 border-green-400 border
                            rounded-md col-span-2  text-center bg-white"
                                   href="{{route('categories.show', $category)}}">
                                    <div>
                                        <p>{{$category->name}}</p>

                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="ml-10 mr-10 mt-2 mb-2">{{$categories->links()}}</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
