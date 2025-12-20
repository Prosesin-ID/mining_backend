<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DriverRequest;
use App\Models\Driver;
use Carbon\Carbon;

class DriverRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = Driver::all();

        $driverRequests = [
            [
                'driver_id' => $drivers[0]->id ?? 1,
                'request_type' => 'pemotongan',
                'amount' => 1000000,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'driver_id' => $drivers[1]->id ?? 2,
                'request_type' => 'top_up',
                'amount' => 500000,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'driver_id' => $drivers[2]->id ?? 3,
                'request_type' => 'pemotongan',
                'amount' => 1500000,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'driver_id' => $drivers[3]->id ?? 4,
                'request_type' => 'top_up',
                'amount' => 750000,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'driver_id' => $drivers[4]->id ?? 5,
                'request_type' => 'pemotongan',
                'amount' => 2000000,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'driver_id' => $drivers[5]->id ?? 6,
                'request_type' => 'top_up',
                'amount' => 300000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'driver_id' => $drivers[6]->id ?? 7,
                'request_type' => 'pemotongan',
                'amount' => 1200000,
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'driver_id' => $drivers[7]->id ?? 8,
                'request_type' => 'top_up',
                'amount' => 600000,
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],
            [
                'driver_id' => $drivers[8]->id ?? 9,
                'request_type' => 'top_up',
                'amount' => 800000,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'driver_id' => $drivers[9]->id ?? 10,
                'request_type' => 'pemotongan',
                'amount' => 1800000,
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => Carbon::now()->subDays(9),
            ],
        ];
        foreach ($driverRequests as $driverRequest) {
            DriverRequest::create($driverRequest);
        }
    }
}