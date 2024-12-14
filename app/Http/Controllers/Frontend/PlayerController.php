<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Category;
use App\Models\State;
use App\Models\TournamentType;
use App\Models\Prize;
use App\Models\PlayerRegistration;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $slug = $request->query('tournament', 1);
        $states= State::get();
        return view("frontend.players.create",compact('states','slug'));
    }
    public function store(Request $request)
    {
        try {

            $slug = $request->input('slug');

            // Validate input
            $rules = [
                "fide_id" => "nullable|string",
                "aicf_id" => "nullable|string",
                "fide_rating" => "nullable|string",
                "state_membership_id" => "nullable|string",
                "player_name" => "required|string|max:255",
                "residential_address" => "required|string|max:1000",
                "gender" => "required|string|in:male,female",
                "father_name" => "required|string|max:255",
                "state" => "required|string",
                "dob" => "required|date|before:today",
                "district" => "required|string|max:255",
                "mobile_1" => "required|string|max:15|regex:/^[0-9]+$/",
                "mobile_2" => "nullable|string|max:15|regex:/^[0-9]+$/",
                "pin_code" => "required|string|max:10|regex:/^[0-9]+$/",
                "email" => "required|email|max:255",
                "school_college_name" => "required|string|max:255",
                "online_chess_id" => "nullable|string|max:255",
                "chess_id" => "nullable|string|max:255",
                "terms" => "accepted",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
            $tournament = new PlayerRegistration();
            $tournament->fide_id = $request->input('fide_id');
            $tournament->aicf_id = $request->input('aicf_id');
            $tournament->fide_rating = $request->input('fide_rating');
            $tournament->state_membership_id = $request->input('state_membership_id');
            $tournament->player_name = $request->input('player_name');
            $tournament->residential_address = $request->input('residential_address');
            $tournament->gender = $request->input('gender');
            $tournament->father_name = $request->input('father_name');
            $tournament->state = $request->input('state');
            $tournament->dob = $request->input('dob');
            $tournament->district = $request->input('district');
            $tournament->mobile_1 = $request->input('mobile_1');
            $tournament->taluk = $request->input('taluk');
            $tournament->mobile_2 = $request->input('mobile_2');
            $tournament->pin_code = $request->input('pin_code');
            $tournament->email = $request->input('email');
            $tournament->school_college_name = $request->input('school_college_name');
            $tournament->online_chess_id = $request->input('online_chess_id');
            $tournament->user_id = Auth::user()->id;
            $tournament->save();
            if ($slug == '1') {
                return redirect()->back()->with('success', "Player added successfully");
            } else {
                return redirect()->to('booking-tournament/' . $slug); // Redirects to the URL
            }
        }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function view(){
       $user_id =Auth::user()->id;
       $players = PlayerRegistration::where('user_id', $user_id)->get();
       return view('frontend.players.view',compact('players'));
    }


    public function edit($id)
    {
        try {
            $player = PlayerRegistration::findOrFail($id);
            $states = State::all();
            return view('frontend.players.update', compact('player','states'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating tournament: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            "fide_id" => "nullable|string",
            "aicf_id" => "nullable|string",
            "fide_rating" => "nullable|string",
            "state_membership_id" => "nullable|string",
            "player_name" => "required|string|max:255",
            "residential_address" => "required|string|max:1000",
            "gender" => "required|string|in:male,female",
            "father_name" => "required|string|max:255",
            "state" => "required|string",
            "dob" => "required|date|before:today",
            "district" => "required|string|max:255",
            "mobile_1" => "required|string|max:15|regex:/^[0-9]+$/",
            "mobile_2" => "nullable|string|max:15|regex:/^[0-9]+$/",
            "pin_code" => "required|string|max:10|regex:/^[0-9]+$/",
            "email" => "required|email|max:255",
            "school_college_name" => "required|string|max:255",
            "online_chess_id" => "nullable|string|max:255",
            "chess_id" => "nullable|string|max:255",
            "terms" => "accepted",
        ]);

        try {
            $tournament = PlayerRegistration::findOrFail($id);

            // Update the model fields
            $tournament->fide_id = $request->input('fide_id');
            $tournament->aicf_id = $request->input('aicf_id');
            $tournament->fide_rating = $request->input('fide_rating');
            $tournament->state_membership_id = $request->input('state_membership_id');
            $tournament->player_name = $request->input('player_name');
            $tournament->residential_address = $request->input('residential_address');
            $tournament->gender = $request->input('gender');
            $tournament->father_name = $request->input('father_name');
            $tournament->mother_name = $request->input('mother_name');
            $tournament->state = $request->input('state');
            $tournament->dob = $request->input('dob');
            $tournament->district = $request->input('district');
            $tournament->mobile_1 = $request->input('mobile_1');
            $tournament->taluk = $request->input('taluk');
            $tournament->mobile_2 = $request->input('mobile_2');
            $tournament->pin_code = $request->input('pin_code');
            $tournament->email = $request->input('email');
            $tournament->school_college_name = $request->input('school_college_name');
            $tournament->online_chess_id = $request->input('online_chess_id');
            $tournament->user_id = Auth::user()->id;

            // Save the updated model
            $tournament->save();
            return redirect()->back()->with('success', "Player Update successfully");
        } catch (Exception $e) {
            return redirect()->back()->with('error', "An error occurred while updating the tournament");
        }
    }



    public function destroy($id)
    {
        try {
            $player = PlayerRegistration::findOrFail($id);
            $player->delete();
            return redirect()->back()->with('status', "Record deleted successfully");
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while deleting tournament: ' . $e->getMessage());
        }
    }
}
