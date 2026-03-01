<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organizer_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'event_date' => $this->faker->dateTimeBetween('+1 days', '+1 year'),
            'location' => $this->faker->address,
            'image_url' => $this->faker->imageUrl(),
            'visibility' => $this->faker->randomElement(['PUBLIC', 'PRIVATE']),
            'max_capacity' => $this->faker->numberBetween(10, 500),
            'status' => $this->faker->randomElement(['DRAFT', 'CANCELLED', 'PUBLISHED']),
        ];
    }
}
