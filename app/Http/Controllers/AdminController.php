<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function getSettings()
    {
        return DB::table('global_settings')->pluck('setting_value', 'setting_key')->toArray();
    }

    // Dashboard Utama dengan Metrik Trafik & Submisi Real-Time
    public function dashboard()
    {
        $settings = $this->getSettings();
        
        $totalSiswa = DB::table('users')->where('role_id', 3)->count();
        $totalGuru = DB::table('users')->where('role_id', 2)->count();
        $totalSubmissions = DB::table('coding_submissions')->count();

        // Metrik Trafik Pengunjung
        $todayVisits = DB::table('visitor_traffic')
            ->whereDate('visited_at', now()->toDateString())
            ->count();

        $weeklyVisits = DB::table('visitor_traffic')
            ->where('visited_at', '>=', now()->subDays(7))
            ->count();

        $totalVisits = DB::table('visitor_traffic')->count();

        // 10 Kunjungan Terbaru
        $recentTraffic = DB::table('visitor_traffic')
            ->orderBy('visited_at', 'desc')
            ->limit(10)
            ->get();

        // 5 Halaman Terpopuler
        $topPages = DB::table('visitor_traffic')
            ->select('page_url', DB::raw('count(*) as total'))
            ->groupBy('page_url')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Pembagian Perangkat (Desktop vs Mobile)
        $deviceDesktop = DB::table('visitor_traffic')->where('device', 'Desktop')->count();
        $deviceMobile = DB::table('visitor_traffic')->where('device', 'Mobile')->count();
        $deviceTablet = DB::table('visitor_traffic')->where('device', 'Tablet')->count();

        // Submisi Koding Terbaru
        $recentSubmissions = DB::table('coding_submissions')
            ->leftJoin('users', 'coding_submissions.user_id', '=', 'users.id')
            ->select('coding_submissions.*', DB::raw('COALESCE(users.name, coding_submissions.guest_name, "Tamu") as student_name'))
            ->orderBy('coding_submissions.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalSubmissions', 'settings',
            'todayVisits', 'weeklyVisits', 'totalVisits', 'recentTraffic',
            'topPages', 'deviceDesktop', 'deviceMobile', 'deviceTablet',
            'recentSubmissions'
        ));
    }

    // Manajemen Pengguna (Daftar User)
    public function users()
    {
        $users = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->orderBy('users.created_at', 'desc')
            ->get();
            
        $settings = $this->getSettings();
        
        return view('admin.users', compact('users', 'settings'));
    }
    
    // Formulir Tambah Pengguna Baru
    public function createUser()
    {
        $roles = DB::table('roles')->get();
        $settings = $this->getSettings();
        
        return view('admin.users_create', compact('roles', 'settings'));
    }

    // Simpan Pengguna Baru
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer|exists:roles,id'
        ], [
            'email.unique' => 'Email atau NISN/NIP ini sudah terdaftar di sistem.',
            'password.min' => 'Password minimal harus 6 karakter.'
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'xp' => 0,
            'level' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Formulir Edit Pengguna
    public function editUser($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect()->route('admin.users')->withErrors(['error' => 'Pengguna tidak ditemukan.']);
        }

        $roles = DB::table('roles')->get();
        $settings = $this->getSettings();

        return view('admin.users_edit', compact('user', 'roles', 'settings'));
    }

    // Update Data Pengguna
    public function updateUser(Request $request, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect()->route('admin.users')->withErrors(['error' => 'Pengguna tidak ditemukan.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $id,
            'role_id' => 'required|integer|exists:roles,id',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'updated_at' => now(),
        ];

        // Ganti password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($updateData);

        return redirect()->route('admin.users')->with('success', "Data pengguna {$request->name} berhasil diperbarui!");
    }

    // Hapus Pengguna
    public function deleteUser($id)
    {
        // Cegah admin menghapus akunnya sendiri yang sedang aktif
        if (Auth::id() == $id) {
            return redirect()->route('admin.users')->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!']);
        }

        $user = DB::table('users')->where('id', $id)->first();
        if ($user) {
            DB::table('users')->where('id', $id)->delete();
            return redirect()->route('admin.users')->with('success', "Pengguna {$user->name} berhasil dihapus dari sistem.");
        }

        return redirect()->route('admin.users')->withErrors(['error' => 'Pengguna tidak ditemukan.']);
    }

    // Pengaturan Global & Konfigurasi Google AdSense
    public function settings()
    {
        $settings = $this->getSettings();
        return view('admin.settings', compact('settings'));
    }
    
    public function updateSettings(Request $request)
    {
        $textSettings = $request->except(['_token', 'app_logo', 'app_favicon']);
        foreach ($textSettings as $key => $value) {
            DB::table('global_settings')->updateOrInsert(
                ['setting_key' => $key],
                [
                    'setting_value' => $value,
                    'updated_at' => now()
                ]
            );
        }

        // Upload Logo
        if ($request->hasFile('app_logo')) {
            $logo = $request->file('app_logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $logoName);
            
            DB::table('global_settings')->updateOrInsert(
                ['setting_key' => 'app_logo'],
                ['setting_value' => 'images/' . $logoName, 'updated_at' => now()]
            );
        }

        // Upload Favicon
        if ($request->hasFile('app_favicon')) {
            $favicon = $request->file('app_favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('images'), $faviconName);
            
            DB::table('global_settings')->updateOrInsert(
                ['setting_key' => 'app_favicon'],
                ['setting_value' => 'images/' . $faviconName, 'updated_at' => now()]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan Aplikasi & Google AdSense berhasil diperbarui!');
    }
    
    // Import Pengguna Masal dari CSV (Mendukung koma dan titik-koma)
    public function importUsers(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:4096',
        ]);

        $file = $request->file('file_csv');
        $handle = fopen($file->getPathname(), "r");
        
        $header = true;
        $count = 0;
        $delimiter = ",";

        // Deteksi delimiter dari baris pertama
        $firstLine = fgets($handle);
        if ($firstLine !== false) {
            if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                $delimiter = ";";
            }
            rewind($handle);
        }

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            if ($header) { $header = false; continue; }
            
            if (count($row) >= 2 && !empty(trim($row[0])) && !empty(trim($row[1]))) {
                $name = trim($row[0]);
                $email = trim($row[1]);
                $password = isset($row[2]) && trim($row[2]) !== '' ? trim($row[2]) : '12345678';

                DB::table('users')->updateOrInsert(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => Hash::make($password),
                        'role_id' => 3, // Otomatis Siswa
                        'xp' => 0,
                        'level' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
                $count++;
            }
        }
        fclose($handle);

        return redirect()->back()->with('success', "{$count} Data Siswa berhasil diimpor!");
    }

    // Monitoring Hasil Koding Siswa & Pengunjung
    public function submissions()
    {
        $submissions = DB::table('coding_submissions')
            ->leftJoin('users', 'coding_submissions.user_id', '=', 'users.id')
            ->select('coding_submissions.*', DB::raw('COALESCE(users.name, coding_submissions.guest_name, "Tamu") as student_name'), 'users.email as student_email')
            ->orderBy('coding_submissions.created_at', 'desc')
            ->get();
            
        $settings = $this->getSettings();
        return view('admin.submissions', compact('submissions', 'settings'));
    }

    // Beri Nilai dan Catatan untuk Hasil Koding
    public function gradeSubmission(Request $request, $id)
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

        return redirect()->back()->with('success', 'Nilai dan umpan balik berhasil disimpan!');
    }
}