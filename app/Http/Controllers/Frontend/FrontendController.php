<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthorInterface;
use App\Interfaces\CitationInterface;
use App\Interfaces\FrontendInterface;
use App\Interfaces\GenotipeInterface;
use App\Interfaces\SampleInterface;
use App\Interfaces\SlideInterface;
use App\Interfaces\VirusInterface;
use App\Models\Genotipe;
use App\Models\Province;
use App\Models\Sample;
use App\Properties\Months;
use App\Properties\Years;
use App\Repositories\HivCaseRepository;
use Carbon\Carbon;
// use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use stdClass;

// use Spatie\FlareClient\Http\Response;

class FrontendController extends Controller
{
    private $frontend;
    private $hivCases;
    private $virus;
    private $sample;
    private $author;
    private $genotipe;
    private $citation;
    private $slide;

    public function __construct(FrontendInterface $frontend, HivCaseRepository $hivCases, VirusInterface $virus, SampleInterface $sample, AuthorInterface $author, GenotipeInterface $genotipe, CitationInterface $citation, SlideInterface $slide)
    {
        $this->frontend = $frontend;
        $this->hivCases = $hivCases;
        $this->virus    = $virus;
        $this->sample   = $sample;
        $this->author   = $author;
        $this->genotipe = $genotipe;
        $this->citation = $citation;
        $this->slide    = $slide;
    }

    public function home()
    {
        $sampleGroupByVirus = $this->sample->getAllGroupByVirus();
        $currentTotalSample = $this->sample->get()->count();
        $rangeSample        = $this->sample->get()->groupBy(function ($val) {
            return Carbon::parse($val->pickup_date)->format('Y');
        })->sortBy(function ($items, $key) {
            return $key;
        });
        $totalCitation = $this->citation->get()->count();

        return view('frontend.home', [
            'sampleGroupByVirus' => $sampleGroupByVirus,
            'currentTotalSample' => $currentTotalSample,
            'rangeSample'        => $rangeSample,
            'totalCitation'      => $totalCitation,
            'slides'             => $this->slide->get()
        ]);
    }

    public function detail($name)
    {
        $virusByGen = $this->sample->getSampleVirusByGen($name);
        $virus      = $this->frontend->getVirusByName($name);
        $listYear = Sample::where('viruses_id', $virus->id)->selectRaw('YEAR(pickup_date) as year')->groupBy('year')->get();
        $listProvinces = Sample::where('viruses_id', $virus->id)->with('province')->select('province_id')->groupBy('province_id')->get();
        $authors = Sample::where('viruses_id', $virus->id)->with('citation.author')->get()->pluck('citation.author')->flatten()->unique();
        //dd($listProvinces);
        return view('frontend.area', [
            'listYear'        => $listYear,
            'authors'         => $authors,
            'listProvinces'   => $listProvinces,
            'totalGenotipe'    => $this->frontend->getVirusByName($name)->genotipes->count(),
            'virus'            => $virus,
            'provinces'        => Province::all(),
            'years'            => Years::getYears(),
            'lastYearSample'   => $this->getLastYearSample($virus->id),
            'lastCitySampleId' => $this->getLastCitySample($virus->id),
            'request'          => null,
            'genotipes'        => $this->genotipe->get(),
            'virusByGen'       => $virusByGen,
            'samples'          => $this->sample->getByVirusId($virus->id),
        ]);
    }

    public function getGrouping(Request $request)
    {
        $genotipes       = Genotipe::where('viruses_id', $request->id)->get();
        $samplesPerMonth = [];
        $provinces       = Sample::with('province')->select('province_id')->where('viruses_id', $request->id)->groupBy('province_id')->get();
        foreach ($provinces as $indexProvince => $province) {
            $stdOne                = new stdClass();
            $stdOne->province_id   = $province->province_id;
            // if province_id = 0 then continue
            if ($province->province_id == 0) {
                continue;
            }
            $stdOne->province_name = $province->province->name;
            $stdOne->totalSample = Sample::where('viruses_id', $request->id)
                // ->where('pickup_date', Carbon::parse($request->year . '-01-01'))
                ->where('province_id', $province->province_id)
                ->get();
            $stdOne->potensi       = $stdOne->totalSample->count() > 50 ? 'Tinggi' : 'Rendah';
            $samplesPerMonth[] = $stdOne;
            // dd($stdOne);
            foreach ($genotipes as $indexGenotipe => $genotipe) {
                $stdTwo              = new stdClass();
                $stdTwo->genotipe    = $genotipe->genotipe_code;
                $stdTwo->genotipe_id = $genotipe->id;
                $stdTwo->jumlah      = Sample::with('genotipe')->where('viruses_id', $request->id)
                    // ->where('pickup_date', Carbon::parse($request->year . '-01-01'))
                    ->where('genotipes_id', $genotipe->id)
                    ->where('province_id', $province->province_id)
                    ->count();
                $stdOne->genotipes[] = $stdTwo;
            }
            // dd($stdOne);
        }

        return $samplesPerMonth;
    }

    public function listCitations(Request $request)
    {
        $virus = $this->frontend->getVirus($request['virus_id']);
        return view('frontend.citation.listCitation', [
            'request'       => $request,
            'virus'         => $this->frontend->getVirus($request['virus_id']),
            'listCitations' => $this->frontend->listCitations($request),
            'virus'         => $virus,
            'provinces'     => Province::all(),
            'years'         => Years::getYears(),
            'genotipes'     => $this->genotipe->get(),
            'authors'       => $this->sample->getByAuthorByVirusId($request['virus_id']),
        ]);
    }

    public function detailCitation($id)
    {
        $sample   = DB::table('samples')->where('id', $id)->first();
        $virus    = DB::table('viruses')->where('id', $sample->viruses_id)->first();
        $citation = $this->frontend->detailCitation($id);
        $fasta    = $citation['sequence_data'];
        $fasta    = wordwrap($fasta, 10, ' ', true);
        $fasta    = wordwrap($fasta, 70, '<br>', true);
        $fasta    = '<pre>' . $fasta . '</pre>';

        $fasta    = explode('<br>', $fasta);
        $fasta[0] = '[<span>1</span>]' . "\t\t\t" . $fasta[0];
        $fasta[0] = str_replace('<pre>', '', $fasta[0]);
        for ($i = 1; $i < count($fasta); $i++) {
            $fasta[$i] = '[<span>' . (60 * $i + 1) . '</span>] ' . "\t\t" . $fasta[$i];
        }
        for ($i = 0; $i < count($fasta); $i++) {
            $fasta[$i] = '<pre>' . $fasta[$i] . '</pre>';
        }
        $fasta[0] = str_replace('<br>', '', $fasta[0]);
        $fasta    = implode('', $fasta);

        return view('frontend.citation.detail', [
            'request'  => null,
            'virus'    => $virus,
            'citation' => $citation,
            'fasta'    => $fasta
        ]);
    }

    public function detailFasta($id)
    {
        $sample = DB::table('samples')->where('id', $id)->first();
        $virus  = DB::table('viruses')->where('id', $sample->viruses_id)->first();

        return view('frontend.citation.fasta', [
            'request'  => null,
            'virus'    => $virus,
            'citation' => $this->frontend->detailFasta($id),
        ]);
    }

    public function downloadFasta(Request $request)
    {
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
        // show sample by city per year and per genotipe
        $genotipes = Genotipe::where('viruses_id', $request->id)->get();
        $provinces = Province::where('id', $request->provincy)->get();
        $samplePerYear = [];

        foreach (Years::getYears() as $year) {
            $samplePerYear[$year] = [];
            foreach ($genotipes as $genotipe) {
                $samplePerYear[$year][$genotipe->genotipe_code] = [];
                foreach ($provinces as $province) {
                    $samplePerYear[$year][$genotipe->genotipe_code] = Sample::with('genotipe')->where('viruses_id', $request->id)
                        ->where('pickup_date', '>=', date('Y-m-d', strtotime($year . '-01-01')))
                        ->where('pickup_date', '<=', date('Y-m-d', strtotime($year . '-12-31')))
                        ->where('genotipes_id', $genotipe->id)
                        ->where('province_id', $province->id)
                        ->count();
                }
            }
        }

        return $samplePerYear;
    }

    public function getLastYearSample($id)
    {
        $data = DB::table('samples')->selectRaw('YEAR(MAX(pickup_date)) as lastYearSample')->where('viruses_id', $id)->first();
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
