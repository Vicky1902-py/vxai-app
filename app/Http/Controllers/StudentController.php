<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        
        // Ambil riwayat submisi siswa
        $mySubmissions = DB::table('coding_submissions')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('siswa.dashboard', compact('user', 'settings', 'mySubmissions'));
    }
}