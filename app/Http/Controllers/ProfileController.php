<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::back()->with('status', 'profile updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function profileView()
    {
        $user = User::find(Auth::user()->id);
        return view('frontend.user_profile', compact('user'));

    }

    public function addProfile(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|integer',
            'address_1' => 'required|string',
            'address_2' => 'nullable|string',
            'pincode' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string'
        ]);


        $user = User::find(Auth::user()->id);
        $user->address_1 = $validatedData['address_1'];
        $user->address_2 = $validatedData['address_2'];
        $user->city = $validatedData['city'];
        $user->state = $validatedData['state'];
        $user->country = $validatedData['country'];
        $user->postcode = $validatedData['pincode'];
        $user->phone = $validatedData['phone'];
        $user->save();

        return Redirect::back()->with('status', 'profile updated');
    }


}
