<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'totalOrder' => $this->faker->randomNumber(),
            'totalCustomer' => $this->faker->randomNumber(),
            'totalStock' => $this->faker->randomNumber(),
            'allocatedOrder' => $this->faker->randomNumber(),
            'approvedOrder' => $this->faker->randomNumber(),
            'completedOrder' => $this->faker->randomNumber(),
            'deliveredOrder' => $this->faker->randomNumber(),
            'totalCost' => $this->faker->randomNumber(),
            'totalProfit' => $this->faker->randomNumber(),
            'totalRevenue' => $this->faker->randomNumber(),
            'monday' => json_encode([$this->faker->randomNumber(), $this->faker->randomNumber()]),
            'tuesday' => json_encode([$this->faker->randomNumber(), $this->faker->randomNumber()]),
            'wednesday' => json_encode([$this->faker->randomNumber(), $this->faker->randomNumber()]),
            'thursday' => json_encode([$this->faker->randomNumber(), $this->faker->randomNumber()]),
            'friday' => json_encode([$this->faker->randomNumber(), $this->faker->randomNumber()]),
            'saturday' => json_encode([$this->faker->randomNumber(), $this->faker->randomNumber()]),
            'sunday' => json_encode([$this->faker->randomNumber(), $this->faker->randomNumber()]),
            
        ];
    }
}
