<?php

namespace Database\Seeders;

use App\Models\HseStat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HseStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HseStat::create([
            'safe_working_days' => 0,
            'accident_count' => 0,
            'start_date' => now(),
            'last_safe_working_day_update' => now(),
        ]);
    }
}
