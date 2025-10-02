<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;

class Cart extends Component
{
    public $cartItems = [];

    protected $listeners = [
        'add' => 'addToCart',
    ];

    public function mount()
    {
        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.cart');
    }

    // Load cart items from session
    public function loadCart()
    {
        $cart = Session::get('cart', []);
        $this->cartItems = collect($cart)->map(function($item) {
            $menu = Menu::find($item['menu_id']);
            return (object) [
                'id' => $item['menu_id'],
                'menu' => $menu,
                'quantity' => $item['quantity'],
            ];
        });
    }

    // Add item to cart
    public function addToCart($menuId)
    {
        $cart = Session::get('cart', []);
        $found = false;

        foreach ($cart as &$item) {
            if ($item['menu_id'] == $menuId) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'menu_id' => $menuId,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);
        $this->loadCart();
    }

    // Increase quantity
    public function increaseQuantity($menuId)
    {
        $cart = Session::get('cart', []);
        foreach ($cart as &$item) {
            if ($item['menu_id'] == $menuId) {
                $item['quantity']++;
                break;
            }
        }
        Session::put('cart', $cart);
        $this->loadCart();
    }

    // Decrease quantity
    public function decreaseQuantity($menuId)
    {
        $cart = Session::get('cart', []);
        foreach ($cart as &$item) {
            if ($item['menu_id'] == $menuId && $item['quantity'] > 1) {
                $item['quantity']--;
                break;
            }
        }
        Session::put('cart', $cart);
        $this->loadCart();
    }

    // Remove item
    public function remove($menuId)
    {
        $cart = Session::get('cart', []);
        $cart = array_filter($cart, fn($item) => $item['menu_id'] != $menuId);
        Session::put('cart', $cart);
        $this->loadCart();
    }
}
