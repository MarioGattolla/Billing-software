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

    public function handle( int $product_id, int $quantity, float $price_ex_vat , float $total ,int $order_id): void
    {

        OrderProduct::create([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price_ex_vat' => $price_ex_vat,
            'total' => $total,
        ])->save();
    }
}
