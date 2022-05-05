@props(['category'])

<?php

/** @var Category $category */
use App\Models\Category;

$parent_categories = Category::where('parent_id', '=', null)->get();
?>

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

            @if($category->parent_id == null)
                <option value="{{null}}" @selected($category->parent)>-- Root --</option>

                @foreach($parent_categories as $parent_category)
                    <option value="{{$parent_category->id}}">{{$parent_category->name }}</option>
                @endforeach
            @else

                <option value="{{null}}" >-- Root --</option>

                @foreach($parent_categories as $parent_category)
                    <option value="{{$parent_category->id}}" @selected($category->parent)>{{$parent_category->name }}</option>
                @endforeach
            @endif

        </select>
    </label>
</div>
