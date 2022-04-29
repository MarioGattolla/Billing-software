<?php

namespace App\Actions\Products;

use App\Models\Company;
use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewProduct
{
    use ActsAsAction;

    public function handle(string $name, string $description, int $min_stock): bool
    {
        $product = Product::create([
            'name' => $name,
            'description' => $description,
            'min_stock' => $min_stock,
        ]);

        return $product->save();
    }
}
