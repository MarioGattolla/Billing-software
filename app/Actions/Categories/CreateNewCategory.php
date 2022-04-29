<?php


namespace App\Actions\Categories;

use App\Models\Category;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewCategory
{
    use ActsAsAction;

    public function handle(string $name, string $description ): bool
    {
        $category = Category::create([
            'name' => $name,
            'description' => $description,
        ]);

        return $category->save();
    }
}
