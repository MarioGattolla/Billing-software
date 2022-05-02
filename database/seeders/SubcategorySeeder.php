<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subcategory::factory()->create(['name' => 'Dell']);
        Subcategory::factory()->create(['name' => 'Asus']);
        Subcategory::factory()->create(['name' => 'HP']);
        Subcategory::factory()->create(['name' => 'Toshiba']);
        Subcategory::factory()->create(['name' => 'Lenovo']);
        Subcategory::factory()->create(['name' => 'Samsung']);
        Subcategory::factory()->create(['name' => 'Apple']);

    }
}
