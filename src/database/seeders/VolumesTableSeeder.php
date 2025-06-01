<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Volume;
use Carbon\Carbon;

class VolumesTableSeeder extends Seeder
{
    public function run(): void
    {
        Volume::create([
            'spec_code' => '00001',
            'order_date' => Carbon::now()->subDays(5)->toDateString(),
            'supplier_name' => '仕入先A',
        ]);

        Volume::create([
            'spec_code' => '00002',
            'order_date' => Carbon::now()->subDays(4)->toDateString(),
            'supplier_name' => '仕入先B',
        ]);

        Volume::create([
            'spec_code' => '00003',
            'order_date' => Carbon::now()->subDays(3)->toDateString(),
            'supplier_name' => '仕入先C',
        ]);

        Volume::create([
            'spec_code' => '00004',
            'order_date' => Carbon::now()->subDays(2)->toDateString(),
            'supplier_name' => '仕入先D',
        ]);

        Volume::create([
            'spec_code' => '00005',
            'order_date' => Carbon::now()->subDay()->toDateString(),
            'supplier_name' => '仕入先E',
        ]);
    }
}
