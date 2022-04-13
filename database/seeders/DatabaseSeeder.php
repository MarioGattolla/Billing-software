<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CompanySeeder::class);

    }
}