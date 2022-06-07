<?php
/** @var \Illuminate\Pagination\LengthAwarePaginator $products */
/** @var string $search */
?>

<div class="  p-3 ml-10 mr-10  mb-10">
    <div class="bg-gray-100 p-3 border rounded-md">
        <div class="m-3 ml-10">
            <input type="text" placeholder="search the product" wire:model.debounce="search">
        </div>
        <div class="ml-10 mr-10  mt-3 text-center mb-3 p-3 border w rounded-md border-green-400 bg-green-200 text-sm">
            Products
            @if($search)
                ({{$search}})
            @endif
        </div>

        <div class=" ml-10 mr-10 flex grid grid-cols-6">
            @foreach($products as $product)
                <a class=" hover:bg-blue-50 p-3 m-2 border-green-400 border
                            rounded-md col-span-2  text-center bg-white"
                   href="{{route('products.show', $product)}}">
                    <div>
                        <p>{{$product->name}}</p>

                    </div>
                </a>
            @endforeach
        </div>
        <div class="ml-10 mr-10 mt-2 mb-2">{{$products->links()}}</div>

    </div>
</div>
