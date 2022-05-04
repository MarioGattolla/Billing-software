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
    public function run(): void
    {
        Category::factory()->create(['name' => 'Computers']);
        Category::factory()->create(['name' => 'Storage Disks']);
        Category::factory()->create(['name' => 'Keyboards']);
        Category::factory()->create(['name' => 'All In One' , 'parent_id' => 1]);
        Category::factory()->create(['name' => 'Notebook' , 'parent_id' => 1]);
        Category::factory()->create(['name' => 'Desktop' , 'parent_id' => 1]);
        Category::factory()->create(['name' => 'Hard Disk' , 'parent_id' => 2]);
        Category::factory()->create(['name' => 'SSD' , 'parent_id' => 2]);
        Category::factory()->create(['name' => 'SSD mini' , 'parent_id' => 2]);
        Category::factory()->create(['name' => 'Mechanics' , 'parent_id' => 3]);
        Category::factory()->create(['name' => 'Wireless' , 'parent_id' => 3]);
    }
}
