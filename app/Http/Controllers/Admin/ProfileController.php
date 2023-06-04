<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        return view('admin.profile.index', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = User::find($id);

        if ($request->hasFile('avatar')) {
            $oldFile = 'public/avatar/' . $user->avatar;
            if (Storage::exists($oldFile)) {
                Storage::delete($oldFile);
            }

            $filename = uniqid() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('public/avatar', $filename);

            $user->avatar = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
            'new_password_confirmation' => 'required|string|min:8|same:new_password'
        ], [
            'new_password_confirmation.same' => 'Konfirmasi password tidak sesuai',
            'new_password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'new_password_confirmation.min' => 'Konfirmasi password minimal 8 karakter',
            'new_password.min' => 'Password minimal 8 karakter',
        ]);

        $user = User::find(auth()->user()->id);

        if (!password_verify($request->old_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui');
    }
}
