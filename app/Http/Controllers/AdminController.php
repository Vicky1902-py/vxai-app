<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    private function getSettings()
    {
        if (!Schema::hasTable('global_settings')) {
            return [];
        }
        return DB::table('global_settings')->pluck('setting_value', 'setting_key')->toArray();
    }

    // Jalankan migrasi dan penambahan kolom secara otomatis jika ada yang kurang
    private function ensureTablesExist()
    {
        try {
            // 1. Kolom role_id, xp, level di tabel users
            if (Schema::hasTable('users')) {
                Schema::table('users', function (Blueprint $table) {
                    if (!Schema::hasColumn('users', 'role_id')) {
                        $table->unsignedBigInteger('role_id')->default(3)->after('password');
                    }
                    if (!Schema::hasColumn('users', 'xp')) {
                        $table->unsignedInteger('xp')->default(0)->after('role_id');
                    }
                    if (!Schema::hasColumn('users', 'level')) {
                        $table->unsignedInteger('level')->default(1)->after('xp');
                    }
                });
            }

            // 2. Tabel roles
            if (!Schema::hasTable('roles')) {
                Schema::create('roles', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('display_name')->nullable();
                    $table->timestamps();
                });
                DB::table('roles')->insertOrIgnore([
                    ['id' => 1, 'name' => 'Super Admin', 'display_name' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 2, 'name' => 'Guru', 'display_name' => 'Tenaga Pendidik', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 3, 'name' => 'Siswa', 'display_name' => 'Pelajar / Peserta', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }

            // 3. Tabel global_settings
            if (!Schema::hasTable('global_settings')) {
                Schema::create('global_settings', function (Blueprint $table) {
                    $table->id();
                    $table->string('setting_key')->unique();
                    $table->text('setting_value')->nullable();
                    $table->timestamps();
                });
                DB::table('global_settings')->insertOrIgnore([
                    ['setting_key' => 'app_name', 'setting_value' => 'VxAI Coding Lab', 'created_at' => now(), 'updated_at' => now()],
                    ['setting_key' => 'maintenance_mode', 'setting_value' => 'false', 'created_at' => now(), 'updated_at' => now()],
                    ['setting_key' => 'contact_email', 'setting_value' => 'admin@vxai.online', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }

            // 4. Tabel coding_submissions dan kolomnya
            if (!Schema::hasTable('coding_submissions')) {
                Schema::create('coding_submissions', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id')->nullable()->index();
                    $table->string('guest_name')->nullable();
                    $table->longText('html_code')->nullable();
                    $table->longText('css_code')->nullable();
                    $table->longText('js_code')->nullable();
                    $table->integer('score')->nullable()->default(0);
                    $table->text('feedback')->nullable();
                    $table->timestamps();
                });
            } else {
                Schema::table('coding_submissions', function (Blueprint $table) {
                    if (!Schema::hasColumn('coding_submissions', 'guest_name')) {
                        $table->string('guest_name')->nullable()->after('user_id');
                    }
                    if (!Schema::hasColumn('coding_submissions', 'score')) {
                        $table->integer('score')->nullable()->default(0)->after('js_code');
                    }
                    if (!Schema::hasColumn('coding_submissions', 'feedback')) {
                        $table->text('feedback')->nullable()->after('score');
                    }
                });
            }

            // 5. Tabel visitor_traffic
            if (!Schema::hasTable('visitor_traffic')) {
                Schema::create('visitor_traffic', function (Blueprint $table) {
                    $table->id();
                    $table->string('ip_address', 45)->nullable()->index();
                    $table->string('page_url')->index();
                    $table->string('referer')->nullable();
                    $table->string('device', 20)->default('Desktop');
                    $table->string('browser', 50)->nullable();
                    $table->text('user_agent')->nullable();
                    $table->timestamp('visited_at')->useCurrent()->index();
                });
            }
        } catch (\Throwable $e) {
            // Tangkap dan abaikan agar request web tidak pernah error fatal
        }
    }

    // Dashboard Utama dengan Metrik Trafik & Submisi Real-Time
    public function dashboard()
    {
        $this->ensureTablesExist();
        $settings = $this->getSettings();
        
        $totalSiswa = Schema::hasTable('users') ? DB::table('users')->where('role_id', 3)->count() : 0;
        $totalGuru = Schema::hasTable('users') ? DB::table('users')->where('role_id', 2)->count() : 0;
        $totalSubmissions = Schema::hasTable('coding_submissions') ? DB::table('coding_submissions')->count() : 0;

        // Metrik Trafik Pengunjung
        $todayVisits = 0;
        $weeklyVisits = 0;
        $totalVisits = 0;
        $recentTraffic = collect();
        $topPages = collect();
        $deviceDesktop = 0;
        $deviceMobile = 0;
        $deviceTablet = 0;

        if (Schema::hasTable('visitor_traffic')) {
            $todayVisits = DB::table('visitor_traffic')
                ->whereDate('visited_at', now()->toDateString())
                ->count();

            $weeklyVisits = DB::table('visitor_traffic')
                ->where('visited_at', '>=', now()->subDays(7))
                ->count();

            $totalVisits = DB::table('visitor_traffic')->count();

            $recentTraffic = DB::table('visitor_traffic')
                ->orderBy('visited_at', 'desc')
                ->limit(10)
                ->get();

            $topPages = DB::table('visitor_traffic')
                ->select('page_url', DB::raw('count(*) as total'))
                ->groupBy('page_url')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            $deviceDesktop = DB::table('visitor_traffic')->where('device', 'Desktop')->count();
            $deviceMobile = DB::table('visitor_traffic')->where('device', 'Mobile')->count();
            $deviceTablet = DB::table('visitor_traffic')->where('device', 'Tablet')->count();
        }

        // Submisi Koding Terbaru (Dengan proteksi kolom guest_name)
        $recentSubmissions = collect();
        if (Schema::hasTable('coding_submissions')) {
            $hasGuestName = Schema::hasColumn('coding_submissions', 'guest_name');
            $nameSelect = $hasGuestName 
                ? 'COALESCE(users.name, coding_submissions.guest_name, "Tamu") as student_name'
                : 'COALESCE(users.name, "Siswa") as student_name';

            $recentSubmissions = DB::table('coding_submissions')
                ->leftJoin('users', 'coding_submissions.user_id', '=', 'users.id')
                ->select('coding_submissions.*', DB::raw($nameSelect))
                ->orderBy('coding_submissions.created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalSubmissions', 'settings',
            'todayVisits', 'weeklyVisits', 'totalVisits', 'recentTraffic',
            'topPages', 'deviceDesktop', 'deviceMobile', 'deviceTablet',
            'recentSubmissions'
        ));
    }

    // Endpoint khusus untuk memicu migrasi & seed database via klik/URL jika diperlukan
    public function runMigration()
    {
        $this->ensureTablesExist();
        return redirect()->route('admin.dashboard')->with('success', 'Seluruh tabel dan struktur database berhasil diperbarui!');
    }

    // Manajemen Pengguna (Daftar User)
    public function users()
    {
        $this->ensureTablesExist();
        
        $users = collect();
        if (Schema::hasTable('users')) {
            $query = DB::table('users');
            if (Schema::hasTable('roles')) {
                $query->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                      ->select('users.*', 'roles.name as role_name');
            } else {
                $query->select('users.*', DB::raw('"User" as role_name'));
            }
            $users = $query->orderBy('users.created_at', 'desc')->get();
        }
            
        $settings = $this->getSettings();
        
        return view('admin.users', compact('users', 'settings'));
    }
    
    // Formulir Tambah Pengguna Baru
    public function createUser()
    {
        $this->ensureTablesExist();
        $roles = Schema::hasTable('roles') ? DB::table('roles')->get() : collect();
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
            'role_id' => 'required|integer'
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

        $roles = Schema::hasTable('roles') ? DB::table('roles')->get() : collect();
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
            'role_id' => 'required|integer',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($updateData);

        return redirect()->route('admin.users')->with('success', "Data pengguna {$request->name} berhasil diperbarui!");
    }

    // Hapus Pengguna
    public function deleteUser($id)
    {
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
        $this->ensureTablesExist();
        $settings = $this->getSettings();
        return view('admin.settings', compact('settings'));
    }
    
    public function updateSettings(Request $request)
    {
        $this->ensureTablesExist();

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

        if ($request->hasFile('app_logo')) {
            $logo = $request->file('app_logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $logoName);
            
            DB::table('global_settings')->updateOrInsert(
                ['setting_key' => 'app_logo'],
                ['setting_value' => 'images/' . $logoName, 'updated_at' => now()]
            );
        }

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
    
    // Import Pengguna Masal dari CSV
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
                        'role_id' => 3,
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
        $this->ensureTablesExist();

        $submissions = collect();
        if (Schema::hasTable('coding_submissions')) {
            $hasGuestName = Schema::hasColumn('coding_submissions', 'guest_name');
            $nameSelect = $hasGuestName 
                ? 'COALESCE(users.name, coding_submissions.guest_name, "Tamu") as student_name'
                : 'COALESCE(users.name, "Siswa") as student_name';

            $submissions = DB::table('coding_submissions')
                ->leftJoin('users', 'coding_submissions.user_id', '=', 'users.id')
                ->select('coding_submissions.*', DB::raw($nameSelect), 'users.email as student_email')
                ->orderBy('coding_submissions.created_at', 'desc')
                ->get();
        }
            
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

        if (Schema::hasTable('coding_submissions')) {
            DB::table('coding_submissions')->where('id', $id)->update([
                'score' => $request->score,
                'feedback' => $request->feedback,
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Nilai dan umpan balik berhasil disimpan!');
    }
}