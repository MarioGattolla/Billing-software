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

    public static function get_permissions_cases_values(): array
    {
        return collect(Permission::cases())
            ->map(fn(Permission $permission) => $permission->value)->sort()->toArray();
    }
}
