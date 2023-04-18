<?php

namespace App\Repositories;

use App\Interfaces\SampleInterface;
use App\Models\Author;
use App\Models\Citation;
use App\Models\Sample;
use App\Models\Virus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SampleRepository implements SampleInterface
{
    private $sample;
    private $citation;
    private $virus;
    private $author;

    public function __construct(Sample $sample, Citation $citation, Virus $virus, Author $author)
    {
        $this->sample   = $sample;
        $this->citation = $citation;
        $this->virus    = $virus;
        $this->author   = $author;
    }

    public function get()
    {
        return $this->sample->with('virus', 'genotipe')->get();
    }

    public function store($data)
    {
        DB::beginTransaction();

        if (isset($data['sequence_data_file'])) {
            $filename = time() . '.' . $data['sequence_data_file']->getClientOriginalExtension();
            $data['sequence_data_file']->storeAs('public/sequence_data', $filename);

            $data['sequence_data_file'] = $filename;
        }

        if (isset($data['new_title'])) {
            // insert to authors
            try {
                $author = $this->author->create([
                    'name'   => $data['new_author'],
                    'member' => $data['new_member']
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th->getMessage());
            }

            // insert to citations
            $citation = $this->citation->create([
                'title'     => $data['new_title'],
                'author_id' => $author->id,
                'users_id'  => auth()->user()->id,
            ]);
        }

        // insert to samples
        try {
            $sample = $this->sample->create([
                'sample_code'        => $data['sample_code'],
                'viruses_id'         => $data['viruses_id'],
                'gene_name'          => $data['gene_name'],
                'sequence_data'      => $data['sequence_data'] ?? null,
                'place'              => $data['place'],
                'regency_id'         => $data['regency_id'],
                'province_id'        => $data['province_id'],
                'pickup_date'        => date('Y-m-d', strtotime($data['pickup_date'])),
                'citation_id'        => isset($data['new_title']) ? $citation->id : $data['citation_id'],
                'genotipes_id'       => $data['genotipes_id'],
                'virus_code'         => $this->virus->generateVirusCode(),
                'sequence_data_file' => $data['sequence_data_file'] ?? null,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        DB::commit();
    }

    public function update($data, $id)
    {
        DB::beginTransaction();

        // update sample
        try {
            $sample = $this->sample->find($id);
            if (isset($data['sequence_data_file'])) {
                // delete old file
                if ($sample->sequence_data_file) {
                    $oldFile = 'public/sequence_data/' . $sample->sequence_data_file;
                    if (Storage::exists($oldFile)) {
                        Storage::delete($oldFile);
                    }
                }

                $filename = time() . '.' . $data['sequence_data_file']->getClientOriginalExtension();
                $data['sequence_data_file']->storeAs('public/sequence_data', $filename);

                $data['sequence_data_file'] = $filename;
            }

            $sample->update([
                'sample_code'        => $data['sample_code'],
                'viruses_id'         => $data['viruses_id'],
                'gene_name'          => $data['gene_name'],
                'sequence_data'      => $data['sequence_data'] ?? null,
                'place'              => $data['place'],
                'regency_id'         => $data['regency_id'],
                'province_id'        => $data['province_id'],
                'pickup_date'        => date('Y-m-d', strtotime($data['pickup_date'])),
                'citation_id'        => $data['title'],
                'genotipes_id'       => $data['genotipes_id'],
                'sequence_data_file' => isset($data['sequence_data_file']) ? $data['sequence_data_file'] : $sample->sequence_data_file,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        DB::commit();
    }

    public function find($id)
    {
        return $this->sample->with('virus', 'genotipe')->find($id);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->sample->find($id)->update([
                'is_active' => 0,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        // try {
        //     $this->citation->where('samples_id', $id)->update([
        //         'is_active' => 0,
        //     ]);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     dd($th->getMessage());
        // }

        DB::commit();
    }

    public function getAttributes()
    {
        $samples = $this->sample->with('virus', 'genotipe', 'province')->get();
        // Attributes
        $sampleCodes = $samples->pluck('sample_code')->unique()->toArray();
        $viruses     = $samples->pluck('virus')->unique('id')->toArray();
        $geneNames   = $samples->pluck('gene_name')->unique()->toArray();
        $genotipes   = $samples->pluck('genotipe')->unique('id')->toArray();
        $provinces   = $samples->pluck('province')->unique('id')->toArray();
        $years       = $samples->pluck('pickup_date')->unique()->toArray();
        $years       = array_map(function ($year) {
            return date('Y', strtotime($year));
        }, $years);

        return [
            'sampleCodes' => $sampleCodes,
            'viruses'     => $viruses,
            'geneNames'   => $geneNames,
            'genotipes'   => $genotipes,
            'provinces'   => $provinces,
            'years'       => $years,
        ];
    }

    public function advancedSearch($data)
    {
        return $this->sample->with('virus', 'genotipe', 'province')
        ->when(isset($data['sample_code']), function ($query) use ($data) {
            return $query->where('sample_code', 'like', '%' . $data['sample_code'] . '%');
        })
        ->when(isset($data['virus_id']), function ($query) use ($data) {
            return $query->where('viruses_id', $data['virus_id']);
        })
        ->when(isset($data['gene_name']), function ($query) use ($data) {
            return $query->where('gene_name', 'like', '%' . $data['gene_name'] . '%');
        })
        ->when(isset($data['genotipe_id']), function ($query) use ($data) {
            return $query->where('genotipes_id', $data['genotipe_id']);
        })
        ->when(isset($data['province_id']), function ($query) use ($data) {
            return $query->where('province_id', $data['province_id']);
        })
        ->when(isset($data['pickup_date']), function ($query) use ($data) {
            return $query->whereYear('pickup_date', $data['pickup_date']);
        })
        ->get();
    }
}
