<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'activity_id'  => Activity::factory(),
            'user_id'      => User::factory(),
            'slots_booked' => fake()->numberBetween(1,5),
            'status'       => $this->faker->randomElement(['pending', 'confirmed', 'cancelled'])
        ];
    }
}
