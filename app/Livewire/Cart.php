<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $cartItems = [];

    protected function getListeners(): array
    {
        return [
            'add-to-cart' => 'addFromEvent',
        ];
    }

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        if (Auth::check()) {
            $this->cartItems = CartItem::with('menu')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $this->cartItems = collect();
        }
    }

    public function addFromEvent($eventData)
    {
        $menuId = $eventData['menuId'] ?? null;
        if (!$menuId || !Auth::check()) return;

        $item = CartItem::where('menu_id', $menuId)
            ->where('user_id', Auth::id())
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'menu_id' => $menuId,
                'quantity' => 1,
                'user_id' => Auth::id(),
            ]);
        }

        $this->loadCart();
    }

    public function remove($itemId)
    {
        CartItem::where('id', $itemId)->where('user_id', Auth::id())->delete();
        $this->loadCart();
    }

    public function increment($itemId)
    {
        $item = CartItem::where('id', $itemId)->where('user_id', Auth::id())->first();
        if ($item) {
            $item->increment('quantity');
            $this->loadCart();
        }
    }

    public function decrement($itemId)
    {
        $item = CartItem::where('id', $itemId)->where('user_id', Auth::id())->first();
        if ($item && $item->quantity > 1) {
            $item->decrement('quantity');
            $this->loadCart();
        }
    }

    // **New computed properties**
    public function getSubtotalProperty()
    {
        return $this->cartItems->sum(fn($item) => $item->menu->price * $item->quantity);
    }

    public function getTaxProperty()
    {
        return $this->subtotal * 0.1; // 10% tax, change as needed
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax;
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
