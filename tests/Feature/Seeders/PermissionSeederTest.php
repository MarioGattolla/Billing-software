<?php

namespace Tests\Feature\Seeders;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('seeder create roles with relative permissions', function ($role_enum) {

    $this->seed(PermissionSeeder::class);

    /** @var Role $role */
    $role = Role::findByName($role_enum->value);

    /** @var User $user */
    $user = User::factory()->create();

    $user->assignRole($role);

    $user_permissions = $user->getAllPermissions()
        ->map(fn(Permission $permission) => $permission->name);

    /** @var \App\Enums\Role $role_enum */
    /** @var \App\Enums\Permission[] $admin_permissions */
    $enum_permissions = $role_enum->get_permissions_values_by_role();


    expect($user_permissions)->toMatchArray($enum_permissions);

})->with(function () {
    return collect(\App\Enums\Role::cases())
        ->KeyBy(fn(\App\Enums\Role $role_enum) => $role_enum->value);
});


test('seeder remove old role ', function () {
    Role::create(['name' => 'Test']);

    $this->seed(PermissionSeeder::class);

    expect(Role::all()->map(fn(Role $role) => $role->name)->toArray())
        ->toMatchArray(\App\Enums\Role::get_roles_cases_values());
});

test('seeder revoke old permissions', function () {

    /** @var \App\Enums\Role $role_enum */
    $role_enum = \App\Enums\Role::get_roles_cases()->first();

    Role::create(['name' => $role_enum->value])
        ->givePermissionTo(Permission::create(['name' => 'Can Test']));

    $this->seed(PermissionSeeder::class);

    $role = Role::findByName($role_enum->value);
    expect($role->getPermissionNames()->toArray())
        ->toMatchArray($role_enum->get_permissions_values_by_role());
});

test('seeder remove old permissions', function () {

    Permission::create(['name' => 'Can Test']);

    $this->seed(PermissionSeeder::class);

    $permissions = Permission::all()->map(fn(Permission $permission) => $permission->name)->toArray();
    $enum_permissions = \App\Enums\Permission::get_permissions_cases_values();
    expect(array_diff($enum_permissions, $permissions))->toBe([]);
});
