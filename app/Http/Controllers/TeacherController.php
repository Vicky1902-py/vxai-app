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

    public function deleteSubmission($id)
    {
        if (!Schema::hasTable('coding_submissions')) {
            return redirect()->back()->with('error', 'Tabel coding_submissions tidak ditemukan.');
        }

        $submission = DB::table('coding_submissions')->where('id', $id)->first();
        if (!$submission) {
            return redirect()->back()->with('error', 'Data submisi tidak ditemukan atau sudah dihapus.');
        }

        $studentName = $submission->guest_name ?? 'Pengguna';
        $challengeTitle = $submission->challenge_title ?? 'Latihan Koding';
        $xpAdjusted = false;
        $newLevel = 1;
        $newXp = 0;

        // 1. Hapus entri dari tabel coding_submissions
        DB::table('coding_submissions')->where('id', $id)->delete();

        // 2. Jika submisi ini milik akun siswa yang terdaftar, sinkronkan ulang XP & Level siswa
        if (!empty($submission->user_id) && Schema::hasTable('users')) {
            $user = DB::table('users')->where('id', $submission->user_id)->first();
            if ($user) {
                $studentName = $user->name;

                // Hitung jumlah submisi koding siswa yang masih tersisa
                $remainingSubmissions = DB::table('coding_submissions')
                    ->where('user_id', $user->id)
                    ->count();

                // Hitung ulang XP (25 XP per submission unik)
                $newXp = $remainingSubmissions * 25;
                $newLevel = max(1, (int) floor($newXp / 100) + 1);

                DB::table('users')->where('id', $user->id)->update([
                    'xp' => $newXp,
                    'level' => $newLevel,
                    'updated_at' => now(),
                ]);

                $xpAdjusted = true;
            }
        }

        $message = "Hasil koding \"{$challengeTitle}\" milik {$studentName} berhasil dihapus.";
        if ($xpAdjusted) {
            $message .= " XP siswa disesuaikan menjadi {$newXp} XP (Level {$newLevel}), dan status level pada akun siswa otomatis terhapus.";
        }

        return redirect()->back()->with('success', $message);
    }
}
