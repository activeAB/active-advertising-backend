<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Freelancer>
 */
class FreelancerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'freelancer_first_name' => $this->faker->firstName,
            'freelancer_last_name' => $this->faker->lastName,
            'freelancer_address' => $this->faker->address,
            'freelancer_phone_number' => $this->faker->phoneNumber,
            'freelancer_email' => $this->faker->unique()->safeEmail,
            'freelancer_image_url' => $this->faker->imageUrl(),
            'freelancer_portfolio_link' => $this->faker->url,
            'freelancer_order_status' => $this->faker->randomElement(['Pending', 'In Progress', 'Completed'])
        ];
    }
}
