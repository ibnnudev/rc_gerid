<?php

namespace App\Repositories;

use App\Interfaces\SampleInterface;
use App\Models\Author;
use App\Models\Citation;
use App\Models\ImportRequest;
use App\Models\Sample;
use App\Models\Virus;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SampleRepository implements SampleInterface
{
    private $sample;
    private $citation;
    private $virus;
    private $author;
    private $importRequest;

    public function __construct(Sample $sample, Citation $citation, Virus $virus, Author $author, ImportRequest $importRequest)
    {
        $this->sample   = $sample;
        $this->citation = $citation;
        $this->virus    = $virus;
        $this->author   = $author;
        $this->importRequest = $importRequest;
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
                'file_code'          => $data['file_code'] ?? null,
                'gene_name'          => $data['gene_name'],
                'size_gene'          => $data['size_gene'],
                'sequence_data'      => $data['sequence_data'] ?? null,
                'place'              => $data['place'],
                'regency_id'         => $data['regency_id'],
                'province_id'        => $data['province_id'],
                'pickup_date'        => date('Y-m-d', strtotime($data['pickup_date'])),
                'citation_id'        => isset($data['new_title']) ? $citation->id : $data['citation_id'],
                'genotipes_id'       => $data['genotipes_id'],
                'virus_code'         => $this->generateVirusCode($data['viruses_id']),
                'sequence_data_file' => $data['sequence_data_file'] ?? null,
                'created_by'         => auth()->user()->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        DB::commit();
    }

    public function generateVirusCode($virus_id)
    {
        // make combination: virus_id + count of sample
        $virus = $this->virus->find($virus_id);
        $count = $this->sample->where('viruses_id', $virus_id)->count();
        $count = str_pad($count, 3, '0', STR_PAD_LEFT);

        $virusName = str_replace(' ', '-', $virus->name);
        $virusName = strtoupper($virusName);

        $code = $virusName . '-' . $count;
        return $code;
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
                'file_code'          => $data['file_code'] ?? null,
                'gene_name'          => $data['gene_name'],
                'size_gene'          => $data['size_gene'],
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
        return $this->sample->withoutGlobalScope(HasActiveScope::class)->with('virus', 'genotipe')->find($id);
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

    public function deleteByFileCode($fileCode)
    {
        DB::beginTransaction();

        try {
            $this->sample->where('file_code', $fileCode)->update([
                'is_active' => 0,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        try {
            $this->importRequest->where('file_code', $fileCode)->update([
                'removed_by' => auth()->user()->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        DB::commit();
    }

    public function recoveryByFileCode($fileCode)
    {
        DB::beginTransaction();

        try {
            $this->sample->withoutGlobalScope(HasActiveScope::class)->where([
                ['file_code', $fileCode],
                ['is_active', 0],
            ])->update([
                'is_active' => 1,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        try {
            $this->importRequest->where('file_code', $fileCode)->update([
                'removed_by' => null,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        DB::commit();
    }

    public function getByFileCode($fileCode)
    {
        return $this->sample->withoutGlobalScope(HasActiveScope::class)
            ->where('file_code', $fileCode)
            ->with('virus', 'genotipe')->get();
    }
}
