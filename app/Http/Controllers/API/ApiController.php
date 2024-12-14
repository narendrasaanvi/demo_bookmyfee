<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tournament;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function tournamentList(Request $request): JsonResponse
    {
        // Get the query parameter
        $query = $request->query('query', '');

        // Fetch tournaments matching the query
        $tournaments = Tournament::query()
            ->where('title', 'like', "%{$query}%")
            ->get();

        // Return the results as JSON
        return response()->json([
            'status' => 'success',
            'data' => $tournaments,
        ]);
    }
}
