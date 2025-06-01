<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientsTableSeeder extends Seeder
{
    public function run(): void
    {
        Ingredient::create([
            'name' => '牛ひき肉',
            'category' => '肉',
            'product_spec_code' => '00001',
            'stock_quantity' => 10.5,
            'unit' => 'kg',
            'status' => 'in_stock',
        ]);

        Ingredient::create([
            'name' => 'エビ',
            'category' => '魚介',
            'product_spec_code' => '00002',
            'stock_quantity' => 20.0,
            'unit' => 'kg',
            'status' => 'in_stock',
        ]);

        Ingredient::create([
            'name' => 'レタス',
            'category' => '野菜',
            'product_spec_code' => '00003',
            'stock_quantity' => 50.0,
            'unit' => '個',
            'status' => 'in_stock',
        ]);

        Ingredient::create([
            'name' => 'ローストビーフ用肉',
            'category' => '肉',
            'product_spec_code' => '00004',
            'stock_quantity' => 8.0,
            'unit' => 'kg',
            'status' => 'low_stock',
        ]);

        Ingredient::create([
            'name' => 'ミックスフルーツ',
            'category' => 'フルーツ',
            'product_spec_code' => '00005',
            'stock_quantity' => 15.0,
            'unit' => 'パック',
            'status' => 'in_stock',
        ]);
    }
}
