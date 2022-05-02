<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create(['name' => 'Computers']);
        Category::factory()->create(['name' => 'Mouses']);
        Category::factory()->create(['name' => 'Keyboards']);
        Category::factory()->create(['name' => 'Laptops']);
        Category::factory()->create(['name' => 'All In One']);
        Category::factory()->create(['name' => 'Storage Drives']);
        Category::factory()->create(['name' => 'Microphones']);

    }
}
