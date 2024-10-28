<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\User;

class Sold_itemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $itemId = 1;

        return [
            'item_id' => $itemId += 2,
            'user_id' => User::inRandomOrder()->first()->id,
            'payment_id' => Payment::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
