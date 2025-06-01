<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecipeStep;

class RecipeStepsTableSeeder extends Seeder
{
    public function run(): void
    {
        RecipeStep::create([
            'spec_code' => '00001',
            'step_order' => 1,
            'step_description' => '材料を全て用意する',
            'step_image_path' => null,
        ]);

        RecipeStep::create([
            'spec_code' => '00001',
            'step_order' => 2,
            'step_description' => '具材を切る',
            'step_image_path' => null,
        ]);

        RecipeStep::create([
            'spec_code' => '00001',
            'step_order' => 3,
            'step_description' => '炒める',
            'step_image_path' => null,
        ]);

        RecipeStep::create([
            'spec_code' => '00002',
            'step_order' => 1,
            'step_description' => 'エビを洗う',
            'step_image_path' => null,
        ]);

        RecipeStep::create([
            'spec_code' => '00002',
            'step_order' => 2,
            'step_description' => '塩ゆでする',
            'step_image_path' => null,
        ]);
    }
}