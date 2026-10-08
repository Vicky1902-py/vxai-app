<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeacherController extends Controller
{
    private function getSettings()
    {
        if (!Schema::hasTable('global_settings')) {
            return [];
        }
        return DB::table('global_settings')->pluck('setting_value', 'setting_key')->toArray();
    }

    public function dashboard()
    {
        $settings = $this->getSettings();
        
        $totalSiswa = Schema::hasTable('users') ? DB::table('users')->where('role_id', 3)->count() : 0;
        $totalSubmissions = Schema::hasTable('coding_submissions') ? DB::table('coding_submissions')->count() : 0;
        $gradedCount = Schema::hasTable('coding_submissions') ? DB::table('coding_submissions')->where('score', '>', 0)->count() : 0;
        $ungradedCount = Schema::hasTable('coding_submissions') ? DB::table('coding_submissions')->where(function($q) {
            $q->where('score', '<=', 0)->orWhereNull('score');
        })->count() : 0;

        // 10 Submisi Terbaru (Dengan identitas siswa / tamu ber-IP)
        $recentSubmissions = collect();
        if (Schema::hasTable('coding_submissions')) {
            $recentSubmissions = DB::table('coding_submissions')
                ->leftJoin('users', 'coding_submissions.user_id', '=', 'users.id')
                ->select(
                    'coding_submissions.*',
                    DB::raw('CASE 
                        WHEN coding_submissions.guest_name LIKE "%[Tamu%" THEN coding_submissions.guest_name
                        WHEN users.name IS NOT NULL THEN users.name
                        WHEN coding_submissions.guest_name IS NOT NULL AND coding_submissions.guest_name != "" THEN coding_submissions.guest_name
                        ELSE "Pengunjung Tamu"
                    END as student_name'),
                    DB::raw('CASE
                        WHEN coding_submissions.guest_name LIKE "%[Tamu%" THEN "Publik (Tamu)"
                        WHEN users.email IS NOT NULL THEN users.email
                        ELSE "Publik (Tamu)"
                    END as student_email'),
                    'users.xp as student_xp',
                    'users.level as student_level'
                )
                ->orderBy('coding_submissions.created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('guru.dashboard', compact(
            'settings', 'totalSiswa', 'totalSubmissions', 'gradedCount', 'ungradedCount', 'recentSubmissions'
        ));
    }

    public function grade(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
        ]);

        if (Schema::hasTable('coding_submissions')) {
            DB::table('coding_submissions')->where('id', $id)->update([
                'score' => $request->score,
                'feedback' => $request->feedback,
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Nilai tugas siswa berhasil disimpan!');
    }
}
