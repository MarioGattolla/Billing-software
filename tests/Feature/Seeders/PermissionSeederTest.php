<?php

namespace Tests\Feature\Seeders;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function _PHPStan_ccec86fc8\React\Promise\map;

uses(RefreshDatabase::class);

test('seeder create roles with relative permissions',  function ($role_enum) {
    $this->seed(DatabaseSeeder::class);

    /** @var Role $role */
    $role = Role::findByName($role_enum->value);

    /** @var User $user */
    $user = User::factory()->create();

    $user->assignRole($role);

    $user_permissions = $user->getAllPermissions()
        ->map(fn(Permission $permission) => $permission->name);

    /** @var \App\Enums\Role $role_enum */
    /** @var \App\Enums\Permission[] $admin_permissions */
    $admin_permissions = collect($role_enum->permissions())
        ->map(fn(\App\Enums\Permission $permission) => $permission->value)->toArray();


    expect($user_permissions)->toMatchArray($admin_permissions);
})->with(function (){
    return collect(\App\Enums\Role::cases())
        ->KeyBy(fn(\App\Enums\Role $role_enum) => $role_enum->value);
});
