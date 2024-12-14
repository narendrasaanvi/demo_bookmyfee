<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('frontend.contact');
    }

    public function submitForm(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'mobile'  => 'required|string|max:15',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'form_name' => 'required|string',
        ]);


        // Store the data in the database
        Contact::create($validatedData);

        // Redirect with a success message
        return redirect()->route('contact.form')->with('success', 'Your message has been saved successfully!');
    }
}

