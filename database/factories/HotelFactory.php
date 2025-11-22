<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            
            'user_id' => User::factory(),

            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'email' => $this->faker->unique()->safeEmail(),
            'location' => $this->faker->city,

           
            'social_links' => [
                'facebook' => $this->faker->url,
                'instagram' => $this->faker->url,
                'linkedin' => $this->faker->url,
            ],

            
           

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
