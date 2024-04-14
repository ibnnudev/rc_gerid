<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthorInterface;
use App\Interfaces\CitationInterface;
use App\Models\Citation;
use Illuminate\Http\Request;

class CitationController extends Controller
{
    private $citation;

    private $author;

    public function __construct(CitationInterface $citation, AuthorInterface $author)
    {
        $this->citation = $citation;
        $this->author = $author;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()
                ->of($this->citation->get())
                ->addColumn('title', function ($data) {
                    return $data->title;
                })
                ->addColumn('author', function ($data) {
                    return $data->author->name ?? '';
                })
                // ->addColumn('year', function($data) {
                //     return date('Y', strtotime($data->created_at));
                // })
                ->addColumn('action', function ($data) {
                    return view('admin.citation.columns.action', compact('data'));
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.citation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.citation.create', [
            'authors' => $this->author->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:citations,title',
            'author' => 'required',
        ]);

        try {
            $this->citation->store($request->all());

            return redirect()->route('admin.citation.index')->with('success', 'Sitasi berhasil ditambahkan');
        } catch (\Throwable $th) {
            dd($th->getMessage());

            return redirect()->route('admin.citation.index')->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.citation.show', [
            'author' => $this->author->find($id),
            'citation' => $this->citation->find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.citation.edit', [
            'citation' => $this->citation->find($id),
            'authors' => $this->author->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:citations,title,'.$id,
            'author' => 'required',
        ]);

        try {
            $this->citation->update($request->all(), $id);

            return redirect()->route('admin.citation.index')->with('success', 'Sitasi berhasil diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());

            return redirect()->route('admin.citation.index')->with('error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->citation->find($id)->setInactive();

            return redirect()->route('admin.citation.index')->with('success', 'Sitasi berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());

            return redirect()->route('admin.citation.index')->with('error', 'Terjadi kesalahan');
        }
    }

    public function getCitationByAuthor(Request $request)
    {
        $citations = Citation::where('author_id', $request->author_id)->get();

        return response()->json($citations);
    }
}
