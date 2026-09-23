<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $role = (int) $user->role_id;

            // Jika situs sedang dalam mode pemeliharaan dan bukan Admin, tolak login
            $maintenance = DB::table('global_settings')
                ->where('setting_key', 'maintenance_mode')
                ->value('setting_value');

            if ($maintenance === 'true' && $role !== 1) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Sistem saat ini sedang dalam mode pemeliharaan berkala. Akses siswa/guru ditutup sementara.',
                ]);
            }
            
            // Arahkan ke dashboard masing-masing peran
            if ($role === 1) {
                return redirect()->intended('/admin');
            } elseif ($role === 2) {
                return redirect()->intended('/guru');
            } else {
                return redirect()->intended('/siswa');
            }
        }

        return back()->withErrors([
            'email' => 'Email/NISN atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}