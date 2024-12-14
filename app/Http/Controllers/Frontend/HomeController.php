<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\State;
use App\Models\Prize;
use App\Models\Tournament;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $prizes = Prize::all();
        $tournaments = Tournament::take(8)->get();
        $tournamentslists = Tournament::take(8)->get();
        $upcommingtournament = Tournament::orderBy('start_date', 'asc')->where('start_date', '>=', now())->first();

        // Get state IDs from the tournaments
        $stateIds = $tournaments->pluck('state_id')->unique();

        // Fetch states where the state_id exists in the tournament state_id
        $states = State::whereIn('id', $stateIds)->get();

        return view('frontend.home', compact('tournaments', 'upcommingtournament', 'tournamentslists', 'states', 'prizes', 'categories'));
    }

    public function about(){
        return view('frontend.about');
    }
    public function contact(){
        return view('frontend.contact');
    }
}
