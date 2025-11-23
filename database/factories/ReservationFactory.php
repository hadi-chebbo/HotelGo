<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Room;
use App\Models\PromoCode;
use App\Models\Reservation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $statuses = ['confirmed', 'cancelled', 'completed'];

        //getting a random room
        $room = Room::inRandomOrder()->first();

        //getting the hotel id for this room
        $hotelId = $room->hotel_id;

        //getting an array of promo codes ids for this specific hotel id
        $promoCodesId = PromoCode::where('hotel_id',$hotelId)->pluck('id')->toArray();

        //picking random promocode
        $promoCodeId = null;
        if (!empty($promoCodesId) && $this->faker->boolean(50)) {
            $promoCodeId = $this->faker->randomElement($promoCodesId);
        }
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'room_id' => $room->id,
            'promo_code_id' => $promoCodeId,
            'check_in_date' => $this->faker->dateTimeBetween('+1 week', '+3 week')->format('Y-m-d'),
            'check_out_date' => $this->faker->dateTimeBetween('+3 week', '+5 week')->format('Y-m-d'),
            'total_price' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
