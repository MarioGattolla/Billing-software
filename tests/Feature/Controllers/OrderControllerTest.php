<?php

use App\Http\Controllers\OrderController;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
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

    create_order_product();

    allow_authorize('createOrder', Order::class);

    $validated = create_validated_request($data, StoreOrderRequest::class);

    $response = app(OrderController::class)->store($validated);

    $product = Product::findOrFail(1);
    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and(Arr::except($data['company'], 'company_id'))->toBeInDatabase('companies')
        ->and($product->price)->toBe(floatval($data['products'][0]['price']))
        ->and($product->vat)->toBe(intval($data['products'][0]['vat']))
        ->and(Company::count())->toBe(1);

})->with([
    'company' => ['data' => newCompanyOrderData()],
    'private' => ['data' => newPrivateOrderData()],
]);


it('can update a company order', function (array $data, array $company) {

    create_order_product();

    allow_authorize('createOrder', Order::class);

    $data[0]['company']['company_id'] = 1;

    $validated = create_validated_request($data, StoreOrderRequest::class);

    $response = app(OrderController::class)->store($validated);

    $product = Product::findOrFail(1);

    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and(Arr::except($data['company'], 'company_id'))->toBeInDatabase('companies')
        ->and($product->price)->toBe(floatval($data['products'][0]['price']))
        ->and($product->vat)->toBe(intval($data['products'][0]['vat']))
        ->and(Company::count())->toBe(1);

})->with(function () {
    return [
        'company' => ['data' => newCompanyOrderData(), 'company' => dataset_business_company_raw()],
        'private' => ['data' => newPrivateOrderData(), 'company' => dataset_private_company_raw()],
    ];
});

it('can store order movements', function (array $data) {

    create_order_product(3);

    allow_authorize('createOrder', Order::class);

    $validated = create_validated_request($data, StoreOrderRequest::class);

    $response = app(OrderController::class)->store($validated);

    $movement1 = OrderProduct::findOrFail(1);
    $movement2 = OrderProduct::findOrFail(2);
    $movement3 = OrderProduct::findOrFail(3);

    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and(OrderProduct::count())->toBe(count($data['products']))
        ->and($movement1->price)->toBe(floatval($data['products'][0]['price']))
        ->and($movement1->vat)->toBe(intval($data['products'][0]['vat']))
        ->and($movement2->price)->toBe(floatval($data['products'][1]['price']))
        ->and($movement2->vat)->toBe(intval($data['products'][1]['vat']))
        ->and($movement3->price)->toBe(floatval($data['products'][2]['price']))
        ->and($movement3->vat)->toBe(intval($data['products'][2]['vat']));

})->with([
    'multiple products' => ['data' => multipleProductsOrderData()],
]);


it('can update order', function (array $data, Company $company) {

    create_order_product();

    $old_order = Order::factory()->with_random_company()->set_movements()->create();

    allow_authorize('editOrder', $old_order);

    $data['company']['company_id'] = 1;

    $validated = create_validated_request($data, UpdateOrderRequest::class);
    $response = app(OrderController::class)->update($validated, $old_order);

    $order = Order::find(1);
    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and($order->type)->toBe($data['type'])
        ->and($order->date)->toBe($data['date']);

})->with(function () {
    return [
        'company' => ['data' => newCompanyOrderData(), 'company' => fn() => Company::factory()->for_business()->create()],
        'private' => ['data' => newPrivateOrderData(), 'company' => fn() => Company::factory()->for_private()->create()],
    ];
});

test('can delete order', function () {

    Company::factory()->create();
    Product::factory()->create();
    $order = Order::factory()->create();

    allow_authorize('deleteOrder', $order);

    app(OrderController::class)->destroy($order);

    expect(Order::count())->toBe(0);
});

