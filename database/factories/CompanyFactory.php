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
            'business_name' => $this->faker->company(),
            'contact_name' => $this->faker->firstName(),
            'country' => $this->faker->country(),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'vat_number' => $this->faker->swiftBicNumber(),
        ];
    }

    function for_private(): CompanyFactory
    {
        return $this->afterCreating(function (Company $company) {
            $company->business_name = null;
            $company->vat_number = null;
        });
    }

    function for_business(): CompanyFactory
    {
       return $this->afterCreating(function (Company $company) {
            $company->contact_name = null;
        });
    }
}
