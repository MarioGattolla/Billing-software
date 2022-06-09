<?php

namespace App\Actions\Orders;

use App\Actions\Companies\UpdateCompany;
use App\Actions\Products\UpdateProduct;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewOrder
{
    use ActsAsAction;

    public function handle(Company $company, array $movements, string $date, string $type): Order
    {

        $updated_company = Company::updateOrCreate((array)$company);

        /** @var Order $order */
        $order = $updated_company->orders()->create([
            'date' => $date,
            'type' => $date,
        ]);

        collect($request->validated('products'))
            ->each(fn(array $product_data) => UpdateProduct::run($product_data, Product::findOrFail($product_data['id'])))
            ->each(fn(array $product_data) => CreateNewOrder::run($product_data, $order->id));

        return redirect()->route('orders.index')->with('success', 'Order created !!');

        $validated['quantity'] = Order::findOrFail($order_id)->type == 'outgoing'
            ? $validated['quantity'] * -1
            : $validated['quantity'];

        return OrderProduct::create([
            'order_id' => $order_id,
            'product_id' => $validated['id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'vat' => $validated['vat'],
        ]);
    }
}
