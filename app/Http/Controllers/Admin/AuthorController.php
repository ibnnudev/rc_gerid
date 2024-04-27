<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthorInterface;
use App\Models\Institution;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    private $author;

    public function __construct(AuthorInterface $author)
    {
        $this->author = $author;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return datatables()
                ->of($this->author->get())
                ->addColumn('name', function ($author) {
                    return $author->name;
                })
                ->addColumn('member', function ($author) {
                    return $author->member;
                })
                ->addColumn('institution', function ($author) {
                    return $author->institution->name ?? '-';
                })
                ->addColumn('action', function ($author) {
                    return view('admin.author.columns.action', [
                        'author' => $author,
                    ]);
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.author.index');
    }

    public function create()
    {
        return view('admin.author.create', [
            'institutions' => Institution::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'member' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'institutions_id' => ['required'],
        ]);

        try {
            $this->author->store($request->all());

            return redirect()->route('admin.author.index')->with('success', 'Penulis berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Penulis gagal ditambahkan');
        }
    }

    public function show(string $id)
    {
        return view('admin.author.show', [
            'author' => $this->author->find($id),
        ]);
    }

    public function edit($id)
    {
        return view('admin.author.edit', [
            'author' => $this->author->find($id),
            'institutions' => Institution::all(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        try {
            $this->author->update($request->all(), $id);

            return redirect()->route('admin.author.index')->with('success', 'Penulis berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Penulis gagal diubah');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->author->destroy($id);

            return back()->with('success', 'Penulis berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('error', 'Penulis gagal dihapus');
        }
    }
}
