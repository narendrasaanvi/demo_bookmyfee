<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Category;
use Exception;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $category = Category::get();
        $tournament = Tournament::with('category')
            ->where('title', 'like', '%' . $keyword . '%')
            ->get();
        return view('frontend.search-list', compact('category', 'tournament'));
    }
}