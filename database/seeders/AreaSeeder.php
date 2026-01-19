<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 9 Area IMIP yang TETAP (tidak bisa diubah user)
        $areas = [
            ['name' => 'IMIP 1', 'code' => 'IMIP1', 'is_active' => true],
            ['name' => 'IMIP 2', 'code' => 'IMIP2', 'is_active' => true],
            ['name' => 'IMIP 3', 'code' => 'IMIP3', 'is_active' => true],
            ['name' => 'IMIP 4', 'code' => 'IMIP4', 'is_active' => true],
            ['name' => 'IMIP 5', 'code' => 'IMIP5', 'is_active' => true],
            ['name' => 'IMIP 6', 'code' => 'IMIP6', 'is_active' => true],
            ['name' => 'IMIP 7', 'code' => 'IMIP7', 'is_active' => true],
            ['name' => 'IMIP 8', 'code' => 'IMIP8', 'is_active' => true],
            ['name' => 'IMIP 9', 'code' => 'IMIP9', 'is_active' => true],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}