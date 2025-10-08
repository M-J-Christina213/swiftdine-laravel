<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OwnerOrdersController extends Controller
{
    /**
     * Display all orders (no filtering by restaurant for now).
     */
    public function index()
    {
        // Get all orders with latest first
        $orders = Order::orderBy('created_at', 'desc')->get();

        return view('owner.orders.index', compact('orders'));
    }

    /**
     * Update the status of an order.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('owner.orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Delete an order.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('owner.orders.index')->with('success', 'Order deleted successfully!');
    }
}
