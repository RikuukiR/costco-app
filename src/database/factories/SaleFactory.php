<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()    //view重視の実現性のない、開発のためのデータ
    {
        // 過去5年間〜未来1年間のランダムなデータを生成
        $date = $this->faker->dateTimeBetween('-5 years', '+1 years');
        $weekday = (int) $date->format('w');

        // 曜日別の売上基準額
        $goals = [
            0 => 4800000, // 日
            1 => 1800000, // 月
            2 => 1800000, // 火
            3 => 2000000, // 水
            4 => 2500000, // 木
            5 => 2800000, // 金
            6 => 4800000, // 土
        ];
        $baseSales = $goals[$weekday] / 20; // 1商品あたりの売上基準額を調整（テストデータの質の向上のため）

        // 基準額の80%〜120%でランダムに売上金額を生成（テストデータの質の向上のため）
        $salesAmount = $this->faker->numberBetween((int)($baseSales * 0.8), (int)($baseSales * 1.2));

        return [
            // spec_codeはSeeder側で指定するため、ここでは設定しない
            'sales_amount' => $salesAmount,
            'sales_date' => $date->format('Y-m-d'),
        ];
    }
}
