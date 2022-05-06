<?php

namespace App\Enums;

enum Permission: string
{
    case create_super_admin = 'create super admin';
    case create_admin = 'create admin' ;
    case create_user = 'create user';
    case edit_user = 'edit user';
    case edit_admin = 'edit admin';
    case edit_super_admin = 'edit super admin';
    case delete_super_admin = 'delete super admin';
    case delete_admin = 'delete admin';
    case delete_user = 'delete user';
    case show_user = 'show user';
    case show_admin = 'show admin';
    case show_super_admin = 'show super admin';
    case create_company = 'create company';
    case edit_company = 'edit company';
    case show_company = 'show company';
    case delete_company = 'delete company';
    case create_product = 'create product';
    case edit_product = 'edit product';
    case show_product = 'show product';
    case delete_product = 'delete product';
    case create_category = 'create category';
    case show_category = 'show category';
    case edit_category = 'edit category';
    case delete_category = 'delete category';
    case create_subcategory = 'create subcategory';
    case show_subcategory = 'show subcategory';
    case edit_subcategory = 'edit subcategory';
    case delete_subcategory = 'delete subcategory';
    case create_order = 'create order';
    case show_order = 'show order';
    case edit_order = 'edit order';
    case delete_order = 'delete order';


    public static function get_permissions_cases_values(): array
    {
        return collect(Permission::cases())
            ->map(fn(Permission $permission) => $permission->value)->sort()->toArray();
    }
}
