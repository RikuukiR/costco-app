<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        $specCode = optional(Product::inRandomOrder()->first())->spec_code ?? '00001';

        // 過去60日間のランダムな日付
        $date = $this->faker->dateTimeBetween('-60 days', 'now');
        $weekday = (int) $date->format('w'); // 0:日〜6:土

        // 曜日別目標金額（ダミーデータ用）
        $goals = [
            0 => 4800000, // 日
            1 => 1800000, // 月
            2 => 1800000, // 火
            3 => 2000000, // 水
            4 => 2500000, // 木
            5 => 2800000, // 金
            6 => 4800000, // 土
        ];
        $goal = $goals[$weekday];

        // 目標金額の70〜100%でランダムに売上金額を生成
        $salesAmount = $this->faker->numberBetween((int)($goal * 0.8), (int)($goal * 1.05));

        return [
            'spec_code' => $specCode,
            'sales_amount' => $salesAmount,
            'sales_date' => $date->format('Y-m-d'),
        ];
    }
}
