<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;
class AdminSubscriberController extends Controller
{
    public function index()
    {
        $subscriber = User::where('role', 'subscriber')->where('organizer', 'yes')->get();
        return view('backend.subscriber.index', compact('subscriber'));
    }

    public function create()
    {
        return view('backend.subscriber.create');
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'phone' => 'required|string|max:15|unique:users,phone',
                'email' => 'required|email|unique:users,email'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {

                $subscriber = new User();
                $subscriber->name = $request->input('name');
                $subscriber->email = $request->input('email');
                $subscriber->phone = $request->input('phone');
                $subscriber->password = Hash::make($request->password);
                $subscriber->organizer = 'yes';
                $subscriber->save();
                $subscriber->sendpassword = $request->input('password');
                Mail::to($subscriber->email)->send(new RegistrationMail($subscriber));
                return redirect()->back()->with('success', "Successfully Added");
            }
        } catch (Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function edit($id)
    {
        try {
            $subscriber = User::findOrFail($id);
            return view('backend.subscriber.update', compact('subscriber'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating users: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $subscriber = User::findOrFail($id);
                $subscriber->name = $request->input('name');
                $subscriber->email = $request->input('email');
                $subscriber->is_active = $request->input('status');
                $subscriber->save();
                return redirect('admin/subscriber')->with('status', "Update successfully");
            }
        } catch (Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $subscriber = User::findOrFail($id);
            $subscriber->delete();
            return redirect()->back()->with('status', "Record deleted successfully");
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while deleting users: ' . $e->getMessage());
        }
    }
}
