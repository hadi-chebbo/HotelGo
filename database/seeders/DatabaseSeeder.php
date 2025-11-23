<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\HotelSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\PromoCodeSeeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UsersTableSeeder::class);

        $this->call(HotelSeeder::class);

        $this->call(RoomSeeder::class);

        $this->call(PromoCodeSeeder::class);
    }
}
