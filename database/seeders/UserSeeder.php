<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. ADMIN (NON-AREA)
        $admin = User::create([
            'name' => 'Admin System',
            'email' => 'admin@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'NON_AREA',
            'area_id' => null,
            'shift_id' => null,
            'department' => 'IT',
            'position' => 'System Administrator',
            'employee_number' => 'ADM001',
            'is_active' => true,
        ]);
        $admin->assignRole('Admin');

        // 2. MANAGER (NON-AREA)
        $manager = User::create([
            'name' => 'Manager Produksi',
            'email' => 'manager@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'NON_AREA',
            'area_id' => null,
            'shift_id' => null,
            'department' => 'Produksi',
            'position' => 'Production Manager',
            'employee_number' => 'MGR001',
            'is_active' => true,
        ]);
        $manager->assignRole('Manager');

        // 3. PENGAWAS AREA IMIP 1 (SHIFT PAGI)
        $pengawas1 = User::create([
            'name' => 'Pengawas IMIP 1',
            'email' => 'pengawas1@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'AREA_BASED',
            'area_id' => 1, // IMIP 1
            'shift_id' => 1, // Shift Pagi
            'department' => 'Produksi',
            'position' => 'Supervisor',
            'employee_number' => 'SPV001',
            'is_active' => true,
        ]);
        $pengawas1->assignRole('Pengawas');

        // 4. PENGAWAS AREA IMIP 2 (SHIFT MALAM)
        $pengawas2 = User::create([
            'name' => 'Pengawas IMIP 2',
            'email' => 'pengawas2@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'AREA_BASED',
            'area_id' => 2, // IMIP 2
            'shift_id' => 2, // Shift Malam
            'department' => 'Produksi',
            'position' => 'Supervisor',
            'employee_number' => 'SPV002',
            'is_active' => true,
        ]);
        $pengawas2->assignRole('Pengawas');

        // 5. KARYAWAN AREA IMIP 1 (SHIFT PAGI)
        $karyawan1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'AREA_BASED',
            'area_id' => 1, // IMIP 1
            'shift_id' => 1, // Shift Pagi
            'department' => 'Produksi',
            'position' => 'Operator',
            'employee_number' => 'EMP001',
            'is_active' => true,
        ]);
        $karyawan1->assignRole('Karyawan');

        // 6. KARYAWAN AREA IMIP 1 (SHIFT PAGI)
        $karyawan2 = User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'AREA_BASED',
            'area_id' => 1, // IMIP 1
            'shift_id' => 1, // Shift Pagi
            'department' => 'Produksi',
            'position' => 'Operator',
            'employee_number' => 'EMP002',
            'is_active' => true,
        ]);
        $karyawan2->assignRole('Karyawan');

        // 7. KARYAWAN AREA IMIP 1 (SHIFT PAGI)
        $karyawan3 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'AREA_BASED',
            'area_id' => 1, // IMIP 1
            'shift_id' => 1, // Shift Pagi
            'department' => 'Produksi',
            'position' => 'Operator',
            'employee_number' => 'EMP003',
            'is_active' => true,
        ]);
        $karyawan3->assignRole('Karyawan');

        // 8. KARYAWAN NON-AREA (SUPIR BUS)
        $supir = User::create([
            'name' => 'Joko Suprapto',
            'email' => 'joko@imip.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'employee_type' => 'NON_AREA',
            'area_id' => null, // tidak terikat area
            'shift_id' => 1, // Shift Pagi (untuk contoh)
            'department' => 'Transportasi',
            'position' => 'Supir Bus Karyawan',
            'employee_number' => 'DRV001',
            'is_active' => true,
        ]);
        $supir->assignRole('Karyawan');
    }
}