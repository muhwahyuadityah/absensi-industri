<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shifts = [
            [
                'name' => 'Pagi',
                'start_time' => '07:00:00',
                'end_time' => '19:00:00',
                'is_night_shift' => false,
            ],
            [
                'name' => 'Malam',
                'start_time' => '19:00:00',
                'end_time' => '07:00:00',
                'is_night_shift' => true, // lintas hari
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::create($shift);
        }
    }
}