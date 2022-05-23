<?php

use App\Http\Controllers\OrderController;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

uses(RefreshDatabase::class);

test('orders index return correct view', function () {

    allow_authorize('viewAny', Order::class);

    $response = app(OrderController::class)->index();

    expect($response)->toBeView('orders.index');
});

test('orders create return correct view', function () {

    allow_authorize('createOrder', Order::class);

    $response = app(OrderController::class)->create();

    expect($response)->toBeView('orders.create');
});

test('orders show return correct view', function () {

    Company::factory()->create();
    $order = Order::factory()->make();

    allow_authorize('view', $order);

    $response = app(OrderController::class)->show($order);

    expect($response)->toBeView('orders.show');
});

test('orders edit return correct view', function () {

    Company::factory()->create();

    $order = Order::factory()->create();

    allow_authorize('editOrder', $order);

    $response = app(OrderController::class)->edit($order);

    expect($response)->toBeView('orders.edit');
});


test('only authorized user can see index page', function () {

    authorize_check_by_policy('show order', 'viewAny', Order::class);
});

test('only authorized user can see create page', function () {

    authorize_check_by_policy('create order', 'createOrder', Order::class);
});

test('only authorized user can see show page', function () {

    Company::factory()->create();
    $order = Order::factory()->create();

    authorize_check_by_policy('show order', 'view', $order);
});

test('only authorized user can see edit page', function () {

    Company::factory()->create();
    $order = Order::factory()->create();

    authorize_check_by_policy('edit order', 'editOrder', $order);
});

it('can store a company order', function (array $data) {

    Product::factory()->create([
        'name' => 'product',
        'description' => 'description',
        'price' => '20',
        'vat' => '22'
    ]);

    allow_authorize('createOrder', Order::class);


    $request = StoreOrderRequest::create('/orders', 'post', $data);

    $response = app(OrderController::class)->store($request);


    expect($response)->toBeSuccessful()
    ->and(Arr::except($data['company'], 'company_id')) ->toBeInDatabase('companies')
    ->and(Company::count())->toBe(1);

})->with([
    'company' => ['data' => companyOrderData()],
    'private' => ['data' => privateOrderData()],
]);

test('can delete order', function () {

    Company::factory()->create();
    Product::factory()->create();
    $order = Order::factory()->create();

    allow_authorize('deleteOrder', $order);

    app(OrderController::class)->destroy($order);

    expect(Order::count())->toBe(0);
});

