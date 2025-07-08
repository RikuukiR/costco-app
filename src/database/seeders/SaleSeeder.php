<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Sale::factory()->count(100)->create();
    }
}
