<?php

use App\Http\Controllers\SearchProductController;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrdersProducts;
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


it('can search products_by_company', function () {

    seed(DatabaseSeeder::class);

    $id = Company::factory()->create()->id;

    $order = Order::factory()->set_movements()->create(['company_id' => $id, 'type' =>'Test']);

    $products_count = OrdersProducts::where('order_id', '=', $order->id)
        ->get()->map(fn(OrdersProducts $movement) => $movement->product_id)->count();

    $request = Request::create('/search/product_by_company', 'GET', [
        'id' => $id,
    ]);

    $response = app(SearchProductController::class)->search_products_by_company($request);

    expect($response->count())->toBe($products_count);

});
