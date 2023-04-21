<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportRequestInterface;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class ImportRequestController extends Controller
{

    private $importRequest;

    public function __construct(ImportRequestInterface $importRequest) {
        $this->importRequest = $importRequest;
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            return datatables()
            ->of($this->importRequest->get())
            ->addColumn('file', function($data) {
                return view('admin.bank.import-request.columns.file', ['data' => $data]);
            })
            ->addColumn('created_at', function($data) {
                return date('d-m-Y H:i', strtotime($data->created_at));
            })
            ->addColumn('description', function($data) {
                return $data->description;
            })
            ->addColumn('status', function($data) {
                return view('admin.bank.import-request.columns.status', ['data' => $data]);
            })
            ->addColumn('action', function($data) {
                return view('admin.bank.import-request.columns.action', ['data' => $data]);
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.bank.import-request.index');
    }

    public function create()
    {
        return view('admin.bank.import-request.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx'],
            'description' => ['required']
        ]);

        try {
            $this->importRequest->store($request->all());
            return redirect()->route('admin.import-request.index')->with('success', 'Permintaan import berhasil dibuat');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with('error', 'Permintaan import gagal dibuat');
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        return view('admin.bank.import-request.edit', ['data'=> $this->importRequest->find($id)]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'file' => ['nullable', 'file', 'mimes:xlsx'],
            'description' => ['required']
        ]);

        try {
            $this->importRequest->update($request->all(), $id);
            return redirect()->route('admin.import-request.index')->with('success', 'Permintaan import berhasil diupdate');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with('error', 'Permintaan import gagal diupdate');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->importRequest->destroy($id);
            return response()->json(true);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
}
