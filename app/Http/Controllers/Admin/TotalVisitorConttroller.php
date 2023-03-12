<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Properties\Months;
use Illuminate\Http\Request;

class TotalVisitorConttroller extends Controller
{
    public function filter(Request $request)
    {
        $visitors = Visitor::all();
        $months = Months::getMonths();
        $totalVisitorPerMonth = [];

        if ($request->has('year')) {
            $visitors = $visitors->where('created_at', '>=', $request->year . '-01-01')
                ->where('created_at', '<=', $request->year . '-12-31');

            foreach ($months as $month) {
                $totalVisitorPerMonth[] = Visitor::whereMonth('created_at', array_search($month, $months) + 1)
                    ->where('created_at', '>=', $request->year . '-01-01')
                    ->where('created_at', '<=', $request->year . '-12-31')
                    ->count();
            }
        }

        return response()->json([
            'totalVisitors'        => $visitors->count(),
            'totalVisitorPerMonth' => $totalVisitorPerMonth,
            'months'               => $months,
        ]);
    }
}
