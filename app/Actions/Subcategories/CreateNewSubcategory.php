<?php


namespace App\Actions\Subcategories;

use App\Models\Subcategory;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewSubcategory
{
    use ActsAsAction;

    public function handle(string $name, mixed $description ): bool
    {
        $subcategory = Subcategory::create([
            'name' => $name,
            'description' => $description,
        ]);

        return $subcategory->save();
    }
}
