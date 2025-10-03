<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartSummary extends Component
{
    public $cartItems;
    public $appliedPromo = null;
    
    public $promoCodes = [
        'ABC123' => 0.1,   // 10%
        'SAVE20' => 0.2,   // 20%
        'LUCKY40' => 0.4,  // 40%
        'SUPER80' => 0.8,  // 80%
        'SWIFT10' => 0.5,  // 50%
    ];

    public $deliveryFee = 300; // default
    public $discount = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Auth::check() 
            ? CartItem::with('menu')->where('user_id', Auth::id())->get()
            : collect();
    }

    public function getSubtotalProperty()
    {
        return $this->cartItems->sum(fn($item) => $item->menu->price * $item->quantity);
    }

    public function getTaxProperty()
    {
        return $this->subtotal * 0.1;
    }

    public function getTotalProperty()
    {
        $discount = $this->appliedPromo ? $this->subtotal * $this->promoCodes[$this->appliedPromo] : 0;
        return $this->subtotal + $this->tax + $this->deliveryFee - $discount;
    }

    public function applyPromo($code)
    {
        if (isset($this->promoCodes[$code])) {
            $this->appliedPromo = $code;
        } else {
            $this->appliedPromo = null;
        }
    }

    public function render()
    {
        $this->discount = $this->appliedPromo ? $this->subtotal * $this->promoCodes[$this->appliedPromo] : 0;
        return view('livewire.cart-summary');
    }
}
