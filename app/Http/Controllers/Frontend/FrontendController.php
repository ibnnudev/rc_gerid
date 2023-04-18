<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\FrontendInterface;
use App\Interfaces\VirusInterface;
use App\Models\HivCases;
use App\Models\Virus;
use App\Repositories\HivCaseRepository;
use Illuminate\Http\Request;

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
        return view('frontend.marker', [
            'virus' => $this->frontend->getVirus($id),
            'request' => NULL,
            'years' => HivCases::select('year')->distinct()->groupBy('year')->orderBy('year')->get(),
            'individualCases' => $this->frontend->hivCases(),
        ]);
    }

    public function listCitations(Request $request)
    {
        return view('frontend.citation.listCitation',[
            'request' => $request,
            'virus' => $this->frontend->getVirus($request['virus_id']),
            'listCitations' => $this->frontend->listCitations($request)
        ]);
    }

    public function detailCitation($id)
    {
        $virus_id = $this->frontend->detailCitation($id)->sample[0]->viruses_id;
        return view('frontend.citation.detail',[
            'request' => NULL,
            'virus' => $this->frontend->getVirus($virus_id),
            'citation' => $this->frontend->detailCitation($id)
        ]);
    }

    public function detailFasta($id)
    {
        // return $this->frontend->detailFasta($id);
        $virus_id = $this->frontend->detailFasta($id)->sample[0]->viruses_id;
        return view('frontend.citation.fasta',[
            'request' => NULL,
            'virus' => $this->frontend->detailFasta($virus_id),
            'citation' => $this->frontend->detailFasta($id)
        ]);
    }
}
