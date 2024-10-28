<?php

namespace Database\Seeders;

use App\Models\Category_item;
use Illuminate\Database\Seeder;

class Category_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category_item::factory()->count(100)->create();
    }
}
