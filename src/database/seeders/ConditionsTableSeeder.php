<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::create([
            'condition'=>'良好',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        Condition::create([
            'condition' => '良い',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Condition::create([
            'condition' => '普通',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Condition::create([
            'condition' => '悪い',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Condition::create([
            'condition' => '不良',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
