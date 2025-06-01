<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use Carbon\Carbon;

class SalesTableSeeder extends Seeder
{
    public function run(): void
    {
        Sale::create([
            'spec_code' => '00001',
            'sales_amount' => 25000.00,
            'sales_date' => Carbon::now()->subDays(5)->toDateString(),
        ]);

        Sale::create([
            'spec_code' => '00002',
            'sales_amount' => 30000.00,
            'sales_date' => Carbon::now()->subDays(4)->toDateString(),
        ]);

        Sale::create([
            'spec_code' => '00003',
            'sales_amount' => 18000.00,
            'sales_date' => Carbon::now()->subDays(3)->toDateString(),
        ]);

        Sale::create([
            'spec_code' => '00004',
            'sales_amount' => 22000.00,
            'sales_date' => Carbon::now()->subDays(2)->toDateString(),
        ]);

        Sale::create([
            'spec_code' => '00005',
            'sales_amount' => 27000.00,
            'sales_date' => Carbon::now()->subDay()->toDateString(),
        ]);
    }
}