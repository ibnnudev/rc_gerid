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
            'samplePerYear'        => $this->samplePerYear(date('Y')),
        ]);
    }

    public function samplePerYear($yearParam)
    {
        $months  = Months::getMonths();
        $viruses = Virus::all();

        $samplesPerMonth = [];

        $samples = Sample::whereYear('pickup_date', $yearParam)->get();

        foreach ($viruses as $virus) {
            $samplesPerMonth[$virus->name] = [];

            foreach ($months as $month) {
                // get the number of samples for each virus in each month by year of pickup_date
                $samplesPerMonth[$virus->name][] = $samples->where('viruses_id', $virus->id)
                    ->where('pickup_date', '>=', date('Y-m-d', strtotime($yearParam . '-' . array_search($month, $months) + 1 . '-01')))
                    ->count();
            }
        }

        return $samplesPerMonth;
    }

    public function filterVisitor(Request $request)
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

    public function filterSample(Request $request)
    {
        $samples = Sample::all();
        $months = Months::getMonths();
        $viruses = Virus::all();

        $samplesPerMonth = [];

        if ($request->has('year')) {
            $samples = $samples->where('pickup_date', '>=', $request->year . '-01-01')
                ->where('pickup_date', '<=', $request->year . '-12-31');

            foreach ($viruses as $virus) {
                $samplesPerMonth[$virus->name] = [];

                foreach ($months as $month) {
                    // get the number of samples for each virus in each month by year of pickup_date
                    $samplesPerMonth[$virus->name][] = $samples->where('viruses_id', $virus->id)
                        ->where('pickup_date', '>=', date('Y-m-d', strtotime($request->year . '-' . array_search($month, $months) + 1 . '-01')))
                        ->count();
                }
            }
        }

        return response()->json([
            'samplePerYear' => $samplesPerMonth,
            'months'        => $months,
        ]);
    }
}
