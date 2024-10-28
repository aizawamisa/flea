<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        $imageFiles = File::files(public_path('/img/dummy'));
        $randomImage = 'img/dummy/' . $imageFiles[array_rand($imageFiles)]->getFilename();

        return [
            'name' => $faker->word(),
            'price' => $faker->numberBetween(1000, 30000),
            'description' => $faker->realText(50),
            'img_url' => $randomImage,
            'user_id' => User::inRandomOrder()->first()->id,
            'condition_id' => Condition::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
