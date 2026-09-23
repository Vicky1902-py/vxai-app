<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        $settings = $this->getSettings();
        $totalSubmissions = Schema::hasTable('coding_submissions') ? DB::table('coding_submissions')->count() : 0;
        $totalStudents = Schema::hasTable('users') ? DB::table('users')->where('role_id', 3)->count() : 0;
        
        $latestArticles = collect();
        if (Schema::hasTable('articles')) {
            $latestArticles = Article::published()
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        }

        return view('welcome', compact('settings', 'totalSubmissions', 'totalStudents', 'latestArticles'));
    }

    // Halaman Playground Publik
    public function playground()
    {
        $settings = $this->getSettings();
        $user = Auth::user();

        return view('public.playground', compact('settings', 'user'));
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
        $settings = $this->getSettings();
        
        $query = Article::published();

        // Filter Kategori
        $activeCategory = $request->query('kategori');
        if ($activeCategory && in_array($activeCategory, ['coding', 'ai', 'teknologi', 'komputer', 'android'])) {
            $query->where('category', $activeCategory);
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
            'coding' => Article::published()->where('category', 'coding')->count(),
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
        $settings = $this->getSettings();

        // Cari artikel (Super Admin bisa melihat draft jika sedang login)
        $article = Article::where('slug', $slug)->firstOrFail();
        if ($article->status !== 'published') {
            if (!Auth::check() || Auth::user()->role_id !== 1) {
                abort(404);
            }
        }

        // Tambah tayangan (views count) secara aman
        $article->increment('views_count');

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
}
