@extends('layouts.public')

@section('title', 'Warta & Tips Teknologi (Coding, AI, Komputer, Android) - ' . ($settings['app_name'] ?? 'VxAI Coding Lab'))
@section('meta_description', 'Portal berita teknologi terkini, tips koding web, prompt engineering AI, panduan komputer hardware, dan trik optimasi smartphone Android.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

    <!-- Header Portal Berita -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold shadow-sm">
            <span>📰 Warta Digital & Edukasi Teknologi</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
            Kabar Teknologi, <span class="text-blue-600">Tips & Trik Koding</span> Terkini
        </h1>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
            Jelajahi artikel mendalam seputar dunia pemrograman, pemanfaatan kecerdasan artifisial (AI), panduan komputer, dan optimasi Android untuk memperluas wawasan digital Anda.
        </p>
    </div>

    <!-- Banner AdSense Atas (Jika Aktif) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <div class="max-w-4xl mx-auto text-center my-4 overflow-hidden rounded-2xl">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="1234567890"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    @endif

    <!-- Navigasi Kategori & Bar Pencarian -->
    <div class="bg-white p-4 sm:p-6 rounded-3xl border border-slate-200/90 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-4">
        
        <!-- Filter Kategori Tabs -->
        <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
            <a href="{{ route('public.news') }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 {{ !$activeCategory ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>Semua</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ !$activeCategory ? 'bg-white/20' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['all'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('public.news', ['kategori' => 'coding']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 {{ $activeCategory === 'coding' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>💻 Coding</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeCategory === 'coding' ? 'bg-white/20' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['coding'] ?? 0 }}</span>
            </a>

            <a href="{{ route('public.news', ['kategori' => 'ai']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 {{ $activeCategory === 'ai' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>🤖 Tips AI</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeCategory === 'ai' ? 'bg-white/20' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['ai'] ?? 0 }}</span>
            </a>

            <a href="{{ route('public.news', ['kategori' => 'teknologi']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 {{ $activeCategory === 'teknologi' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>🌐 Teknologi</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeCategory === 'teknologi' ? 'bg-white/20' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['teknologi'] ?? 0 }}</span>
            </a>

            <a href="{{ route('public.news', ['kategori' => 'komputer']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 {{ $activeCategory === 'komputer' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>🖥️ Komputer</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeCategory === 'komputer' ? 'bg-white/20' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['komputer'] ?? 0 }}</span>
            </a>

            <a href="{{ route('public.news', ['kategori' => 'android']) }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 {{ $activeCategory === 'android' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <span>📱 Android</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $activeCategory === 'android' ? 'bg-white/20' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['android'] ?? 0 }}</span>
            </a>
        </div>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('public.news') }}" class="relative w-full lg:w-72">
            @if($activeCategory)
                <input type="hidden" name="kategori" value="{{ $activeCategory }}">
            @endif
            <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari artikel berita..." 
                   class="w-full pl-10 pr-4 py-2.5 rounded-2xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-slate-50 text-slate-800 placeholder-slate-400">
            <span class="absolute left-3.5 top-3 text-xs text-slate-400">🔍</span>
            @if($searchQuery)
                <a href="{{ route('public.news', $activeCategory ? ['kategori' => $activeCategory] : []) }}" class="absolute right-3.5 top-2.5 text-xs text-slate-400 hover:text-slate-600">✕</a>
            @endif
        </form>

    </div>

    <!-- ======================================================== -->
    <!-- ARTIKEL UTAMA (FEATURED HERO CARD) -->
    <!-- ======================================================== -->
    @if($featuredArticle)
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                
                <!-- Gambar Hero Kiri -->
                <div class="lg:col-span-7 relative h-72 sm:h-96 lg:h-auto overflow-hidden bg-slate-900">
                    <img src="{{ $featuredArticle->safe_thumbnail }}" alt="{{ $featuredArticle->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-black text-xs px-3.5 py-1.5 rounded-xl shadow-lg flex items-center gap-1.5">
                        <span>⭐</span> <span>Artikel Sorotan</span>
                    </div>
                </div>

                <!-- Konten Hero Kanan -->
                <div class="lg:col-span-5 p-6 sm:p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $featuredArticle->category_badge_classes }}">
                                {{ $featuredArticle->category_icon }} {{ $featuredArticle->category_label }}
                            </span>
                            <span class="text-xs text-slate-400">• {{ $featuredArticle->reading_time }}</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 group-hover:text-blue-600 transition leading-snug tracking-tight">
                            <a href="{{ route('public.news.detail', $featuredArticle->slug) }}">
                                {{ $featuredArticle->title }}
                            </a>
                        </h2>

                        <p class="text-xs sm:text-sm text-slate-600 mt-4 leading-relaxed line-clamp-3">
                            {{ $featuredArticle->summary ?? strip_tags($featuredArticle->content) }}
                        </p>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-xs text-slate-500">
                            <span class="font-bold text-slate-800 block">{{ $featuredArticle->author_name }}</span>
                            <span class="text-[11px] text-slate-400">{{ $featuredArticle->published_at ? $featuredArticle->published_at->format('d M Y') : $featuredArticle->created_at->format('d M Y') }}</span>
                        </div>

                        <a href="{{ route('public.news.detail', $featuredArticle->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition flex items-center gap-1.5">
                            <span>Baca Lengkap</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- GRID DAFTAR ARTIKEL -->
    <!-- ======================================================== -->
    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $art)
                <article class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between overflow-hidden group">
                    <div>
                        <!-- Thumbnail Gambar -->
                        <div class="relative h-52 overflow-hidden bg-slate-100">
                            <img src="{{ $art->safe_thumbnail }}" alt="{{ $art->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 rounded-xl text-[11px] font-bold border backdrop-blur-md bg-white/95 shadow-sm {{ $art->category_badge_classes }}">
                                    {{ $art->category_icon }} {{ $art->category_label }}
                                </span>
                            </div>
                        </div>

                        <!-- Teks Artikel -->
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-[11px] text-slate-400 mb-2">
                                <span>{{ $art->published_at ? $art->published_at->format('d M Y') : $art->created_at->format('d M Y') }}</span>
                                <span>•</span>
                                <span>{{ $art->reading_time }}</span>
                                <span>•</span>
                                <span>{{ number_format($art->views_count) }} views</span>
                            </div>

                            <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition leading-snug line-clamp-2">
                                <a href="{{ route('public.news.detail', $art->slug) }}">
                                    {{ $art->title }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-600 mt-2.5 leading-relaxed line-clamp-3">
                                {{ $art->summary ?? strip_tags($art->content) }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Kartu -->
                    <div class="px-6 pb-6 pt-2 flex items-center justify-between border-t border-slate-50">
                        <span class="text-[11px] font-semibold text-slate-500">
                            Oleh: {{ $art->author_name }}
                        </span>
                        <a href="{{ route('public.news.detail', $art->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                            <span>Baca</span>
                            <span>➔</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="pt-6 flex justify-center">
                {{ $articles->links() }}
            </div>
        @endif

    @else
        <!-- State Kosong -->
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/90 shadow-sm max-w-md mx-auto space-y-4">
            <div class="text-4xl">🔍</div>
            <h3 class="text-lg font-bold text-slate-900">Tidak ada artikel yang ditemukan</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Kata kunci atau kategori yang Anda pilih belum memiliki artikel terkait. Silakan coba kata kunci lain.
            </p>
            <a href="{{ route('public.news') }}" class="inline-block px-5 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-bold shadow hover:bg-blue-700 transition">
                Reset Filter
            </a>
        </div>
    @endif

</div>
@endsection
