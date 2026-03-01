<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => \App\Models\Event::factory(),
            'status' => $this->faker->randomElement(['CONFIRMED', 'CANCELED']),
            'contact_email' => $this->faker->unique()->safeEmail,
            'contact_name' => $this->faker->name,
        ];
    }
}
