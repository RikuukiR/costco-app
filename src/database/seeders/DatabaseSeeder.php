<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('login_id', 'admin')->exists()) {
            User::create([
                'login_id' => 'admin',
                'password' => Hash::make('password123'),
                'is_manager' => true,
            ]);
        }

        $this->call([
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            IngredientsTableSeeder::class,
            RecipeStepsTableSeeder::class,
            IngredientUsagesTableSeeder::class,
            SpecIngredientsTableSeeder::class,
            SalesTableSeeder::class,
            DestroysTableSeeder::class,
            WeightsTableSeeder::class,
            SchedulesTableSeeder::class,
            VolumesTableSeeder::class,
            VolumeDetailsTableSeeder::class,
            SalesForecastsTableSeeder::class,
        ]);
    }
}
