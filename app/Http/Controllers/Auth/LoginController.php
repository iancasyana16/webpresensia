<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {

        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('dashboard-admin-home');
            } elseif (auth()->user()->role === 'guru') {
                return redirect()->route('dashboard-guru-absen');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('dashboard-admin-home');
            } elseif ($user->role === 'guru') {
                return redirect()->route('dashboard-guru-absen');
            } else {
                return redirect()->route('/')->with('error', 'Role tidak dikenali.');
            }

        }

        return back()->with('error', 'Login Gagal Periksa Username dan Password !');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('loginPage');
    }
}
