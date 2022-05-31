<?php

use App\Http\Controllers\SearchProductController;
use App\Models\Company;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('should return correct products', function () {


    Product::factory()->count(10)->create(['name' => 'test']);

    /** @var Company $company */
    $company = Company::factory()->create();

    $company->orders()->create(['type' => 'ingoing', 'date' => today()]);

    OrderProduct::factory()->create([
        'product_id' => 1,
        'order_id' => 1,
        'quantity' => 10,
        'price' => 10,
        'vat' => 20
    ]);

    OrderProduct::factory()->create([
        'product_id' => 1,
        'order_id' => 1,
        'quantity' => 5,
        'price' => 10,
        'vat' => 20
    ]);

    OrderProduct::factory()->create([
        'product_id' => 2,
        'order_id' => 1,
        'quantity' => -30,
        'price' => 10,
        'vat' => 20
    ]);

    OrderProduct::factory()->create([
        'product_id' => 2,
        'order_id' => 1,
        'quantity' => 20,
        'price' => 10,
        'vat' => 20
    ]);


    $request = Request::create('/search/product_with_available_stock', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchProductController::class)->search_products_with_available_stock($request);

    expect($response->count())->toBe(1);

})->only();
