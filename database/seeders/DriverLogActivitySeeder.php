<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DriverLogActivity;
use App\Models\Driver;
use App\Models\CheckPoint;
use Carbon\Carbon;

class DriverLogActivitySeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::all();
        $checkpoints = CheckPoint::all();

        $logActivities = [
            [
                'driver_id' => $drivers[0]->id ?? 1,
                'check_point_id' => $checkpoints[0]->id ?? 1,
                'status' => 'selesai',
                'check_In' => Carbon::now()->subHours(5)->format('Y-m-d H:i:s'),
                'check_Out' => Carbon::now()->subHours(3)->format('Y-m-d H:i:s'),
                'last_activity' => 'check_out',
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'driver_id' => $drivers[0]->id ?? 1,
                'check_point_id' => $checkpoints[3]->id ?? 4,
                'status' => 'selesai',
                'check_In' => Carbon::now()->subHours(2)->format('Y-m-d H:i:s'),
                'check_Out' => Carbon::now()->subHours(1)->format('Y-m-d H:i:s'),
                'last_activity' => 'check_out',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'driver_id' => $drivers[1]->id ?? 2,
                'check_point_id' => $checkpoints[1]->id ?? 2,
                'status' => 'on_location',
                'check_In' => Carbon::now()->subMinutes(45)->format('Y-m-d H:i:s'),
                'check_Out' => null,
                'last_activity' => 'check_in',
                'created_at' => Carbon::now()->subMinutes(45),
                'updated_at' => Carbon::now()->subMinutes(45),
            ],
            [
                'driver_id' => $drivers[2]->id ?? 3,
                'check_point_id' => $checkpoints[2]->id ?? 3,
                'status' => 'selesai',
                'check_In' => Carbon::now()->subHours(4)->format('Y-m-d H:i:s'),
                'check_Out' => Carbon::now()->subHours(2)->format('Y-m-d H:i:s'),
                'last_activity' => 'check_out',
                'created_at' => Carbon::now()->subHours(4),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'driver_id' => $drivers[3]->id ?? 4,
                'check_point_id' => $checkpoints[4]->id ?? 5,
                'status' => 'selesai',
                'check_In' => Carbon::now()->subHours(6)->format('Y-m-d H:i:s'),
                'check_Out' => Carbon::now()->subHours(5)->format('Y-m-d H:i:s'),
                'last_activity' => 'check_out',
                'created_at' => Carbon::now()->subHours(6),
                'updated_at' => Carbon::now()->subHours(5),
            ],
            [
                'driver_id' => $drivers[4]->id ?? 5,
                'check_point_id' => $checkpoints[5]->id ?? 6,
                'status' => 'on_location',
                'check_In' => Carbon::now()->subMinutes(30)->format('Y-m-d H:i:s'),
                'check_Out' => null,
                'last_activity' => 'check_in',
                'created_at' => Carbon::now()->subMinutes(30),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
            [
                'driver_id' => $drivers[5]->id ?? 6,
                'check_point_id' => $checkpoints[6]->id ?? 7,
                'status' => 'selesai',
                'check_In' => Carbon::now()->subHours(3)->format('Y-m-d H:i:s'),
                'check_Out' => Carbon::now()->subHours(1)->format('Y-m-d H:i:s'),
                'last_activity' => 'check_out',
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'driver_id' => $drivers[6]->id ?? 7,
                'check_point_id' => $checkpoints[0]->id ?? 1,
                'status' => 'on_location',
                'check_In' => Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s'),
                'check_Out' => null,
                'last_activity' => 'check_in',
                'created_at' => Carbon::now()->subMinutes(20),
                'updated_at' => Carbon::now()->subMinutes(20),
            ],
            [
                'driver_id' => $drivers[7]->id ?? 8,
                'check_point_id' => $checkpoints[9]->id ?? 10,
                'status' => 'selesai',
                'check_In' => Carbon::now()->subHours(7)->format('Y-m-d H:i:s'),
                'check_Out' => Carbon::now()->subHours(6)->format('Y-m-d H:i:s'),
                'last_activity' => 'check_out',
                'created_at' => Carbon::now()->subHours(7),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'driver_id' => $drivers[8]->id ?? 9,
                'check_point_id' => $checkpoints[3]->id ?? 4,
                'status' => 'on_location',
                'check_In' => Carbon::now()->subMinutes(15)->format('Y-m-d H:i:s'),
                'check_Out' => null,
                'last_activity' => 'check_in',
                'created_at' => Carbon::now()->subMinutes(15),
                'updated_at' => Carbon::now()->subMinutes(15),
            ],
        ];

        foreach ($logActivities as $logActivity) {
            DriverLogActivity::create($logActivity);
        }
    }
}
