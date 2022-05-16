<?php

namespace App\Actions\Products;

use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewProduct
{
    use ActsAsAction;

    public function handle(mixed $validated): bool
    {
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'min_stock' => $validated['min_stock'],
            'weight' => $validated['weight'],
            'department' => $validated['department'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'vat' => $validated['vat'],
        ]);

        return $product->save();
    }
}
