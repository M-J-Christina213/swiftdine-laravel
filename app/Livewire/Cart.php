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

    public function render()
    {
        return view('livewire.cart');
    }
}
