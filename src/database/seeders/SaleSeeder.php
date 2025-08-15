<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run()
    {
        // 曜日ごとの目標金額（部署全体）
        $goals = [
            0 => 4800000, // 日
            1 => 1800000, // 月
            2 => 1800000, // 火
            3 => 2000000, // 水
            4 => 2500000, // 木
            5 => 2800000, // 金
            6 => 4800000, // 土
        ];

        // 過去30日分の売上を生成
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weekday = $date->dayOfWeek; // 0:日〜6:土
            $goal = $goals[$weekday];

            $amount = rand((int)($goal * 0.8), (int)($goal * 1.05));

            Sale::create([
                'spec_code' => '00000', // ダミー商品コード
                'sales_amount' => $amount,
                'sales_date' => $date->format('Y-m-d'),
            ]);
        }
    }
}
