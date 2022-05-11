<?php

use App\Http\Controllers\SearchProductController;
use App\Models\Company;
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


    $request = Request::create('/search', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchProductController::class)->search_products($request);


    expect($response->count())->toBe(5);

});



it('can search products_by_company', function () {

    Company::factory()->count(2)->create();

    Product::factory()->count(3)->create();



    $products = Product::factory()->count(5)->create(['name' => 'test'])
        ->map(fn(Product $product) => [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'vat' => $product->vat,

        ]);


    $request = Request::create('/search', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchProductController::class)->search_products($request);


    expect($response->count())->toBe(5);

})->only();
