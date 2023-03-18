<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\HivCasesImport;
use App\Interfaces\HivCaseInterface;
use App\Interfaces\TransmissionInterface;
use App\Models\HivCases;
use App\Models\Province;
use App\Properties\Years;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HivCaseController extends Controller
{
    private $hivCase;
    private $transmission;

    public function __construct(HivCaseInterface $hivCase, TransmissionInterface $transmission)
    {
        $this->hivCase = $hivCase;
        $this->transmission = $transmission;
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            return datatables()
            ->of($this->hivCase->get())
            ->addColumn('idkd', function($case) {
                return $case->idkd;
            })
            ->addColumn('location', function($case) {
                return view('admin.hiv-cases.columns.location', ['case' => $case]);
            })
            ->addColumn('age', function($case) {
                return $case->age;
            })
            ->addColumn('sex', function($case) {
                return $case->sex == 1 ? 'L' : 'P';
            })
            ->addColumn('transmission', function($case) {
                return $case->transmission->name;
            })
            ->addColumn('year', function($case) {
                return $case->year;
            })
            ->addColumn('action', function($case) {
                return view('admin.hiv-cases.columns.action', ['case' => $case]);
            })
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.hiv-cases.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hiv-cases.create', [
            'provinces'     => Province::all(),
            'transmissions' => $this->transmission->get(),
            'years'         => Years::getYears()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idkd'            => ['unique:hiv_cases,idkd', 'required'],
            'idkd_address'    => ['required', 'string', 'max:255'],
            'latitude'        => ['required', 'string', 'max:255'],
            'longitude'       => ['required', 'string', 'max:255'],
            'province_id'     => ['required'],
            'regency_id'      => ['required'],
            'district_id'     => ['required'],
            'region'          => ['required'],
            'count_of_cases'  => ['required', 'numeric'],
            'age'             => ['required', 'numeric'],
            'age_group'       => ['required'],
            'sex'             => ['required'],
            'transmission_id' => ['required', 'numeric'],
            'year'            => ['required'],
        ]);

        try {
            $this->hivCase->store($request->all());
            return redirect()->route('admin.hiv-case.index')->with('success', 'Data HIV berhasil ditambahkan!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Data HIV gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.hiv-cases.show', [
            'case' => $this->hivCase->find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.hiv-cases.edit', [
            'provinces'     => Province::all(),
            'transmissions' => $this->transmission->get(),
            'years'         => Years::getYears(),
            'case' => $this->hivCase->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idkd'            => ['required', 'unique:hiv_cases,idkd,' . $id],
            'idkd_address'    => ['required', 'string', 'max:255'],
            'latitude'        => ['required', 'string', 'max:255'],
            'longitude'       => ['required', 'string', 'max:255'],
            'province_id'     => ['required'],
            'regency_id'      => ['required'],
            'district_id'     => ['required'],
            'region'          => ['required'],
            'count_of_cases'  => ['required', 'numeric'],
            'age'             => ['required', 'numeric'],
            'age_group'       => ['required'],
            'sex'             => ['required'],
            'transmission_id' => ['required', 'numeric'],
            'year'            => ['required'],
        ]);

        try {
            $this->hivCase->update($request->all(), $id);
            return redirect()->route('admin.hiv-case.index')->with('success', 'Data HIV berhasil diubah!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Data HIV gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->hivCase->destroy($id);
            return redirect()->route('admin.hiv-case.index')->with('success', 'Data HIV berhasil dihapus!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Data HIV gagal dihapus!');
        }
    }

    // Custom Function

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new HivCasesImport, $request->file('import_file'));

        return redirect()->route('admin.hiv-case.index')->with('success', 'Data HIV berhasil diimport!');
    }
}
