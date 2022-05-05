<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'min_stock' => $this->faker->numberBetween(1,100),
            'weight' => $this->faker->numberBetween(1,20),
            'department' => $this->faker->numberBetween(1,10),
            'price' => $this->faker->numberBetween(10,2000),
            'vat' => $this->faker->numberBetween(0, 30),
        ];
    }

    public function with_random_category(): ProductFactory
    {
        return $this->afterCreating(function (Product $product){

            $subcategories = Category::count();

            $product->category_id = rand(1, $subcategories);
            $product->save();
        });
    }
}
