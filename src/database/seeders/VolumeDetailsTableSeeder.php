<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VolumeDetail;

class VolumeDetailsTableSeeder extends Seeder
{
    public function run(): void
    {
        VolumeDetail::create([
            'volume_id' => 1,
            'cell_number' => 1,
            'actual_weight' => 10.5,
            'calculated_price' => 3500.00,
        ]);

        VolumeDetail::create([
            'volume_id' => 1,
            'cell_number' => 2,
            'actual_weight' => 11.0,
            'calculated_price' => 3600.00,
        ]);

        VolumeDetail::create([
            'volume_id' => 2,
            'cell_number' => 1,
            'actual_weight' => 8.0,
            'calculated_price' => 2800.00,
        ]);

        VolumeDetail::create([
            'volume_id' => 3,
            'cell_number' => 1,
            'actual_weight' => 15.2,
            'calculated_price' => 5000.00,
        ]);

        VolumeDetail::create([
            'volume_id' => 4,
            'cell_number' => 1,
            'actual_weight' => 12.0,
            'calculated_price' => 4200.00,
        ]);
    }
}
