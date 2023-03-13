<?php

namespace App\Repositories;

use App\Interfaces\SampleInterface;
use App\Models\Citation;
use App\Models\Sample;
use App\Models\Virus;
use Illuminate\Support\Facades\DB;

class SampleRepository implements SampleInterface
{
    private $sample;
    private $citation;
    private $virus;

    public function __construct(Sample $sample, Citation $citation, Virus $virus)
    {
        $this->sample   = $sample;
        $this->citation = $citation;
        $this->virus    = $virus;
    }

    public function get()
    {
        return $this->sample->with('author', 'virus', 'genotipe')->get();
    }

    public function store($data)
    {
        DB::beginTransaction();

        // insert sample
        try {
            $sample = $this->sample->create([
                'sample_code'   => $data['sample_code'],
                'viruses_id'    => $data['viruses_id'],
                'gene_name'     => $data['gene_name'],
                'sequence_data' => $data['sequence_data'],
                'place'         => $data['place'],
                'city'          => $data['city'],
                // 'subdistrict'   => $data['subdistrict'],
                'region'        => $data['region'],
                'pickup_date'   => date('Y-m-d', strtotime($data['pickup_date'])),
                'authors_id'    => $data['authors_id'],
                'genotipes_id'  => $data['genotipes_id'],
                'virus_code'    => $this->virus->generateVirusCode(),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        // insert citation
        try {
            $this->citation->create([
                'title'      => $data['title'],
                'author_id'  => $data['authors_id'],
                'samples_id' => $sample->id,
                'users_id'   => auth()->user()->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        DB::commit();
    }
}
