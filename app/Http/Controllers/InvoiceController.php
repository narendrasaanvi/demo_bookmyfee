<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use App\Models\Payment;

class InvoiceController extends Controller
{
    public function index()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access your invoices.');
        }

        $userId = Auth::user()->id;

        // Fetch invoices for the authenticated user
        $invoices = Payment::where('user_id', $userId)->where('payment_status','approve')->get();

        // Pass invoices to the view
        return view('frontend.invoice.index', compact('invoices'));
    }
}
