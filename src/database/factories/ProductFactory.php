<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $productNames = [
            '特製ハンバーグ', 'シーフードミックス', 'グリーンサラダ', 'ローストビーフ', '季節のフルーツ盛り',
            'チキンシーザーサラダ', 'サーモンポキ', 'マルゲリータピザ', 'プルコギビーフ', 'ハイローラー（BLT）'
        ];
        $categories = ['肉', '魚介', 'サラダ', 'デリ', 'デザート'];

        return [
            'spec_code' => $this->faker->unique()->numerify('#####'),
            'name' => $this->faker->randomElement($productNames),
            'image_path' => null,
            'price' => $this->faker->numberBetween(300, 700) * 10,
            'target_weight' => $this->faker->numberBetween(200, 600),
            'category' => $this->faker->randomElement($categories),
        ];
    }
}
