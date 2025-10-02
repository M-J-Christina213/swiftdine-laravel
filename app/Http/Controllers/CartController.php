<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    // Show full cart page (optional)
    public function view()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('menu')->get();
        return view('cart.index', compact('cartItems'));
    }

    // Add item to cart via AJAX
    public function add(Request $request, Menu $menu)
    {
        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('menu_id', $menu->id)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'menu_id' => $menu->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
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
        $cartItems = Cart::with('menu')->where('user_id', auth()->id())->get();
        return view('cart.summary', compact('cartItems'));
    }

}
