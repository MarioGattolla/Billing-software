<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Role: string
{
    case super_admin = 'Super Admin';
    case admin = 'Admin';
    case operator = 'Operator';

    public static function values(): array
    {
        return Collection::make(self::cases())
            ->mapWithKeys(fn(Role $role) => [$role->name => $role->value])
            ->toArray();

    }
    public function permissions(): array
    {
        return match ($this){
            self::super_admin => [
                Permission::create_user,
                Permission::create_super_admin,
                Permission::edit_user,
                Permission::edit_super_admin,
                Permission::delete_user,
                Permission::delete_super_admin,
                Permission::show_user,
                Permission::show_super_admin,
            ],
            self::admin => [
                Permission::create_user,
                Permission::edit_user,
                Permission::delete_user,
                Permission::show_user,
            ],
            self::operator => [
                Permission::show_user,
            ],

        };
    }
}
