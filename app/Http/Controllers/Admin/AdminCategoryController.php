<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Category;
use Exception;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('backend.category.index', compact('category'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|unique:categories,title',
                'content' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $category = new Category();
                $category->title = $request->input('title');
                $category->content = $request->input('content');
                $category->parent = $request->input('parent');
                $category->slug = $request->input('slug');
                $category->seo_title = $request->input('seo_title');
                $category->seo_description = $request->input('seo_description');
                if($request->hasfile('image'))
                {
                    $file = $request->file('image');
                    $extenstion = $file->getClientOriginalExtension();
                    $filename = time().'1.'.$extenstion;
                    $file->move('uploads/category/', $filename);
                    $category->image =  $filename;
                }
                $category->save();
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
            $category = Category::findOrFail($id);
            $categories = Category::all();
            return view('backend.category.update', compact('category', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating category: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'title' => 'required',
                'content' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $category = Category::findOrFail($id);
                $category->title = $request->input('title');
                $category->content = $request->input('content');
                $category->parent = $request->input('parent');
                $category->slug = $request->input('slug');
                $category->seo_title = $request->input('seo_title');
                $category->seo_description = $request->input('seo_description');
                if($request->hasfile('image'))
                {
                    $file = $request->file('image');
                    $extenstion = $file->getClientOriginalExtension();
                    $filename = time().'1.'.$extenstion;
                    $file->move('uploads/category/', $filename);
                    $category->image =  $filename;
                }
                $category->save();
                return redirect('admin/category')->with('status', "Update successfully");
            }
        } catch (Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->back()->with('status', "Record deleted successfully");
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while deleting category: ' . $e->getMessage());
        }
    }
}