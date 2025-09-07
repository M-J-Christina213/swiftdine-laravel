<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        // show checkout page
        return view('orders.checkout');
    }

    public function store(Request $request)
    {
        // process order from cart
        Order::create($request->all());
        return redirect()->route('home')->with('success', 'Order placed!');
    }

    public function track()
{
    return view('orders.track'); 
}
}
