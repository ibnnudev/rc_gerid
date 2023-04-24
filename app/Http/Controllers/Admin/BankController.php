<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SampleImport;
use App\Interfaces\AuthorInterface;
use App\Interfaces\ImportRequestInterface;
use App\Interfaces\SampleInterface;
use App\Interfaces\VirusInterface;
use App\Models\Citation;
use App\Models\District;
use App\Models\Genotipe;
use App\Models\Province;
use App\Models\Regency;
use App\Properties\Months;
use App\Properties\Years;
use App\Scopes\HasActiveScope;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class BankController extends Controller
{
    private $author;
    private $virus;
    private $sample;
    private $importRequest;

    public function __construct(AuthorInterface $author, VirusInterface $virus, SampleInterface $sample, ImportRequestInterface $importRequest)
    {
        $this->author           = $author;
        $this->virus            = $virus;
        $this->sample           = $sample;
        $this->importRequest    = $importRequest;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()
                ->of($this->sample->get())
                ->addColumn('sample_code', function ($sample) {
                    return $sample->sample_code ?? null;
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
                ->addColumn('action', function ($sample) {
                    return view('admin.bank.columns.action', [
                        'sample' => $sample,
                    ]);
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.bank.index', [
            'totalSample' => $this->sample->get(),
        ]);
    }

    public function create()
    {
        return view('admin.bank.create', [
            'authors'   => $this->author->get(),
            'viruses'   => $this->virus->get(),
            'provinces' => Province::all(),
            'months'    => Months::getMonths(),
            'years'     => Years::getYears(),
            'citations' => Citation::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pickup_date = $request->pickup_date;
        $month = explode('/', $pickup_date)[0];
        $year = explode('/', $pickup_date)[1];

        // conver to date
        $pickup_date = date('Y-m-d', strtotime($year . '-' . $month . '-01'));
        $request->merge(['pickup_date' => $pickup_date]);

        try {
            $this->sample->store($request->all());
            return redirect()->route('admin.bank.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.bank.show', [
            'sample'    => $this->sample->find($id),
            'provinces' => Province::all(),
            'authors'   => $this->author->get(),
            'viruses'   => $this->virus->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.bank.edit', [
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $months = Months::getMonths();
        $month = array_search($request->pickup_month, $months) + 1;
        $pickup_date = date('Y-m-d', strtotime($request->pickup_year . '-' . $month . '-01'));

        $request->merge(['pickup_date' => $pickup_date]);

        try {
            $this->sample->update($request->all(), $id);
            return redirect()->route('admin.bank.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->sample->destroy($id);
            return redirect()->route('admin.bank.index')->with('success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('error', 'Data gagal dihapus');
        }
    }

    // Custom Function

    public function getRegency(Request $request)
    {
        $regencies = Regency::where('province_id', $request->province_id)->get();
        return response()->json($regencies);
    }

    public function getGenotipe(Request $request)
    {
        $genotipes = Genotipe::where('viruses_id', $request->virus_id)->get();
        return response()->json($genotipes);
    }

    public function getDistrict(Request $request)
    {
        $districts = District::where('regency_id', $request->regency_id)->get();
        return response()->json($districts);
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $file_code = uniqid();
            Excel::import(new SampleImport($file_code), $request->file('import_file'));
            $filename = $file_code . '.' . $request->file('import_file')->getClientOriginalExtension();
            $request->file('import_file')->storeAs('public/imported', $filename);

            // TODO: save file to table import request and set status as 4 (imported) and set imported_by as current user

            return redirect()->route('admin.bank.index')->with('success', 'Data berhasil diimport');
        } catch (ValidationException $e) {
            return view('admin.bank.index', [
                'failures' => $e->failures(),
                'totalSample' => $this->sample->get(),
            ]);
        }
    }

    public function advancedSearch(Request $request)
    {
        $attributes = $this->sample->getAttributes();
        return view('admin.bank.advance-search', [
            'attributes' => $attributes,
        ]);
    }

    public function getData(Request $request)
    {
        $samples = $this->sample->advancedSearch($request->all());
        return view('admin.bank.tables.table-content', [
            'samples' => $samples,
        ])->render();
    }

    public function imported(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            if ($request->ajax()) {
                return datatables()
                    ->of($this->importRequest->imported())
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
                    ->addColumn('approved', function ($data) {
                        return view('admin.bank.imported.columns.approved', ['data' => $data]);
                    })
                    ->addColumn('rejected', function ($data) {
                        return view('admin.bank.imported.columns.rejected', ['data' => $data]);
                    })
                    ->addColumn('imported', function ($data) {
                        return view('admin.bank.imported.columns.imported', ['data' => $data]);
                    })
                    ->addColumn('status', function ($data) {
                        return view('admin.bank.imported.columns.status', ['data' => $data]);
                    })
                    ->addColumn('action', function ($data) {
                        return view('admin.bank.imported.columns.action', ['data' => $data]);
                    })
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('admin.bank.imported.index');
        } else {
            if ($request->ajax()) {
                return datatables()
                    ->of(
                        $this->sample->get()
                    )
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
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('admin.bank.imported.user.index', [
                'totalSample' => $this->sample->get(),
            ]);
        }
    }

    public function deleteByFileCode(Request $request)
    {
        try {
            $this->sample->deleteByFileCode($request->file_code);
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data sekuen pada file ' . $request->file_code . ' berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data sekuen pada file ' . $request->file_code . ' gagal dihapus',
                'error'     => $th->getMessage(),
            ]);
        }
    }

    public function recoveryByFileCode(Request $request)
    {
        try {
            $this->sample->recoveryByFileCode($request->file_code);
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data sekuen pada file ' . $request->file_code . ' berhasil direcovery',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data sekuen pada file ' . $request->file_code . ' gagal direcovery',
                'error'     => $th->getMessage(),
            ]);
        }
    }
}
