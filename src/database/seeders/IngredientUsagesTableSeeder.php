<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IngredientUsage;

class IngredientUsagesTableSeeder extends Seeder
{
    public function run(): void
    {
        IngredientUsage::create([
            'ingredient_id' => 1,
            'quantity_used' => 2.5,
            'used_at' => now()->subDays(1), // 1日前
        ]);

        IngredientUsage::create([
            'ingredient_id' => 2,
            'quantity_used' => 1.2,
            'used_at' => now()->subDays(2),
        ]);

        IngredientUsage::create([
            'ingredient_id' => 3,
            'quantity_used' => 5,
            'used_at' => now()->subDays(3),
        ]);

        IngredientUsage::create([
            'ingredient_id' => 4,
            'quantity_used' => 0.8,
            'used_at' => now()->subDays(4),
        ]);

        IngredientUsage::create([
            'ingredient_id' => 5,
            'quantity_used' => 3.4,
            'used_at' => now()->subDays(5),
        ]);
    }
}