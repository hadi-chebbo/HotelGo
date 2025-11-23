<?php

namespace Database\Seeders;
use Database\Seeders\HotelSeeder;
use Database\Seeders\RoomSeeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder; 


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(HotelSeeder::class);
        $this->call(RoomSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(ReviewSeeder::class);
    }
}
