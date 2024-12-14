<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function orderView()
    {
        $user = Auth::user()->id;
        $orders = Order::where('user_id', $user)->get();

    
        // Return the view with all the grouped order data
        return view('frontend.orders', compact('orders'));
    }

   public function orderpayment(Request $request){

   }
}