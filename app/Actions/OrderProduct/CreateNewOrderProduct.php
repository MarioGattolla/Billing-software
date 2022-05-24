<?php

namespace App\Actions\OrderProduct;

use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewOrderProduct
{
    use ActsAsAction;

    public function handle(array $validated, int $order_id): OrderProduct
    {
        return OrderProduct::create([
            'order_id' => $order_id,
            'product_id' => $validated['id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'vat' => $validated['vat'],
        ]);
    }
}
