<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PlaygroundChallenge;
use App\Services\PlaygroundChallengeService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
                    ['setting_key' => 'robots_txt_content', 'setting_value' => "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nDisallow: /guru\nDisallow: /siswa\nDisallow: /migrate-db\n\nUser-agent: Mediapartners-Google\nAllow: /\n\nSitemap: https://vxai.online/sitemap.xml", 'created_at' => now(), 'updated_at' => now()],
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

            // 6. Tabel articles (Portal Berita & Tips Koding, AI, Komputer, Android)
            if (!Schema::hasTable('articles')) {
                Schema::create('articles', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->string('slug')->unique()->index();
                    $table->string('category', 50)->default('coding')->index();
                    $table->text('summary')->nullable();
                    $table->longText('content');
                    $table->string('thumbnail_url')->nullable();
                    $table->unsignedBigInteger('author_id')->nullable()->index();
                    $table->string('author_name')->default('Admin Editorial');
                    $table->unsignedInteger('views_count')->default(0);
                    $table->string('status', 20)->default('published')->index();
                    $table->boolean('is_featured')->default(false)->index();
                    $table->timestamp('published_at')->nullable()->index();
                    $table->timestamps();
                });
            }

            if (Schema::hasTable('articles')) {
                \App\Services\ArticleContentService::syncDefaultArticles();
            }

            // 7. Tabel playground_challenges (Modul Tantangan Koding Berjenjang)
            if (!Schema::hasTable('playground_challenges')) {
                Schema::create('playground_challenges', function (Blueprint $table) {
                    $table->id();
                    $table->string('slug')->unique()->index();
                    $table->string('title');
                    $table->string('level', 30)->default('pemula')->index();
                    $table->string('level_badge')->default('🟢 Pemula (HTML5)');
                    $table->string('category', 50)->default('html')->index();
                    $table->text('desc')->nullable();
                    $table->longText('instructions')->nullable();
                    $table->longText('html_code')->nullable();
                    $table->longText('css_code')->nullable();
                    $table->longText('js_code')->nullable();
                    $table->integer('order_num')->default(1)->index();
                    $table->boolean('is_active')->default(true)->index();
                    $table->timestamps();
                });
            }

            if (Schema::hasTable('playground_challenges')) {
                PlaygroundChallengeService::syncDefaultChallenges();
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
        $totalArticles = Schema::hasTable('articles') ? DB::table('articles')->count() : 0;
        $totalChallenges = Schema::hasTable('playground_challenges') ? DB::table('playground_challenges')->count() : 0;

        // 1. Metrik Trafik Pengunjung Real-Time
        $todayVisits = 0;
        $weeklyVisits = 0;
        $totalVisits = 0;
        $onlineVisitors = 0;
        $recentTraffic = collect();
        $topPages = collect();
        $deviceDesktop = 0;
        $deviceMobile = 0;
        $deviceTablet = 0;

        if (Schema::hasTable('visitor_traffic')) {
            $onlineVisitors = DB::table('visitor_traffic')
                ->where('visited_at', '>=', now()->subMinutes(5))
                ->distinct('ip_address')
                ->count('ip_address');

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

        // 2. Metrik Berita & Tayangan Pembaca Riil (Tanpa Data Dummy)
        $totalArticleViews = 0;
        $topArticles = collect();
        if (Schema::hasTable('articles')) {
            $totalArticleViews = DB::table('articles')->sum('views_count');
            $topArticles = Article::published()
                ->orderByDesc('views_count')
                ->limit(5)
                ->get(['id', 'title', 'slug', 'category', 'views_count', 'thumbnail_url']);
        }

        // 3. Status Perangkat Keras / Server & Resource aaPanel Style
        $diskPath = base_path();
        $diskTotal = @disk_total_space($diskPath) ?: 1;
        $diskFree = @disk_free_space($diskPath) ?: 0;
        $diskUsed = max(0, $diskTotal - $diskFree);
        $diskPercent = min(100, (int) round(($diskUsed / $diskTotal) * 100));
        $diskTotalGb = round($diskTotal / 1024 / 1024 / 1024, 1);
        $diskUsedGb = round($diskUsed / 1024 / 1024 / 1024, 1);
        $diskFreeGb = round($diskFree / 1024 / 1024 / 1024, 1);

        $ramUsedMb = (int) round(memory_get_usage(true) / 1024 / 1024);
        $ramTotalMb = 2048;
        $ramPercent = 18;
        if (@file_exists('/proc/meminfo')) {
            $memData = @file_get_contents('/proc/meminfo');
            if ($memData) {
                preg_match('/MemTotal:\s+(\d+)\s+kB/', $memData, $matchesTotal);
                preg_match('/MemAvailable:\s+(\d+)\s+kB/', $memData, $matchesAvail);
                if (!empty($matchesTotal[1]) && !empty($matchesAvail[1])) {
                    $memTotalKb = (int)$matchesTotal[1];
                    $memAvailKb = (int)$matchesAvail[1];
                    $memUsedKb = $memTotalKb - $memAvailKb;
                    $ramTotalMb = (int) round($memTotalKb / 1024);
                    $ramUsedMb = (int) round($memUsedKb / 1024);
                    $ramPercent = min(100, (int) round(($memUsedKb / $memTotalKb) * 100));
                }
            }
        } else {
            $ramPercent = min(100, max(12, (int) round(($ramUsedMb / 512) * 100)));
        }

        $cpuPercent = 14;
        $loadAvgStr = '0.15, 0.10, 0.05';
        if (function_exists('sys_getloadavg')) {
            $load = @sys_getloadavg();
            if (is_array($load) && isset($load[0])) {
                $cpuPercent = min(100, max(5, (int) round($load[0] * 100)));
                $loadAvgStr = number_format($load[0], 2) . ', ' . number_format($load[1] ?? 0.1, 2) . ', ' . number_format($load[2] ?? 0.05, 2);
            }
        }

        $serverOs = php_uname('s') . ' ' . php_uname('r');
        $serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? (PHP_SAPI === 'cli' ? 'CLI / Embedded' : 'Nginx / Apache');
        $phpVersion = PHP_VERSION;
        $dbDriver = config('database.default', 'mysql');

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
            'totalSiswa', 'totalGuru', 'totalSubmissions', 'totalArticles', 'totalChallenges', 'settings',
            'todayVisits', 'weeklyVisits', 'totalVisits', 'onlineVisitors', 'recentTraffic',
            'topPages', 'deviceDesktop', 'deviceMobile', 'deviceTablet',
            'totalArticleViews', 'topArticles',
            'diskPercent', 'diskTotalGb', 'diskUsedGb', 'diskFreeGb',
            'ramPercent', 'ramUsedMb', 'ramTotalMb',
            'cpuPercent', 'loadAvgStr',
            'serverOs', 'serverSoftware', 'phpVersion', 'dbDriver',
            'recentSubmissions'
        ));
    }

    // Endpoint khusus untuk memicu migrasi & seed database via klik/URL jika diperlukan
    public function runMigration()
    {
        $this->ensureTablesExist();
        \App\Services\ArticleContentService::syncDefaultArticles(true);
        PlaygroundChallengeService::syncDefaultChallenges(true);

        if (Auth::check() && Auth::user()->role_id === 1) {
            return redirect()->route('admin.dashboard')->with('success', 'Seluruh tabel, struktur database, artikel tutorial, dan modul playground berhasil diperbarui!');
        }

        return response('<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Update Berhasil</title><style>body{font-family:sans-serif;padding:60px 20px;text-align:center;background:#f8fafc;color:#0f172a}h1{color:#16a34a;margin-bottom:12px}p{color:#475569;margin-bottom:24px}a{color:#2563eb;font-weight:bold;text-decoration:none;margin:0 12px;padding:8px 16px;background:#e0e7ff;border-radius:8px}</style></head><body><h1>✅ Sukses! Database, Artikel, & 10 Modul Tantangan Playground Berhasil Disinkronisasi!</h1><p>Seluruh sistem terbaru kini telah aktif dan tersimpan rapi di database.</p><p><a href="/">Kembali ke Beranda</a><a href="/playground">Buka Live Playground</a><a href="/admin">Masuk ke Admin</a></p></body></html>', 200, ['Content-Type' => 'text/html; charset=utf-8']);
    }

    // API Real-Time AJAX untuk Live Monitoring aaPanel Dashboard
    public function liveStatsApi()
    {
        $this->ensureTablesExist();

        $onlineVisitors = 0;
        $todayVisits = 0;
        $totalVisits = 0;
        $recentTraffic = [];

        if (Schema::hasTable('visitor_traffic')) {
            $onlineVisitors = DB::table('visitor_traffic')
                ->where('visited_at', '>=', now()->subMinutes(5))
                ->distinct('ip_address')
                ->count('ip_address');

            $todayVisits = DB::table('visitor_traffic')
                ->whereDate('visited_at', now()->toDateString())
                ->count();

            $totalVisits = DB::table('visitor_traffic')->count();

            $recent = DB::table('visitor_traffic')
                ->orderBy('visited_at', 'desc')
                ->limit(10)
                ->get();

            foreach ($recent as $t) {
                $recentTraffic[] = [
                    'ip' => $t->ip_address,
                    'page' => '/' . ltrim($t->page_url, '/'),
                    'device' => $t->device,
                    'browser' => $t->browser,
                    'time_ago' => \Carbon\Carbon::parse($t->visited_at)->diffForHumans(),
                ];
            }
        }

        $totalArticleViews = Schema::hasTable('articles') ? DB::table('articles')->sum('views_count') : 0;
        $totalSubmissions = Schema::hasTable('coding_submissions') ? DB::table('coding_submissions')->count() : 0;

        return response()->json([
            'online_visitors' => $onlineVisitors,
            'today_visits' => $todayVisits,
            'total_visits' => $totalVisits,
            'total_article_views' => $totalArticleViews,
            'total_submissions' => $totalSubmissions,
            'recent_traffic' => $recentTraffic,
            'timestamp' => now()->format('H:i:s'),
        ]);
    }

    // Reset Views Artikel ke 0 agar murni menghitung pembaca asli secara real-time
    public function resetArticleViews()
    {
        if (Schema::hasTable('articles')) {
            DB::table('articles')->update(['views_count' => 0]);
        }
        return redirect()->back()->with('success', 'Semua counter views artikel berhasil di-reset ke 0! Mulai sekarang seluruh tayangan adalah 100% murni pengunjung real-time.');
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

    // ========================================================
    // MANAJEMEN ARTIKEL & BERITA (CRUD LENGKAP ADMIN)
    // ========================================================

    // Daftar Artikel
    public function articles(Request $request)
    {
        $this->ensureTablesExist();
        $query = Article::query();

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('summary', 'like', '%' . $request->q . '%');
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(15);
        $settings = $this->getSettings();

        return view('admin.articles.index', compact('articles', 'settings'));
    }

    // Form Buat Artikel Baru
    public function createArticle()
    {
        $this->ensureTablesExist();
        $settings = $this->getSettings();
        $article = new Article();

        return view('admin.articles.form', compact('article', 'settings'));
    }

    // Simpan Artikel Baru
    public function storeArticle(Request $request)
    {
        $this->ensureTablesExist();

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:coding,ai,teknologi,komputer,android',
            'summary' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'thumbnail_url' => 'nullable|string|max:1000',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
        ]);

        $thumbnailUrl = $request->thumbnail_url;

        // Proses unggah file gambar sampul lokal jika ada
        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $uploadDir = public_path('uploads/articles');
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir, 0755, true);
            }
            $filename = 'thumb_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $thumbnailUrl = '/uploads/articles/' . $filename;
        }

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $user = Auth::user();

        Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'category' => $request->category,
            'summary' => $request->summary,
            'content' => $request->content,
            'thumbnail_url' => $thumbnailUrl,
            'author_id' => $user?->id,
            'author_name' => $user?->name ?? 'Admin Editorial',
            'views_count' => 0, // Mulai dari 0 murni real-time
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.articles')->with('success', 'Artikel berita berhasil diterbitkan dengan gambar sampul!');
    }

    // Form Edit Artikel
    public function editArticle($id)
    {
        $this->ensureTablesExist();
        $article = Article::findOrFail($id);
        $settings = $this->getSettings();

        return view('admin.articles.form', compact('article', 'settings'));
    }

    // Perbarui Artikel
    public function updateArticle(Request $request, $id)
    {
        $this->ensureTablesExist();
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:coding,ai,teknologi,komputer,android',
            'summary' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'thumbnail_url' => 'nullable|string|max:1000',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($article->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $article->slug = $slug;
        }

        // Proses unggah file baru jika ada
        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $uploadDir = public_path('uploads/articles');
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir, 0755, true);
            }
            $filename = 'thumb_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $article->thumbnail_url = '/uploads/articles/' . $filename;
        } elseif ($request->filled('thumbnail_url')) {
            $article->thumbnail_url = $request->thumbnail_url;
        }

        $article->title = $request->title;
        $article->category = $request->category;
        $article->summary = $request->summary;
        $article->content = $request->content;
        $article->status = $request->status;
        $article->is_featured = $request->boolean('is_featured');
        if ($request->status === 'published' && !$article->published_at) {
            $article->published_at = now();
        }
        $article->save();

        return redirect()->route('admin.articles')->with('success', 'Artikel berita berhasil diperbarui!');
    }

    // Hapus Artikel
    public function deleteArticle($id)
    {
        $this->ensureTablesExist();
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.articles')->with('success', 'Artikel berhasil dihapus!');
    }

    // Seeder Konten Awal Berkualitas Tinggi untuk Persetujuan AdSense & SEO
    private function seedInitialArticles()
    {
        \App\Services\ArticleContentService::syncDefaultArticles(true);
    }

    // ========================================================
    // MANAJEMEN MODUL PLAYGROUND & TANTANGAN KODING (CRUD)
    // ========================================================

    // Daftar Modul Tantangan Koding
    public function playgroundChallenges(Request $request)
    {
        $this->ensureTablesExist();

        $query = PlaygroundChallenge::query();

        // Filter Level
        if ($request->filled('level') && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        // Filter Kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Pencarian Judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $challenges = $query->orderBy('order_num', 'asc')->orderBy('id', 'asc')->paginate(15);
        $settings = $this->getSettings();
        
        $counts = [
            'total' => PlaygroundChallenge::count(),
            'pemula' => PlaygroundChallenge::where('level', 'pemula')->count(),
            'menengah' => PlaygroundChallenge::where('level', 'menengah')->count(),
            'mahir' => PlaygroundChallenge::where('level', 'mahir')->count(),
            'active' => PlaygroundChallenge::where('is_active', true)->count(),
        ];

        return view('admin.playground.index', compact('challenges', 'settings', 'counts'));
    }

    // Formulir Tambah Modul Tantangan Koding
    public function createPlaygroundChallenge()
    {
        $this->ensureTablesExist();
        $settings = $this->getSettings();
        $templates = PlaygroundChallengeService::getStarterTemplates();
        $challenge = null;
        $nextOrder = (PlaygroundChallenge::max('order_num') ?? 0) + 1;

        return view('admin.playground.form', compact('settings', 'templates', 'challenge', 'nextOrder'));
    }

    // Simpan Modul Tantangan Koding Baru
    public function storePlaygroundChallenge(Request $request)
    {
        $this->ensureTablesExist();

        $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|in:pemula,menengah,mahir',
            'category' => 'required|string|max:50',
            'level_badge' => 'nullable|string|max:100',
            'desc' => 'nullable|string|max:1000',
            'instructions' => 'nullable|string',
            'html_code' => 'nullable|string',
            'css_code' => 'nullable|string',
            'js_code' => 'nullable|string',
            'order_num' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        // Buat slug unik
        $baseSlug = Str::slug($request->title, '_');
        $slug = $baseSlug ?: 'latihan_' . time();
        $counter = 1;
        while (PlaygroundChallenge::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '_' . $counter++;
        }

        // Tentukan level_badge otomatis jika kosong
        $levelBadge = $request->level_badge;
        if (empty($levelBadge)) {
            $levelBadge = match ($request->level) {
                'pemula' => '🟢 Pemula (' . strtoupper($request->category) . ')',
                'menengah' => '🔵 Menengah (' . strtoupper($request->category) . ')',
                'mahir' => '🟣 Mahir (' . strtoupper($request->category) . ')',
                default => '⚪ ' . ucfirst($request->level),
            };
        }

        // Parsing instruksi baris per baris menjadi array
        $instructions = [];
        if ($request->filled('instructions')) {
            $lines = explode("\n", str_replace("\r", "", $request->instructions));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $instructions[] = $trimmed;
                }
            }
        }

        $challenge = new PlaygroundChallenge();
        $challenge->slug = $slug;
        $challenge->title = $request->title;
        $challenge->level = $request->level;
        $challenge->level_badge = $levelBadge;
        $challenge->category = $request->category;
        $challenge->desc = $request->desc;
        $challenge->instructions = $instructions;
        $challenge->html_code = $request->html_code ?? '';
        $challenge->css_code = $request->css_code ?? '';
        $challenge->js_code = $request->js_code ?? '';
        $challenge->order_num = $request->order_num ?? ((PlaygroundChallenge::max('order_num') ?? 0) + 1);
        $challenge->is_active = $request->boolean('is_active', true);
        $challenge->save();

        return redirect()->route('admin.playground')->with('success', "Modul latihan '{$challenge->title}' berhasil ditambahkan ke Playground!");
    }

    // Formulir Edit Modul Tantangan Koding
    public function editPlaygroundChallenge($id)
    {
        $this->ensureTablesExist();
        $challenge = PlaygroundChallenge::findOrFail($id);
        $settings = $this->getSettings();
        $templates = PlaygroundChallengeService::getStarterTemplates();
        $nextOrder = $challenge->order_num;

        return view('admin.playground.form', compact('settings', 'templates', 'challenge', 'nextOrder'));
    }

    // Update Modul Tantangan Koding
    public function updatePlaygroundChallenge(Request $request, $id)
    {
        $this->ensureTablesExist();
        $challenge = PlaygroundChallenge::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|in:pemula,menengah,mahir',
            'category' => 'required|string|max:50',
            'level_badge' => 'nullable|string|max:100',
            'desc' => 'nullable|string|max:1000',
            'instructions' => 'nullable|string',
            'html_code' => 'nullable|string',
            'css_code' => 'nullable|string',
            'js_code' => 'nullable|string',
            'order_num' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        // Tentukan level_badge jika kosong
        $levelBadge = $request->level_badge;
        if (empty($levelBadge)) {
            $levelBadge = match ($request->level) {
                'pemula' => '🟢 Pemula (' . strtoupper($request->category) . ')',
                'menengah' => '🔵 Menengah (' . strtoupper($request->category) . ')',
                'mahir' => '🟣 Mahir (' . strtoupper($request->category) . ')',
                default => '⚪ ' . ucfirst($request->level),
            };
        }

        // Parsing instruksi baris per baris menjadi array
        $instructions = [];
        if ($request->filled('instructions')) {
            $lines = explode("\n", str_replace("\r", "", $request->instructions));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if (!empty($trimmed)) {
                    $instructions[] = $trimmed;
                }
            }
        }

        $challenge->title = $request->title;
        $challenge->level = $request->level;
        $challenge->level_badge = $levelBadge;
        $challenge->category = $request->category;
        $challenge->desc = $request->desc;
        $challenge->instructions = $instructions;
        $challenge->html_code = $request->html_code ?? '';
        $challenge->css_code = $request->css_code ?? '';
        $challenge->js_code = $request->js_code ?? '';
        $challenge->order_num = $request->order_num ?? $challenge->order_num;
        $challenge->is_active = $request->boolean('is_active');
        $challenge->save();

        return redirect()->route('admin.playground')->with('success', "Modul latihan '{$challenge->title}' berhasil diperbarui!");
    }

    // Hapus Modul Tantangan
    public function deletePlaygroundChallenge($id)
    {
        $this->ensureTablesExist();
        $challenge = PlaygroundChallenge::findOrFail($id);
        $title = $challenge->title;
        $challenge->delete();

        return redirect()->route('admin.playground')->with('success', "Modul latihan '{$title}' berhasil dihapus!");
    }

    // Toggle Status Aktif / Nonaktif
    public function togglePlaygroundChallenge($id)
    {
        $this->ensureTablesExist();
        $challenge = PlaygroundChallenge::findOrFail($id);
        $challenge->is_active = !$challenge->is_active;
        $challenge->save();

        $status = $challenge->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Modul latihan '{$challenge->title}' berhasil {$status}!");
    }

    // Reset ke 10 Tantangan Bawaan Default
    public function resetDefaultPlaygroundChallenges()
    {
        $this->ensureTablesExist();
        PlaygroundChallengeService::syncDefaultChallenges(true);

        return redirect()->route('admin.playground')->with('success', 'Berhasil mereset seluruh modul latihan ke 10 tantangan bawaan lengkap!');
    }
}