<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function view()
    {
        $cartItems = Cart::all(); // For demo, or filter by user session/auth
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        // For website, you can handle adding via POST form
        // e.g., $request->menu_id, $request->quantity
        Cart::create($request->all());
        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request)
    {
        $item = Cart::findOrFail($request->id);
        $item->quantity = $request->quantity;
        $item->save();

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item removed!');
    }
}
