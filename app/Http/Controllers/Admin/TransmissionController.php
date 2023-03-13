<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\TransmissionInterface;
use Illuminate\Http\Request;

class TransmissionController extends Controller
{

    private $transmission;

    public function __construct(TransmissionInterface $transmission)
    {
        $this->transmission = $transmission;
    }

    public function index()
    {
        return view('admin.transmission.index', [
            'transmissions' => $this->transmission->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.transmission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:transmissions,name,NULL,id,is_active,1'
        ]);

        try {
            $this->transmission->store($request->all());
            return redirect()->route('admin.transmission.index')->with('success', 'Transmisi berhasil ditambahkan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Transmisi gagal ditambahkan');
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
    public function edit($id)
    {
        return view('admin.transmission.edit', [
            'transmission' => $this->transmission->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:transmissions,name,' . $id . ',id,is_active,1'
        ]);

        try {
            $this->transmission->update($request->all(), $id);
            return redirect()->route('admin.transmission.index')->with('success', 'Transmisi berhasil diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Transmisi gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->transmission->destroy($id);
            return redirect()->route('admin.transmission.index')->with('success', 'Transmisi berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Transmisi gagal dihapus');
        }
    }
}
