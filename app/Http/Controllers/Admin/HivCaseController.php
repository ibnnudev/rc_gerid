<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\HivCasesImport;
use App\Interfaces\HivCaseInterface;
use App\Models\HivCases;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HivCaseController extends Controller
{
    private $hivCase;

    public function __construct(HivCaseInterface $hivCase) {
        $this->hivCase = $hivCase;
    }

    public function index()
    {
        return view('admin.hiv-cases.index', [
            'hivCases' => $this->hivCase->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Custom Function

    public function import(Request $request) {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        HivCases::truncate();

        Excel::import(new HivCasesImport, $request->file('import_file'));

        return redirect()->route('admin.hiv-case.index')->with('success', 'Data HIV Cases berhasil diimport!');
    }
}
