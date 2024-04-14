<?php

namespace App\Repositories;

use App\Imports\SampleImport;
use App\Interfaces\ImportRequestInterface;
use App\Mail\NewImportRequest;
use App\Mail\StatusActivationImportRequest;
use App\Models\Author;
use App\Models\Citation;
use App\Models\ImportRequest;
use App\Models\Sample;
use App\Models\Virus;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportRequestRepository implements ImportRequestInterface
{
    private $sample;

    private $citation;

    private $virus;

    private $author;

    private $importRequest;

    public function __construct(Sample $sample, Citation $citation, Virus $virus, Author $author, ImportRequest $importRequest)
    {
        $this->sample = $sample;
        $this->citation = $citation;
        $this->virus = $virus;
        $this->author = $author;
        $this->importRequest = $importRequest;
    }

    public function get()
    {
        return $this->importRequest->with(['importedBy', 'viruses'])->get();
    }

    public function store($data)
    {
        $filename = time().uniqid().'.'.$data['file']->getClientOriginalExtension();
        $data['file']->storeAs('public/import-request', $filename);
        $data['file'] = $filename;

        $user = auth()->user()->id;

        $importRequest = $this->importRequest->create([
            'viruses_id' => $data['viruses_id'],
            'filename' => $data['file'],
            'file_code' => uniqid(),
            'imported_by' => $user,
            'description' => $data['description'],
        ]);

        Mail::send(new NewImportRequest(auth()->user(), $importRequest->file_code));

        return true;
    }

    public function find($id)
    {
        return $this->importRequest->find($id);
    }

    public function update($data, $id)
    {
        $importRequest = $this->importRequest->find($id);
        if (isset($data['file'])) {
            if ($importRequest->filename) {
                $oldFile = 'public/import-request/'.$importRequest->filename;
                if (Storage::exists($oldFile)) {
                    Storage::delete($oldFile);
                }
            }

            $filename = time().uniqid().'.'.$data['file']->getClientOriginalExtension();
            $data['file']->storeAs('public/import-request', $filename);
            $data['file'] = $filename;

            $importRequest->filename = $data['file'];
        }

        $importRequest->viruses_id = $data['viruses_id'];
        $importRequest->description = $data['description'];
        $importRequest->status = 0;
        $importRequest->save();

        return true;
    }

    public function destroy($id)
    {
        $importRequest = $this->importRequest->find($id);
        // delete file
        if ($importRequest->filename) {
            $oldFile = 'public/import-request/'.$importRequest->filename;
            if (Storage::exists($oldFile)) {
                Storage::delete($oldFile);
            }
        }

        $importRequest->delete();

        return true;
    }

    public function changeStatus($id, $status, $reason)
    {
        DB::beginTransaction();

        try {
            $importRequest = $this->importRequest->find($id);

            if ($status == 1) {
                $importRequest->accepted_by = auth()->user()->id;
                $importRequest->accepted_reason = $reason;
                $importRequest->rejected_by = null;
                $importRequest->rejected_reason = null;
            } elseif ($status == 2) {
                $importRequest->rejected_by = auth()->user()->id;
                $importRequest->rejected_reason = $reason;
                $importRequest->accepted_by = null;
                $importRequest->accepted_reason = null;
            } elseif ($status == 0) {
                $importRequest->rejected_by = null;
                $importRequest->accepted_by = null;
                $importRequest->rejected_reason = null;
                $importRequest->accepted_reason = null;
            }

            $importRequest->status = $status;
            $importRequest->save();
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }

        DB::commit();

        Mail::send(new StatusActivationImportRequest($status, $importRequest->file_code, $reason, auth()->user()));

        return true;
    }

    public function import($id)
    {
        DB::beginTransaction();
        try {
            $importRequest = $this->importRequest->find($id);
            $importRequest->status = 3;
            $importRequest->save();

            $file = 'public/import-request/'.$importRequest->filename;
            Excel::import(new SampleImport($importRequest->file_code), $file);

            $importRequest->status = 3; // 3 = imported
            $importRequest->save();

            // save file to new location
            $newFile = 'public/imported/'.$importRequest->file_code.'-'.$importRequest->filename;

            // copy file
            Storage::copy($file, $newFile);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function imported($userId = null)
    {
        $importRequest = $this->importRequest->where(
            // status 1 or 3
            function ($query) {
                $query->where('status', 1)
                    ->orWhere('status', 3);
            }
        )->with(['importedBy', 'acceptedBy', 'rejectedBy']);

        if ($userId) {
            $importRequest->where('imported_by', $userId);
        }

        return $importRequest->get();
    }

    public function generateVirusCode($virus_id)
    {
        // make combination: virus_id + count of sample
        $virus = $this->virus->find($virus_id);
        $count = $this->sample->where('viruses_id', $virus_id)->count();
        $count = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        $virusName = str_replace(' ', '-', $virus->name);
        $virusName = strtoupper($virusName);

        $code = $virusName.'-'.$count.'-'.uniqid();

        return $code;
    }

    public function storeSingle($data)
    {
        DB::beginTransaction();

        if (isset($data['sequence_data_file'])) {
            $filename = time().'.'.$data['sequence_data_file']->getClientOriginalExtension();
            $data['sequence_data_file']->storeAs('public/sequence_data', $filename);

            $data['sequence_data_file'] = $filename;
        }

        if (isset($data['new_title'])) {
            // insert to authors
            try {
                $author = $this->author->create([
                    'name' => $data['new_author'],
                    'member' => $data['new_member'],
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                dd($th->getMessage());
            }

            // insert to citations
            $citation = $this->citation->create([
                'title' => $data['new_title'],
                'author_id' => $author->id,
                'users_id' => auth()->user()->id,
            ]);
        }

        // insert to samples
        try {
            $sample = $this->sample->create([
                'sample_code' => $data['sample_code'],
                'viruses_id' => $data['viruses_id'],
                'file_code' => $data['file_code'] ?? null,
                'gene_name' => $data['gene_name'],
                'size_gene' => $data['size_gene'],
                'sequence_data' => $data['sequence_data'] ?? null,
                'place' => $data['place'],
                'regency_id' => $data['regency_id'],
                'province_id' => $data['province_id'],
                'pickup_date' => date('Y-m-d', strtotime($data['pickup_date'])),
                'citation_id' => isset($data['new_title']) ? $citation->id : $data['citation_id'],
                'genotipes_id' => $data['genotipes_id'],
                'virus_code' => $this->generateVirusCode($data['viruses_id']),
                'sequence_data_file' => $data['sequence_data_file'] ?? null,
                'is_active' => 2, // 2 = waiting for approval
                'created_by' => auth()->user()->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage());
        }

        DB::commit();
    }

    public function findByFileCode($fileCode)
    {
        return $this->importRequest->where('file_code', $fileCode)->first();
    }

    public function updateSingle($data, $id)
    {
        DB::beginTransaction();

        // update sample
        try {
            $sample = $this->sample->withoutGlobalScope(HasActiveScope::class)->find($id);
            if (isset($data['sequence_data_file'])) {
                // delete old file
                if ($sample->sequence_data_file) {
                    $oldFile = 'public/sequence_data/'.$sample->sequence_data_file;
                    if (Storage::exists($oldFile)) {
                        Storage::delete($oldFile);
                    }
                }

                $filename = time().'.'.$data['sequence_data_file']->getClientOriginalExtension();
                $data['sequence_data_file']->storeAs('public/sequence_data', $filename);

                $data['sequence_data_file'] = $filename;
            }

            $sample->update([
                'sample_code' => $data['sample_code'],
                'viruses_id' => $data['viruses_id'],
                'file_code' => $data['file_code'] ?? null,
                'gene_name' => $data['gene_name'],
                'size_gene' => $data['size_gene'],
                'sequence_data' => $data['sequence_data'] ?? null,
                'place' => $data['place'],
                'regency_id' => $data['regency_id'],
                'province_id' => $data['province_id'],
                'pickup_date' => date('Y-m-d', strtotime($data['pickup_date'])),
                'citation_id' => $data['title'],
                'genotipes_id' => $data['genotipes_id'],
                'sequence_data_file' => isset($data['sequence_data_file']) ? $data['sequence_data_file'] : $sample->sequence_data_file,
                'is_active' => 2, // 2 = waiting for approval
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }

        DB::commit();
    }

    public function changeStatusSingle($id, $status)
    {
        DB::beginTransaction();

        try {
            $this->sample
                ->withoutGlobalScope(HasActiveScope::class)
                ->find($id)->update([
                'is_active' => $status,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        DB::commit();
    }

    public function getByValidator()
    {
        $virus_id = auth()->user()->virus_id;

        return $this->importRequest->with(['importedBy', 'viruses'])->where('viruses_id', $virus_id)->get();
    }
}
