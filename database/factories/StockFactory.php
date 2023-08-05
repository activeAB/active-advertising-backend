<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 500),
            'total_price' => $this->faker->randomFloat(2, 100, 5000),
            'unit_measurement' => $this->faker->word,
            'purchase_date' => $this->faker->date,
            'expire_date' => $this->faker->dateTimeBetween('+1 month', '+5 years')->format('Y-m-d'),
            'dealer_name' => $this->faker->company,
        ];
    }
}
