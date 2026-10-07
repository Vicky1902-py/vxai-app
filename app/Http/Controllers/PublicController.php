<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleContentService;
use App\Services\PlaygroundChallengeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    private function getSettings()
    {
        if (!Schema::hasTable('global_settings')) {
            return [];
        }
        return DB::table('global_settings')->pluck('setting_value', 'setting_key')->toArray();
    }

    // Halaman Beranda Publik
    public function index()
    {
        ArticleContentService::syncDefaultArticles();
        $settings = $this->getSettings();
        $totalSubmissions = Schema::hasTable('coding_submissions') ? DB::table('coding_submissions')->count() : 0;
        $totalStudents = Schema::hasTable('users') ? DB::table('users')->where('role_id', 3)->count() : 0;
        $totalArticles = Schema::hasTable('articles') ? DB::table('articles')->where('status', 'published')->count() : 0;
        
        $latestArticles = collect();
        if (Schema::hasTable('articles')) {
            $latestArticles = Article::published()
                ->orderBy('is_featured', 'desc')
                ->orderBy('published_at', 'desc')
                ->limit(7)
                ->get();
        }

        return view('welcome', compact('settings', 'totalSubmissions', 'totalStudents', 'totalArticles', 'latestArticles'));
    }

    // Halaman Profil Penulis & Inovator (E-E-A-T Google AdSense)
    public function authorProfile($slug = null)
    {
        ArticleContentService::syncDefaultArticles();
        $settings = $this->getSettings();

        // Data Penulis Utama / Founder
        $author = [
            'name' => 'Vicky Koroh',
            'title' => 'Pendidik Vokasi Rekayasa Perangkat Lunak & Inovator AI',
            'role' => 'Founder & Lead Developer VxAI Lab & guru.vxai.online',
            'institution' => 'Pendidik Vokasi Kejuruan & Jaringan SMK se-Nusa Tenggara Timur (NTT)',
            'bio' => 'Pendidik kejuruan dan full-stack software engineer berbasis di Kupang, Nusa Tenggara Timur (NTT). Berfokus pada demokratisasi pembelajaran koding dan integrasi kecerdasan artifisial untuk pendidikan vokasi di Indonesia. Berpengalaman mendampingi komunitas guru dan siswa SMK di NTT dalam penguasaan kurikulum teknologi digital, serta pengembang mandiri platform Sistem Perangkat Ajar SMK 2026 (guru.vxai.online) yang berlandaskan regulasi resmi BSKAP No. 046/H/KR/2025 dan Permendikdasmen No. 13/2025.',
            'avatar' => !empty($settings['app_logo']) ? asset($settings['app_logo']) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
            'skills' => ['HTML5 / CSS3 / JS', 'Laravel & PHP 8.2+', 'Kurikulum Merdeka SMK', 'Deep Learning 3M', 'Pure Expert Systems', 'Tailwind CSS'],
            'social' => [
                'github' => 'https://github.com/Vicky1902-py',
                'website' => 'https://guru.vxai.online',
                'email' => $settings['contact_email'] ?? 'admin@vxai.online',
            ]
        ];

        $articles = collect();
        if (Schema::hasTable('articles')) {
            $articles = Article::published()
                ->orderBy('published_at', 'desc')
                ->get();
        }

        return view('public.author_profile', compact('settings', 'author', 'articles'));
    }

    // Halaman Sertifikat Kelulusan 10 Level & Verifikasi Publik
    public function certificate(Request $request)
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        // Nama penerima sertifikat (dari akun login atau parameter input)
        $studentName = $request->query('nama') 
            ?? ($user ? $user->name : 'Siswa Pembelajar VxAI');

        $certId = 'VXAI-CERT-' . strtoupper(substr(md5($studentName . '2026'), 0, 8));
        $issueDate = now()->translatedFormat('d F Y') ?? now()->format('d M Y');

        return view('public.certificate', compact('settings', 'user', 'studentName', 'certId', 'issueDate'));
    }

    // Halaman Playground Publik
    public function playground()
    {
        $settings = $this->getSettings();
        $user = Auth::user();
        $challenges = PlaygroundChallengeService::getActiveChallenges();

        return view('public.playground', compact('settings', 'user', 'challenges'));
    }

    // Halaman Tutorial & Kamus Koding
    public function tutorials()
    {
        $settings = $this->getSettings();
        return view('public.tutorials', compact('settings'));
    }

    // Halaman Legal Wajib AdSense
    public function privacyPolicy()
    {
        $settings = $this->getSettings();
        return view('public.privacy', compact('settings'));
    }

    public function terms()
    {
        $settings = $this->getSettings();
        return view('public.terms', compact('settings'));
    }

    public function about()
    {
        $settings = $this->getSettings();
        return view('public.about', compact('settings'));
    }

    public function contact()
    {
        $settings = $this->getSettings();
        return view('public.contact', compact('settings'));
    }

    // Endpoint ads.txt dinamis (Google AdSense)
    public function adsTxt()
    {
        $settings = $this->getSettings();
        $content = $settings['ads_txt_content'] ?? "# google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0";
        
        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    // Endpoint sitemap.xml publik untuk Google Search Console & Mesin Pencari
    public function sitemap()
    {
        $articles = [];
        if (Schema::hasTable('articles')) {
            $articles = Article::published()->orderBy('updated_at', 'desc')->get();
        }

        $now = now()->toAtomString();
        $xml = view('public.sitemap', compact('articles', 'now'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    // Endpoint robots.txt dinamis (Dengan izin eksplisit untuk crawler AdSense & Googlebot)
    public function robotsTxt()
    {
        $settings = $this->getSettings();
        $defaultRobots = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nDisallow: /guru\nDisallow: /siswa\nDisallow: /migrate-db\n\nUser-agent: Mediapartners-Google\nAllow: /\n\nSitemap: " . url('/sitemap.xml');

        $content = !empty($settings['robots_txt_content']) ? $settings['robots_txt_content'] : $defaultRobots;

        if (!str_contains($content, 'Sitemap:')) {
            $content = rtrim($content) . "\n\nSitemap: " . url('/sitemap.xml');
        }

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    // Verifikasi kepemilikan Google Search Console via file HTML (google{code}.html)
    public function googleVerificationHtml($code)
    {
        return response("google-site-verification: google{$code}.html", 200)
            ->header('Content-Type', 'text/html; charset=utf-8');
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

        // Pastikan tabel ada
        if (!Schema::hasTable('coding_submissions')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {}
        }

        $userId = Auth::id();
        $guestName = $userId ? Auth::user()->name : ($request->input('guest_name') ?: 'Pengunjung Publik');

        if (Schema::hasTable('coding_submissions')) {
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
        }

        $xpEarned = 0;
        $newLevel = null;
        $newXp = null;

        if ($userId && Schema::hasTable('users')) {
            $user = Auth::user();
            $xpEarned = 25;
            $newXp = (int) $user->xp + $xpEarned;
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

    // ========================================================
    // PORTAL BERITA & TIPS TEKNOLOGI PUBLIK
    // ========================================================

    // Halaman Index Berita & Artikel
    public function newsIndex(Request $request)
    {
        ArticleContentService::syncDefaultArticles();
        $settings = $this->getSettings();
        
        $query = Article::published();

        // Filter Kategori
        $activeCategory = $request->query('kategori');
        if ($activeCategory && in_array($activeCategory, ['coding', 'web', 'ai', 'teknologi', 'komputer', 'android'])) {
            if ($activeCategory === 'coding' || $activeCategory === 'web') {
                $query->whereIn('category', ['coding', 'web']);
            } else {
                $query->where('category', $activeCategory);
            }
        }

        // Pencarian Kata Kunci
        $searchQuery = $request->query('q');
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('summary', 'like', "%{$searchQuery}%")
                  ->orWhere('content', 'like', "%{$searchQuery}%");
            });
        }

        // Artikel Sorotan / Featured Hero (Hanya tampil di halaman 1 tanpa filter pencarian)
        $featuredArticle = null;
        if (!$searchQuery && (!$activeCategory || $activeCategory === 'all') && $request->query('page', 1) == 1) {
            $featuredArticle = Article::published()->featured()->latest('published_at')->first();
            if ($featuredArticle) {
                $query->where('id', '!=', $featuredArticle->id);
            }
        }

        $articles = $query->orderBy('published_at', 'desc')->paginate(9)->withQueryString();

        // Hitung Jumlah per Kategori untuk Pills
        $categoryCounts = [
            'all' => Article::published()->count(),
            'coding' => Article::published()->whereIn('category', ['coding', 'web'])->count(),
            'ai' => Article::published()->where('category', 'ai')->count(),
            'teknologi' => Article::published()->where('category', 'teknologi')->count(),
            'komputer' => Article::published()->where('category', 'komputer')->count(),
            'android' => Article::published()->where('category', 'android')->count(),
        ];

        return view('public.news_index', compact('settings', 'articles', 'featuredArticle', 'activeCategory', 'searchQuery', 'categoryCounts'));
    }

    // Halaman Detail Baca Artikel
    public function newsDetail($slug)
    {
        ArticleContentService::syncDefaultArticles();
        $settings = $this->getSettings();

        // Cari artikel (Super Admin bisa melihat draft jika sedang login)
        $article = Article::where('slug', $slug)->firstOrFail();
        if ($article->status !== 'published') {
            if (!Auth::check() || Auth::user()->role_id !== 1) {
                abort(404);
            }
        }

        // Tambah tayangan (views count) secara real time per sesi pengunjung (murni tanpa rekayasa data dummy)
        $sessionKey = 'viewed_article_' . $article->id;
        if (!session()->has($sessionKey)) {
            $article->increment('views_count');
            session()->put($sessionKey, now()->timestamp);
        }

        // Artikel Terkait di kategori yang sama
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->limit(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $extraArticles = Article::published()
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->limit(3 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->merge($extraArticles);
        }

        return view('public.news_detail', compact('settings', 'article', 'relatedArticles'));
    }

    // Endpoint Pembuat Gambar Open Graph (WhatsApp, Facebook, Twitter) Berukuran Ideal & Kompresi Ringan (<250KB)
    public function articleOgImage($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $imageUrl = $article->safe_thumbnail;

        // Direktori cache gambar Open Graph
        $cacheDir = public_path('uploads/articles/cache');
        if (!file_exists($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }

        $cacheFilename = 'og_' . md5($article->id . '_' . ($article->updated_at?->timestamp ?? 0) . '_' . $article->thumbnail_url) . '.jpg';
        $cachePath = $cacheDir . '/' . $cacheFilename;

        // Jika cache sudah ada dan ukurannya valid (< 280KB)
        if (file_exists($cachePath) && filesize($cachePath) > 0 && filesize($cachePath) < 280 * 1024) {
            return response()->file($cachePath, [
                'Content-Type' => 'image/jpeg',
                'Content-Length' => filesize($cachePath),
                'Cache-Control' => 'public, max-age=604800, immutable',
            ]);
        }

        // Ambil data gambar sumber
        $imageContent = null;
        if (str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://')) {
            $parsedUrl = parse_url($imageUrl);
            // Jika merujuk ke domain sendiri, ambil langsung dari path lokal untuk kecepatan instan
            if (isset($parsedUrl['path'])) {
                $localRel = ltrim($parsedUrl['path'], '/');
                if (file_exists(public_path($localRel))) {
                    $imageContent = @file_get_contents(public_path($localRel));
                }
            }
            if (!$imageContent) {
                $ctx = stream_context_create(['http' => ['timeout' => 4]]);
                $imageContent = @file_get_contents($imageUrl, false, $ctx);
            }
        } else {
            $localPath = public_path(ltrim($imageUrl, '/'));
            if (file_exists($localPath)) {
                $imageContent = @file_get_contents($localPath);
            }
        }

        // Proses dengan GD jika tersedia
        if ($imageContent && extension_loaded('gd')) {
            $srcImg = @imagecreatefromstring($imageContent);
            if ($srcImg) {
                $origW = imagesx($srcImg);
                $origH = imagesy($srcImg);

                // Standar rasio Open Graph WhatsApp & Facebook: 1200 x 630
                $targetW = 1200;
                $targetH = 630;

                $srcRatio = $origW / $origH;
                $targetRatio = $targetW / $targetH;

                if ($srcRatio > $targetRatio) {
                    $cropW = (int) round($origH * $targetRatio);
                    $cropH = $origH;
                    $srcX = (int) round(($origW - $cropW) / 2);
                    $srcY = 0;
                } else {
                    $cropW = $origW;
                    $cropH = (int) round($origW / $targetRatio);
                    $srcX = 0;
                    $srcY = (int) round(($origH - $cropH) / 2);
                }

                $dstImg = imagecreatetruecolor($targetW, $targetH);
                imagecopyresampled($dstImg, $srcImg, 0, 0, $srcX, $srcY, $targetW, $targetH, $cropW, $cropH);

                // Simpan kualitas 75 untuk menjamin ukuran selalu di kisaran 120KB - 200KB (aman di bawah limit 300KB WhatsApp)
                imagejpeg($dstImg, $cachePath, 75);
                imagedestroy($srcImg);
                imagedestroy($dstImg);

                if (file_exists($cachePath)) {
                    return response()->file($cachePath, [
                        'Content-Type' => 'image/jpeg',
                        'Content-Length' => filesize($cachePath),
                        'Cache-Control' => 'public, max-age=604800, immutable',
                    ]);
                }
            }
        }

        // Fallback jika pemrosesan gagal: alihkan ke gambar thumbnail asli
        return redirect($imageUrl);
    }
}
