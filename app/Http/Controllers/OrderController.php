<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use MongoDB\Client as MongoClient;
use MongoDB\BSON\UTCDateTime;


class OrderController extends Controller
{
    // Show checkout page
    public function checkout()
    {
        $cartItems = session('cart.items', []);
        $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = round($subtotal * 0.1);
        $deliveryFee = 200;
        $total = $subtotal + $tax + $deliveryFee;

        return view('orders.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'deliveryFee' => $deliveryFee,
            'total' => $total,
        ]);
    }

    // Show order confirmation page
    public function confirm(Request $request)
    {
        $cartItems = session('cart.items', []);
        $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = round($subtotal * 0.1);
        $deliveryFee = 200;
        $total = $subtotal + $tax + $deliveryFee;

        $customer = $request->only([
            'name', 'phone', 'email', 'address', 'city', 'postal_code', 
            'instructions', 'payment_method', 'delivery_method'
        ]);

        $now = Carbon::now();

        return view('orders.confirmation', [
            'orderItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'deliveryFee' => $deliveryFee,
            'total' => $total,
            'orderNumber' => rand(100000, 999999),
            'estimatedDelivery' => '30-40 mins',
            'estimatedArrival' => '30-40 mins',
            'orderDateTime' => $now->format('d M Y | g:i A'),
            'fulfillment' => $customer['delivery_method'] ?? 'Delivery',
            'deliveryAddress' => $customer['address'] ?? 'N/A',
            'instructions' => $customer['instructions'] ?? 'None',
            'cardLast4' => $customer['payment_method'] === 'card' ? '4242' : null,
            'cardExpiry' => $customer['payment_method'] === 'card' ? '09/27' : null,
            'customerName' => $customer['name'] ?? 'Guest',
            'customerPhone' => $customer['phone'] ?? 'N/A',
            'customerEmail' => $customer['email'] ?? 'N/A',
            'orderReceivedTime' => $now->format('g:i A'),
            'orderConfirmedTime' => $now->addMinutes(3)->format('g:i A'),
            'outForDeliveryEst' => $now->addMinutes(45)->format('g:i A'),
        ]);
    }

    // Save order to MySQL
    public function store(Request $request)
    {
        $cartItems = session('cart.items', []);
        $customer = $request->only(['name', 'phone', 'email', 'address', 'payment_method', 'delivery_method']);
        $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = round($subtotal * 0.1);
        $deliveryFee = 200;
        $total = $subtotal + $tax + $deliveryFee;

        // Save to MySQL
        $order = Order::create([
            'order_number' => rand(100000, 999999),
            'customer_name' => $customer['name'],
            'customer_email' => $customer['email'],
            'customer_phone' => $customer['phone'],
            'delivery_address' => $customer['address'],
            'fulfillment' => $customer['delivery_method'] ?? 'Delivery',
            'payment_method' => $customer['payment_method'] ?? 'cash',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'status' => 'received',
        ]);

        // Save order items in pivot table
        foreach ($cartItems as $item) {
            $order->items()->create([
                'menu_id' => $item['menu_id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Save to MongoDB
        $mongo = new MongoClient(env('MONGO_URI'));
        $mongoDB = $mongo->selectDatabase('swiftdine_db');
        $mongoOrders = $mongoDB->orders;
        $mongoOrders->insertOne([
            'order_number' => $order->order_number,
            'customer' => $customer,
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'status' => 'received',
            'created_at' => now()->toDateTimeString(),
        ]);

        // Clear cart
        session()->forget('cart.items');

        return redirect()->route('order.confirmation')->with([
            'orderNumber' => $order->order_number,
            'orderItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'deliveryFee' => $deliveryFee,
            'total' => $total,
        ]);
    }
}
