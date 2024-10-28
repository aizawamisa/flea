<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $userId = 1;

        $faker = $this->faker;

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'postcode' => $faker->postcode,
            'address' => $faker->prefecture . $faker->city . $faker->ward . $faker->streetAddress,
            'building' => $faker->optional($weight = 0.5)->secondaryAddress(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
