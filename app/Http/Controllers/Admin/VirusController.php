<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\VirusInterface;
use Illuminate\Http\Request;

class VirusController extends Controller
{

    private $virus;

    public function __construct(VirusInterface $virus)
    {
        $this->virus = $virus;
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            return datatables()
            ->of($this->virus->get())
            ->addColumn('name', function($virus) {
                return view('admin.virus.columns.name', ['virus' => $virus]);
            })
            ->addColumn('genotipe', function($virus) {
                return view('admin.virus.columns.genotipe', ['virus' => $virus]);
            })
            ->addColumn('action', function($virus) {
                return view('admin.virus.columns.action', ['virus' => $virus]);
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.virus.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.virus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->virus->store($request->all());
            return redirect()->route('admin.virus.index')->with('success', 'Virus berhasil ditambahkan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Virus gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.virus.show', [
            'virus' => $this->virus->find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.virus.edit', [
            'virus' => $this->virus->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->virus->update($request->all(), $id);
            return redirect()->route('admin.virus.index')->with('success', 'Virus berhasil diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Virus gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->virus->destroy($id);
            return redirect()->route('admin.virus.index')->with('success', 'Virus berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Virus gagal dihapus');
        }
    }
}
