<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SampleImport;
use App\Interfaces\AuthorInterface;
use App\Interfaces\SampleInterface;
use App\Interfaces\VirusInterface;
use App\Models\Author;
use App\Models\District;
use App\Models\Genotipe;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Sample;
use App\Properties\Months;
use App\Properties\Years;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\returnSelf;

class BankController extends Controller
{
    private $author;
    private $virus;
    private $sample;

    public function __construct(AuthorInterface $author, VirusInterface $virus, SampleInterface $sample)
    {
        $this->author = $author;
        $this->virus  = $virus;
        $this->sample = $sample;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()
                ->of($this->sample->get())
                ->addColumn('sample_code', function ($sample) {
                    return $sample->sample_code;
                })
                ->addColumn('virus', function ($sample) {
                    return $sample->virus->name;
                })
                ->addColumn('genotipe', function ($sample) {
                    return $sample->genotipe->genotipe_code;
                })
                ->addColumn('pickup_date', function ($sample) {
                    return date('Y', strtotime($sample->pickup_date));
                })
                ->addColumn('place', function ($sample) {
                    return $sample->place;
                })
                ->addColumn('province', function ($sample) {
                    return $sample->province->name ?? null;
                })
                ->addColumn('gene_name', function ($sample) {
                    return $sample->gene_name;
                })
                // ->addColumn('title', function ($sample) {
                //     return $sample->citations->title;
                // })
                ->addColumn('author', function ($sample) {
                    return $sample->author->name;
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
        return view('admin.bank.index');
    }

    public function create()
    {
        return view('admin.bank.create', [
            'authors'    => $this->author->get(),
            'viruses'    => $this->virus->get(),
            'provinces'  => Province::all(),
            'months'     => Months::getMonths(),
            'years'      => Years::getYears(),
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pickup_date = $request->pickup_date;
        $month = explode('/', $pickup_date)[0];
        $year = explode('/', $pickup_date)[1];

        // conver to date
        $pickup_date = date('Y-m-d', strtotime($year . '-' . $month . '-01'));
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

        Excel::import(new SampleImport, $request->file('import_file'));

        return redirect()->route('admin.bank.index')->with('success', 'Data berhasil diimport');
    }
}
