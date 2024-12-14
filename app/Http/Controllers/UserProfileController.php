<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    // Show user profile form
    public function showProfile()
    {
        return view('frontend.profile.index'); // Assuming the profile view is located here
    }

    // Update user profile
    public function updateProfile(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:15',
        ]);

        // Find the logged-in user
        $user = Auth::user();

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alternate_number = $request->alternate_number;
        $user->organization_name = $request->organization_name;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Change user password
    public function changePassword(Request $request)
    {
        // Validate input data
        $request->validate([
            'current_password' => 'required|string',
        ]);

        // Find the logged-in user
        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
