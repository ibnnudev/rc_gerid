<?php

namespace App\Repositories;

use App\Interfaces\FrontendInterface;
use App\Models\Author;
use App\Models\Citation;
use App\Models\HivCases;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Sample;
use App\Models\User;
use App\Models\Virus;
use Illuminate\Support\Facades\DB;

class FrontendRepository implements FrontendInterface
{
    private $virus;

    private $hivCases;

    private $citation;

    private $user;

    private $author;

    private $sample;

    public function __construct(Virus $virus, HivCases $hivCases, Citation $citation, User $user, Author $author, Sample $sample)
    {
        $this->virus = $virus;
        $this->hivCases = $hivCases;
        $this->citation = $citation;
        $this->user = $user;
        $this->author = $author;
        $this->sample = $sample;
    }

    public function getVirus($id)
    {
        return $this->virus->where('id', $id)->first();
    }

    public function getAllSampleByVirus($req)
    {
        // return $req;
        $data = DB::table('samples')
            ->selectRaw('count(genotipe_code) as jumlah, genotipe_code')
            ->leftJoin('genotipes', 'genotipes.id', 'samples.genotipes_id')
            ->leftJoin('viruses', 'viruses.id', 'samples.viruses_id')
            ->where('viruses.id', $req->id)
            ->whereYear('samples.pickup_date', $req->year)
            ->groupBy('genotipes.id', 'genotipe_code')
            ->get();

        $arr = [];
        foreach ($data as $item) {
            $arr['label'][] = $item->genotipe_code;
            $arr['data'][] = $item->jumlah;
        }

        return $arr;
    }

    public function hivCases()
    {
        return $this->hivCases->with(['province', 'regency', 'district', 'transmission'])->get();
    }

    public function listCitations($request)
    {
        // dd(request()->all());
        $data = $this->sample->with(['citation.author', 'province', 'regency', 'virus'])
            ->where('viruses_id', $request['virus_id'])
            ->when(request()->filled('province'), function ($query) {
                return $query->where('province_id', request('province'));
            })
            ->when(request()->filled('regency'), function ($query) {
                return $query->where('regency_id', request('regency'));
            })
            ->when(request()->filled('author'), function ($query) {
                return $query->whereHas('citation.author', function ($query) {
                    return $query->where('author_id', request('author'));
                });
            })
            ->when(request()->filled('year'), function ($query) {
                $year = request('year').'-01-01';

                return $query->where('pickup_date', '>=', $year);
            })
            ->when(request()->filled('genotipe'), function ($query) {
                return $query->where('genotipes_id', request('genotipe'));
            })
            ->get();

        return $data->map(function ($item, $key) {
            return [
                'id_citation' => $item->id,
                'user' => $item->citation->author->name,
                'title' => $item->title,
                'province' => $this->getProvince($item->province_id),
                'regency' => $this->getRegency($item->regency_id),
                'citation' => $item->citation->title,
                'author' => $item->citation->author,
                'monthYear' => $this->getMonthYear($item->pickup_date),
                'accession_ncbi' => $item->sample_code,
                'accession_indagi' => substr($item->virus_code, 0, 3).date('Ym', strtotime($item->pickup_date)).$item->id,
            ];
        });
    }

    public function detailCitation($id)
    {
        $data = DB::table('samples')
            ->where('samples.id', '=', $id)
            ->select('samples.id as id', 'samples.sequence_data', 'samples.gene_name', 'samples.province_id', 'samples.regency_id', 'samples.pickup_date', 'samples.virus_code', 'samples.sample_code', 'users.name', 'citations.title', 'citations.author_id', 'samples.viruses_id')
            // ->select('samples.id', 'samples.province_id', 'samples.regency_id', 'samples.pickup_date', 'samples.virus_code', 'samples.sample_code', 'users.name', 'citations.title', 'citations.author_id', 'samples.viruses_id')
            ->join('citations', 'citations.id', '=', 'samples.citation_id')
            ->join(
                'users',
                'users.id',
                '=',
                'samples.created_by'
            )
            ->join('viruses', 'viruses.id', '=', 'samples.viruses_id')
            ->join('genotipes', 'genotipes.id', '=', 'samples.genotipes_id')
            // ->where('samples.viruses_id', $request['virus_id'])
            // ->Orwhere('genotipes.genotipe_code', $request['q'])
            ->get();

        return $data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'user' => $item->name,
                'title' => $item->title,
                'gene_name' => $item->gene_name,
                'sequence_data' => $item->sequence_data,
                'province' => $this->getProvince($item->province_id),
                'regency' => $this->getRegency($item->regency_id),
                'author' => $this->getAuthor($item->author_id),
                'monthYear' => $this->getMonthYear($item->pickup_date),
                // // accession ncbi from sample code
                'accession_ncbi' => $item->sample_code,
                // // accession indagi from virus code
                'accession_indagi' => $item->virus_code,
            ];
        })[0];
        // return $this->citation->with('author', 'sample')->where('id', $id)->first();
    }

    public function detailFasta($id)
    {
        // return $id;
        $data = DB::table('samples')
            ->where('samples.id', '=', $id)
            // ->select('samples.id as id', 'samples.sequence_data', 'samples.gene_name', 'samples.province_id', 'samples.regency_id', 'samples.pickup_date', 'samples.virus_code', 'samples.sample_code', 'users.name', 'citations.title', 'citations.author_id', 'samples.viruses_id')
            ->join('citations', 'citations.id', '=', 'samples.citation_id')
            ->join(
                'users',
                'users.id',
                '=',
                'samples.created_by'
            )
            ->join('viruses', 'viruses.id', '=', 'samples.viruses_id')
            ->join('genotipes', 'genotipes.id', '=', 'samples.genotipes_id')
            // ->where('samples.viruses_id', $request['virus_id'])
            // ->Orwhere('genotipes.genotipe_code', $request['q'])
            ->get();

        // return $data;
        return $data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'user' => $item->name,
                'title' => $item->title,
                'gene_name' => $item->gene_name,
                'sequence_data' => $item->sequence_data,
                'province' => $this->getProvince($item->province_id),
                'regency' => $this->getRegency($item->regency_id),
                'author' => $this->getAuthor($item->author_id),
                'monthYear' => $this->getMonthYear($item->pickup_date),
                // // accession ncbi from sample code
                'accession_ncbi' => $item->sample_code,
                // // accession indagi from virus code
                'accession_indagi' => $item->virus_code,
            ];
        })[0];
        // return $this->citation->with('sample')->where('id', $id)->first();
    }

    public function getProvince($districtId)
    {
        return Province::where('id', $districtId)->first()->name ?? '';
    }

    public function getRegency($regencyId)
    {
        if ($regencyId == 0) {
            return null;
        }

        return Regency::where('id', $regencyId)->first()->name;
    }

    public function getAuthor($authorId)
    {
        return $this->author->with('institution')->where('id', $authorId)->first();
    }

    public function getMonthYear($date)
    {
        $month = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $split = explode('-', $date);

        return $month[(int) $split[1]].' '.$split[0];
    }

    public function getVirusByName($name)
    {
        return $this->virus->where('name', $name)->first();
    }
}
