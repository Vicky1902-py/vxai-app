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
                'title' => 'Panduan Lengkap Belajar Web Development Modern dari Nol di Tahun 2026',
                'slug' => 'panduan-lengkap-belajar-web-development-modern-2026',
                'category' => 'coding',
                'summary' => 'Pelajari peta jalan (roadmap) lengkap menjadi web developer handal, mulai dari pemahaman semantik HTML5, tata letak CSS3 Grid & Flexbox, hingga logika JavaScript modern.',
                'content' => '<h2>Membangun Fondasi Web Modern</h2><p>Di era kecerdasan artifisial saat ini, keahlian rekayasa web (web development) tetap menjadi pilar utama industri digital. Browser telah bertransformasi menjadi platform sistem operasi tempat berbagai aplikasi canggih berjalan, mulai dari editor koding seperti VxAI hingga aplikasi desain profesional.</p><h3>1. Mengapa Memulai dari HTML5 Semantik?</h3><p>Banyak pemula tergoda langsung melompat ke framework canggih seperti React atau Vue tanpa memahami HTML5 dengan benar. Padahal, struktur semantik (seperti <code>&lt;header&gt;</code>, <code>&lt;main&gt;</code>, <code>&lt;article&gt;</code>, dan <code>&lt;footer&gt;</code>) adalah kunci agar website Anda ramah mesin pencari (SEO) dan mudah diakses (accessibility/a11y) oleh semua pengguna.</p><h3>2. Menguasai CSS3 Modern: Flexbox &amp; Grid</h3><p>Lupakan masa-masa mengatur posisi elemen dengan <code>float</code> atau <code>table</code>. Dengan CSS Flexbox untuk tata letak satu dimensi dan CSS Grid untuk dua dimensi, membangun tampilan responsif yang mulus di ponsel dan komputer kini jauh lebih intuitif dan bersih.</p><pre><code>/* Contoh Flexbox Sederhana */
.card-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
}</code></pre><h3>3. Logika Interaktif dengan JavaScript</h3><p>JavaScript adalah bahasa pemrograman resmi peramban web. Mulailah dengan memahami manipulasi DOM (Document Object Model), penanganan event pengguna, dan konsep async/await untuk mengambil data dari REST API. Kuasai dasar-dasar ini di live playground kami sebelum melangkah ke tingkat berikutnya!</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 142,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(1),
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
            [
                'title' => '7 Trik Prompt Engineering untuk Memaksimalkan Coding dengan AI Assistant',
                'slug' => '7-trik-prompt-engineering-coding-ai-assistant',
                'category' => 'ai',
                'summary' => 'Tingkatkan produktivitas koding hingga 300% dengan teknik prompt engineering terbaik. Pelajari role-prompting, few-shot coding, dan cara menghindari halusinasi kode AI.',
                'content' => '<h2>Revolusi Koding Berbantuan Kecerdasan Artifisial</h2><p>Asisten AI seperti ChatGPT, Claude, dan Gemini bukan untuk menggantikan programmer, melainkan menjadi asisten super cerdas (*co-pilot*) yang mempercepat alur kerja hingga tiga kali lipat. Namun, kualitas jawaban AI sangat bergantung pada bagaimana Anda menyusun instruksi (prompt).</p><h3>Simak Video Tutorial Praktis Prompt Engineering:</h3><div class="my-6 rounded-2xl overflow-hidden shadow-lg border border-slate-200"><div class="relative w-full" style="padding-bottom: 56.25%;"><iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/jC4v5AS4RIM" title="Prompt Engineering Tutorial" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div><p class="text-xs text-center text-slate-500 py-2.5 bg-slate-50">Video Panduan Praktis: Menguasai Prompt Engineering untuk Efisiensi Pemrograman</p></div><h3>Trik 1: Terapkan Teknik "Role Prompting"</h3><p>Selalu berikan persona spesifik kepada AI sebelum meminta bantuan. Misalnya: <em>"Bertindaklah sebagai Senior Security Engineer PHP Laravel. Review kode login berikut dari celah SQL Injection dan CSRF."</em> Hasilnya akan jauh lebih spesifik dan berstandar industri.</p><h3>Trik 2: Sertakan Konteks Batasan (Constraints)</h3><p>Beritahu AI apa yang <strong>TIDAK BOLEH</strong> dilakukan. Misalnya: <em>"Gunakan hanya JavaScript vanilla murni tanpa library eksternal, dan buat kode seringkas mungkin."</em></p><h3>Trik 3: Berikan Contoh Pola Input dan Output (Few-Shot Prompting)</h3><p>Jika Anda menginginkan format data tertentu (misalnya JSON terstruktur), cantumkan 1 atau 2 contoh hasil yang diharapkan di dalam prompt Anda.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Admin Editorial',
                'views_count' => 285,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(2),
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'title' => 'Tren Kecerdasan Artifisial 2026: Bagaimana Teknologi Mengubah Industri Digital Indonesia',
                'slug' => 'tren-kecerdasan-artifisial-2026-industri-digital-indonesia',
                'category' => 'teknologi',
                'summary' => 'Eksplorasi mendalam mengenai perkembangan pesat teknologi AI generatif, otomasi cerdas, dan transformasi digital yang membuka peluang karir baru di tanah air.',
                'content' => '<h2>Lanskap Transformasi Digital Indonesia</h2><p>Perkembangan teknologi kecerdasan buatan (AI) di tahun 2026 telah memasuki fase integrasi praktis di seluruh sektor ekonomi nasional. Mulai dari layanan perbankan digital, pertanian presisi, hingga platform edukasi kejuruan seperti VxAI, adopsi AI terbukti mempercepat efisiensi dan inovasi secara nyata.</p><h3>1. Munculnya Generasi "AI-Augmented Developers"</h3><p>Kebutuhan industri kini beralih dari sekadar programmer yang menulis kode mekanis menjadi talenta yang mampu merancang arsitektur sistem, memandu AI agent, dan memvalidasi keamanan kode yang dihasilkan model kecerdasan buatan.</p><h3>2. Kedaulatan Data & Infrastruktur Cloud Lokal</h3><p>Pemerintah dan sektor swasta kian gencar membangun pusat data (*data center*) berstandar tinggi di Indonesia guna memastikan kepatuhan regulasi privasi data dan kedaulatan digital nasional.</p><h3>3. Vokasi sebagai Ujung Tombak Literasi</h3><p>Sekolah Menengah Kejuruan (SMK) memegang peranan krusial sebagai jembatan antara kurikulum akademis dan kebutuhan riil dunia kerja industri 4.0.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Riset VxAI',
                'views_count' => 198,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(3),
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'title' => 'Panduan Troubleshooting Komputer: Cara Mengatasi PC Lemot & Blue Screen Tanpa Panik',
                'slug' => 'panduan-troubleshooting-komputer-pc-lemot-blue-screen',
                'category' => 'komputer',
                'summary' => 'Langkah demi langkah mendiagnosis dan memperbaiki masalah umum komputer, mulai dari thermal throttling, pembersihan RAM, pemeriksaan kesehatan SSD, hingga update driver sistem.',
                'content' => '<h2>Menjaga Komputer Tetap Prima untuk Koding & Produktivitas</h2><p>Komputer atau laptop yang lambat dan sering mengalami layar biru (*Blue Screen of Death / BSOD*) adalah momok bagi setiap pengguna, terutama saat sedang mengerjakan proyek penting. Sebagian besar kendala ini dapat diselesaikan secara mandiri tanpa perlu buru-buru ke tempat servis.</p><h3>Langkah 1: Periksa Suhu Prosesor (Thermal Throttling)</h3><p>Debu yang menumpuk di kipas pendingin atau pasta termal yang telah mengering menyebabkan prosesor membatasi kecepatannya secara drastis untuk mencegah kerusakan fisik. Gunakan software monitoring suhu (seperti HWMonitor) dan pastikan suhu saat koding tidak melebihi 85°C.</p><h3>Langkah 2: Cek Kesehatan Media Penyimpanan (SSD / HDD)</h3><p>Gejala komputer sering macet tiba-tiba (*freeze*) seringkali disebabkan oleh *bad sector* pada storage. Periksa status SMART menggunakan CrystalDiskInfo untuk memastikan media penyimpanan dalam kondisi sehat (Good 100%).</p><h3>Langkah 3: Bersihkan Startup Apps & Layanan Latar Belakang</h3><p>Buka Task Manager (Ctrl + Shift + Esc), masuk ke tab <strong>Startup</strong>, dan nonaktifkan aplikasi yang tidak diperlukan agar waktu booting komputer kembali instan.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Laboratorium Komputer',
                'views_count' => 220,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(4),
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
            ],
            [
                'title' => '10 Trik Rahasia Optimasi HP Android: Bikin Performa Ngebut & Baterai Tahan Seharian',
                'slug' => '10-trik-rahasia-optimasi-hp-android-performa-baterai',
                'category' => 'android',
                'summary' => 'Trik praktis memaksimalkan smartphone Android Anda: aktifkan developer options, kurangi skala animasi, batasi background processes, dan kelola manajemen baterai cerdas.',
                'content' => '<h2>Optimasi Ekosistem Android untuk Pengalaman Maksimal</h2><p>Sistem operasi Android menawarkan fleksibilitas kustomisasi yang luar biasa. Sayangnya, banyak pengaturan bawaan pabrik yang belum dioptimalkan untuk performa maksimal. Berikut tips teruji yang langsung terasa dampaknya:</p><h3>Trik 1: Pangkas Skala Animasi ke 0.5x</h3><p>Buka <em>Pengaturan &gt; Tentang Ponsel</em>, lalu ketuk <strong>Nomor Bentukan (Build Number)</strong> sebanyak 7 kali hingga opsi pengembang aktif. Masuk ke <strong>Opsi Pengembang (Developer Options)</strong> dan ubah ketiga skala animasi (Window, Transition, Animator) dari 1.0x menjadi <strong>0.5x</strong>. HP Anda akan langsung terasa dua kali lebih responsif!</p><h3>Trik 2: Nonaktifkan Fitur RAM Plus / Virtual RAM</h3><p>Fitur penambahan RAM virtual meminjam memori internal (eMMC/UFS) yang kecepatannya jauh lebih lambat dibanding RAM fisik. Pada banyak kasus, mematikan RAM Plus justru membuat multitasking lebih mulus dan menghemat siklus baca/tulis memori internal.</p><h3>Trik 3: Batasi Aplikasi Berjalan di Latar Belakang</h3><p>Beri status *Deep Sleep* (Tidur Pulas) pada aplikasi media sosial atau e-commerce yang jarang digunakan agar tidak menguras baterai dan kuota internet di latar belakang.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Mobile VxAI',
                'views_count' => 310,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(5),
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'title' => 'Membangun Ekosistem Talenta Digital Vokasi Unggulan dari Bumi Flobamorata (NTT)',
                'slug' => 'membangun-talenta-digital-vokasi-flobamorata-ntt',
                'category' => 'teknologi',
                'summary' => 'Bagaimana inisiatif pembelajaran koding interaktif di SMKN 1 Kupang Barat membuka jalan bagi generasi muda Nusa Tenggara Timur untuk menembus industri teknologi nasional dan global.',
                'content' => '<h2>Menjawab Tantangan Kesenjangan Digital</h2><p>Nusa Tenggara Timur menyimpan potensi sumber daya manusia yang luar biasa besar. Geografi kepulauan yang membentang dari Timor, Rote, Sabu, Sumba, hingga Flores (Flobamorata) kini dijembatani oleh keterbukaan akses teknologi dan internet berkecepatan tinggi.</p><h3>Inisiatif Laboratorium Koding SMKN 1 Kupang Barat</h3><p>Melalui kehadiran platform <strong>VxAI Coding Lab</strong>, para pelajar kejuruan tidak lagi terbatas oleh keterbatasan software berbayar atau spesifikasi komputer tinggi. Cukup dengan browser biasa, siswa dapat langsung menulis kode HTML, CSS, JavaScript, dan melihat hasilnya secara seketika.</p><blockquote>"Bakat tidak mengenal batas geografis. Dengan alat yang tepat dan ketekunan belajar, anak-anak NTT mampu menciptakan solusi perangkat lunak yang berdaya guna bagi masyarakat luas."</blockquote><h3>Menuju Masa Depan Digital Berdaya Saing Global</h3><p>Dengan memadukan kurikulum berjenjang 10 tantangan koding praktis, wawasan kecerdasan artifisial, dan publikasi warta teknologi yang konsisten, ekosistem digital NTT siap mencetak talenta unggul yang berkontribusi nyata bagi kemajuan bangsa.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1548784741-0e7f108d7755?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Keluarga Besar SMKN 1 Kupang Barat',
                'views_count' => 450,
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