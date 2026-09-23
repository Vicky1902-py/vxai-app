<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    private function getSettings()
    {
        return DB::table('global_settings')->pluck('setting_value', 'setting_key')->toArray();
    }

    // Halaman Beranda Publik
    public function index()
    {
        $settings = $this->getSettings();
        $totalSubmissions = DB::table('coding_submissions')->count();
        $totalStudents = DB::table('users')->where('role_id', 3)->count();

        return view('welcome', compact('settings', 'totalSubmissions', 'totalStudents'));
    }

    // Halaman Playground Publik (Bisa diakses siapa saja tanpa login)
    public function playground()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        return view('public.playground', compact('settings', 'user'));
    }

    // Halaman Tutorial & Kamus Koding (Bagus untuk SEO & Pengunjung Organik Google)
    public function tutorials()
    {
        $settings = $this->getSettings();
        return view('public.tutorials', compact('settings'));
    }

    // Halaman Legal Wajib AdSense: Kebijakan Privasi
    public function privacyPolicy()
    {
        $settings = $this->getSettings();
        return view('public.privacy', compact('settings'));
    }

    // Halaman Legal Wajib AdSense: Syarat dan Ketentuan
    public function terms()
    {
        $settings = $this->getSettings();
        return view('public.terms', compact('settings'));
    }

    // Halaman Tentang Kami
    public function about()
    {
        $settings = $this->getSettings();
        return view('public.about', compact('settings'));
    }

    // Halaman Kontak
    public function contact()
    {
        $settings = $this->getSettings();
        return view('public.contact', compact('settings'));
    }

    // Endpoint ads.txt dinamis
    public function adsTxt()
    {
        $settings = $this->getSettings();
        $content = $settings['ads_txt_content'] ?? "# google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0";
        
        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }

    // Submit Kode dari Playground (Mendukung Siswa Login & Pengunjung Tamu)
    public function submitCode(Request $request)
    {
        $request->validate([
            'html_code' => 'nullable|string|max:100000',
            'css_code' => 'nullable|string|max:100000',
            'js_code' => 'nullable|string|max:100000',
            'guest_name' => 'nullable|string|max:100',
        ]);

        $userId = Auth::id();
        $guestName = $userId ? Auth::user()->name : ($request->input('guest_name') ?: 'Pengunjung Publik');

        // Simpan submisi koding
        DB::table('coding_submissions')->insert([
            'user_id' => $userId,
            'guest_name' => $guestName,
            'html_code' => $request->html_code,
            'css_code' => $request->css_code,
            'js_code' => $request->js_code,
            'score' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Jika user sedang login (Siswa), tambahkan gamifikasi XP & Level
        $xpEarned = 0;
        $newLevel = null;
        $newXp = null;

        if ($userId) {
            $user = Auth::user();
            $xpEarned = 25; // +25 XP tiap submit
            $newXp = (int) $user->xp + $xpEarned;
            // Rumus level: tiap 100 XP naik 1 level
            $newLevel = (int) floor($newXp / 100) + 1;

            DB::table('users')->where('id', $userId)->update([
                'xp' => $newXp,
                'level' => $newLevel,
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $userId 
                ? "Luar biasa! Kode Anda berhasil dikirim ke guru. (+{$xpEarned} XP diperoleh!)" 
                : "Kode Anda berhasil diuji dan disimpan di sistem publik!",
            'is_logged_in' => (bool) $userId,
            'xp_earned' => $xpEarned,
            'total_xp' => $newXp,
            'level' => $newLevel,
        ]);
    }
}
