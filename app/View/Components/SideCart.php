<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\CartItem; // Import the CartItem model

class SideCart extends Component
{
    public $cartItems;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cartItems = CartItem::where('user_id', auth()->id())->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side-cart', ['cartItems' => $this->cartItems]);
    }
}
