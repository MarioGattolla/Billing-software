<?php

namespace App\Actions\Products;

use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateProduct
{
    use ActsAsAction;

    public function handle(mixed $validated, Product $product): bool
    {
        $name = $validated['name'];
        $description = $validated['description'];
        $min_stock = $validated['min_stock'];
        $weight = $validated['weight'];
        $department = $validated['department'];
        $category_id = $validated['category_id'];
        $price = $validated['price'];
        $vat = $validated['vat'];

        $old_product = Product::findOrFail($product->id);

        $old_product->update([
            'name' => $name,
            'description' => $description,
            'min_stock' => $min_stock,
            'weight' => $weight,
            'department' => $department,
            'category_id' => $category_id,
            'price' => $price,
            'vat' => $vat,
        ]);

        return $old_product->save();
    }
}
