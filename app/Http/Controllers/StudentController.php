<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        // Pastikan hanya user dengan role_id 3 (Siswa) yang bisa masuk sini
        if (Auth::user()->role_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        
        return view('siswa.dashboard', compact('user', 'settings'));
    }
    
    public function playground()
    {
        if (Auth::user()->role_id != 3) {
            return redirect('/');
        }
        
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        return view('siswa.playground', compact('settings'));
    }
    
    public function submitCode(Request $request)
    {
        DB::table('coding_submissions')->insert([
            'user_id' => Auth::id(),
            'html_code' => $request->html_code,
            'css_code' => $request->css_code,
            'js_code' => $request->js_code,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Luar biasa! Kode Anda berhasil dikirim ke guru.']);
    }
}