<?php

namespace App\Actions\Users ;

use App\Models\Company;
use App\Models\User;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewUser
{
    use ActsAsAction;

    public function handle($name, $email, $password, $role): bool
    {

        /** @var User $user */
       return  User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->assignRole($role)->save();

    }
}
