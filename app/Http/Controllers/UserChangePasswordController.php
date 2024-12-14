<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserChangePasswordController extends Controller
{
    

    public function viewChnagePassword()
    {
        return view('frontend.changepassword');
        
    }

    public function changePassword(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',  // 'confirmed' ensures 'new_password' matches 'confirm_password'
        ]);

        // Get the authenticated user
        $user = User::find(Auth::id());

        // Check if the old password is correct
        if (Hash::check($validatedData['old_password'], $user->password)) {
            // Hash and save the new password
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();

            return response()->json(['status' => true, 'success' => 'Password changed successfully'], 200);
        }

        return response()->json(['status' => false, 'error' => 'Old password is incorrect'], 400);
    }

}