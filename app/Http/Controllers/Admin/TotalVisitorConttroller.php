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

        if ($request->has('month')) {
            $visitors = $visitors->whereMonth('created_at', $request->month);
        }

        if ($request->has('year')) {
            $visitors = $visitors->where('created_at', '>=', $request->year . '-01-01')
                ->where('created_at', '<=', $request->year . '-12-31');
        }

        return response()->json($visitors);
    }
}
