<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'            => fake()->sentence(3),
            'description'     => fake()->text(30),
            'location'        => fake()->city(),
            'price'           => fake()->randomFloat(2,50,500),
            'available_slots' => fake()->numberBetween(5,20),
            'start_date'      => fake()->dateTimeBetween('+1 days','+1 month')
        ];
    }
}
