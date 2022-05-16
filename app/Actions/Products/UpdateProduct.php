<?php

namespace App\Actions\Products;

use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateProduct
{
    use ActsAsAction;

    public function handle(mixed $validated, Product $product): bool
    {

        $old_product = Product::findOrFail($product->id);

        $old_product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'min_stock' => $validated['min_stock'],
            'weight' => $validated['weight'],
            'department' => $validated['department'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'vat' => $validated['vat'],
        ]);

        return $old_product->save();
    }
}
