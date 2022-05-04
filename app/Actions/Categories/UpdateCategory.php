<?php


namespace App\Actions\Categories;

use App\Models\Category;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateCategory
{
    use ActsAsAction;

    public function handle(string $name, mixed $description, mixed $parent_id, Category $category ): bool
    {
        $old_category = Category::findOrFail($category->id);

        $old_category->update([
            'name' => $name,
            'description' => $description,
            'parent_id' => $parent_id,
        ]);

        return $old_category->save();

    }
}
