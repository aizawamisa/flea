<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'item_id' => Item::inRandomOrder()->first()->id,
            'comment' => $this->faker->realText(20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
