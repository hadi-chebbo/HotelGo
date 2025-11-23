<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $methods=['CreditCard','Cash','VisaCard'];
        $statuses=['Sucessful','Failed'];
        return [
            'reservation_id'=>Reservation::inRandomOrder()->first()->id, 
            'amount' => $this->faker->randomFloat(2, 50, 1000),
            'method'=> $this->faker->randomElement($methods),
            'status'=> $this->faker->randomElement($statuses),
            'transaction_date'=>$this->faker->now(),

        ];
    }
}
