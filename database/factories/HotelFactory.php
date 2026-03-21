<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    public function definition(): array
    {
        $cities = [
            ['name' => 'Zahle', 'lat' => 33.8462, 'lng' => 35.9020],
            ['name' => 'Baalbek', 'lat' => 34.0058, 'lng' => 36.2181],
            ['name' => 'Aley', 'lat' => 33.8078, 'lng' => 35.6006],
            ['name' => 'Bhamdoun', 'lat' => 33.7950, 'lng' => 35.6581],
            ['name' => 'Chtaura', 'lat' => 33.8200, 'lng' => 35.8500],
        ];

        $city = fake()->randomElement($cities);

        $latitude = $city['lat'] + fake()->randomFloat(4, -0.01, 0.01);
        $longitude = $city['lng'] + fake()->randomFloat(4, -0.01, 0.01);

        return [
            'user_id' => User::factory()->state([
                'role' => 2,
            ]),

            'name' => fake()->company(),
            'description' => fake()->paragraph(),
            'email' => fake()->unique()->safeEmail(),
            'location' => $city['name'],
            'latitude' => $latitude,
            'longitude' => $longitude,

            'social_links' => [
                'facebook' => fake()->url(),
                'instagram' => fake()->url(),
                'linkedin' => fake()->url(),
            ],

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
