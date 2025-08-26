<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function view(Request $request)
{
    $cartItems = auth()->user()->cart()->with('menuItem')->get();
    return response()->json($cartItems);
}

    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = auth()->user()->cart()->updateOrCreate(
            ['menu_item_id' => $request->menu_item_id],
            ['quantity' => $request->quantity]
        );

        return response()->json($cartItem);
    }

}
