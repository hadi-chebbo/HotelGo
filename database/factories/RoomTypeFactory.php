<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hotel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        

        return [
            'description' => $this->faker->sentence(),
            'capacity' => $this->faker->numberBetween(1, 6),
            'price_per_night' => $this->faker->numberBetween(50, 500),
            'image' => $this->faker->imageUrl(640, 480, 'rooms', true),
        ];
    }
}
