<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'method' => 'クレジットカード',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Payment::create([
            'method' => '銀行振込',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Payment::create([
            'method' => 'コンビニ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
