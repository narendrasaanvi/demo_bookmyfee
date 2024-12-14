<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\CartItem;

class CartCount extends Component
{
    public $cartCount;

    public function __construct()
    {
        if (auth()->check()) {
            $this->cartCount = CartItem::where('user_id', auth()->id())->count();
        } else {
            $this->cartCount = 0;
        }
    }

    public function render()
    {
        return view('components.cart-count');
    }
}
