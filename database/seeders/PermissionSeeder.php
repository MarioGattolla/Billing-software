<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    public function run()
    {


        /** @var Role $role */
        /** @var \App\Enums\Permission $permission */


        foreach (\App\Enums\Role::cases() as $role_enum) {
            $role = Role::findOrCreate($role_enum->value);

            foreach ($role_enum->permissions() as $permission_enum){
               Permission::findOrCreate($permission_enum->value);
               $role->givePermissionTo($permission_enum->value);
            }
        }



    }
}
