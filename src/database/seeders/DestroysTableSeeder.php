<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destroy;
use Carbon\Carbon;

class DestroysTableSeeder extends Seeder
{
    public function run(): void
    {
        Destroy::create([
            'spec_code' => '00001',
            'destroyed_weight' => 5.0,
            'destroy_date' => Carbon::now()->subDays(5)->toDateString(),
        ]);

        Destroy::create([
            'spec_code' => '00002',
            'destroyed_weight' => 3.2,
            'destroy_date' => Carbon::now()->subDays(4)->toDateString(),
        ]);

        Destroy::create([
            'spec_code' => '00003',
            'destroyed_weight' => 4.5,
            'destroy_date' => Carbon::now()->subDays(3)->toDateString(),
        ]);

        Destroy::create([
            'spec_code' => '00004',
            'destroyed_weight' => 2.8,
            'destroy_date' => Carbon::now()->subDays(2)->toDateString(),
        ]);

        Destroy::create([
            'spec_code' => '00005',
            'destroyed_weight' => 6.0,
            'destroy_date' => Carbon::now()->subDay()->toDateString(),
        ]);
    }
}
