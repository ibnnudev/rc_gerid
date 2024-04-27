<?php

namespace App\Http\Controllers;

use App\Interfaces\SlideInterface;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    private $slide;

    public function __construct(SlideInterface $slide)
    {
        $this->slide = $slide;
    }

    public function index(Request $request)
    {
        $slides = $this->slide->get();
        if ($request->wantsJson()) {
            return datatables()
                ->of($slides)
                ->addColumn('title', function ($data) {
                    return $data->title;
                })
                ->addColumn('action', function ($data) {
                    return view('admin.slide.column.action', compact('data'));
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.slide.index');
    }

    public function create()
    {
        return view('admin.slide.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable',
        ]);

        $this->slide->store($request->except('_token'));

        return redirect()->route('admin.slide.index')->with('success', 'Slide berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin.slide.edit', [
            'data' => $this->slide->getById($id),
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'title' => 'required',
            'content' => 'required',
            'video' => 'nullable',
        ]);

        $this->slide->update($id, $request->except('_token', '_method'));

        return redirect()->route('admin.slide.index')->with('success', 'Slide berhasil diubah');
    }

    public function destroy($id)
    {
        $this->slide->destroy($id);

        return json_encode(true);
    }

    public function show($slug)
    {
        return view('guest.slide.show', [
            'data' => $this->slide->getBySlug($slug),
        ]);
    }
}
