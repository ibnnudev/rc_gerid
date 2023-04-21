<?php

namespace App\Repositories;

use App\Interfaces\ImportRequestInterface;
use App\Models\ImportRequest;
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

        $this->importRequest->create([
            'filename' => $data['file'],
            'imported_by' => $user,
            'description' => $data['description']
        ]);

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
        $importRequest->save();

        return true;
    }

    public function destroy($id)
    {
        return $this->importRequest->find($id)->update([
            'is_active' => 0
        ]);
    }
}
