<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $super_admin */
        $super_admin = User::factory()->count(1)->create([
            'email' => 'mario.gattolla@gmail.com',
            'password' => Hash::make('provaprova'),
        ])->first();
        $super_admin->assignRole('Super Admin');


        $admins = User::factory(2)->create([]);
        foreach ($admins as $admin){
            /** @var User $admin */
            $admin->assignRole('Admin');
        }

        /** @var User[] $users */
        $users = User::factory(10)->create([]);
        foreach ($users as $user){
            /** @var User $user */
            $user->assignRole('Operator');
        }

    }


}
