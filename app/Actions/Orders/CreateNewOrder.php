<?php

namespace App\Actions\Orders;

use App\Models\Order;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewOrder
{
    use ActsAsAction;

    public function handle(mixed $validated): void
    {
        Order::create([
            'date' => $validated['date'],
            'type' => $validated['type'],
            'company_id' => $validated['company_id'],
        ])->save();
    }
}
