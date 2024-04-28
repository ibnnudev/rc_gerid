<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Jobs\NotifyUserLoggedIn;
use App\Jobs\SaveVisitor;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stevebauman\Location\Facades\Location;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            if (Auth::user()->is_active == 0) {
                Auth::guard('web')->logout();

                return redirect()->back()->with('error', 'Akun kamu belum aktif, silahkan hubungi admin');
            }

            dispatch(new SaveVisitor($_SERVER['REMOTE_ADDR']) ?? request()->ip());

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Email atau password salah');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
