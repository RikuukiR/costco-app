<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'spec_code' => '00001',
                'name' => '特製ハンバーグ',
                'image_path' => null,
                'price' => 350.00,
                'target_weight' => 200.00,
                'category' => '肉',
            ],
            [
                'spec_code' => '00002',
                'name' => 'シーフードミックス',
                'image_path' => null,
                'price' => 420.00,
                'target_weight' => 500.00,
                'category' => '魚介',
            ],
            [
                'spec_code' => '00003',
                'name' => 'グリーンサラダ',
                'image_path' => null,
                'price' => 250.00,
                'target_weight' => 300.00,
                'category' => 'サラダ',
            ],
            [
                'spec_code' => '00004',
                'name' => 'ローストビーフ',
                'image_path' => null,
                'price' => 680.00,
                'target_weight' => 250.00,
                'category' => '肉',
            ],
            [
                'spec_code' => '00005',
                'name' => '季節のフルーツ盛り',
                'image_path' => null,
                'price' => 540.00,
                'target_weight' => 400.00,
                'category' => 'デザート',
            ],
        ];

        foreach ($products as $product) {
            if (!Product::where('spec_code', $product['spec_code'])->exists()) {
                Product::create($product);
            }
        }
    }
}
