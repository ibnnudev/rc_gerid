<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function index()
    {
        return view('admin.bank.index', [
            'samples' => $this->sample->get()
        ]);
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

    public function getCity(Request $request)
    {
        $regencies = Regency::where('province_id', $request->province_id)->get();
        return response()->json($regencies);
    }

    public function getGenotipe(Request $request)
    {
        $genotipes = Genotipe::where('viruses_id', $request->virus_id)->get();
        return response()->json($genotipes);
    }
}
