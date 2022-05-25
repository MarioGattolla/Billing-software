@props(['product'])

<?php
/** @var  Product $product */
use App\Models\Product;
?>


<div class=" flex">
    <div class="m-2">
        <p>Name</p>
        <label for="name">
            <input class="rounded-md " value="{{$product->name}}" name="name" type="text" id="name" required/>
        </label>
    </div>

    <div class="m-2">
        <p>Description</p>
        <label for="description">
            <input class="rounded-md" value="{{$product->description}}" type="text" id="description" name="description" required/>
        </label>
    </div>
</div>


<div class="flex ">
    <div class="m-2">
        <p>Minimum Stock</p>
        <label for="min_stock">
            <input class="rounded-md " value="{{$product->min_stock}}" type="number" id="min_stock" name="min_stock" required/>
        </label>
    </div>

    <div class="m-2">
        <p>Weight</p>
        <label for="weight">
            <input class="rounded-md " value="{{$product->weight}}" type="number" id="weight" name="weight" required/>
        </label>
    </div>
</div>

<div class="flex">
    <div class="m-2">
        <p>Department</p>
        <label for="department">
            <input class="rounded-md " value="{{$product->department}}" type="number" id="department" name="department"
                   required/>
        </label>
    </div>

    <div class="m-2">
        <p>Price</p>
        <label for="price">
            <input class="rounded-md " value="{{$product->price}}" type="number" id="price" name="price" required/>
        </label>
    </div>
</div>

<div class="m-2">
    <p>Vat</p>
    <label for="vat">
        <input class="rounded-md " value="{{$product->vat}}" type="number" id="vat" name="vat" required/>
    </label>
</div>
