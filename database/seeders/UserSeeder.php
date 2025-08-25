<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Customers
        User::create([
            'name' => 'Nadeesha Perera',
            'email' => 'nadeesha@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Tharushi Silva',
            'email' => 'tharushi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Restaurant owners
        User::create([
            'name' => 'Kamal Fernando',
            'email' => 'kamal@example.com',
            'password' => Hash::make('password'),
            'role' => 'restaurant_owner',
        ]);

        User::create([
            'name' => 'Shanika Jayawardena',
            'email' => 'shanika@example.com',
            'password' => Hash::make('password'),
            'role' => 'restaurant_owner',
        ]);

        User::create([
            'name' => 'Ruwan Perera',
            'email' => 'ruwan@example.com',
            'password' => Hash::make('password'),
            'role' => 'restaurant_owner',
        ]);

        // Admin
        User::create([
            'name' => 'Christina',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
