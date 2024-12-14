<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Category;
use App\Models\State;
use App\Models\TournamentType;
use App\Models\Prize;
use App\Models\TournamentRegistration;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\TournamentMail;
use Illuminate\Support\Facades\Mail;


class TournamentListController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories, states, tournament types, and prizes
        $category = Category::all();
        $states = State::all();
        $tournamenttype = TournamentType::all();
        $prizes = Prize::all();

        // Default tournament query
        $tournamentsQuery = Tournament::query();

        // Check if a date filter is applied
        if ($request->has("date")) {
            $dateFilter = $request->input("date");
            if ($dateFilter == "this_week") {
                // Get the current week range using Carbon
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
                // Filter tournaments that occur within this week
                $tournamentsQuery->whereBetween("start_date", [
                    $startOfWeek,
                    $endOfWeek,
                ]);
            }
            if ($dateFilter == "next_week") {
                // Get the next week range using Carbon
                $startOfNextWeek = Carbon::now()->addWeek()->startOfWeek();
                $endOfNextWeek = Carbon::now()->addWeek()->endOfWeek();
                // Filter tournaments that occur next week
                $tournamentsQuery->whereBetween("start_date", [
                    $startOfNextWeek,
                    $endOfNextWeek,
                ]);
            }
            if ($dateFilter == "weekends") {
                // Filter tournaments that occur on weekends (Saturday and Sunday)
                $tournamentsQuery->whereIn("start_date", [
                    Carbon::now()->next(Carbon::SATURDAY)->format("Y-m-d"),
                    Carbon::now()->next(Carbon::SUNDAY)->format("Y-m-d"),
                ]);
            }
        }

        // Check if a day filter is applied
        if ($request->has("day")) {
            $dayFilter = $request->input("day");
            $tournamentsQuery->whereRaw("DAYNAME(start_date) = ?", [$dayFilter]);
        }

        // Check if tournament type filter is applied
        if ($request->has("tournamenttype")) {
            $tournamentTypes = $request->input("tournamenttype");
            $tournamentsQuery->whereIn("tournament_type_id", $tournamentTypes);
        }

        if ($request->has('categories')) {
            $categories = $request->input('categories');
            $tournamentsQuery->where(function ($query) use ($categories) {
                foreach ($categories as $category) {
                    $query->orWhere('category_id', 'LIKE', "%{$category}%");
                }
            });
        }

        // Check if entry fee filter is applied
        if ($request->has("price")) {
            $entryFees = $request->input("price");
            if (in_array("0", $entryFees)) {
                $tournamentsQuery->orWhere("price", 0);
            }
            if (in_array("0-500", $entryFees)) {
                $tournamentsQuery->orWhereBetween("price", [0, 500]);
            }
            if (in_array("500-1500", $entryFees)) {
                $tournamentsQuery->orWhereBetween("price", [500, 1500]);
            }
            if (in_array("1500", $entryFees)) {
                $tournamentsQuery->orWhere("price", ">", 1500);
            }
        }

        // Check if prizes filter is applied
        if ($request->has("prizes")) {
            $prizesFilter = $request->input("prizes");
            $tournamentsQuery->whereIn("prize_id", $prizesFilter);
        }
        if ($request->has("gender")) {
            $genderFilter = $request->input("gender");
            $tournamentsQuery->whereIn("gender", $genderFilter);
        }

        // Check if state filter is applied
        if ($request->has("state")) {
            $statesFilter = $request->input("state");
            $tournamentsQuery->whereIn("state_id", $statesFilter);
        }

        // Paginate the filtered tournaments
        $tournament = $tournamentsQuery
        ->where('status', 1)
        ->orderBy('order_number')
        ->orderBy('created_at')
        ->get();

        // Get days of the week for the view
        $days = collect([
            (object) ["title" => "Monday"],
            (object) ["title" => "Tuesday"],
            (object) ["title" => "Wednesday"],
            (object) ["title" => "Thursday"],
            (object) ["title" => "Friday"],
            (object) ["title" => "Saturday"],
            (object) ["title" => "Sunday"],
        ]);

        // Return the view with the filtered tournaments and data
        return view(
            "frontend.tournaments",
            compact(
                "category",
                "tournament",
                "days",
                "states",
                "tournamenttype",
                "prizes"
            )
        );
    }
    // TournamentController.php
    public function showTournamentDetails(Request $request, $slug)
    {
        $category = Category::all();
        $tournament = Tournament::with("category")
            ->where("slug", $slug)
            ->first();
        if (!$tournament) {
            abort(404, "Tournament not found");
        }
        // Fetch related tournaments, excluding the current one
        $relatedTournaments = Tournament::where("id", "!=", $tournament->id)
            ->limit(4)
            ->get();
        return view(
            "frontend.tournament-details",
            compact("category", "tournament", "relatedTournaments")
        );
    }
    public function productAccordingCategory($id)
    {
        $category = Category::where("id", $id)->get();
        $tournament = Tournament::where("category_id", $id)
            ->with("category")
            ->get();
        return view("frontend.tournaments", compact("category", "tournament"));
    }

    public function thanks($slug)
    {
        return view("frontend.thanks")->with(
            "message",
            "Thank you for registering!"
        );
    }
    public function payNow($slug)
    {
        return view("frontend.pay-now")->with(
            "message",
            "Proceed with online payment!"
        );
    }

    public function createTournament(){
        $categories = Category::orderByRaw("FIELD(title, 'open') DESC, LENGTH(title), title")->get();
        $states = State::all();
        $prizes = Prize::all();
        $tournamenttypes = TournamentType::all();
        return view('frontend.tournament.index', compact('categories','states','prizes','tournamenttypes'));
    }
    public function storeTournament(Request $request)
    {
        try {
                $rules = [
                    'organizer' => 'required',
                    'time' => 'required',
                    'address' => 'required',
                    'title' => 'required',
                    'price' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'address' => 'required',
                    'contact_person' => 'required',
                    'contact_number' => 'required',
                    'contact_email' => 'required',
                    'document' => 'required|mimes:pdf|max:2048',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'category' => 'required|array',
                    'city' => 'required',
                    'prize_id' => 'required',
                    'state_id' => 'required',
                    'tournament_type_id' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);


                if ($validator->fails()) {
                    return redirect()->back()->withInput()->withErrors($validator);
                } else {
                $tournament = new Tournament();
                $tournament->organizer = $request->input('organizer');
                $tournament->title = $request->input('title');
                $tournament->price = $request->input('price');
                $tournament->start_date = $request->input('start_date');
                $tournament->end_date = $request->input('end_date');
                $tournament->content = $request->input('content');
                $tournament->address = $request->input('address');
                $tournament->gender = $request->input('gender');
                $tournament->contact_number = $request->input('contact_number');
                $tournament->contact_email = $request->input('contact_email');
                $tournament->contact_person = $request->input('contact_person');
                // Store categories as a comma-separated string
                $categoryIds = implode(',', $request->input('category')); // Convert array to a comma-separated string
                $tournament->category_id = $categoryIds;
                $tournament->payment_mode = $request->input('payment_mode');
                $tournament->tournament_type_id = $request->input('tournament_type_id');
                $tournament->city = $request->input('city');
                $tournament->state_id = $request->input('state_id');
                $tournament->prize_id = $request->input('prize_id');
                $tournament->google_map_link = $request->input('google_map_link');
                $tournament->time = $request->input('time');
                $tournament->facebook = $request->input('facebook');
                $tournament->instgram = $request->input('instgram');
                $tournament->website = $request->input('website');
                $tournament->order_number = '0';
                $tournament->user_id = Auth::user()->id;
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
                Mail::to('info@bookmyfee.com')->send(new TournamentMail($tournament));
                return redirect()->back()->with('success', "Tournament successfully added and will be displayed after admin confirmation.");
            }
        } catch (Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function viewTournament()
    {
        $userId = auth()->user()->id;
        $tournaments = Tournament::with('category')->where('user_id', $userId)->get();
        return view('frontend.tournament.view', compact('tournaments'));
    }
    public function PlayersList($tournament_id)
    {
        $userId = auth()->user()->id;
        $tournament = Tournament::where('id', $tournament_id)->where('user_id', $userId)->first();

        if (!$tournament) {
            return abort(404, 'Tournament not found.');
        }

        $playerlists = TournamentRegistration::with(['player', 'payment' => function ($query) {
            $query->where('payment_status', 'approve');
        }])
        ->where('tournament_id', $tournament_id)
        ->get();

        $playerlists = $playerlists->filter(function ($registration) {
            return $registration->payment !== null;
        });

        return view('frontend.tournament.players-list', compact('playerlists', 'tournament'));
    }


}
