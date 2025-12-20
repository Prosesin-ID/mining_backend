<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Driver;
use Carbon\Carbon;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567801',
                'own_type' => 'PT/perusahaan',
                'nama_pemilik' => 'PT Tambang Jaya Abadi',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ahmad Hidayat',
                'email' => 'ahmad.hidayat@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567802',
                'own_type' => 'perseorangan',
                'nama_pemilik' => 'Ahmad Hidayat',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Suwandi',
                'email' => 'suwandi@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567803',
                'own_type' => 'PT/perusahaan',
                'nama_pemilik' => 'PT Karya Maju Sejahtera',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi.hartono@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567804',
                'own_type' => 'perseorangan',
                'nama_pemilik' => 'Rudi Hartono',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567805',
                'own_type' => 'PT/perusahaan',
                'nama_pemilik' => 'PT Mining Resources',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Agus Setiawan',
                'email' => 'agus.setiawan@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567806',
                'own_type' => 'perseorangan',
                'nama_pemilik' => 'Agus Setiawan',
                'status' => 'ditangguhkan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bambang Susilo',
                'email' => 'bambang.susilo@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567807',
                'own_type' => 'PT/perusahaan',
                'nama_pemilik' => 'PT Sumber Rezeki Bersama',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567808',
                'own_type' => 'perseorangan',
                'nama_pemilik' => 'Dedi Kurniawan',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567809',
                'own_type' => 'PT/perusahaan',
                'nama_pemilik' => 'PT Berkah Tambang Nusantara',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Faisal Rahman',
                'email' => 'faisal.rahman@mining.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567810',
                'own_type' => 'perseorangan',
                'nama_pemilik' => 'Faisal Rahman',
                'status' => 'inactive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}