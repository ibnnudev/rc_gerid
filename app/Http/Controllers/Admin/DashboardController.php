<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Sample;
use App\Models\Virus;
use App\Models\Visitor;
use App\Properties\Months;
use App\Properties\Years;

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

    public function samplePerMonth($yearParam)
    {
        $year = date('Y', strtotime($yearParam));
        // dd($year);
        $months  = Months::getMonths();
        $viruses = Virus::all();

        $samplesPerMonth = [];

        foreach ($viruses as $virus) {
            $samplesPerMonth[$virus->name] = [];

            foreach ($months as $month) {
                // get the number of samples for each virus in each month by year of pickup_date
                $samplesPerMonth[$virus->name][] = Sample::whereMonth('pickup_date', array_search($month, $months) + 1)
                    ->whereYear('pickup_date', $year)
                    ->where('viruses_id', $virus->id)
                    ->count();
            }
        }

        return $samplesPerMonth;
    }

    public function samplePerYear($yearParam)
    {
        $year = date('Y', strtotime($yearParam));
        $months  = Months::getMonths();
        $viruses = Virus::all();

        $samplesPerMonth = [];

        foreach ($viruses as $virus) {
            $samplesPerMonth[$virus->name] = [];

            foreach ($months as $month) {
                // get the number of samples for each virus in each month by year of pickup_date
                $samplesPerMonth[$virus->name][] = Sample::whereMonth('pickup_date', array_search($month, $months) + 1)
                    ->whereYear('pickup_date', $year)
                    ->where('viruses_id', $virus->id)
                    ->count();
            }
        }

        return $samplesPerMonth;
    }
}
