<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => '洋服',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Category::create([
            'name' => 'メンズ',
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Category::create([
            'name' => 'レディース',
            'parent_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
