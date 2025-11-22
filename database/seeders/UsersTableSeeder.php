<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creates a super admin for the website
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'phone' => '000000000',
            'role' => 1,
            'loyalty_points' => 0,
            'blocked' => 0
        ]);

        //creates 5 users for testing
        User::factory()->count(5)->create();
    }
}
