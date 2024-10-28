<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sold_item;

class Sold_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sold_item::factory()->count(30)->create();
        Sold_item::factory()->count(15)->create(['user_id' => 1,]);        
    }
}
