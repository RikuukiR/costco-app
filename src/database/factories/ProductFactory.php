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
        return [
            'spec_code' => Str::padLeft(rand(1, 99999), 5, '0'),
            'name' => $this->faker->word,
            'target_weight' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
