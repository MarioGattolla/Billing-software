<?php

namespace App\Actions\Products;

use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateProduct
{
    use ActsAsAction;

    public function handle(string $name, string $description, int $min_stock, Product $product): bool
    {
        $old_product = Product::findOrFail($product->id);

        $old_product->update([
            'name' => $name,
            'description' => $description,
            'min_stock' => $min_stock,
        ]);

        return $old_product->save();
    }
}
