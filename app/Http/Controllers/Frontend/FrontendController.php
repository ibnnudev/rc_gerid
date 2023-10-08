<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\FrontendInterface;
use App\Interfaces\VirusInterface;
use App\Models\Genotipe;
use App\Models\HivCases;
use App\Models\Province;
use App\Models\Sample;
use App\Models\Virus;
use App\Properties\Months;
use App\Properties\Years;
use App\Repositories\HivCaseRepository;
// use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use stdClass;

use function PHPUnit\Framework\isEmpty;

// use Spatie\FlareClient\Http\Response;

class FrontendController extends Controller
{
    private $frontend;
    private $hivCases;


    public function __construct(FrontendInterface $frontend, HivCaseRepository $hivCases)
    {
        $this->frontend = $frontend;
        $this->hivCases = $hivCases;
    }

    public function home()
    {
        return view('frontend.home', [
            'viruses' => Virus::all()
        ]);
    }

    public function detail($id)
    {
        // if ($id == 1) {
        //     return view('frontend.marker', [
        //         'virus' => $this->frontend->getVirus($id),
        //         'provinces' => Province::all(),
        //         'years'     => Years::getYears(),
        //         'lastYearSample' => $this->getLastYearSample($id),
        //         'lastCitySampleId' => $this->getLastCitySample($id),
        //         'request' => NULL,
        //         // 'years' => HivCases::select('year')->distinct()->groupBy('year')->orderBy('year')->get(),
        //         'individualCases' => $this->frontend->hivCases(),
        //     ]);
        // } else {
        // return $this->getGrouping(1);
        // return Years::getYears();

        return view('frontend.area', [
            'virus'            => $this->frontend->getVirus($id),
            'provinces'        => Province::all(),
            'years'            => Years::getYears(),
            'lastYearSample'   => $this->getLastYearSample($id),
            'lastCitySampleId' => $this->getLastCitySample($id),
            'request'          => NULL,
            // 'data' => $this->getGrouping(1)
            // 'years' => HivCases::select('year')->distinct()->groupBy('year')->orderBy('year')->get(),
            // 'individualCases' => $this->frontend->hivCases(),
        ]);
        // }
    }

    public function getGrouping(Request $request)
    {
        $genotipes = Genotipe::where('viruses_id', $request->id)->get();

        $samplesPerMonth = [];

        $provinces = Sample::with('province')->select('province_id')->where('viruses_id', $request->id)->groupBy('province_id')->get();
        foreach ($provinces as $indexProvince => $province) {
            $stdOne                = new stdClass();
            $stdOne->province_id   = $province->province_id;
            $stdOne->province_name = $province->province->name;
            $stdOne->potensi       = Sample::where('viruses_id', $request->id)
                ->whereBetween('pickup_date', [date('Y-m-d', strtotime($request->startYear . '-01-01')), date('Y-m-d', strtotime($request->endYear . '-01-01'))])
                ->where('province_id', $province->province_id)
                ->count() > 50 ? "Tinggi" : "Rendah";
            $samplesPerMonth[] = $stdOne;
            foreach ($genotipes as $indexGenotipe => $genotipe) {
                $stdTwo              = new stdClass();
                $stdTwo->genotipe    = $genotipe->genotipe_code;
                $stdTwo->genotipe_id = $genotipe->id;
                $stdTwo->jumlah      = Sample::with('genotipe')->where('viruses_id', $request->id)
                    ->whereBetween('pickup_date', [date('Y-m-d', strtotime($request->startYear . '-01-01')), date('Y-m-d', strtotime($request->endYear . '-01-01'))])
                    ->where('genotipes_id', $genotipe->id)
                    ->where('province_id', $province->province_id)
                    ->count();
                $stdOne->genotipes[] = $stdTwo;
            }
        }

        return $samplesPerMonth;
    }

    public function listCitations(Request $request)
    {
        // return $this->frontend->listCitations($request);
        return view('frontend.citation.listCitation', [
            'request'       => $request,
            'virus'         => $this->frontend->getVirus($request['virus_id']),
            'listCitations' => $this->frontend->listCitations($request)
        ]);
    }

    public function detailCitation($id)
    {
        $sample = DB::table('samples')->where('id', $id)->first();
        $virus  = DB::table('viruses')->where('id', $sample->viruses_id)->first();
        return view('frontend.citation.detail', [
            'request'  => NULL,
            'virus'    => $virus,
            'citation' => $this->frontend->detailCitation($id)
        ]);
    }

    public function detailFasta($id)
    {
        // $virus_id = $this->frontend->detailFasta($id)->sample[0]->viruses_id;
        // return $id;
        $sample = DB::table('samples')->where('id', $id)->first();
        $virus  = DB::table('viruses')->where('id', $sample->viruses_id)->first();
        // return $this->frontend->detailFasta($id);
        return view('frontend.citation.fasta', [
            'request'  => NULL,
            'virus'    => $virus,
            'citation' => $this->frontend->detailFasta($id)
        ]);
    }

    public function downloadFasta(Request $request)
    {
        // return $request;
        if ($request->fasta == null) {
            $contents = 'Maaf anda belum memilih file';
        } else {
            foreach ($request->fasta as $key => $value) {
                $arr[$key]['sample_code']   = DB::table('samples')->find($value)->sample_code;
                $arr[$key]['gene_name']     = DB::table('samples')->find($value)->gene_name;
                $arr[$key]['sequence_data'] = DB::table('samples')->find($value)->sequence_data;
            }
        }
        // return $ke;
        $contents = json_encode($arr);
        $$headers = [
            'Content-Type'        => 'application/plain',
            'Content-Description' => 'File name',
        ];

        return Response::make($contents, 200, $headers);
    }


    public function pieChart(Request $request)
    {
        return $this->frontend->getAllSampleByVirus($request);
    }

    public function groupChartYear(Request $request)
    {
        $months    = Months::getMonths();
        $genotipes = Genotipe::where('viruses_id', $request->id)->get();

        $samplesPerMonth = [];

        $samples = Sample::whereYear('pickup_date', $request->year ?? date('Y', strtotime(now())))->where('viruses_id', $request->id)->get();

        if (count($samples) < 1) {
            return $samples;
        }

        foreach ($genotipes as $genotipe) {
            $samplesPerMonth[$genotipe->genotipe_code] = [];

            foreach ($months as $month) {
                // get the number of samples for each genotipe in each month by year of pickup_date
                $samplesPerMonth[$genotipe->genotipe_code][] = Sample::with('genotipe')->where('viruses_id', $request->id)
                    ->where('pickup_date', '>=', date('Y-m-d', strtotime($request->year . '-' . array_search($month, $months) + 1 . '-01')))
                    ->where('pickup_date', '<=', date('Y-m-d', strtotime('+30 days', strtotime($request->year . '-' . array_search($month, $months) + 1 . '-01'))))
                    ->where('genotipes_id', $genotipe->id)
                    ->count();
            }
        }

        return $samplesPerMonth;
    }

    public function groupChartCity(Request $request)
    {
        $months    = Months::getMonths();
        $genotipes = Genotipe::where('viruses_id', $request->id)->get();

        $samplesPerMonth = [];

        $samples = Sample::whereYear('pickup_date', $request->year ?? date('Y', strtotime(now())))->where('viruses_id', $request->id)->where('province_id', $request->provincy)->get();

        if (count($samples) < 1) {
            return $samples;
        }

        foreach ($genotipes as $genotipe) {
            $samplesPerMonth[$genotipe->genotipe_code] = [];

            foreach ($months as $month) {
                // get the number of samples for each genotipe in each month by year of pickup_date
                $samplesPerMonth[$genotipe->genotipe_code][] = Sample::with('genotipe')->where('viruses_id', $request->id)
                    ->where('pickup_date', '>=', date('Y-m-d', strtotime($request->year . '-' . array_search($month, $months) + 1 . '-01')))
                    ->where('pickup_date', '<=', date('Y-m-d', strtotime('+30 days', strtotime($request->year . '-' . array_search($month, $months) + 1 . '-01'))))
                    ->where('genotipes_id', $genotipe->id)
                    ->where('province_id', $request->provincy)
                    ->count();
            }
        }

        return $samplesPerMonth;
    }

    public function getLastYearSample($id)
    {
        $data = DB::table('samples')->selectRaw('YEAR(pickup_date) as lastYearSample')->where('viruses_id', $id)->groupBy('pickup_date')->orderByDesc('pickup_date')->first();
        if (!empty($data)) {
            return $data->lastYearSample;
        } else {
            return null;
        }
    }

    public function getLastCitySample($id)
    {
        $data = DB::table('samples')->select('province_id')->where('viruses_id', $id)->groupBy('province_id')->first();
        if (!empty($data)) {
            return $data->province_id;
        } else {
            return null;
        }
    }
}
