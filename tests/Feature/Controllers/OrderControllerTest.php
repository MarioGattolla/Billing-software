<?php

use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can search products', function () {

    Product::factory()->count(10)->create();


    $products = Product::factory()->count(5)->create(['name' => 'test'])
        ->map(fn(Product $product) => [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'vat' => $product->vat,

        ]);


    $request = Request::create('/orders/search', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(OrderController::class)->search($request);

    /** @var Product[] $filtered_products */
    $filtered_products = $response->original;

    expect($filtered_products)->toHaveCount(5);

});
