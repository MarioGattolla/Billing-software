<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        /** @var Role $role */
        /** @var \App\Enums\Permission $permission */

        foreach (\App\Enums\Role::cases() as $role_enum) {
            $role = Role::findOrCreate($role_enum->value);
            $permissions_enum = $role_enum->permissions();

            foreach ($permissions_enum as $permission_enum) {
                Permission::findOrCreate($permission_enum->value);
                $role->givePermissionTo($permission_enum->value);
            }

            $this->revoke_old_permissions($role, $role_enum);
        }

        $this->delete_old_rules_and_permissions();

    }

    private function revoke_old_permissions(Role $role, \App\Enums\Role $role_enum)
    {
        $role_permissions = collect($role->getPermissionNames())->toArray();

        $enum_permissions = $role_enum->get_permissions_values_by_role();

        $permissions_diff = array_diff($role_permissions, $enum_permissions);

        foreach ($permissions_diff as $permission_diff) {
            $role->revokePermissionTo($permission_diff);
        }

    }

    private function delete_old_rules_and_permissions()
    {
        $roles = Role::all()->map(fn(Role $role) => $role->name)->toArray();

        $roles_enum = \App\Enums\Role::get_roles_cases_values();

        $roles_diff = array_diff($roles, $roles_enum);

        foreach ($roles_diff as $role_diff) {
            Role::findByName($role_diff)->deleteOrFail();
        }

        $permissions = Permission::all()->map(fn(Permission $permission) => $permission->name)->toArray();

        $permissions_enum = \App\Enums\Permission::get_permissions_cases_values();
        $permissions_diff = array_diff($permissions, $permissions_enum);

        foreach ($permissions_diff as $permission_diff) {
            Permission::findByName($permission_diff)->deleteOrFail();
        }
    }
}
