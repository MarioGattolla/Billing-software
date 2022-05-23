<?php

namespace App\Actions\Products;

use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

/**
 * @method static Product run(array $validate, Product $product = null)
 */
class UpdateProduct
{
    use ActsAsAction;

    public function handle(array $validated): Product
    {

        $product = Product::findOrFail($validated['id']);

        $product->update($validated);

        $product->save();

        return  $product;
    }
}
