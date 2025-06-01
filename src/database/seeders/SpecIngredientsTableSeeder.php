<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecIngredient;

class SpecIngredientsTableSeeder extends Seeder
{
    public function run(): void
    {
        SpecIngredient::create([
            'spec_code' => '00001',
            'ingredient_id' => 1,
            'quantity_per_unit' => 0.5,
            'unit' => 'kg',
        ]);

        SpecIngredient::create([
            'spec_code' => '00001',
            'ingredient_id' => 2,
            'quantity_per_unit' => 0.3,
            'unit' => 'kg',
        ]);

        SpecIngredient::create([
            'spec_code' => '00002',
            'ingredient_id' => 3,
            'quantity_per_unit' => 1.0,
            'unit' => '個',
        ]);

        SpecIngredient::create([
            'spec_code' => '00003',
            'ingredient_id' => 4,
            'quantity_per_unit' => 0.2,
            'unit' => 'kg',
        ]);

        SpecIngredient::create([
            'spec_code' => '00003',
            'ingredient_id' => 5,
            'quantity_per_unit' => 0.5,
            'unit' => 'パック',
        ]);
    }
}