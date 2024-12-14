<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\TournamentType;
use Exception;

class AdminTypeController extends Controller
{
    public function index()
    {
        $type = TournamentType::all();
        return view('backend.type.index', compact('type'));
    }

    public function create()
    {
        $categories = TournamentType::all();
        return view('backend.type.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|unique:categories,title',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $type = new TournamentType();
                $type->title = $request->input('title');
                $type->save();
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
            $type = TournamentType::findOrFail($id);
            $categories = TournamentType::all();
            return view('backend.type.update', compact('type', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating type: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'title' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $type = TournamentType::findOrFail($id);
                $type->title = $request->input('title');
                $type->save();
                return redirect('admin/type')->with('status', "Update successfully");
            }
        } catch (Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $type = TournamentType::findOrFail($id);
            $type->delete();
            return redirect()->back()->with('status', "Record deleted successfully");
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while deleting type: ' . $e->getMessage());
        }
    }
}