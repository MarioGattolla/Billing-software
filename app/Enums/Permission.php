<?php

namespace App\Enums;

enum Permission: string
{
    case create_super_admin = 'create super admin';
    case create_user = 'create user';
    case edit_user = 'edit user';
    case edit_super_admin = 'edit super admin';
    case delete_super_admin = 'delete super admin';
    case delete_user = 'delete user';
    case show_user = 'show user';
    case show_super_admin = 'show super admin';
}
