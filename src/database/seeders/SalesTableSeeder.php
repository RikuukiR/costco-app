<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Product;
use Carbon\CarbonPeriod;

class SalesTableSeeder extends Seeder
{
    public function run(): void
    {
        // 既存のデータをクリア
        Sale::query()->delete();

        // 登録されている全ての商品を取得
        $products = Product::all();
        if ($products->isEmpty()) {
            // 商品がなければ処理を終了
            return;
        }

        // 挿入するデータを一時的に貯める配列
        $salesData = [];
        // 一度に挿入する件数（メモリ使用量を調整するため）
        $chunkSize = 500;

        // 過去5年〜未来1年の日付を1日ずつループ
        $period = CarbonPeriod::create(now()->subYears(5), now()->addYear());

        foreach ($period as $date) {
            // 各商品に対して、その日の売上データを生成
            foreach ($products as $product) {
                // Factoryを使ってデータの内容を生成するが、DBには保存しない
                $sale = Sale::factory()->make([
                    'spec_code' => $product->spec_code,
                    'sales_date' => $date->format('Y-m-d'),
                ]);
                // 配列に変換して追加
                $salesData[] = $sale->toArray();
            }

            // 一定数たまったら、まとめてDBに挿入する
            if (count($salesData) >= $chunkSize) {
                Sale::insert($salesData);
                // 配列をリセット
                $salesData = [];
            }
        }

        // ループ後に残ったデータがあれば、それも挿入する
        if (!empty($salesData)) {
            Sale::insert($salesData);
        }
    }
}