<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OwnerOrdersController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id();

        // Only orders for restaurants owned by this user
        $orders = Order::whereHas('restaurant', function($q) use ($ownerId) {
            $q->where('owner_id', $ownerId);
        })->with(['user','restaurant'])->orderBy('created_at', 'desc')->get();

        return view('owner.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        // Only allow update if this order belongs to one of the owner's restaurants
        if ($order->restaurant->owner_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('owner.orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy(Order $order)
    {
        if ($order->restaurant->owner_id !== Auth::id()) {
            abort(403);
        }

        $order->delete();

        return redirect()->route('owner.orders.index')->with('success', 'Order deleted successfully!');
    }
}
