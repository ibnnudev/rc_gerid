<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\HivCaseInterface;
use App\Interfaces\TransmissionInterface;
use App\Interfaces\VirusInterface;
use Illuminate\Http\Request;

class CasesController extends Controller
{
    private $hivCase;

    public function __construct(HivCaseInterface $hivCase)
    {
        $this->hivCase = $hivCase;
    }

    public function hiv(Request $request)
    {
        if ($request->ajax()) {
            return datatables()
                ->of($this->hivCase->get())
                ->addColumn('idkd', function ($case) {
                    return $case->idkd;
                })
                ->addColumn('location', function ($case) {
                    return view('admin.hiv-cases.columns.location', ['case' => $case]);
                })
                ->addColumn('age', function ($case) {
                    return $case->age;
                })
                ->addColumn('sex', function ($case) {
                    return $case->sex == 1 ? 'L' : 'P';
                })
                ->addColumn('transmission', function ($case) {
                    return $case->transmission->name;
                })
                ->addColumn('year', function ($case) {
                    return $case->year;
                })
                ->addColumn('action', function ($case) {
                    return view('admin.hiv-cases.columns.action', ['case' => $case]);
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.hiv-cases.index');
    }
}
