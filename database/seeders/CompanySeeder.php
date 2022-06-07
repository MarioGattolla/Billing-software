<?php

namespace Database\Seeders;

use App\Models\Company;
use Doctrine\DBAL\Schema\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::factory()->count(200)->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
            ['type' => 'private', 'vat_number' => null],
            ['type' => 'business']))->create();
    }
}
