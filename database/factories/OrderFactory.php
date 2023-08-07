<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $proformas = \App\Models\Proforma::all();
        $freelancers = \App\Models\Freelancer::all();
        $users = \App\Models\User::all();
        return [
            'item_description' => $this->faker->sentence(),
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 100),
            'total_price' => $this->faker->randomFloat(2, 10, 1000),
            'vendor_name' => $this->faker->name(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'status_description' => $this->faker->sentence(),
            'proforma_id' => $this->faker->randomElement($proformas->pluck('id')),
            'freelancer_id' => $this->faker->randomElement($freelancers->pluck('id')),
            'user_id' => $this->faker->randomElement($users->pluck('id')),
        ];
    }
}
