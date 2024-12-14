<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\TournamentRegistration;
use App\Models\PlayerRegistration;
class AdminPaymentHistoryController extends Controller
{
    public function index(){
        $payments = Payment::with(['user', 'tournament'])->get();
        return view('backend.payment-history.index', compact('payments'));
    }
}

