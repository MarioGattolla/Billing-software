<?php

namespace App\Actions\Orders;

use App\Models\Order;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateOrder
{
    use ActsAsAction;

    public function handle(mixed $validated, Order $order): bool
    {
        $order->update([
            'date' => $validated['date'],
            'type' => $validated['type'],
        ]);

        return $order->save();
    }
}
