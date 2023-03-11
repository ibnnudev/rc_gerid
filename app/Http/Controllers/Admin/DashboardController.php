<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Sample;
use App\Models\Virus;
use App\Models\Visitor;
use App\Properties\Months;
use App\Properties\Years;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $samples  = Sample::all();
        $visitors = Visitor::all();
        $viruses  = Virus::all();
        $authors  = Author::all();

        $months               = Months::getMonths();
        $totalVisitorPerMonth = [];

        foreach ($months as $month) {
            $totalVisitorPerMonth[] = Visitor::whereMonth('created_at', array_search($month, $months) + 1)->count();
        }

        $years = Years::getYears();

        return view('admin.dashboard.index', [
            'totalSamples'         => $samples->count(),
            'totalSampleToday'     => $samples->where('created_at', '>=', now()->startOfDay())->count(),
            'totalVisitors'        => $visitors->count(),
            'totalVisitorToday'    => $visitors->where('created_at', '>=', now()->startOfDay())->count(),
            'totalViruses'         => $viruses->count(),
            'totalAuthors'         => $authors->count(),
            'months'               => $months,
            'totalVisitorPerMonth' => $totalVisitorPerMonth,
            'years'                => $years,
        ]);
    }
}
