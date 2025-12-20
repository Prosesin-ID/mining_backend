<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BiayaRute;
use Carbon\Carbon;

class BiayaRuteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $biayaRutes = [
            [
                'from' => 1, // Quarry Pit A
                'to' => 4,   // Stockpile Utama
                'biaya' => 250000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 1, // Quarry Pit A
                'to' => 5,   // Crusher Plant
                'biaya' => 300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 2, // Quarry Pit B
                'to' => 4,   // Stockpile Utama
                'biaya' => 275000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 2, // Quarry Pit B
                'to' => 6,   // Port Loading Area
                'biaya' => 350000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 3, // Quarry Pit C
                'to' => 5,   // Crusher Plant
                'biaya' => 280000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 4, // Stockpile Utama
                'to' => 6,   // Port Loading Area
                'biaya' => 200000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 5, // Crusher Plant
                'to' => 7,   // Stockpile Sekunder
                'biaya' => 150000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 1, // Quarry Pit A
                'to' => 10,  // ROM Pad
                'biaya' => 225000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 10, // ROM Pad
                'to' => 6,    // Port Loading Area
                'biaya' => 320000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'from' => 7, // Stockpile Sekunder
                'to' => 6,   // Port Loading Area
                'biaya' => 180000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($biayaRutes as $biayaRute) {
            BiayaRute::create($biayaRute);
        }
    }
}