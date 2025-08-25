<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'user_id' => User::where('role', 'customer')->first()->id,
            'restaurant_id' => Restaurant::first()->id,
            'total_price' => 1300.00,
            'status' => 'completed',
            'mode' => 'delivery',
        ]);
    }
}
