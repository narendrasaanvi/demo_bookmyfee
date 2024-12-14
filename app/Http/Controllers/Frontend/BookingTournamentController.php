<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayerRegistration;
use App\Models\TournamentRegistration;
use Illuminate\Support\Str;  // Add Str facade for better order_id generation

class BookingTournamentController extends Controller
{
    public function index(Request $request, $slug)
    {
        $userid = Auth::id();
        $tournament = Tournament::with("category")->where("slug", $slug)->firstOrFail();
        $categoryIds = explode(',', $tournament->category_id); // Split category IDs
        $category = Category::whereIn('id', $categoryIds)->get();
        $players = PlayerRegistration::where('user_id', $userid)->get();

        return view("frontend.booking.index", compact("category", "tournament", "players", "userid"));
    }
    public function registerPlayers(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'player_id' => 'required|array|min:1',
            'category' => 'required|array|min:1',
            'total_amount' => 'required|numeric',
            'payment_mode' => 'required|in:Online,Offline',
            'online_amount' => 'required_if:payment_mode,Online|numeric',
        ], [
            'player_id.required' => 'Select Player to Register',
        ]);

        // Generate a unique order ID using Str::random for better security
        $orderId = Str::random(10); // You can adjust the length here

        try {
            // Register each player in the tournament
            foreach ($request->player_id as $index => $playerId) {
                // Ensure that the category matches the player by using the same index
                $category = isset($request->category[$index]) ? $request->category[$index] : null;

                if ($category) {
                    TournamentRegistration::create([
                        'tournament_id' => $request->tournament_id,
                        'player_id' => $playerId,
                        'category' => $category,  // Insert the correct category for each player
                        'amount' => $request->total_amount,
                        'order_id' => $orderId

                    ]);
                }
            }

            // Handle payment based on the selected payment mode
            if ($request->payment_mode == 'Online') {
                // Create payment record for online payment
                Payment::create([
                    'order_id' => $orderId,
                    'tournament_id' => $request->tournament_id,
                    'amount' => $request->online_amount,
                    'user_id' => Auth::user()->id,
                    'payment_status' => 'pending', // Mark as pending until payment succeeds
                    'payment_mode' => 'Online', // Mark as pending until payment succeeds
                ]);

                // Redirect to the payment page
                return redirect()->route('payment.index', ['orderId' => $orderId]);
            }

            if ($request->payment_mode == 'Offline') {
                Payment::create([
                    'order_id' => $orderId,
                    'tournament_id' => $request->tournament_id,
                    'amount' => $request->online_amount,
                    'user_id' => Auth::user()->id,
                    'payment_status' => 'pending',
                    'payment_mode' => 'Offline', // Mark as pending until payment succeeds
                ]);
                return redirect()->route('thanks', ['orderId' => $orderId]);
            }

        } catch (\Exception $e) {
            // Handle any errors during registration
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function thanks($orderId)
    {
        return view('frontend.payment.thanks', compact('orderId'));
    }
}
