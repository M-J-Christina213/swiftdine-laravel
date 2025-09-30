<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;

class OwnerOrdersController extends Controller
{
    // Show all orders
    public function index()
    {
        // Eager load user and restaurant
        $orders = Order::with(['user', 'restaurant'])->orderBy('created_at', 'desc')->get();
        return view('owner.orders.index', compact('orders'));
    }

    // Update order status
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('owner.orders')->with('success', 'Order updated successfully.');
    }

    // Delete order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('owner.orders')->with('success', 'Order deleted successfully.');
    }
}
