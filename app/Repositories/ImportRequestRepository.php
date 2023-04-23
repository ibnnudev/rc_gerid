<?php

namespace App\Repositories;

use App\Interfaces\ImportRequestInterface;
use App\Mail\NewImportRequest;
use App\Mail\StatusActivationImportRequest;
use App\Models\ImportRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ImportRequestRepository implements ImportRequestInterface
{
    private $importRequest;

    public function __construct(ImportRequest $importRequest) {
        $this->importRequest = $importRequest;
    }

    public function get()
    {
        return $this->importRequest->with('importedBy')->get();
    }

    public function store($data)
    {
        $filename = time() . uniqid() . '.' . $data['file']->getClientOriginalExtension();
        $data['file']->storeAs('public/import-request', $filename);
        $data['file'] = $filename;

        $user = auth()->user()->id;

        $importRequest = $this->importRequest->create([
            'filename' => $data['file'],
            'file_code' => uniqid(),
            'imported_by' => $user,
            'description' => $data['description']
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
        if(isset($data['file'])) {
            if ($importRequest->filename) {
                $oldFile = 'public/import-request/' . $importRequest->filename;
                if(Storage::exists($oldFile)) {
                    Storage::delete($oldFile);
                }
            }

            $filename = time() . uniqid() . '.' . $data['file']->getClientOriginalExtension();
            $data['file']->storeAs('public/import-request', $filename);
            $data['file'] = $filename;

            $importRequest->filename = $data['file'];
        }

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
            $oldFile = 'public/import-request/' . $importRequest->filename;
            if(Storage::exists($oldFile)) {
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

        if($status == 1) {
            $importRequest->accepted_by       = auth()->user()->id;
            $importRequest->accepted_reason   = $reason;
            $importRequest->rejected_by       = null;
            $importRequest->rejected_reason   = null;
        } elseif($status == 2) {
            $importRequest->rejected_by       = auth()->user()->id;
            $importRequest->rejected_reason   = $reason;
            $importRequest->accepted_by       = null;
            $importRequest->accepted_reason   = null;
        } elseif($status == 0) {
            $importRequest->rejected_by       = null;
            $importRequest->accepted_by       = null;
            $importRequest->rejected_reason   = null;
            $importRequest->accepted_reason   = null;
        }

        $importRequest->status                = $status;
        $importRequest->save();

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        DB::commit();

        Mail::send(new StatusActivationImportRequest($status, $importRequest->file_code, $reason, auth()->user()));

        return true;
    }
}
