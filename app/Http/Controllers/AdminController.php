<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = DB::table('users')->where('role_id', 3)->count();
        $totalGuru = DB::table('users')->where('role_id', 2)->count();
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'settings'));
    }

    // Method Baru untuk Manajemen User
    public function users()
    {
        // Mengambil semua user dan menggabungkannya dengan tabel roles
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->orderBy('users.created_at', 'desc')
            ->get();
            
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        
        return view('admin.users', compact('users', 'settings'));
    }
    
    // Menampilkan formulir tambah pengguna
    public function createUser()
    {
        // Mengambil daftar peran (Super Admin, Guru, Siswa) untuk dropdown
        $roles = DB::table('roles')->get();
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        
        return view('admin.users_create', compact('roles', 'settings'));
    }

    // Memproses dan menyimpan data pengguna baru
    public function storeUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|integer|exists:roles,id'
        ], [
            'email.unique' => 'Email atau NISN/NIP ini sudah terdaftar di sistem.',
            'password.min' => 'Password minimal harus 6 karakter.'
        ]);

        // Simpan ke database dengan password yang dienkripsi
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email, // Bisa diisi email nyata atau sekadar NISN/NIP untuk siswa
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role_id' => $request->role_id,
            'xp' => 0,
            'level' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Lempar kembali ke halaman daftar user dengan pesan sukses
        return redirect()->route('admin.users')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function settings()
    {
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        return view('admin.settings', compact('settings'));
    }
    
    // Memproses pembaruan Global Settings
    public function updateSettings(Request $request)
    {
        // 1. Simpan input teks (app_name, primary_color, maintenance_mode)
        $textSettings = $request->except(['_token', 'app_logo', 'app_favicon']);
        foreach ($textSettings as $key => $value) {
            DB::table('global_settings')
                ->where('setting_key', $key)
                ->update(['setting_value' => $value]);
        }

        // 2. Proses upload Logo jika ada
        if ($request->hasFile('app_logo')) {
            $logo = $request->file('app_logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $logoName);
            
            DB::table('global_settings')
                ->where('setting_key', 'app_logo')
                ->update(['setting_value' => 'images/' . $logoName]);
        }

        // 3. Proses upload Favicon jika ada
        if ($request->hasFile('app_favicon')) {
            $favicon = $request->file('app_favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('images'), $faviconName);
            
            DB::table('global_settings')
                ->where('setting_key', 'app_favicon')
                ->update(['setting_value' => 'images/' . $faviconName]);
        }

        return redirect()->back()->with('success', 'Pengaturan Global berhasil diperbarui!');
    }
    
    // Fungsi Import Siswa dari CSV
    public function importUsers(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_csv');
        $handle = fopen($file->getPathname(), "r");
        
        $header = true;
        $count = 0;

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($header) { $header = false; continue; } // Lewati baris pertama (Judul Kolom)
            
            // Asumsi format CSV: Nama (0), Email/NISN (1), Password (2)
            DB::table('users')->updateOrInsert(
                ['email' => $row[1]], // Cek jangan sampai duplikat
                [
                    'name' => $row[0],
                    'password' => \Illuminate\Support\Facades\Hash::make($row[2]),
                    'role_id' => 3, // Otomatis diset sebagai Siswa
                    'xp' => 0,
                    'level' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
            $count++;
        }
        fclose($handle);

        return redirect()->back()->with('success', $count . ' Data Siswa berhasil diimpor!');
    }

    // Fungsi Melihat Hasil Koding Siswa
    public function submissions()
    {
        $submissions = DB::table('coding_submissions')
            ->join('users', 'coding_submissions.user_id', '=', 'users.id')
            ->select('coding_submissions.*', 'users.name as student_name')
            ->orderBy('coding_submissions.created_at', 'desc')
            ->get();
            
        $settings = DB::table('global_settings')->pluck('setting_value', 'setting_key');
        return view('admin.submissions', compact('submissions', 'settings'));
    }
}