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

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\actingAs;

uses(Tests\TestCase::class)->in('Feature');

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

function authorize_check_by_policy(string $permission_name,string $policy_name ): void
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
    $response_admin = Gate::check($policy_name, $admin);

    actingAs($operator);
    $response_operator = Gate::check($policy_name, $operator);

    expect($response_admin)->toBe(true);
    expect($response_operator)->toBe(false);
}
