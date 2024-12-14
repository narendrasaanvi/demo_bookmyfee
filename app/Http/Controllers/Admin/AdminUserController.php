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
class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'subscriber')->where('organizer', 'no')->get();
        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
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

                $users = new User();
                $users->name = $request->input('name');
                $users->email = $request->input('email');
                $users->phone = $request->input('phone');
                $users->password = Hash::make($request->password);
                $users->organizer = 'yes';
                $users->save();
                $users->sendpassword = $request->input('password');
                Mail::to($users->email)->send(new RegistrationMail($users));
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
            $users = User::findOrFail($id);
            return view('backend.users.update', compact('users'));
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
                $users = User::findOrFail($id);
                $users->name = $request->input('name');
                $users->email = $request->input('email');
                $users->is_active = $request->input('status');
                $users->save();
                return redirect('admin/users')->with('status', "Update successfully");
            }
        } catch (Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $users = User::findOrFail($id);
            $users->delete();
            return redirect()->back()->with('status', "Record deleted successfully");
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while deleting users: ' . $e->getMessage());
        }
    }
}
