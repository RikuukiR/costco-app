<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        // 既存のデータをクリア
        Product::query()->delete();

        // 部署全体売上用のダミー商品を追加
        Product::create([
            'spec_code' => '00000',
            'name' => '部署全体売上',
            'image_path' => null,
            'price' => 0,
            'target_weight' => 0,
            'category' => '集計用',
        ]);

        // Factoryを使ってダミー商品を20個生成
        Product::factory()->count(20)->create();
    }
}
