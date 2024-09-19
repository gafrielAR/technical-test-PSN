<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'address' => $this->faker->streetAddress,
            'district' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'postal_code' => $this->faker->numberBetween(10000, 99999)
        ];
    }
}
