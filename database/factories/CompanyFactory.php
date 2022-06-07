<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'country' => $this->faker->country(),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'vat_number' => $this->faker->swiftBicNumber(),
            'type' => $this->faker->randomElement(['private', 'business'])
        ];
    }

    function for_private(): CompanyFactory
    {
        return $this->afterCreating(function (Company $company) {
            $company->type = 'private';
            $company->vat_number = null;
        });
    }

    function for_business(): CompanyFactory
    {
        return $this->afterCreating(function (Company $company) {
            $company->type = 'business';
        });
    }
}
