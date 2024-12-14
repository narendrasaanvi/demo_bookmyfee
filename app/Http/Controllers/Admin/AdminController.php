<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlayerRegistration;
use App\Models\User;
use App\Models\Tournament;

class AdminController extends Controller
{
    public function index(){
        $players = PlayerRegistration::count();
        $tournament = Tournament::count();
        $organizer = User::where('role', 'subscriber')->where('organizer','yes')->count();
        $user = User::where('role', 'subscriber')->where('organizer', 'no')->count();
        return view('backend.index',compact('tournament','players','organizer','user'));
    }
    public function profile(){
        $user = auth()->user();
        return view('backend.profile',compact('user'));
    }
}
