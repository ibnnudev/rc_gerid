<?php

namespace App\Repositories;

use App\Interfaces\FrontendInterface;
use App\Models\Author;
use App\Models\Citation;
use App\Models\District;
use App\Models\HivCases;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Virus;

class FrontendRepository implements FrontendInterface
{

    private $virus;
    private $hivCases;
    private $citation;
    private $user;
    private $author;



    public function __construct(Virus $virus, HivCases $hivCases, Citation $citation ,User $user, Author $author) 
    {
        $this->virus = $virus;
        $this->hivCases = $hivCases;
        $this->citation = $citation;
        $this->user = $user;
        $this->author = $author;
    }

    public function getVirus($id)
    {
        return $this->virus->where('id', $id)->first();
    }

    public function hivCases()
    {
        return $this->hivCases->with(['province', 'regency', 'district', 'transmission'])->get();
    }

    public function listCitations($request)
    {
        // get data from filtering
        $data =  $this->citation->with(['author', 'sampleCitation'])
        ->whereHas('sample', function ($q) use ($request){
            $q->where('viruses_id',$request['virus_id'])
            ->Orwhere('sequence_data', 'like', '%' . $request['q'] . '%')
            ->OrWhere('gene_name', 'like', '%' . $request['q'] . '%')
            ->whereHas('virus', function ($r) use ($request){
                $r->Orwhere('name', '=', $request['q']);
            })
            ->whereHas('genotipe', function ($r) use ($request){
                $r->Orwhere('genotipe_code', '=', $request['q']);
            });
        })
        ->wherehas('author', function ($q) use ($request){
            $q->Orwhere('name', 'like', '%' . $request['q'] . '%'); 
        })
        ->get();
        
        // mapping data
        return $data->map(function ($item, $key) {
            return [
                'id_citation' => $item['id'],
                'user' => $this->user->getName($item['users_id']),    
                'title' => $item->title,
                'province' => $this->getProvince($item->sample[0]->province_id),
                'regency' => $this->getRegency($item->sample[0]->regency_id),
                'author' => $this->getAuthor($item->author_id),
                'monthYear' => $this->getMonthYear($item->sample[0]->pickup_date),
                // accession ncbi from sample code
                'accession_ncbi' => $item->sample[0]->sample_code,
                // accession indagi from virus code
                'accession_indagi' => $item->sample[0]->virus_code,
            ];
        });
    }

    public function detailCitation($id)
    {
        return $this->citation->with('author','sample')->where('id', $id)->first();   
    }

    public function detailFasta($id)
    {
        return $this->citation->with('sample')->where('id', $id)->first();   
    }

    public function getProvince($districtId)
    {
        return Province::where('id', $districtId)->first()->name;
    }

    public function getRegency($regencyId)
    {
        return Regency::where('id', $regencyId)->first()->name;
    }

    public function getAuthor($authorId)
    {
        return $this->author->with('institution')->where('id', $authorId)->first();
    }

    public function getMonthYear($date)
    {
        $month = array (1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
        $split = explode('-', $date);
        return $month[ (int)$split[1] ] . " " . $split[0];
    }
}
