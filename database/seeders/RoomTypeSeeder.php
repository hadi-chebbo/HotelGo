<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Hotel;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Single', 'Double', 'Twin', 'Suite', 'Deluxe'];
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            foreach ($types as $type) {
                RoomType::factory()->create([
                    'hotel_id' => $hotel->id,
                    'type' => $type,
                ]);
            }
        }
    }
}
