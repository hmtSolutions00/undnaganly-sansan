<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        // Kalau sudah login, langsung lempar ke dashboard admin
        if (session('is_admin')) {
            return redirect()->route('admin.invitations.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $envUsername = env('ADMIN_USERNAME', 'admin');
        $envPassword = env('ADMIN_PASSWORD', 'rahasia123');

        if (
            $credentials['username'] === $envUsername &&
            $credentials['password'] === $envPassword
        ) {
            // set flag di session
            session(['is_admin' => true]);

            return redirect()
                ->route('admin.invitations.index')
                ->with('success', 'Berhasil login sebagai admin.');
        }

        return back()
            ->withInput(['username' => $credentials['username']])
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Anda sudah logout.');
    }
}
