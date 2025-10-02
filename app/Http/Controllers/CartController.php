<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show full cart page (optional)
    public function view()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('menu')->get();
        return view('cart.index', compact('cartItems'));
    }

    // Add item to cart via AJAX
    public function add(Request $request)
    {
        $menuId = $request->menu_id;
        $quantity = $request->quantity;

        if (!$menuId || !$quantity) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data']);
        }

        if (!auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please log in to add items to your cart 😊'
            ]);
        }

        $userId = auth()->id();

        // Update quantity if exists, else create
        $cart = Cart::where('user_id', $userId)->where('menu_id', $menuId)->first();

        if($cart) {
            $cart->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => $userId,
                'menu_id' => $menuId,
                'quantity' => $quantity
            ]);
        }


        return response()->json(['status' => 'success']);
    }

   

    public function update(Request $request)
    {
        $item = Cart::findOrFail($request->id);

        // Determine action
        $action = $request->action ?? 'increase'; // default to increase if not provided

        if($action === 'increase') {
            $item->quantity += 1;
        } elseif($action === 'decrease') {
            $item->quantity = max(1, $item->quantity - 1); // don't allow <1
        } elseif($action === 'set') {
            $item->quantity = max(1, (int)$request->quantity);
        }

        $item->save();

        if($request->ajax()) {
            // Return updated summary
            $cartItems = Cart::where('user_id', auth()->id())->with('menu')->get();
            return view('cart.summary', compact('cartItems'));
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    // Remove item (optional)
    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item removed!');
    }

    // Cart summary for sidebar (AJAX)
    public function summary()
    {
        if (!auth()->check()) {
            return '<p>Please log in to see your cart 😊</p>';
        }

        $cartItems = Cart::where('user_id', auth()->id())->with('menu')->get();

        return view('cart.summary', compact('cartItems'));
    }
}
