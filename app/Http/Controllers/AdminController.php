<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

            if (Schema::hasTable('articles') && DB::table('articles')->count() === 0) {
                $this->seedInitialArticles();
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
            'totalSiswa', 'totalGuru', 'totalSubmissions', 'totalArticles', 'settings',
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
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
        ]);

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
            'thumbnail_url' => $request->thumbnail_url,
            'author_id' => $user?->id,
            'author_name' => $user?->name ?? 'Admin Editorial',
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.articles')->with('success', 'Artikel berita berhasil diterbitkan!');
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

        $article->title = $request->title;
        $article->category = $request->category;
        $article->summary = $request->summary;
        $article->content = $request->content;
        $article->thumbnail_url = $request->thumbnail_url;
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
        $now = now();
        $articles = [
            [
                'title' => 'Belajar HTML dari Nol: Panduan Lengkap Membuat Halaman Web Pertamamu',
                'slug' => 'belajar-html-dari-nol-panduan-lengkap-halaman-web-pertama',
                'category' => 'coding',
                'summary' => 'Belum pernah menulis kode sama sekali? Tenang. Panduan ini akan membimbingmu langkah demi langkah membuat halaman web pertama menggunakan HTML — dari membuka editor hingga melihat hasilnya di browser.',
                'content' => '<p>Kalau kamu baru pertama kali mendengar istilah HTML, kamu tidak sendirian. Hampir semua programmer profesional yang kamu kagumi hari ini juga pernah berada di titik yang sama persis — bingung, penasaran, tapi semangat untuk mencoba. Nah, artikel ini ditulis khusus untuk kamu yang benar-benar mulai dari nol.</p><img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1100&q=80" alt="Seseorang sedang belajar coding di laptop" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Apa Itu HTML, Sih?</h2><p>HTML adalah singkatan dari <strong>HyperText Markup Language</strong>. Sederhananya, HTML adalah bahasa yang digunakan untuk memberi tahu browser (seperti Chrome atau Firefox) tentang <em>struktur</em> sebuah halaman web. Mana bagian judul, mana paragraf, mana gambar — semuanya ditentukan oleh HTML.</p><p>Bayangkan kamu sedang membangun rumah. HTML itu seperti kerangka bangunannya: dinding, pintu, jendela, dan atap. Tanpa kerangka, rumah tidak punya bentuk. Begitu juga website — tanpa HTML, browser tidak tahu harus menampilkan apa.</p><h2>Langkah 1: Siapkan Alat yang Kamu Butuhkan</h2><p>Kabar baiknya, kamu <strong>tidak perlu menginstal software mahal</strong>. Cukup dua hal:</p><ul><li><strong>Browser</strong> — Chrome, Firefox, atau Edge yang sudah ada di komputermu.</li><li><strong>Editor teks</strong> — Bisa Notepad (bawaan Windows), atau langsung gunakan <strong>Live Playground</strong> di VxAI yang sudah siap pakai tanpa instalasi.</li></ul><h2>Langkah 2: Tulis Kode HTML Pertamamu</h2><p>Buka editor teks atau Live Playground, lalu ketik kode berikut dengan teliti:</p><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;title&gt;Halaman Pertamaku&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;h1&gt;Halo, Dunia!&lt;/h1&gt;\n    &lt;p&gt;Ini adalah halaman web pertama yang saya buat sendiri.&lt;/p&gt;\n    &lt;p&gt;Saya sedang belajar HTML dan ini sangat seru!&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;</code></pre><p>Jangan khawatir kalau kodenya terlihat asing. Mari kita bedah satu per satu.</p><h2>Langkah 3: Pahami Setiap Bagian Kode</h2><p>Setiap baris di atas punya fungsi yang jelas:</p><ul><li><code>&lt;!DOCTYPE html&gt;</code> — Memberitahu browser bahwa ini dokumen HTML versi terbaru (HTML5).</li><li><code>&lt;html&gt;</code> — Wadah utama seluruh isi halaman.</li><li><code>&lt;head&gt;</code> — Tempat informasi &quot;di balik layar&quot; seperti judul tab browser.</li><li><code>&lt;title&gt;</code> — Teks yang muncul di tab browser paling atas.</li><li><code>&lt;body&gt;</code> — Semua yang tampil di layar pengunjung ada di sini.</li><li><code>&lt;h1&gt;</code> — Heading atau judul terbesar. Ada juga <code>&lt;h2&gt;</code> sampai <code>&lt;h6&gt;</code> untuk sub-judul.</li><li><code>&lt;p&gt;</code> — Paragraf biasa untuk teks.</li></ul><img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=1100&q=80" alt="Layar monitor menampilkan kode HTML" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Langkah 4: Simpan dan Lihat Hasilnya</h2><p>Kalau kamu menggunakan Notepad, simpan file dengan nama <code>index.html</code> (pastikan ekstensinya <code>.html</code>, bukan <code>.txt</code>). Kemudian klik dua kali file tersebut — browser akan otomatis membukanya dan menampilkan halaman web pertamamu!</p><p>Kalau kamu menggunakan Live Playground VxAI, hasilnya langsung terlihat di panel sebelah kanan secara real-time. Lebih praktis, kan?</p><h2>Langkah 5: Coba Tambahkan Elemen Baru</h2><p>Sekarang, coba tambahkan elemen-elemen berikut di dalam <code>&lt;body&gt;</code> untuk bereksperimen:</p><pre><code>&lt;h2&gt;Tentang Saya&lt;/h2&gt;\n&lt;p&gt;Nama saya Andi. Saya suka &lt;strong&gt;belajar teknologi&lt;/strong&gt; dan &lt;em&gt;bermain game&lt;/em&gt;.&lt;/p&gt;\n\n&lt;h2&gt;Hobi Saya&lt;/h2&gt;\n&lt;ul&gt;\n    &lt;li&gt;Membaca buku&lt;/li&gt;\n    &lt;li&gt;Bermain sepak bola&lt;/li&gt;\n    &lt;li&gt;Belajar koding&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;a href=&quot;https://vxai.online&quot;&gt;Kunjungi VxAI Coding Lab&lt;/a&gt;</code></pre><p>Perhatikan beberapa tag baru di sini: <code>&lt;strong&gt;</code> untuk teks tebal, <code>&lt;em&gt;</code> untuk teks miring, <code>&lt;ul&gt;</code> dan <code>&lt;li&gt;</code> untuk daftar berbutir, serta <code>&lt;a href=&quot;...&quot;&gt;</code> untuk membuat link yang bisa diklik.</p><h2>Tips untuk Pemula</h2><blockquote>&quot;Jangan takut salah. Setiap programmer hebat pernah lupa menutup tag. Yang penting, kamu terus mencoba dan tidak menyerah.&quot;</blockquote><p>Beberapa tips yang akan sangat membantu perjalanan belajarmu:</p><ol><li><strong>Selalu tutup tag yang kamu buka.</strong> Kalau ada <code>&lt;p&gt;</code>, harus ada <code>&lt;/p&gt;</code>.</li><li><strong>Gunakan indentasi (spasi/tab)</strong> agar kode lebih rapi dan mudah dibaca.</li><li><strong>Sering-sering praktik.</strong> Teori tanpa praktik itu seperti belajar berenang dari buku — kamu harus nyemplung ke air!</li><li><strong>Manfaatkan Live Playground.</strong> Kamu bisa langsung melihat hasil perubahan kode secara instan tanpa harus bolak-balik menyimpan file.</li></ol><p>Selamat — kamu baru saja menyelesaikan langkah pertama dalam dunia pemrograman web! Di artikel berikutnya, kita akan belajar cara mempercantik halaman ini menggunakan CSS. Sampai jumpa!</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 342,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(1),
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
            [
                'title' => 'Dasar-Dasar Koding: Apa Itu Pemrograman dan Dari Mana Harus Memulai?',
                'slug' => 'dasar-dasar-koding-apa-itu-pemrograman-dari-mana-memulai',
                'category' => 'coding',
                'summary' => 'Panduan paling ramah pemula tentang dunia koding. Kami jelaskan apa itu pemrograman, mengapa penting untuk dipelajari, dan bagaimana langkah konkret memulainya — tanpa jargon rumit.',
                'content' => '<p>Mungkin kamu sering mendengar kata &quot;koding&quot; atau &quot;programming&quot; di mana-mana — di media sosial, di sekolah, bahkan di iklan lowongan kerja. Tapi apa sih sebenarnya koding itu? Apakah harus jago matematika dulu? Apakah perlu komputer mahal? Artikel ini akan menjawab semua pertanyaan itu dengan bahasa yang sederhana.</p><img src="https://images.unsplash.com/photo-1515879218367-8466d910auj9?auto=format&fit=crop&w=1100&q=80" alt="Layar laptop menampilkan kode pemrograman berwarna-warni" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Apa Itu Koding?</h2><p>Secara sederhana, <strong>koding adalah cara kita berkomunikasi dengan komputer</strong>. Komputer tidak mengerti bahasa Indonesia atau bahasa Inggris — ia hanya mengerti instruksi yang ditulis dalam bahasa pemrograman tertentu. Koding adalah proses menulis instruksi-instruksi itu.</p><p>Contoh nyata yang mudah dipahami: ketika kamu mengetik sesuatu di kolom pencarian Google lalu menekan Enter, ada ribuan baris kode yang bekerja di balik layar untuk mencarikan jawaban terbaik untukmu dalam hitungan milidetik. Seseorang menulis kode-kode itu — dan orang itu disebut <em>programmer</em> atau <em>developer</em>.</p><h2>Mengapa Belajar Koding Itu Penting?</h2><p>Kamu tidak harus bercita-cita jadi programmer untuk mendapat manfaat dari belajar koding. Berikut alasan konkretnya:</p><ol><li><strong>Melatih cara berpikir logis.</strong> Koding mengajarkan kamu memecah masalah besar menjadi langkah-langkah kecil yang terstruktur. Kemampuan ini berguna di bidang apa pun — kedokteran, bisnis, seni, bahkan memasak.</li><li><strong>Membuka peluang karir yang luas.</strong> Hampir semua industri saat ini membutuhkan orang yang paham teknologi. Dengan kemampuan koding, kamu bisa bekerja dari mana saja di dunia.</li><li><strong>Membuat ide jadi nyata.</strong> Punya ide aplikasi? Ingin membuat website portofolio? Dengan koding, kamu bisa mewujudkannya sendiri tanpa tergantung orang lain.</li></ol><img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1100&q=80" alt="Workspace developer modern dengan dua monitor" style="width:100%;border-radius:16px;margin:20px 0;"><h2>3 Bahasa Pemrograman Terbaik untuk Pemula</h2><p>Ada ratusan bahasa pemrograman di dunia, tapi kamu tidak perlu mempelajari semuanya. Cukup mulai dari tiga ini:</p><h3>1. HTML — Kerangka Halaman Web</h3><p>HTML bukan bahasa pemrograman dalam arti tradisional (ia tidak punya logika if-else), tapi ia adalah fondasi <em>mutlak</em> setiap halaman web yang pernah kamu buka. HTML menentukan struktur: mana yang judul, mana yang paragraf, mana yang gambar.</p><h3>2. CSS — Penata Tampilan</h3><p>Kalau HTML adalah kerangka rumah, maka CSS adalah cat dinding, lantai keramik, dan dekorasi interiornya. CSS mengatur warna, ukuran huruf, tata letak, jarak antar elemen, dan semua aspek visual halaman web.</p><h3>3. JavaScript — Otak Interaktif</h3><p>JavaScript membuat halaman web yang tadinya statis menjadi &quot;hidup&quot;. Tombol yang bisa diklik, formulir yang memvalidasi input, animasi yang bergerak — semua itu adalah pekerjaan JavaScript.</p><h2>Langkah Konkret Memulai Hari Ini</h2><p>Jangan menunda. Berikut yang bisa kamu lakukan <strong>dalam 15 menit ke depan</strong>:</p><ol><li><strong>Buka Live Playground</strong> di VxAI — tidak perlu instal apa pun.</li><li><strong>Ketik kode HTML sederhana</strong> seperti yang diajarkan di panduan &quot;Belajar HTML dari Nol&quot; di website ini.</li><li><strong>Lihat hasilnya secara langsung</strong> di panel preview. Rasakan sensasi pertama kali melihat kode yang kamu tulis berubah menjadi tampilan nyata di layar.</li><li><strong>Baca panduan lanjutan</strong> yang sudah tersedia di halaman Panduan Koding.</li></ol><blockquote>&quot;Perjalanan seribu mil dimulai dari satu langkah. Langkah pertamamu hari ini adalah membuka editor dan menulis satu baris kode — cuma satu baris saja. Sisanya akan mengalir dengan sendirinya.&quot;</blockquote><p>Kamu sudah membaca artikel ini sampai akhir — itu artinya kamu punya rasa ingin tahu yang besar. Dan rasa ingin tahu adalah modal paling berharga dalam belajar koding. Selamat memulai perjalananmu!</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 485,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(2),
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'title' => 'Mengenal Kecerdasan Buatan (AI): Panduan Dasar yang Mudah Dipahami Siapa Saja',
                'slug' => 'mengenal-kecerdasan-buatan-ai-panduan-dasar-mudah-dipahami',
                'category' => 'ai',
                'summary' => 'Apa sebenarnya kecerdasan buatan itu? Bagaimana cara kerjanya? Apakah AI akan menggantikan manusia? Artikel ini menjawab semua pertanyaan dasarmu tentang AI dengan bahasa sehari-hari.',
                'content' => '<p>Kamu pasti sudah sering mendengar istilah AI — mungkin dari berita tentang ChatGPT, dari fitur filter wajah di Instagram, atau dari rekomendasi video di YouTube yang selalu tepat sasaran. Tapi pernahkah kamu bertanya: <em>bagaimana sebenarnya semua itu bekerja?</em></p><img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=1100&q=80" alt="Visualisasi jaringan neural dan kecerdasan buatan" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Apa Itu Kecerdasan Buatan (AI)?</h2><p><strong>Kecerdasan Buatan</strong>, atau dalam bahasa Inggris disebut <em>Artificial Intelligence (AI)</em>, adalah cabang ilmu komputer yang bertujuan membuat mesin atau perangkat lunak yang bisa melakukan tugas-tugas yang biasanya membutuhkan kecerdasan manusia.</p><p>Contoh tugas-tugas itu antara lain:</p><ul><li>Mengenali wajah di foto (seperti yang dilakukan kamera HP saat kamu memotret).</li><li>Menerjemahkan bahasa secara otomatis (Google Translate).</li><li>Menjawab pertanyaan dalam bentuk percakapan (ChatGPT, Gemini).</li><li>Mengemudikan mobil tanpa sopir (Tesla Autopilot).</li><li>Merekomendasikan lagu yang cocok dengan seleramu (Spotify).</li></ul><p>Yang perlu dipahami: AI tidak benar-benar &quot;berpikir&quot; seperti manusia. AI bekerja berdasarkan <strong>pola-pola yang dipelajari dari data</strong>. Semakin banyak data berkualitas yang diberikan, semakin baik AI menjalankan tugasnya.</p><h2>Bagaimana AI Belajar? (Machine Learning Sederhana)</h2><p>Bayangkan kamu ingin mengajarkan AI untuk membedakan foto kucing dan anjing. Begini prosesnya secara sederhana:</p><ol><li><strong>Langkah 1: Kumpulkan Data.</strong> Kamu menyediakan ribuan foto kucing dan ribuan foto anjing.</li><li><strong>Langkah 2: Beri Label.</strong> Setiap foto diberi keterangan — &quot;ini kucing&quot; atau &quot;ini anjing.&quot;</li><li><strong>Langkah 3: Latih Model.</strong> AI mempelajari pola dari semua foto tersebut. Ia menemukan bahwa kucing cenderung punya telinga runcing, kumis panjang, dan tubuh kecil — sedangkan anjing punya moncong panjang dan tubuh lebih besar.</li><li><strong>Langkah 4: Uji Coba.</strong> Kamu berikan foto baru yang belum pernah dilihat AI. Kalau AI bisa menjawab dengan benar, berarti proses latihannya berhasil!</li></ol><p>Proses inilah yang disebut <strong>Machine Learning</strong> — mesin yang belajar dari pengalaman (data), bukan dari instruksi kaku yang ditulis manusia satu per satu.</p><img src="https://images.unsplash.com/photo-1677442136019-21780efad99a?auto=format&fit=crop&w=1100&q=80" alt="Representasi AI generatif dan model bahasa besar" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Jenis-Jenis AI yang Perlu Kamu Tahu</h2><h3>1. AI Generatif (Generative AI)</h3><p>Ini adalah jenis AI yang sedang paling populer saat ini. AI generatif bisa <em>membuat</em> konten baru — teks, gambar, musik, bahkan kode program. Contohnya: ChatGPT bisa menulis esai, Midjourney bisa membuat gambar dari deskripsi teks, dan GitHub Copilot bisa menulis kode secara otomatis.</p><h3>2. AI Pengenalan (Recognition AI)</h3><p>AI jenis ini spesialisasinya adalah <em>mengenali</em> sesuatu: wajah, suara, tulisan tangan, bahkan emosi. Face ID di iPhone, Google Lens, dan fitur voice-to-text di HP kamu semuanya menggunakan AI pengenalan.</p><h3>3. AI Rekomendasi</h3><p>Pernah heran kenapa YouTube selalu tahu video apa yang ingin kamu tonton? Itu karena AI rekomendasi mempelajari kebiasaan menontonmu dan menyarankan konten yang mirip dengan preferensimu.</p><h2>Apakah AI Akan Menggantikan Manusia?</h2><p>Ini pertanyaan yang wajar dan sering ditanyakan. Jawaban singkatnya: <strong>tidak sepenuhnya</strong>. AI sangat hebat dalam mengerjakan tugas yang berulang, memproses data besar, dan menemukan pola. Tapi AI belum bisa (dan mungkin tidak akan pernah bisa) menggantikan kreativitas, empati, penilaian moral, dan intuisi manusia.</p><blockquote>&quot;AI bukan pengganti manusia — ia adalah alat yang memperkuat kemampuan manusia. Orang yang menguasai AI akan unggul dari orang yang mengabaikannya.&quot;</blockquote><h2>Langkah Awal Belajar AI</h2><p>Kamu tidak perlu jadi ahli matematika untuk mulai memahami AI. Berikut langkah praktis yang bisa kamu ambil:</p><ol><li><strong>Coba gunakan AI secara langsung.</strong> Buka ChatGPT atau Gemini dan ajukan pertanyaan. Perhatikan bagaimana AI menjawab, dan coba variasikan cara kamu bertanya.</li><li><strong>Pahami konsep dasar Machine Learning</strong> melalui video dan artikel seperti yang ada di portal ini.</li><li><strong>Pelajari Python</strong> — bahasa pemrograman yang paling populer digunakan di dunia AI dan data science.</li><li><strong>Ikuti kursus gratis</strong> seperti &quot;AI for Everyone&quot; dari Andrew Ng di Coursera.</li></ol><p>Dunia AI berkembang sangat cepat. Yang terpenting bukan mengetahui segalanya hari ini, tapi membangun kebiasaan untuk terus belajar setiap hari. Mulailah dari satu langkah kecil — dan kamu sudah lebih maju dari kebanyakan orang.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Riset AI VxAI',
                'views_count' => 528,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(3),
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'title' => 'Belajar CSS untuk Pemula: Cara Mempercantik Halaman Web Langkah demi Langkah',
                'slug' => 'belajar-css-pemula-cara-mempercantik-halaman-web',
                'category' => 'coding',
                'summary' => 'Setelah membuat kerangka HTML, saatnya memberi warna, tata letak, dan gaya visual. Panduan CSS ini menunjukkan cara mengubah halaman polos menjadi desain yang menarik mata.',
                'content' => '<p>Kalau HTML adalah kerangka rumah, maka CSS adalah semua yang membuat rumah itu terlihat cantik — cat dinding, lantai, pencahayaan, dan penataan furnitur. Tanpa CSS, halaman web hanya berupa teks hitam di atas latar putih yang sangat membosankan. Mari kita ubah itu.</p><img src="https://images.unsplash.com/photo-1507721999472-8ed4421c4af2?auto=format&fit=crop&w=1100&q=80" alt="Desainer web sedang mengerjakan tata letak CSS" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Apa Itu CSS?</h2><p><strong>CSS</strong> adalah singkatan dari <em>Cascading Style Sheets</em>. CSS bertugas mengatur tampilan visual dari elemen HTML: warna teks, ukuran huruf, jarak antar elemen, latar belakang, tata letak kolom, dan masih banyak lagi.</p><p>Yang keren dari CSS: kamu bisa mengubah tampilan seluruh website hanya dengan mengedit satu file CSS — tanpa menyentuh kode HTML sama sekali.</p><h2>Langkah 1: Menambahkan CSS ke HTML</h2><p>Ada tiga cara menambahkan CSS ke halaman HTML. Untuk pemula, cara paling mudah adalah menggunakan tag <code>&lt;style&gt;</code> di dalam <code>&lt;head&gt;</code>:</p><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;title&gt;Belajar CSS&lt;/title&gt;\n    &lt;style&gt;\n        body {\n            font-family: Arial, sans-serif;\n            background-color: #f0f4f8;\n            color: #1e293b;\n            padding: 40px;\n        }\n        h1 {\n            color: #2563eb;\n            text-align: center;\n        }\n        p {\n            line-height: 1.8;\n            font-size: 16px;\n        }\n    &lt;/style&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;h1&gt;Website Pertamaku yang Cantik&lt;/h1&gt;\n    &lt;p&gt;Halaman ini sudah menggunakan CSS untuk mengatur tampilan.&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;</code></pre><p>Coba ketik kode di atas di Live Playground, lalu perhatikan perbedaannya dengan HTML polos tanpa CSS. Jauh lebih enak dilihat, kan?</p><h2>Langkah 2: Memahami Selektor dan Properti</h2><p>CSS bekerja dengan pola yang sangat konsisten:</p><pre><code>selektor {\n    properti: nilai;\n}</code></pre><p>Contoh:</p><ul><li><code>body { background-color: #f0f4f8; }</code> → mengubah warna latar belakang seluruh halaman.</li><li><code>h1 { color: #2563eb; }</code> → mengubah warna teks judul menjadi biru.</li><li><code>p { font-size: 16px; }</code> → mengatur ukuran huruf paragraf menjadi 16 pixel.</li></ul><img src="https://images.unsplash.com/photo-1523437113738-bbd3cc89fb19?auto=format&fit=crop&w=1100&q=80" alt="Contoh tampilan kode CSS di editor modern" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Langkah 3: Membuat Kartu Profil Sederhana</h2><p>Sekarang, mari praktik membuat komponen yang lebih nyata — sebuah kartu profil:</p><pre><code>&lt;style&gt;\n    .kartu {\n        background: white;\n        border-radius: 16px;\n        padding: 30px;\n        max-width: 400px;\n        margin: 40px auto;\n        box-shadow: 0 4px 20px rgba(0,0,0,0.1);\n        text-align: center;\n    }\n    .kartu h2 {\n        margin-bottom: 8px;\n        color: #0f172a;\n    }\n    .kartu p {\n        color: #64748b;\n        font-size: 14px;\n    }\n    .tombol {\n        display: inline-block;\n        background: #2563eb;\n        color: white;\n        padding: 10px 24px;\n        border-radius: 8px;\n        text-decoration: none;\n        font-weight: bold;\n        margin-top: 16px;\n    }\n&lt;/style&gt;\n\n&lt;div class=&quot;kartu&quot;&gt;\n    &lt;h2&gt;Andi Pratama&lt;/h2&gt;\n    &lt;p&gt;Pelajar Koding &amp; Calon Web Developer&lt;/p&gt;\n    &lt;a href=&quot;#&quot; class=&quot;tombol&quot;&gt;Lihat Portofolio&lt;/a&gt;\n&lt;/div&gt;</code></pre><p>Perhatikan beberapa konsep baru di sini:</p><ul><li><code>border-radius</code> membuat sudut melengkung.</li><li><code>box-shadow</code> memberi efek bayangan yang elegan.</li><li><code>margin: 40px auto</code> menempatkan kartu di tengah halaman.</li><li><code>.kartu</code> dan <code>.tombol</code> adalah <strong>class selector</strong> — cara menargetkan elemen tertentu menggunakan atribut <code>class</code>.</li></ul><h2>Tips Belajar CSS</h2><ol><li><strong>Eksperimen dengan warna.</strong> Coba ganti nilai <code>background-color</code> dan <code>color</code> dengan kode warna berbeda. Situs seperti coolors.co bisa membantumu menemukan kombinasi warna yang bagus.</li><li><strong>Gunakan DevTools browser.</strong> Klik kanan di halaman web mana saja, pilih &quot;Inspect&quot;, dan kamu bisa melihat serta mengedit CSS secara langsung. Ini cara terbaik untuk belajar dari website yang sudah jadi.</li><li><strong>Pelajari Flexbox.</strong> Ini adalah teknik tata letak CSS modern yang paling sering digunakan. Dengan Flexbox, mengatur posisi elemen jadi jauh lebih mudah daripada cara lama.</li></ol><blockquote>&quot;CSS itu seperti melukis. Kamu mungkin tidak langsung menghasilkan karya bagus, tapi semakin sering berlatih, tanganmu akan semakin luwes dan hasilnya semakin memukau.&quot;</blockquote><p>Selamat! Kamu sekarang sudah memahami dasar-dasar CSS. Di artikel berikutnya, kita akan belajar JavaScript — bahasa yang membuat halaman web bisa merespons tindakan pengunjung. Tetap semangat!</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1507721999472-8ed4421c4af2?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 267,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(4),
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
            ],
            [
                'title' => 'Belajar JavaScript Dasar: Membuat Halaman Web yang Bisa Merespons Pengunjung',
                'slug' => 'belajar-javascript-dasar-halaman-web-interaktif-responsif',
                'category' => 'coding',
                'summary' => 'JavaScript adalah bahasa yang membuat website jadi hidup. Pelajari dasar-dasar variabel, fungsi, event, dan manipulasi DOM melalui contoh praktis yang bisa langsung kamu coba.',
                'content' => '<p>Kamu sudah bisa membuat kerangka halaman dengan HTML dan mempercantiknya dengan CSS. Sekarang, saatnya memberi &quot;nyawa&quot; pada halaman webmu. Di situlah JavaScript berperan.</p><img src="https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?auto=format&fit=crop&w=1100&q=80" alt="Kode JavaScript di layar monitor developer" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Apa Itu JavaScript?</h2><p><strong>JavaScript</strong> adalah satu-satunya bahasa pemrograman yang bisa berjalan langsung di browser. Dengan JavaScript, kamu bisa membuat tombol yang merespons klik, formulir yang memvalidasi input sebelum dikirim, animasi visual, dan bahkan game sederhana — semuanya di dalam browser.</p><p>Kalau HTML adalah tulang, CSS adalah kulit, maka JavaScript adalah otot dan saraf yang membuat semuanya bergerak.</p><h2>Langkah 1: Menulis JavaScript Pertamamu</h2><p>Cara termudah menambahkan JavaScript adalah dengan tag <code>&lt;script&gt;</code> di dalam HTML:</p><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;title&gt;Belajar JavaScript&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;h1&gt;Halo, JavaScript!&lt;/h1&gt;\n    &lt;button onclick=&quot;sapaPengguna()&quot;&gt;Klik Saya&lt;/button&gt;\n\n    &lt;script&gt;\n        function sapaPengguna() {\n            alert(&quot;Hai! Selamat datang di dunia JavaScript!&quot;);\n        }\n    &lt;/script&gt;\n&lt;/body&gt;\n&lt;/html&gt;</code></pre><p>Coba ketik kode ini di Live Playground, lalu klik tombolnya. Kamu akan melihat kotak pesan muncul — itu adalah JavaScript bekerja!</p><h2>Langkah 2: Memahami Variabel</h2><p>Variabel adalah &quot;wadah&quot; untuk menyimpan data. Bayangkan seperti kotak berlabel yang bisa kamu isi dengan apa saja:</p><pre><code>let nama = &quot;Andi&quot;;\nlet umur = 17;\nlet sedangBelajar = true;\n\nconsole.log(&quot;Nama saya &quot; + nama);\nconsole.log(&quot;Umur saya &quot; + umur + &quot; tahun&quot;);</code></pre><p>Ada tiga kata kunci untuk membuat variabel:</p><ul><li><code>let</code> — untuk variabel yang nilainya bisa berubah.</li><li><code>const</code> — untuk nilai yang tidak akan berubah (konstan).</li><li><code>var</code> — cara lama, sebaiknya gunakan <code>let</code> atau <code>const</code>.</li></ul><h2>Langkah 3: Membuat Fungsi</h2><p>Fungsi adalah kumpulan instruksi yang bisa dipanggil kapan saja. Seperti resep masakan — kamu tulis sekali, lalu bisa dipakai berulang kali:</p><pre><code>function hitungLuasPersegi(sisi) {\n    let luas = sisi * sisi;\n    return luas;\n}\n\nlet hasil = hitungLuasPersegi(5);\nconsole.log(&quot;Luas persegi: &quot; + hasil); // Output: 25</code></pre><img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1100&q=80" alt="Kode program berwarna di layar gelap" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Langkah 4: Memanipulasi Halaman Web (DOM)</h2><p>Ini adalah bagian paling seru dari JavaScript — kemampuan untuk mengubah isi halaman web secara langsung! Teknik ini disebut <strong>manipulasi DOM</strong> (Document Object Model):</p><pre><code>&lt;p id=&quot;pesan&quot;&gt;Teks ini akan berubah.&lt;/p&gt;\n&lt;button onclick=&quot;ubahTeks()&quot;&gt;Ubah Teks&lt;/button&gt;\n\n&lt;script&gt;\n    function ubahTeks() {\n        document.getElementById(&quot;pesan&quot;).innerText = \n            &quot;Wow, teksnya sudah berubah! JavaScript keren!&quot;;\n    }\n&lt;/script&gt;</code></pre><p>Dengan <code>document.getElementById()</code>, kamu bisa &quot;meraih&quot; elemen HTML tertentu dan mengubah isinya, warnanya, atau bahkan menyembunyikannya.</p><h2>Langkah 5: Membuat Proyek Mini — Penghitung Klik</h2><p>Sekarang, mari gabungkan semua konsep di atas menjadi proyek kecil yang menyenangkan:</p><pre><code>&lt;h2&gt;Penghitung Klik&lt;/h2&gt;\n&lt;p&gt;Kamu sudah mengklik &lt;span id=&quot;angka&quot;&gt;0&lt;/span&gt; kali!&lt;/p&gt;\n&lt;button onclick=&quot;tambahKlik()&quot;&gt;Klik Dong!&lt;/button&gt;\n\n&lt;script&gt;\n    let jumlahKlik = 0;\n\n    function tambahKlik() {\n        jumlahKlik = jumlahKlik + 1;\n        document.getElementById(&quot;angka&quot;).innerText = jumlahKlik;\n    }\n&lt;/script&gt;</code></pre><p>Proyek kecil seperti ini sangat penting untuk membangun kepercayaan diri. Setiap kali kamu berhasil membuat sesuatu berfungsi, otakmu akan semakin terbiasa dengan pola pikir programming.</p><h2>Tips Belajar JavaScript</h2><ol><li><strong>Jangan hafal, tapi pahami.</strong> Kamu tidak perlu mengingat semua nama fungsi. Yang penting adalah memahami <em>logikanya</em> — ketika paham logikanya, kamu selalu bisa mencari sintaks yang benar di Google.</li><li><strong>Sering-sering baca error.</strong> Pesan error di JavaScript sebenarnya sangat membantu. Jangan panik saat melihat tulisan merah — baca pesannya, pahami masalahnya, lalu perbaiki.</li><li><strong>Buat proyek kecil-kecilan.</strong> Kalkulator sederhana, to-do list, quiz interaktif — proyek kecil ini mengajarkan lebih banyak daripada membaca teori berjam-jam.</li></ol><blockquote>&quot;Satu-satunya cara untuk belajar bahasa pemrograman baru adalah dengan menulis banyak program di dalamnya.&quot; — Dennis Ritchie, pencipta bahasa C.</blockquote><p>Kamu sudah menyelesaikan tiga pilar dasar web: HTML, CSS, dan JavaScript. Selamat! Dari sini, dunia pemrograman terbuka lebar untukmu. Teruslah bereksperimen di Live Playground dan jangan pernah berhenti bertanya.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 394,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(5),
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'title' => 'Cara Menggunakan AI untuk Belajar Koding Lebih Cepat: Panduan Praktis Prompt Engineering',
                'slug' => 'cara-menggunakan-ai-belajar-koding-lebih-cepat-prompt-engineering',
                'category' => 'ai',
                'summary' => 'AI bukan hanya untuk perusahaan besar. Kamu juga bisa memanfaatkan ChatGPT, Gemini, dan asisten AI lainnya untuk mempercepat proses belajar koding. Begini caranya.',
                'content' => '<p>Bayangkan kamu punya guru privat yang tersedia 24 jam, tidak pernah capek, dan bisa menjawab pertanyaan apa pun tentang koding dalam hitungan detik. Itulah yang bisa dilakukan AI seperti ChatGPT dan Gemini untuk proses belajarmu — <em>asalkan</em> kamu tahu cara bertanya yang tepat.</p><img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1100&q=80" alt="Tampilan data matrix dan kecerdasan buatan" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Apa Itu Prompt Engineering?</h2><p><strong>Prompt Engineering</strong> adalah seni dan teknik menyusun pertanyaan atau instruksi yang tepat kepada AI agar mendapatkan jawaban yang berkualitas tinggi. Analoginya sederhana: kalau kamu bertanya &quot;buatkan kode&quot; tanpa konteks, hasilnya akan generik dan mungkin tidak sesuai kebutuhan. Tapi kalau kamu bertanya dengan detail dan spesifik, hasilnya bisa luar biasa akurat.</p><h2>Teknik 1: Berikan Konteks yang Jelas</h2><p>Alih-alih bertanya seperti ini:</p><blockquote>&quot;Buatkan kode tombol.&quot;</blockquote><p>Coba bertanya seperti ini:</p><blockquote>&quot;Buatkan kode HTML dan CSS untuk tombol berwarna biru dengan teks putih, sudut melengkung 8px, efek bayangan halus, dan efek hover yang membuat warnanya menjadi lebih gelap. Gunakan font-family Arial.&quot;</blockquote><p>Lihat perbedaannya? Prompt kedua memberikan <strong>konteks yang sangat spesifik</strong>, sehingga AI bisa memberikan hasil yang langsung sesuai keinginanmu tanpa perlu bolak-balik revisi.</p><h2>Teknik 2: Minta AI Menjelaskan Kode Baris per Baris</h2><p>Salah satu cara terbaik belajar koding dengan AI adalah meminta penjelasan detail:</p><blockquote>&quot;Jelaskan kode JavaScript berikut baris per baris, seolah-olah kamu sedang mengajar siswa yang baru pertama kali belajar programming. Gunakan analogi kehidupan sehari-hari untuk setiap konsep.&quot;</blockquote><p>Kemudian tempelkan kode yang ingin kamu pahami. AI akan memberikan penjelasan yang sangat detail dan mudah dicerna. Ini jauh lebih efektif daripada hanya membaca dokumentasi resmi yang sering kali terlalu teknis untuk pemula.</p><img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1100&q=80" alt="Infrastruktur cloud dan teknologi server" style="width:100%;border-radius:16px;margin:20px 0;"><h2>Teknik 3: Minta AI Membuat Latihan Soal</h2><p>Ini teknik yang jarang diketahui tapi sangat powerful:</p><blockquote>&quot;Buatkan 5 soal latihan JavaScript tentang manipulasi DOM untuk tingkat pemula. Setiap soal harus memiliki: deskripsi tugas yang jelas, kode awal (starter code) yang harus dilengkapi siswa, dan kunci jawaban beserta penjelasannya.&quot;</blockquote><p>Dalam hitungan detik, kamu mendapatkan materi latihan berkualitas yang biasanya butuh waktu berjam-jam untuk dibuat oleh guru.</p><h2>Teknik 4: Gunakan AI untuk Debugging</h2><p>Menemukan bug dalam kode bisa sangat membuat frustrasi, terutama untuk pemula. AI bisa menjadi detektif bug yang sangat andal:</p><blockquote>&quot;Kode HTML/CSS saya di bawah ini seharusnya menampilkan kartu profil di tengah layar, tapi posisinya selalu menempel di kiri. Tolong identifikasi masalahnya dan berikan solusi perbaikan beserta penjelasan mengapa kode aslinya tidak berfungsi.&quot;</blockquote><p>Perhatikan bahwa prompt ini tidak hanya meminta perbaikan, tapi juga meminta <strong>penjelasan mengapa</strong> kode tidak berfungsi. Ini kunci agar kamu benar-benar belajar, bukan sekadar copy-paste solusi.</p><h2>Hal-Hal yang Perlu Diingat</h2><ol><li><strong>AI bisa salah.</strong> Jangan langsung percaya 100% pada kode yang diberikan AI. Selalu uji hasilnya di browser atau Live Playground dan pastikan berfungsi sesuai harapan.</li><li><strong>Jangan jadikan AI sebagai pengganti belajar.</strong> AI adalah <em>akselerator</em>, bukan <em>jalan pintas</em>. Gunakan AI untuk mempercepat pemahaman, tapi pastikan kamu benar-benar memahami konsepnya — bukan sekadar menyalin jawabannya.</li><li><strong>Semakin baik pertanyaanmu, semakin baik jawabannya.</strong> Luangkan waktu sebentar untuk menyusun prompt yang jelas dan spesifik. Investasi kecil ini akan menghemat banyak waktumu.</li><li><strong>Gunakan AI untuk review kode.</strong> Setelah menulis kode sendiri, minta AI untuk mereview dan memberikan saran perbaikan. Ini seperti punya mentor yang selalu siap memberi masukan.</li></ol><blockquote>&quot;Kemampuan bertanya yang baik kepada AI akan menjadi salah satu keahlian paling berharga di dunia kerja masa depan. Mulai asah kemampuan itu dari sekarang.&quot;</blockquote><p>Selamat bereksperimen! Ingat — AI adalah alat yang luar biasa, tapi kamu tetap sang pemandu. Gunakan AI dengan bijak, dan proses belajar kodingmu akan terasa jauh lebih menyenangkan dan efisien.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Riset AI VxAI',
                'views_count' => 612,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(6),
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(6),
            ]
        ];

        foreach ($articles as $art) {
            DB::table('articles')->insertOrIgnore($art);
        }
    }
}