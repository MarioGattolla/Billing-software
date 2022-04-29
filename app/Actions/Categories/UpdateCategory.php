<?php


namespace App\Actions\Categories;

use App\Models\Category;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateCategory
{
    use ActsAsAction;

    public function handle(string $name, string $description, Category $category ): bool
    {
        $old_category = Category::findOrFail($category->id);

        $old_category->update([
            'name' => $name,
            'description' => $description,
        ]);

        return $old_category->save();

    }
}
