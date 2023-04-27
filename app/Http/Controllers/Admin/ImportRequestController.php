<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\NewImportRequestValidator;
use App\Interfaces\AuthorInterface;
use App\Interfaces\ImportRequestInterface;
use App\Interfaces\SampleInterface;
use App\Interfaces\VirusInterface;
use App\Mail\ActivationSingleRequest;
use App\Models\Citation;
use App\Models\Genotipe;
use App\Models\Province;
use App\Models\Regency;
use App\Properties\Months;
use App\Properties\Years;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportRequestController extends Controller
{

    private $importRequest;
    private $author;
    private $virus;
    private $sample;

    public function __construct(ImportRequestInterface $importRequest, AuthorInterface $author, VirusInterface $virus, SampleInterface $sample)
    {
        $this->importRequest = $importRequest;
        $this->author        = $author;
        $this->virus         = $virus;
        $this->sample        = $sample;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()
                ->of($this->importRequest->get()->where(
                    'created_by',
                    auth()->user()->id
                ))
                ->addColumn('file', function ($data) {
                    return view('admin.bank.import-request.columns.file', ['data' => $data]);
                })
                ->addColumn('file_code', function ($data) {
                    $file_code = $data->file_code;
                    $file_code = substr($file_code, 0, -3);
                    $file_code = $file_code . "***";
                    return $file_code;
                })
                ->addColumn('created_at', function ($data) {
                    return date('d-m-Y H:i', strtotime($data->created_at));
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('status', function ($data) {
                    return view('admin.bank.import-request.columns.status', ['data' => $data]);
                })
                ->addColumn('action', function ($data) {
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

    public function show(string $id, Request $request)
    {
        $importRequest = $this->importRequest->find($id);
        $sample = $this->sample->getByFileCode($importRequest->file_code)->where('is_queue', 1);
        if ($request->ajax()) {
            return datatables()
                ->of($sample)
                ->addColumn('sample_code', function ($sample) {
                    return $sample->sample_code ?? null;
                })
                ->addColumn('file_code', function ($sample) {
                    $file_code = $sample->file_code;
                    $file_code = substr($file_code, 0, -3);
                    $file_code = $file_code . "***";
                    return $file_code ?? null;
                })
                ->addColumn('virus', function ($sample) {
                    return $sample->virus->name ?? null;
                })
                ->addColumn('genotipe', function ($sample) {
                    return $sample->genotipe->genotipe_code ?? null;
                })
                ->addColumn('pickup_date', function ($sample) {
                    return date('Y', strtotime($sample->pickup_date));
                })
                ->addColumn('place', function ($sample) {
                    return $sample->place ?? null;
                })
                ->addColumn('province', function ($sample) {
                    return $sample->province->name ?? null;
                })
                ->addColumn('gene_name', function ($sample) {
                    return $sample->gene_name ?? null;
                })
                ->addColumn('citation', function ($sample) {
                    return $sample->citation->title ?? null;
                })
                ->addColumn('file_sequence', function ($sample) {
                    return view('admin.bank.columns.file_sequence', ['sample' => $sample]);
                })
                ->addColumn('status', function ($sample) {
                    return $sample->is_active == 1 ? 'Diterima' : ($sample->is_active == 2 ? 'Ditolak' : 'Belum Diverifikasi');
                })
                ->addColumn('action', function ($sample) {
                    return view('admin.bank.import-request.detail-columns.action', [
                        'sample' => $sample
                    ]);
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.bank.import-request.show', [
            'importRequest' => $this->importRequest->find($id)
        ]);
    }

    public function edit(string $id)
    {
        return view('admin.bank.import-request.edit', ['data' => $this->importRequest->find($id)]);
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

    public function admin(Request $request)
    {
        if ($request->ajax()) {
            return datatables()
                ->of($this->importRequest->get())
                ->addColumn('file', function ($data) {
                    return view('admin.bank.import-request.columns.file', ['data' => $data]);
                })
                ->addColumn('file_code', function ($data) {
                    $file_code = $data->file_code;
                    $file_code = substr($file_code, 0, -3);
                    $file_code = $file_code . "***";
                    return $file_code;
                })
                ->addColumn('created_at', function ($data) {
                    return date('d-m-Y H:i', strtotime($data->created_at));
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('status', function ($data) {
                    return view('admin.bank.import-request.columns.status', ['data' => $data]);
                })
                ->addColumn('action', function ($data) {
                    return view('admin.bank.import-request.admin.columns.action', ['data' => $data]);
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.bank.import-request.admin.index');
    }

    public function changeStatus(Request $request)
    {
        $status = $request->status == 'accepted' ? 1 : ($request->status == 'rejected' ? 2 : 0);
        try {
            $this->importRequest->changeStatus($request->id, $status, $request->reason);
            return response()->json(true);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }

    public function validationFile(Request $request)
    {
        try {
            Excel::import(new NewImportRequestValidator, $request->file('file'));
            return response()->json(true);
        } catch (ValidationException $e) {
            // send row number and error message
            $failures = $e->failures();
            $error = [];
            foreach ($failures as $failure) {
                $error[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values()
                ];
            }

            return response()->json($error);
        }
    }

    public function import(Request $request)
    {
        try {
            $this->importRequest->import($request->id);
            return response()->json([
                'status' => true,
                'message' => 'Import berhasil'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function createSingle($fileCode)
    {
        return view('admin.bank.import-request.create-single-data', [
            'fileCode' => $fileCode,
            'authors'   => $this->author->get(),
            'viruses'   => $this->virus->get(),
            'provinces' => Province::all(),
            'months'    => Months::getMonths(),
            'years'     => Years::getYears(),
            'citations' => Citation::all()
        ]);
    }

    public function storeSingle(Request $request)
    {
        $pickup_date = $request->pickup_date;
        $month = explode('/', $pickup_date)[0];
        $year = explode('/', $pickup_date)[1];

        // conver to date
        $pickup_date = date('Y-m-d', strtotime($year . '-' . $month . '-01'));
        $request->merge(['pickup_date' => $pickup_date]);

        try {
            $this->importRequest->storeSingle($request->all());
            Mail::send(new ActivationSingleRequest(auth()->user(), '2'));
            return redirect()->route('admin.import-request.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }

    public function showSingle($id)
    {
        $sample = $this->sample->find($id);
        $importRequest = $this->importRequest->findByFileCode($sample->file_code);
        return view('admin.bank.import-request.show-single-data', [
            'sample'        => $sample,
            'provinces'     => Province::all(),
            'authors'       => $this->author->get(),
            'viruses'       => $this->virus->get(),
            'importRequest' => $importRequest,
        ]);
    }

    public function editSingle($id)
    {
        return view('admin.bank.import-request.edit-single-data', [
            'sample'    => $this->sample->find($id),
            'authors'   => $this->author->get(),
            'viruses'   => $this->virus->get(),
            'provinces' => Province::all(),
            'genotipes' => Genotipe::all(),
            'regencies' => Regency::all(),
            'months'    => Months::getMonths(),
            'years'     => Years::getYears(),
            'citations' => Citation::all()
        ]);
    }

    public function updateSingle(Request $request, $id)
    {
        $months         = Months::getMonths();
        $month          = array_search($request->pickup_month, $months) + 1;
        $pickup_date    = date('Y-m-d', strtotime($request->pickup_year . '-' . $month . '-01'));

        $request->merge(['pickup_date' => $pickup_date]);

        try {
            $this->importRequest->updateSingle($request->all(), $id);

            Mail::send(new ActivationSingleRequest(auth()->user(), '2'));

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Data gagal disimpan');
        }
    }

    public function changeStatusSingle(Request $request, $id)
    {
        try {
            $this->importRequest->changeStatusSingle($id, $request->status);
            Mail::send(new ActivationSingleRequest(auth()->user(), $request->status));
            return response()->json([
                'status' => 'success',
                'message' => 'Status berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
