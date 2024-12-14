<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactFromController extends Controller
{
    public function index(){
     $enquiries = Contact::get();
     return view('backend.contact-enquiry.index',compact('enquiries'));
    }
    public function destroy($id)
    {
        try {
            $category = Contact::findOrFail($id);
            $category->delete();
            return redirect()->back()->with('success', "Record deleted successfully");
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while deleting category: ' . $e->getMessage());
        }
    }
}
