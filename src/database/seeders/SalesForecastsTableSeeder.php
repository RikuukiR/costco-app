<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesForecast;
use Carbon\Carbon;

class SalesForecastsTableSeeder extends Seeder
{
    public function run(): void
    {
        $dates = [
            Carbon::now()->toDateString(),
            Carbon::now()->addDay()->toDateString(),
            Carbon::now()->addDays(2)->toDateString(),
            Carbon::now()->addDays(3)->toDateString(),
            Carbon::now()->addDays(4)->toDateString(),
        ];

        foreach ($dates as $index => $date) {
            SalesForecast::create([
                'date' => $date,
                'product_name' => '商品名' . ($index + 1),
                'forecast_value' => rand(10000, 50000) / 100, // 100.00〜500.00 の範囲でランダム
            ]);
        }
    }
}
