<?php

use App\Http\Controllers\OrderController;
use App\Http\Requests\StoreOrderRequest;
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

test('can store orders with existing company', function () {

    allow_authorize('createOrder', Order::class);

    Company::factory()->create([
        'business_name' => 'Test name',
        'contact_name' => null,
        'email' => 'email@oldtest.it',
        'country' => 'Old Test',
        'address' => 'Old Test',
        'phone' => '12345123',
        'vat_number' => '11111111',

    ]);

    Category::factory()->create();
    Product::factory()->create([
        'name' => ' Old Product',
        'price' => 9,
        'vat' => 21,
        'description' => 'Old Description',
    ]);

    $translator = $this->createMock(Translator::class);
    $request = new StoreOrderRequest();
    $validator = new Validator($translator,
        [
            'contact_name' => null,
            'type' => 'incoming',
            'company_id' => 1,
            'email' => 'email@test.it',
            'country' => 'Test',
            'address' => 'Test',
            'phone' => '123451231',
            'vat_number' => '111111112',
            'business_name' => 'Test',
            'id' => [1],
            'name' => ['Product'],
            'price' => [10.10],
            'vat' => [22],
            'description' => ['Description'],
            'total' => [100],
            'quantity' => [2],
            'date' => today()->format('d-m-Y'),

        ],
        $request->rules());

    $validated = $request->setValidator($validator);

    $response = app(OrderController::class)->store($validated);

    /** @var Product $product */
    $product = Product::findOrFail(1);

    expect($product->name)->toBe('Product');
    expect($product->description)->toBe('Description');
    expect($product->price)->toBe(10.1);
    expect($product->vat)->toBe(22);

    /** @var Company $company */
    $company = Company::findOrFail(1);

    expect($company->business_name)->toBe('Test');
    expect($company->contact_name)->toBe(null);
    expect($company->email)->toBe('email@test.it');
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test');
    expect($company->phone)->toBe('123451231');
    expect($company->vat_number)->toBe('111111112');

    /** @var Order $order */
    $order = Order::findOrFail(1);

    expect($order->date)->toBe(today()->format('d-m-Y'));
    expect($order->type)->toBe('incoming');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('orders.index'));
});

test('can store orders with new company', function () {

    allow_authorize('createOrder', Order::class);

    Category::factory()->create();
    Product::factory()->create([
        'name' => ' Old Product',
        'price' => 9,
        'vat' => 21,
        'description' => 'Old Description',
    ]);

    $translator = $this->createMock(Translator::class);
    $request = new StoreOrderRequest();
    $validator = new Validator($translator,
        [
            'contact_name' => null,
            'type' => 'incoming',
            'company_id' => null,
            'email' => 'email@test.it',
            'country' => 'Test',
            'address' => 'Test',
            'phone' => '123451231',
            'vat_number' => '111111112',
            'business_name' => 'Test',
            'id' => [1],
            'name' => ['Product'],
            'price' => [10.10],
            'vat' => [22],
            'description' => ['Description'],
            'total' => [100],
            'quantity' => [2],
            'date' => today()->format('d-m-Y'),

        ],
        $request->rules());

    $validated = $request->setValidator($validator);

    $response = app(OrderController::class)->store($validated);

    /** @var Product $product */
    $product = Product::findOrFail(1);

    expect($product->name)->toBe('Product');
    expect($product->description)->toBe('Description');
    expect($product->price)->toBe(10.1);
    expect($product->vat)->toBe(22);

    /** @var Company $company */
    $company = Company::findOrFail(1);

    expect($company->business_name)->toBe('Test');
    expect($company->contact_name)->toBe(null);
    expect($company->email)->toBe('email@test.it');
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test');
    expect($company->phone)->toBe('123451231');
    expect($company->vat_number)->toBe('111111112');

    /** @var Order $order */
    $order = Order::findOrFail(1);

    expect($order->date)->toBe(today()->format('d-m-Y'));
    expect($order->type)->toBe('incoming');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('orders.index'));
});

test('can delete order', function () {

    Company::factory()->create();
    Product::factory()->create();
    $order = Order::factory()->create();

    allow_authorize('deleteOrder', $order);

    app(OrderController::class)->destroy($order);

    expect(Order::count())->toBe(0);
});
