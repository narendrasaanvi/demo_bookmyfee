<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Category;
use App\Models\User;
use App\Models\State;
use App\Models\TournamentType;
use App\Models\Prize;
use Exception;
use App\Models\PlayerRegistration;
use App\Models\TournamentRegistration;
use Illuminate\Support\Facades\Auth;
class AdminTournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::with('category')->get();
        return view('backend.tournament.index', compact('tournaments'));
    }

    public function create()
    {
        $categories = Category::all();
        $orgnizers = User::where('organizer','yes')->get();
        $states = State::all();
        $prizes = Prize::all();
        $tournamenttypes = TournamentType::all();
        $categories = Category::all();
        return view('backend.tournament.create', compact('categories','states','prizes','tournamenttypes','orgnizers'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'organizer' => 'required|exists:users,id',
                'title' => 'required',
                'price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'address' => 'required',
                'contact_person' => 'required',
                'contact_number' => 'required',
                'contact_email' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'document' => 'required|mimes:pdf|max:2048',
                'category' => 'required|array',
                'state_id' => 'required',
                'prize_id' => 'required',
                'city' => 'required',
                'tournament_type_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
            $organizeruser = User::findOrFail($request->input('organizer'));
            $tournament = new Tournament();
            $tournament->organizer = $organizeruser->name;
            $tournament->title = $request->input('title');
            $tournament->price = $request->input('price');
            $tournament->start_date = $request->input('start_date');
            $tournament->end_date = $request->input('end_date');
            $tournament->content = $request->input('content');
            $tournament->address = $request->input('address');
            $tournament->contact_number = $request->input('contact_number');
            $tournament->contact_email = $request->input('contact_email');
            $tournament->contact_person = $request->input('contact_person');
            // Store categories as a comma-separated string
            $categoryIds = implode(',', $request->input('category')); // Convert array to a comma-separated string
            $tournament->category_id = $categoryIds;
            $tournament->payment_mode = $request->input('payment_mode');
            $tournament->tournament_type_id = $request->input('tournament_type_id');
            $tournament->state_id = $request->input('state_id');
            $tournament->city = $request->input('city');
            $tournament->prize_id = $request->input('prize_id');
            $tournament->google_map_link = $request->input('google_map_link');
            $tournament->time = $request->input('time');
            $tournament->facebook = $request->input('facebook');
            $tournament->instgram = $request->input('instgram');
            $tournament->website = $request->input('website');
            $tournament->user_id =$request->input('organizer');
            if($request->hasfile('document'))
            {
                $documentfile = $request->file('document');
                $documentextenstion = $documentfile->getClientOriginalExtension();
                $documentfilename = time().'1.'.$documentextenstion;
                $documentfile->move('uploads/tournament/', $documentfilename);
                $tournament->document =  $documentfilename;
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '1.' . $extension;
                $file->move('uploads/tournament/', $filename);
                $tournament->image = $filename;
            } else {

                $tournament->image = 'default-image.jpg';
            }
            $tournament->slug = $request->input('slug');
            $tournament->seo_title = $request->input('seo_title');
            $tournament->seo_description = $request->input('seo_description');
            $tournament->save();
            return redirect()->back()->with('success', "Tournament successfully added");
        }
    } catch (Exception $e) {
        report($e);
        return response()->json(['error' => $e->getMessage()], 401);
    }
    }

    public function edit($id)
    {
        try {
            $tournament = Tournament::findOrFail($id);
            $orgnizers = User::where('organizer','yes')->get();
            $categories = Category::all();
            $states = State::all();
            $prizes = Prize::all();
            $tournamenttypes = TournamentType::all();
            $categories = Category::all();
            $orgnizers = User::where('organizer','yes')->get();
            return view('backend.tournament.update', compact('tournament','categories','states','prizes','tournamenttypes','orgnizers'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating tournament: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'organizer' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'price' => 'required|numeric',
            'city' => 'required',
            'payment_mode' => 'required|string'
        ]);

        try {
            $tournament = Tournament::findOrFail($id);
            $tournament->organizer = $request->input('organizer');
            $tournament->title = $request->input('title');
            $tournament->order_number = $request->input('order_number');
            $tournament->status = $request->input('status');
            $tournament->admin_commission = $request->input('admin_commission');
            $tournament->price = $request->input('price');
            $tournament->start_date = $request->input('start_date');
            $tournament->end_date = $request->input('end_date');
            $tournament->content = $request->input('content');
            $tournament->city = $request->input('city');
            $tournament->address = $request->input('address');
            $tournament->contact_number = $request->input('contact_number');
            $tournament->contact_email = $request->input('contact_email');
            $tournament->contact_person = $request->input('contact_person');
            $categoryIds = implode(',', $request->input('category')); // Convert array to a comma-separated string
            $tournament->category_id = $categoryIds;
            $tournament->payment_mode = $request->input('payment_mode');
            $tournament->tournament_type_id = $request->input('tournament_type_id');
            $tournament->prize_id = $request->input('prize_id');
            $tournament->google_map_link = $request->input('google_map_link');
            $tournament->time = $request->input('time');
            $tournament->facebook = $request->input('facebook');
            $tournament->instgram = $request->input('instgram');
            $tournament->website = $request->input('website');
            if($request->hasfile('document'))
            {
                $documentfile = $request->file('document');
                $documentextenstion = $documentfile->getClientOriginalExtension();
                $documentfilename = time().'1.'.$documentextenstion;
                $documentfile->move('uploads/tournament/', $documentfilename);
                $tournament->document =  $documentfilename;
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '1.' . $extension;
                $file->move('uploads/tournament/', $filename);
                $tournament->image = $filename;
            }
            $tournament->save();
            return redirect('admin/tournament')->with('status', "Update successfully");
        } catch (Exception $e) {
            return redirect()->back()->with('error', "An error occurred while updating the tournament");
        }
    }




    public function destroy($id)
    {
        try {
            $tournament = Tournament::findOrFail($id);
            $tournament->delete();
            return redirect()->back()->with('status', "Record deleted successfully");
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while deleting tournament: ' . $e->getMessage());
        }
    }
    public function registerPlayersList($tournament_id){
        $playerlists = TournamentRegistration::where('tournament_id',$tournament_id)->get();
        return view('backend.tournament.register-players-list', compact('playerlists'));
    }
}
