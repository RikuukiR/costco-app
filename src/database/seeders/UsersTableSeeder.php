<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
    }
}
