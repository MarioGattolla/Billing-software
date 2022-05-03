<?php


namespace App\Actions\Categories;

use App\Models\Category;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewCategory
{
    use ActsAsAction;

    public function handle(string $name, mixed $description, mixed $parent_id ): bool
    {
        $category = Category::create([
            'name' => $name,
            'description' => $description,
            'parent_id' => $parent_id,
        ]);

        return $category->save();
    }
}
