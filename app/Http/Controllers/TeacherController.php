<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    private function getSettings()
    {
        return DB::table('global_settings')->pluck('setting_value', 'setting_key')->toArray();
    }

    public function dashboard()
    {
        $settings = $this->getSettings();
        
        $totalSiswa = DB::table('users')->where('role_id', 3)->count();
        $totalSubmissions = DB::table('coding_submissions')->count();
        $gradedCount = DB::table('coding_submissions')->where('score', '>', 0)->count();
        $ungradedCount = DB::table('coding_submissions')->where('score', '<=', 0)->orWhereNull('score')->count();

        // 10 Submisi Terbaru
        $recentSubmissions = DB::table('coding_submissions')
            ->leftJoin('users', 'coding_submissions.user_id', '=', 'users.id')
            ->select('coding_submissions.*', DB::raw('COALESCE(users.name, coding_submissions.guest_name, "Tamu") as student_name'))
            ->orderBy('coding_submissions.created_at', 'desc')
            ->limit(10)
            ->get();

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

        DB::table('coding_submissions')->where('id', $id)->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Nilai tugas siswa berhasil disimpan!');
    }
}
