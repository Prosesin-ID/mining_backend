<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CheckPoint;
use Carbon\Carbon;

class CheckPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checkpoints = [
            [
                'name' => 'Quarry Pit A - Area Penggalian Utama',
                'kategori' => 'quarry',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'radius' => 50,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Quarry Pit B - Area Penggalian Timur',
                'kategori' => 'quarry',
                'latitude' => -6.2145,
                'longitude' => 106.8523,
                'radius' => 45,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Quarry Pit C - Area Penggalian Barat',
                'kategori' => 'quarry',
                'latitude' => -6.2034,
                'longitude' => 106.8389,
                'radius' => 40,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Stockpile Utama - Area Penimbunan',
                'kategori' => 'bongkar',
                'latitude' => -6.2156,
                'longitude' => 106.8467,
                'radius' => 60,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Crusher Plant - Pemecah Batu',
                'kategori' => 'bongkar',
                'latitude' => -6.2189,
                'longitude' => 106.8501,
                'radius' => 55,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Port Loading Area - Dermaga Muat',
                'kategori' => 'bongkar',
                'latitude' => -6.2223,
                'longitude' => 106.8578,
                'radius' => 70,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Stockpile Sekunder - Area Cadangan',
                'kategori' => 'bongkar',
                'latitude' => -6.2167,
                'longitude' => 106.8534,
                'radius' => 50,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Quarry Pit D - Area Eksplorasi Baru',
                'kategori' => 'quarry',
                'latitude' => -6.2078,
                'longitude' => 106.8612,
                'radius' => 35,
                'status' => 'inactive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Workshop Area - Tempat Bongkar Maintenance',
                'kategori' => 'bongkar',
                'latitude' => -6.2201,
                'longitude' => 106.8445,
                'radius' => 45,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ROM Pad - Run of Mine Stockpile',
                'kategori' => 'bongkar',
                'latitude' => -6.2134,
                'longitude' => 106.8489,
                'radius' => 65,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($checkpoints as $checkpoint) {
            CheckPoint::create($checkpoint);
        }
    }
}