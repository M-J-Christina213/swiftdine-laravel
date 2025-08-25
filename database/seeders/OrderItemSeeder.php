<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Menu;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::first();

        OrderItem::create([
            'order_id' => $order->id,
            'name' => Menu::first()->name,
            'price' => Menu::first()->price,
            'quantity' => 2,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'name' => Menu::skip(1)->first()->name,
            'price' => Menu::skip(1)->first()->price,
            'quantity' => 1,
        ]);
    }
}
