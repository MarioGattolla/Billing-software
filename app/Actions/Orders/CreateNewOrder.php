<?php

namespace App\Actions\Orders;

use App\Models\Order;
use DefStudio\Actions\Concerns\ActsAsAction;
use Illuminate\Database\Eloquent\Collection;

class CreateNewOrder
{
    use ActsAsAction;

    public function handle(mixed $validated): mixed
    {
        return Order::create([
             'date' => $validated['date'],
             'type' => $validated['type'],
             'company_id' => $validated['company_id'],
         ])->getKey();
    }
}
