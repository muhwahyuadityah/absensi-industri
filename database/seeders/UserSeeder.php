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
        // Buat user Admin untuk testing
        $admin = User::create([
            'name' => 'Admin System',
            'email' => 'admin@imip.com',
            'password' => Hash::make('password'),
            'employee_type' => 'NON_AREA',
            'department' => 'IT',
            'position' => 'System Administrator',
            'employee_number' => 'ADM001',
            'is_active' => true,
        ]);

        // Assign role Admin
        $admin->assignRole('Admin');
    }
}