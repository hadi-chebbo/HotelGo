<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Single', 'Double', 'Twin', 'Suite', 'Deluxe'];
        $statuses = ['available', 'maintenance'];

        return [
            'hotel_id' => Hotel::factory(), 
            'type' => $this->faker->randomElement($types),
            'price_per_night' => $this->faker->numberBetween(50, 500), 
            'status' => $this->faker->randomElement($statuses),
           
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
