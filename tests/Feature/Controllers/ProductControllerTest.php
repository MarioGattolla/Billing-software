<?php


use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('products index return correct view', function () {

    allow_authorize('viewAny', Product::class);

    $response = app(ProductController::class)->index();

    expect($response)->toBeView('products.index');

});

test('only authorized user can see index page', function () {

    authorize_check_by_policy('show product', 'viewAny', Product::class);

});

test('products create return correct view', function () {

    allow_authorize('createProduct', Product::class);

    $response = app(ProductController::class)->create();

    expect($response)->toBeView('products.create');

});

test('only authorized user can see create page', function () {

    authorize_check_by_policy('create product', 'createProduct', Product::class);

});

test('can store product and return correct redirect', function () {

    allow_authorize('createProduct', Product::class);

    $request = \Illuminate\Http\Request::create(route('products.create'), 'POST', [
        'name' => 'Test Name',
        'description' => 'Test Description',
        'min_stock' => 10,
    ]);

    $response = app(ProductController::class)->store($request);

    /** @var Product $product */
    $product = Product::findOrFail(1);

    expect($product->name)->toBe('Test Name');
    expect($product->description)->toBe('Test Description');
    expect($product->min_stock)->toBe(10);

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('products.index'));
});


test('products show return correct view', function () {

    $product = Product::factory()->make();

    allow_authorize('view', $product);

    $response = app(ProductController::class)->show($product);

    expect($response)->toBeView('products.show');

});

test('only authorized user can see products show page', function () {


    $product = Product::factory()->make();

    authorize_check_by_policy('show product', 'view', $product);

});

test('products edit return correct view', function () {

    $product = Product::factory()->make();

    allow_authorize('editProduct', $product);

    $response = app(ProductController::class)->edit($product);

    expect($response)->toBeView('products.edit');

});

test('only authorized user can see user edit page', function () {

    $products = Product::factory()->make();

    authorize_check_by_policy('edit product', 'editProduct', $products);

});


test('can update product and return correct redirect', function () {


    /** @var Product $old_product */
    $old_product = Product::factory()->create([
        'name' => 'Test Name',
        'description' => 'Test Description',
        'min_stock' => 10,
    ]);

    allow_authorize('editProduct', $old_product);

    $request = \Illuminate\Http\Request::create(route('products.edit', $old_product), 'PUT', [
        'name' => 'New Test Name',
        'description' => 'New Test Description',
        'min_stock' => 11,
    ]);

    $response = app(ProductController::class)->update($request, $old_product);

    /** @var Product $product */
    $product = Product::findOrFail(1);

    expect($product->name)->toBe('New Test Name');
    expect($product->description)->toBe('New Test Description');
    expect($product->min_stock)->toBe(11);

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('products.show', $product));

});


test('can delete product and return correct redirect', function () {

    /** @var Product $product */
    $product = Product::factory()->create();

    allow_authorize('deleteProduct', $product);

    $response = app(ProductController::class)->destroy($product);

    expect(Product::count())->toBe(0);
    expect($response)->toBeRedirect(route('products.index'));

});
