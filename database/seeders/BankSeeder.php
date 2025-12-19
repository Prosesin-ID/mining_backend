<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            'BCA',
            'Mandiri',
            'BNI',
            'BRI',
            'CIMB Niaga',
            'Permata Bank',
            'Danamon',
        ];
        foreach ($banks as $bankName) {
            \App\Models\Bank::firstOrCreate(['name' => $bankName]);
        }
    }
}
