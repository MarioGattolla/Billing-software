<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition()
    {
        $count = Company::count();
        return [
            'date' => $this->faker->date,
            'company_id' => random_int(1, $count),
            'type' => $this->faker->randomElement(['incoming', 'outcoming']),
        ];

    }

    public function with_random_company(): OrderFactory
    {
        $count = Company::count();
        return $this->afterCreating(fn(Order $order) => $order->company_id = random_int(1, $count));
    }

    public function set_movements(): OrderFactory
    {
        return $this->afterCreating(function (Order $order) {
            $product_count = Product::count();

            $random_count = random_int(1, 5);

            for ($i = 0; $i < $random_count; $i++) {

                $random_product = random_int(1, $product_count);


                /** @var Product $product */
                $product = Product::find($random_product);

                $quantity = random_int(1, 10);
                OrderProduct::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'vat' => $product->vat,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }


        });
    }
}
