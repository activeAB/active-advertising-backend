<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Basic_info>
 */
class Basic_infoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'active_tin_nUmber' => $this->faker->unique()->bothify('###??#??##'),
            'active_vat' => $this->faker->unique()->randomNumber(5),
            'active_email' => $this->faker->unique()->safeEmail,
        ];
    }
}
