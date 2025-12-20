<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DriverMoney;
use App\Models\Driver;
use Carbon\Carbon;

class DriverMoneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = Driver::all();

        $driverMoneys = [
            [
                'driver_id' => $drivers[0]->id ?? 1,
                'amount' => 5000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[1]->id ?? 2,
                'amount' => 3500000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[2]->id ?? 3,
                'amount' => 4200000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[3]->id ?? 4,
                'amount' => 2800000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[4]->id ?? 5,
                'amount' => 6100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[5]->id ?? 6,
                'amount' => 1500000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[6]->id ?? 7,
                'amount' => 4750000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[7]->id ?? 8,
                'amount' => 3300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[8]->id ?? 9,
                'amount' => 5500000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[9]->id ?? 10,
                'amount' => 2100000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($driverMoneys as $driverMoney) {
            DriverMoney::create($driverMoney);
        }
    }
}