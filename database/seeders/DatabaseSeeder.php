<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
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
        User::factory(1)->create([
            'email' => 'mario.gattolla@gmail.com',
            'password' => \Hash::make('provaprova'),
            ]);
        Company::factory()->count(200)->state(new Sequence(
            ['business_name' => 'null', 'vat_number' => 'null'],
            ['contact_name' => 'null']))->create();
    }
}
