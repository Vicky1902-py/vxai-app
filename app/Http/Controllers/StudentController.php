<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        
        // Ambil riwayat submisi siswa lengkap dengan nilai dan catatan guru
        $mySubmissions = collect();
        $totalSubmissions = 0;
        $gradedSubmissions = 0;
        $averageScore = 0;

        if (Schema::hasTable('coding_submissions')) {
            $mySubmissions = DB::table('coding_submissions')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $totalSubmissions = $mySubmissions->count();
            $graded = $mySubmissions->where('score', '>', 0);
            $gradedSubmissions = $graded->count();
            $averageScore = $gradedSubmissions > 0 ? round($graded->avg('score'), 1) : 0;
        }

        return view('siswa.dashboard', compact('user', 'settings', 'mySubmissions', 'totalSubmissions', 'gradedSubmissions', 'averageScore'));
    }
}