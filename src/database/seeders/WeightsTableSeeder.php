<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Weight;
use Carbon\Carbon;

class WeightsTableSeeder extends Seeder
{
    public function run(): void
    {
        Weight::create([
            'spec_code' => '00001',
            'destroyed_weight' => 1.2,
            'actual_weight_1' => 5.0,
            'actual_weight_2' => 5.1,
            'actual_weight_3' => 4.9,
            'actual_weight_4' => null,
            'actual_weight_5' => null,
        ]);

        Weight::create([
            'spec_code' => '00002',
            'destroyed_weight' => 0.8,
            'actual_weight_1' => 4.5,
            'actual_weight_2' => 4.6,
            'actual_weight_3' => 4.4,
            'actual_weight_4' => null,
            'actual_weight_5' => null,
        ]);

        Weight::create([
            'spec_code' => '00003',
            'destroyed_weight' => 1.0,
            'actual_weight_1' => 6.0,
            'actual_weight_2' => 6.1,
            'actual_weight_3' => 5.9,
            'actual_weight_4' => null,
            'actual_weight_5' => null,
        ]);
    }
}
