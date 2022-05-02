<?php


namespace App\Actions\Subcategories;

use App\Models\Subcategory;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateSubcategory
{
    use ActsAsAction;

    public function handle(string $name, mixed $description, Subcategory $subcategory): bool
    {
        $old_subcategory = Subcategory::findOrFail($subcategory->id);

        $old_subcategory->update([
            'name' => $name,
            'description' => $description,
        ]);

        return $old_subcategory->save();

    }
}
