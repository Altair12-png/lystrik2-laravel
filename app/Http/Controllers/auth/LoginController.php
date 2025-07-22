<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        // Jika sudah login, langsung arahkan ke dashboard yang sesuai
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Memproses permintaan login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'user_type' => 'required|string|in:admin,pelanggan',
        ]);

        $guard = ($request->user_type === 'admin') ? 'web' : 'pelanggan';

        if (Auth::guard($guard)->attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            if ($guard === 'web') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('pelanggan.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Kombinasi username dan password tidak cocok.',
        ])->onlyInput('username');
    }

    /**
     * Memproses permintaan logout.
     */
    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // INI BAGIAN YANG DIPERBAIKI
        return redirect()->route('login');
    }
}