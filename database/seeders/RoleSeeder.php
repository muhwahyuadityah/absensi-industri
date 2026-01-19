<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 4 role utama sistem
        $roles = [
            'Admin',
            'Manager',
            'Pengawas',
            'Karyawan',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}