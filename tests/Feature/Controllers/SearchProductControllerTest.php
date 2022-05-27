<?php

use App\Http\Controllers\SearchProductController;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\seed;

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


    $request = Request::create('/search/product', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchProductController::class)->search_products($request);


    expect($response->count())->toBe(5);

});

it('can search products with available stock', function () {


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
        'product_id' => 2,
        'order_id' => 1,
        'quantity' => -10,
        'price' => 10,
        'vat' => 20
    ]);


    $request = Request::create('/search/product_with_available_stock', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchProductController::class)->search_products_with_available_stock($request);

    expect($response->count())->toBe(1);

})->only();


it('can search products_by_company', function () {

    seed(DatabaseSeeder::class);

    $id = Company::factory()->create()->id;

    $order = Order::factory()->set_movements()->create(['company_id' => $id, 'type' => 'Test']);

    $products_count = OrderProduct::where('order_id', '=', $order->id)
        ->get()->map(fn(OrderProduct $movement) => $movement->product_id)->count();

    $request = Request::create('/search/product_by_company', 'GET', [
        'id' => $id,
    ]);

    $response = app(SearchProductController::class)->search_products_by_company($request);

    expect($response->count())->toBe($products_count);

});
