<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function getSalesData()
    {
        // Get the last 4 months including the current month
        $months = [];
        $data = [];

        for ($i = 0; $i < 4; $i++) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('F');
            $startOfMonth = $month->startOfMonth()->toDateTimeString();
            $endOfMonth = $month->endOfMonth()->toDateTimeString();

            // Count tournaments for the specific month
            $tournamentsCount = Tournament::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

            $months[] = $monthName;
            $data[] = $tournamentsCount;
        }

        // Reverse to have chronological order
        $months = array_reverse($months);
        $data = array_reverse($data);

        return response()->json([
            'months' => $months,
            'tournaments_count' => $data,
        ]);
    }
}
