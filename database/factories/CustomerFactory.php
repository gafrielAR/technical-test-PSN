<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'image' => $this->faker->imageUrl(),
        ];
    }
}
