<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitTruck;
use App\Models\Driver;
use Carbon\Carbon;

class UnitTruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua driver yang sudah dibuat
        $drivers = Driver::all();

        $unitTrucks = [
            [
                'no_unit' => 'DT-001',
                'plate_number' => 'B 1234 XYZ',
                'bank_id' => 1, // Sesuaikan dengan ID bank yang ada
                'driver_id' => $drivers[0]->id ?? 1,
                'bank_account_number' => '1234567890',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-002',
                'plate_number' => 'B 2345 ABC',
                'bank_id' => 1,
                'driver_id' => $drivers[1]->id ?? 2,
                'bank_account_number' => '1234567891',
                'status' => 'maintenance',
                'reason_maintenance' => 'Routine check-up',
                'maintenance_start_time' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-003',
                'plate_number' => 'B 3456 DEF',
                'bank_id' => 2,
                'driver_id' => $drivers[2]->id ?? 3,
                'bank_account_number' => '2234567890',
                'status' => 'maintenance',
                'reason_maintenance' => 'Engine repair',
                'maintenance_start_time' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-004',
                'plate_number' => 'B 4567 GHI',
                'bank_id' => 2,
                'driver_id' => $drivers[3]->id ?? 4,
                'bank_account_number' => '2234567891',
                'status' => 'inactive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-005',
                'plate_number' => 'B 5678 JKL',
                'bank_id' => 3,
                'driver_id' => $drivers[4]->id ?? 5,
                'bank_account_number' => '3234567890',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-006',
                'plate_number' => 'B 6789 MNO',
                'bank_id' => 3,
                'driver_id' => $drivers[5]->id ?? 6,
                'bank_account_number' => '3234567891',
                'status' => 'maintenance',
                'reason_maintenance' => 'Tire replacement',
                'maintenance_start_time' => Carbon::now()->subDay()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-007',
                'plate_number' => 'B 7890 PQR',
                'bank_id' => 1,
                'driver_id' => $drivers[6]->id ?? 7,
                'bank_account_number' => '1234567892',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-008',
                'plate_number' => 'B 8901 STU',
                'bank_id' => 2,
                'driver_id' => $drivers[7]->id ?? 8,
                'bank_account_number' => '2234567892',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-009',
                'plate_number' => 'B 9012 VWX',
                'bank_id' => 1,
                'driver_id' => $drivers[8]->id ?? 9,
                'bank_account_number' => '1234567893',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'no_unit' => 'DT-010',
                'plate_number' => 'B 0123 YZA',
                'bank_id' => 3,
                'driver_id' => $drivers[9]->id ?? 10,
                'bank_account_number' => '3234567892',
                'status' => 'maintenance',
                'reason_maintenance' => 'Brake system check',
                'maintenance_start_time' => Carbon::now()->subHours(10)->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($unitTrucks as $unitTruck) {
            UnitTruck::create($unitTruck);
        }
    }
}