<?php

namespace App\Repositories;

use App\Interfaces\SampleInterface;
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
        if($data['sequence_data_file']) {
            $filename = time() . '.' . $data['sequence_data_file']->getClientOriginalExtension();
            $data['sequence_data_file']->storeAs('public/sequence_data', $filename);

            $data['sequence_data_file'] = $filename;
        }
        // insert sample
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
                'authors_id'         => $data['authors_id'],
                'genotipes_id'       => $data['genotipes_id'],
                'virus_code'         => $this->virus->generateVirusCode(),
                'sequence_data_file' => $data['sequence_data_file'] ?? null,
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

    public function update($data, $id)
    {
        DB::beginTransaction();

        // update sample
        try {
            $sample = $this->sample->find($id);
            if(isset($data['sequence_data_file'])) {
                // delete old file
                if($sample->sequence_data_file) {
                    $oldFile = 'public/sequence_data/' . $sample->sequence_data_file;
                    if(Storage::exists($oldFile)) {
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
                'authors_id'         => $data['authors_id'],
                'genotipes_id'       => $data['genotipes_id'],
                'sequence_data_file' => isset($data['sequence_data_file']) ? $data['sequence_data_file'] : $sample->sequence_data_file,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        // update citation
        try {
            $this->citation->where('samples_id', $id)->update([
                'title'      => $data['title'],
                'author_id'  => $data['authors_id'],
                'samples_id' => $id,
                'users_id'   => auth()->user()->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        DB::commit();
    }

    public function find($id)
    {
        return $this->sample->with('author', 'virus', 'genotipe')->find($id);
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

        try {
            $this->citation->where('samples_id', $id)->update([
                'is_active' => 0,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        DB::commit();
    }
}
