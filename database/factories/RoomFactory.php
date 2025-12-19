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
        
        $statuses = ['available', 'maintenance'];
        $hotel = Hotel::inRandomOrder()->first();
        

        return [
            'hotel_id' => $hotel->id, 
            'room_type_id' => $hotel->roomTypes()->inRandomOrder()->first()->id,
            'room_number' => $this->faker->unique()->numberBetween(100, 999), 
            'floor' => $this->faker->numberBetween(1, 10), 
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
