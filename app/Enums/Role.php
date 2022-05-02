<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Role: string
{
    case super_admin = 'Super Admin';
    case admin = 'Admin';
    case operator = 'Operator';



    public static function get_roles_cases_values(): array
    {
        return collect(Role::cases())
            ->map(fn(Role $role) => $role->value)->toArray();
    }


    public function get_permissions_values_by_role( ): array
    {
        return collect($this->permissions())
            ->map(fn(Permission $permission) => $permission->value)->toArray();

    }

    /** @return Collection<int, Role> */
    public static function get_roles_cases(): Collection
    {
       return collect(Role::cases());
    }

    public function permissions(): array
    {
        return match ($this){
            self::super_admin => [
                Permission::create_user,
                Permission::create_admin,
                Permission::create_super_admin,
                Permission::edit_user,
                Permission::edit_admin,
                Permission::edit_super_admin,
                Permission::delete_user,
                Permission::delete_admin,
                Permission::delete_super_admin,
                Permission::show_user,
                Permission::show_admin,
                Permission::show_super_admin,
                Permission::create_company,
                Permission::show_company,
                Permission::edit_company,
                Permission::delete_company,
                Permission::create_product,
                Permission::edit_product,
                Permission::show_product,
                Permission::delete_product,
                Permission::create_category,
                Permission::delete_category,
                Permission::edit_category,
                Permission::show_category,
                Permission::create_subcategory,
                Permission::delete_subcategory,
                Permission::edit_subcategory,
                Permission::show_subcategory,
            ],
            self::admin => [
                Permission::create_user,
                Permission::edit_user,
                Permission::delete_user,
                Permission::show_user,
                Permission::show_admin,
                Permission::create_company,
                Permission::show_company,
                Permission::edit_company,
                Permission::delete_company,
                Permission::create_product,
                Permission::edit_product,
                Permission::show_product,
                Permission::delete_product,
                Permission::edit_category,
                Permission::show_category,
                Permission::show_subcategory,


            ],
            self::operator => [
                Permission::show_user,
                Permission::show_company,
                Permission::show_product,
                Permission::show_category,
                Permission::show_subcategory,
            ],

        };
    }
}
