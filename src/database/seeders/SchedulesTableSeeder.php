<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Carbon\Carbon;

class SchedulesTableSeeder extends Seeder
{
    public function run(): void
    {
        Schedule::create([
            'spec_code' => '00001',
            'scheduled_date' => Carbon::now()->addDays(1)->toDateString(),
            'scheduled_time' => '10:00:00',
            'quantity_cell' => 50,
        ]);

        Schedule::create([
            'spec_code' => '00002',
            'scheduled_date' => Carbon::now()->addDays(2)->toDateString(),
            'scheduled_time' => '14:00:00',
            'quantity_cell' => 30,
        ]);

        Schedule::create([
            'spec_code' => '00003',
            'scheduled_date' => Carbon::now()->addDays(3)->toDateString(),
            'scheduled_time' => '09:00:00',
            'quantity_cell' => 40,
        ]);

        Schedule::create([
            'spec_code' => '00004',
            'scheduled_date' => Carbon::now()->addDays(4)->toDateString(),
            'scheduled_time' => '13:00:00',
            'quantity_cell' => 60,
        ]);

        Schedule::create([
            'spec_code' => '00005',
            'scheduled_date' => Carbon::now()->addDays(5)->toDateString(),
            'scheduled_time' => '15:30:00',
            'quantity_cell' => 70,
        ]);
    }
}