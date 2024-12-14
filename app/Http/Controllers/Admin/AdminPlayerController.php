<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlayerRegistration;
class AdminPlayerController extends Controller
{
    public function index(){
        $players = PlayerRegistration::all();
        return view('backend.player.index', compact('players'));
    }
}
