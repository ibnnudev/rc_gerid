<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\GenotipeInterface;
use App\Models\Virus;
use App\Scopes\HasActiveScope;

class GenotipeController extends Controller
{
    private $genotipe;

    public function __construct(GenotipeInterface $genotipe)
    {
        $this->genotipe = $genotipe;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.genotipe.index', [
            'genotipes' => $this->genotipe->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.genotipe.create',[
            'viruses' => Virus::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->genotipe->store($request->all());
            return redirect()->route('admin.genotipe.index')->with('success', 'Genotipe berhasil ditambahkan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Genotipe gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.genotipe.show', [
            'genotipe' => $this->genotipe->find($id),
            'viruses' => Virus::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.genotipe.edit', [
            'genotipe' => $this->genotipe->find($id),
            'viruses' => Virus::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->genotipe->update($request->all(), $id);
            return redirect()->route('admin.genotipe.index')->with('success', 'Genotipe berhasil diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Genotipe gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->genotipe->destroy($id);
            return redirect()->route('admin.genotipe.index')->with('success', 'Virus berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Virus gagal dihapus');
        }
    }
}
