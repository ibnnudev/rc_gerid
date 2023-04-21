<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ActivateUser;
use App\Mail\DeactivateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()
                ->of(User::all())
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('role', function ($data) {
                    return view('admin.user-management.columns.role', ['data' => $data]);
                })
                ->addColumn('created_at', function ($data) {
                    return date('d-m-Y', strtotime($data->created_at));
                })
                ->addColumn('is_active', function ($data) {
                    return view('admin.user-management.columns.status', ['is_active' => $data->is_active]);
                })
                ->addColumn('action', function ($data) {
                    return view('admin.user-management.columns.action', [
                        'id' => $data->id,
                        'name' => $data->email,
                        'is_active' => $data->is_active,
                    ]);
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.user-management.index');
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

    public function activate(string $id)
    {
        $user = User::find($id);
        $user->is_active = 1;
        $user->save();

        Mail::send(new ActivateUser($user));

        return redirect()->back()->with('success', 'Berhasil mengaktifkan akun');
    }

    public function deactivate(string $id)
    {
        $user = User::find($id);
        $user->is_active = 0;
        $user->save();

        Mail::send(new DeactivateUser($user));

        return redirect()->back()->with('success', 'Berhasil menonaktifkan akun');
    }

    function role(Request $request) {
        $user = User::find($request->id);
        $user->role = $request->role;
        $user->save();

        return response()->json(true);
    }
}
