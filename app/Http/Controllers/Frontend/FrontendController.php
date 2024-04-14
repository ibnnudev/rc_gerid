<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthorInterface;
use App\Interfaces\FrontendInterface;
use App\Interfaces\GenotipeInterface;
use App\Interfaces\SampleInterface;
use App\Interfaces\VirusInterface;
use App\Models\Genotipe;
use App\Models\Province;
use App\Models\Sample;
use App\Properties\Months;
use App\Properties\Years;
use App\Repositories\HivCaseRepository;
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

    public function __construct(FrontendInterface $frontend, HivCaseRepository $hivCases, VirusInterface $virus, SampleInterface $sample, AuthorInterface $author, GenotipeInterface $genotipe)
    {
        $this->frontend = $frontend;
        $this->hivCases = $hivCases;
        $this->virus = $virus;
        $this->sample = $sample;
        $this->author = $author;
        $this->genotipe = $genotipe;
    }

    public function home()
    {
        $sampleGroupByVirus = $this->sample->getAllGroupByVirus();

        return view('frontend.home', [
            'sampleGroupByVirus' => $sampleGroupByVirus,
        ]);
    }

    public function detail($name)
    {
        $virusByGen = $this->sample->getSampleVirusByGen($name);
        $virus = $this->frontend->getVirusByName($name);
        return view('frontend.area', [
            'totalGenotipe' => $this->frontend->getVirusByName($name)->genotipes->count(),
            'virus' => $virus,
            'provinces' => Province::all(),
            'years' => Years::getYears(),
            'lastYearSample' => $this->getLastYearSample($virus->id),
            'lastCitySampleId' => $this->getLastCitySample($virus->id),
            'request' => null,
            'authors' => $this->sample->getByAuthorByVirusId($virus->id),
            'genotipes' => $this->genotipe->get(),
            'virusByGen' => $virusByGen,
        ]);
    }

    public function getGrouping(Request $request)
    {
        $genotipes = Genotipe::where('viruses_id', $request->id)->get();
        $samplesPerMonth = [];
        $provinces = Sample::with('province')->select('province_id')->where('viruses_id', $request->id)->groupBy('province_id')->get();
        foreach ($provinces as $indexProvince => $province) {
            $stdOne = new stdClass();
            $stdOne->province_id = $province->province_id;
            $stdOne->province_name = $province->province->name;
            $stdOne->potensi = Sample::where('viruses_id', $request->id)
                ->whereBetween('pickup_date', [date('Y-m-d', strtotime($request->startYear . '-01-01')), date('Y-m-d', strtotime($request->endYear . '-01-01'))])
                ->where('province_id', $province->province_id)
                ->count() > 50 ? 'Tinggi' : 'Rendah';
            $samplesPerMonth[] = $stdOne;
            foreach ($genotipes as $indexGenotipe => $genotipe) {
                $stdTwo = new stdClass();
                $stdTwo->genotipe = $genotipe->genotipe_code;
                $stdTwo->genotipe_id = $genotipe->id;
                $stdTwo->jumlah = Sample::with('genotipe')->where('viruses_id', $request->id)
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
        $virus = $this->frontend->getVirus($request['virus_id']);
        return view('frontend.citation.listCitation', [
            'request' => $request,
            'virus' => $this->frontend->getVirus($request['virus_id']),
            'listCitations' => $this->frontend->listCitations($request),
            'virus' => $virus,
            'provinces' => Province::all(),
            'years' => Years::getYears(),
            'genotipes' => $this->genotipe->get(),
            'authors' => $this->sample->getByAuthorByVirusId($request['virus_id']),
        ]);
    }

    public function detailCitation($id)
    {
        $sample = DB::table('samples')->where('id', $id)->first();
        $virus = DB::table('viruses')->where('id', $sample->viruses_id)->first();
        $citation = $this->frontend->detailCitation($id);
        $fasta = $citation['sequence_data'];
        $fasta = wordwrap($fasta, 10, ' ', true);
        $fasta = wordwrap($fasta, 70, '<br>', true);
        $fasta = '<pre>' . $fasta . '</pre>';

        $fasta = explode('<br>', $fasta);
        $fasta[0] = '[<span>1</span>]' . "\t\t\t" . $fasta[0];
        $fasta[0] = str_replace('<pre>', '', $fasta[0]);
        for ($i = 1; $i < count($fasta); $i++) {
            $fasta[$i] = '[<span>' . (60 * $i + 1) . '</span>] ' . "\t\t" . $fasta[$i];
        }
        for ($i = 0; $i < count($fasta); $i++) {
            $fasta[$i] = '<pre class="w-fit">' . $fasta[$i] . '</pre>';
        }
        $fasta[0] = str_replace('<br>', '', $fasta[0]);
        $fasta = implode('', $fasta);

        return view('frontend.citation.detail', [
            'request' => null,
            'virus' => $virus,
            'citation' => $citation,
            'fasta' => $fasta
        ]);
    }

    public function detailFasta($id)
    {
        $sample = DB::table('samples')->where('id', $id)->first();
        $virus = DB::table('viruses')->where('id', $sample->viruses_id)->first();

        return view('frontend.citation.fasta', [
            'request' => null,
            'virus' => $virus,
            'citation' => $this->frontend->detailFasta($id),
        ]);
    }

    public function downloadFasta(Request $request)
    {
        if ($request->fasta == null) {
            $contents = 'Maaf anda belum memilih file';
        } else {
            foreach ($request->fasta as $key => $value) {
                $arr[$key]['sample_code'] = DB::table('samples')->find($value)->sample_code;
                $arr[$key]['gene_name'] = DB::table('samples')->find($value)->gene_name;
                $arr[$key]['sequence_data'] = DB::table('samples')->find($value)->sequence_data;
            }
        }
        // return $ke;
        $contents = json_encode($arr);
        $$headers = [
            'Content-Type' => 'application/plain',
            'Content-Description' => 'File name',
        ];

        return Response::make($contents, 200, $headers);
    }

    public function groupChartYear(Request $request)
    {
        $months = Months::getMonths();
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
        $months = Months::getMonths();
        $genotipes = Genotipe::where('viruses_id', $request->id)->get();

        $samplesPerMonth = [];

        $samples = Sample::whereYear('pickup_date', $request->year ?? date('Y', strtotime(now())))->where('viruses_id', $request->id)->where('province_id', $request->provincy)->get();

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
                    ->where('province_id', $request->provincy)
                    ->count();
            }
        }

        return $samplesPerMonth;
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
