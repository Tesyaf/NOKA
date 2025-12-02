<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(array_merge($credentials, ['is_admin' => true]), $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin')->with('success', 'Selamat datang di panel admin.');
        }

        return back()->withErrors([
            'email' => 'Kredensial tidak valid atau bukan admin.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Anda telah keluar.');
    }
}
