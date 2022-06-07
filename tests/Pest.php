<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Translation\Translator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\actingAs;
use Illuminate\Validation\Validator;

uses(Tests\TestCase::class)->group('feature')->in('Feature');

uses(Tests\TestCase::class)->group('unit')->in('Regression');
uses(Tests\TestCase::class)->group('unit')->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something(): void
{
    // ..
}

function allow_authorize(string $ability, mixed ...$params): void
{
    Gate::shouldReceive('authorize')
        ->with($ability, ...$params)
        ->atLeast()->once()
        ->andReturn(\Illuminate\Auth\Access\Response::allow());
}

function authorize_check_by_policy(string $permission_name, string $policy_name, mixed $params): void
{

    Permission::create(['name' => $permission_name]);

    $admin_role = Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Operator']);

    /** @var Role $admin_role */
    $admin_role->givePermissionTo($permission_name);

    /** @var User $operator */
    $operator = User::factory()->create();
    $operator->assignRole('Operator');

    /** @var User $admin */
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    actingAs($admin);
    $response_admin = Gate::check($policy_name, $params);

    actingAs($operator);
    $response_operator = Gate::check($policy_name, $params);

    expect($response_admin)->toBe(true);
    expect($response_operator)->toBe(false);
}


function newPrivateOrderData(): array
{
    return [

        'type' => 'ingoing',
        'date' => today()->format('d-m-Y'),
        'company' => [
            'company_id' => null,
            'email' => 'email@test.it',
            'country' => 'country',
            'address' => 'address',
            'phone' => 'phone',
            'vat_number' => null,
            'name' => 'name',
            'type' => 'private'
        ],
        'products' => [
            [
                'id' => 1,
                'price' => '20',
                'vat' => '22',
                'quantity' => '1',
            ]
        ],
    ];
}

function newCompanyOrderData(): array
{
    return [

        'type' => 'ingoing',
        'date' => today()->format('d-m-Y'),
        'company' => [
            'company_id' => null,
            'name' => 'name',
            'email' => 'email@test.it',
            'country' => 'country',
            'address' => 'address',
            'phone' => 'phone',
            'vat_number' => 'vat',
            'type' => 'business'
        ],
        'products' => [
            [
                'id' => 1,
                'price' => '20',
                'vat' => '22',
                'quantity' => '1',
            ]
        ],
    ];
}

function multipleProductsOrderData(): array
{
    return [

        'type' => 'ingoing',
        'date' => today()->format('d-m-Y'),
        'company' => [
            'company_id' => null,
            'email' => 'email@test.it',
            'country' => 'country',
            'address' => 'address',
            'phone' => 'phone',
            'vat_number' => null,
            'name' => 'name',
            'type' => 'private',
        ],
        'products' => [
            [
                'id' => 1,
                'price' => '10',
                'vat' => '22',
                'quantity' => '2',
            ],
            [
                'id' => 2,
                'price' => '15',
                'vat' => '18',
                'quantity' => '1',
            ],
            [
                'id' => 3,
                'price' => '20',
                'vat' => '21',
                'quantity' => '3',
            ]
        ],
    ];
}

function create_order_product(int $count = 1)
{
    return Product::factory()->count($count)->create([
        'name' => 'product',
        'description' => 'description',
        'price' => '20',
        'vat' => '22'
    ]);
}

function create_validated_request(array $data, $resource)
{
    $translator = Mockery::mock(Translator::class);
    $request = new $resource;
    $validator = new Validator($translator, $data, $request->rules());

    return $request->setValidator($validator);
}

function dataset_private_company_raw(): Closure
{
    return fn() => Company::factory()->for_private()->raw();
}

function dataset_business_company_raw(): Closure
{
    return fn() => Company::factory()->for_business()->raw();
}

function newPrivateData(): array
{
    return [
        'selectedRadioID' => 2,
        'name' => 'Test Name',
        'vat_number' => '123456789',
        'country' => 'Test',
        'address' => 'Test Address',
        'email' => 'email@test.it',
        'phone' => '392222222',
        'type' => 'private'
    ];
}

function newBusinessData(): array
{
    return [
        'name' => 'Test',
        'vat_number' => '123456789',
        'country' => 'Test',
        'address' => 'Test Address',
        'email' => 'email@test.it',
        'phone' => '392222222',
    ];
}

function productData(): array
{
    return [
        'name' => 'Test name',
        'description' => 'Test description',
        'min_stock' => 10,
        'weight' => 2,
        'category_id' => 1,
        'price' => 20.1,
        'vat' => 20,
        'department' => 2,
    ];
}
