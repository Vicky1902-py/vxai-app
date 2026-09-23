@extends('layouts.public')

@section('title', $article->title . ' - ' . ($settings['app_name'] ?? 'VxAI Coding Lab'))
@section('meta_description', Str::limit(strip_tags($article->summary ?? $article->content), 160))

@push('styles')
<style>
    /* Styling Format Artikel untuk Keterbacaan Optimal & Kenyamanan Mata */
    .article-body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1e293b;
        font-size: 1.0625rem;
        line-height: 1.85;
    }
    .article-body h2 {
        font-size: 1.625rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 2.25rem;
        margin-bottom: 1rem;
        letter-spacing: -0.025em;
        line-height: 1.35;
    }
    .article-body h3 {
        font-size: 1.275rem;
        font-weight: 700;
        color: #1e293b;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    .article-body p {
        margin-bottom: 1.35rem;
    }
    .article-body ul, .article-body ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .article-body ul { list-style-type: disc; }
    .article-body ol { list-style-type: decimal; }
    .article-body li { margin-bottom: 0.5rem; }
    .article-body blockquote {
        border-left: 4px solid #2563eb;
        background-color: #f8fafc;
        padding: 1.25rem 1.5rem;
        margin: 1.75rem 0;
        border-radius: 0 1rem 1rem 0;
        font-style: italic;
        color: #334155;
    }
    .article-body pre {
        background-color: #0f172a;
        color: #38bdf8;
        padding: 1.25rem;
        border-radius: 1rem;
        overflow-x: auto;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.875rem;
        margin: 1.5rem 0;
    }
    .article-body code:not(pre code) {
        background-color: #f1f5f9;
        color: #2563eb;
        padding: 0.2rem 0.4rem;
        border-radius: 0.375rem;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.875em;
        font-weight: 600;
    }
    .article-body img {
        border-radius: 1.25rem;
        margin: 1.75rem auto;
        max-width: 100%;
        height: auto;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.08);
    }
    /* Responsivitas Video YouTube & Iframe */
    .article-body iframe {
        max-width: 100%;
        border-radius: 1rem;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

    <!-- Breadcrumb Navigasi -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 overflow-x-auto whitespace-nowrap">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>/</span>
        <a href="{{ route('public.news') }}" class="hover:text-blue-600 transition">Berita & Tips</a>
        <span>/</span>
        <a href="{{ route('public.news', ['kategori' => $article->category]) }}" class="hover:text-blue-600 transition">
            {{ $article->category_label }}
        </a>
    </nav>

    <!-- Header Artikel -->
    <header class="space-y-4">
        <div class="flex flex-wrap items-center gap-2.5">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold border {{ $article->category_badge_classes }}">
                {{ $article->category_icon }} {{ $article->category_label }}
            </span>
            <span class="text-xs text-slate-400">•</span>
            <span class="text-xs font-semibold text-slate-500">⏱️ {{ $article->reading_time }}</span>
            <span class="text-xs text-slate-400">•</span>
            <span class="text-xs font-semibold text-slate-500">👁️ {{ number_format($article->views_count) }} kali dibaca</span>
        </div>

        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight tracking-tight">
            {{ $article->title }}
        </h1>

        <!-- Penulis & Tanggal -->
        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow">
                    {{ substr($article->author_name, 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-slate-900">{{ $article->author_name }}</div>
                    <div class="text-[11px] text-slate-400">{{ $article->published_at ? $article->published_at->format('l, d F Y') : $article->created_at->format('l, d F Y') }}</div>
                </div>
            </div>

            <!-- Tombol Bagikan Cepat -->
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-bold text-slate-400 hidden sm:inline">Bagikan:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-emerald-100 hover:bg-emerald-200 text-emerald-700 flex items-center justify-center transition" title="Kirim ke WhatsApp">
                    💬
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-700 flex items-center justify-center transition" title="Bagikan ke Facebook">
                    📘
                </a>
                <button type="button" onclick="salinTautan()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition" title="Salin Tautan Artikel">
                    🔗
                </button>
            </div>
        </div>
    </header>

    <!-- Gambar Sampul Resolusi Tinggi -->
    <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md">
        <img src="{{ $article->safe_thumbnail }}" alt="{{ $article->title }}" class="w-full max-h-[460px] object-cover">
    </div>

    <!-- Ringkasan Artikel / Lead Paragraph -->
    @if($article->summary)
        <div class="bg-blue-50/70 border-l-4 border-blue-600 p-5 sm:p-6 rounded-r-2xl text-slate-700 font-medium text-sm sm:text-base leading-relaxed">
            {{ $article->summary }}
        </div>
    @endif

    <!-- Banner AdSense Tengah (Jika Aktif) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <div class="my-6 text-center overflow-hidden rounded-2xl">
            <ins class="adsbygoogle"
                 style="display:block; text-align:center;"
                 data-ad-layout="in-article"
                 data-ad-format="fluid"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="1234567890"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    @endif

    <!-- Konten Artikel Lengkap -->
    <main class="article-body bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/90 shadow-sm">
        {!! $article->content !!}
    </main>

    <!-- Banner Tombol Praktik Langsung ke Playground -->
    <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="space-y-1 text-center sm:text-left">
            <span class="text-xs text-sky-200 font-extrabold uppercase tracking-wider">Praktikkan Langsung</span>
            <h3 class="text-xl sm:text-2xl font-black">Mau Coba Koding Sendiri?</h3>
            <p class="text-xs sm:text-sm text-blue-100 max-w-md">
                Buka Live Code Editor kami sekarang. Tanpa perlu instal software berat, langsung eksekusi kode di peramban browser Anda!
            </p>
        </div>
        <a href="{{ route('public.playground') }}" class="bg-white hover:bg-slate-50 text-blue-700 font-bold px-6 py-3.5 rounded-2xl shadow-lg transition active:scale-95 shrink-0 text-sm">
            ⚡ Buka Live Playground
        </a>
    </div>

    <!-- Banner AdSense Bawah (Jika Aktif) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <div class="my-6 text-center overflow-hidden rounded-2xl">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="1234567890"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- ARTIKEL TERKAIT -->
    <!-- ======================================================== -->
    @if($relatedArticles->count() > 0)
        <div class="pt-8 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>📚</span> <span>Artikel Terkait Lainnya</span>
                </h3>
                <a href="{{ route('public.news', ['kategori' => $article->category]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                    Lihat Semua di Kategori Ini ➔
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedArticles as $rel)
                    <a href="{{ route('public.news.detail', $rel->slug) }}" class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition hover:-translate-y-1 flex flex-col justify-between group">
                        <div>
                            <div class="h-36 overflow-hidden bg-slate-100">
                                <img src="{{ $rel->safe_thumbnail }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-4 space-y-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $rel->category_badge_classes }}">
                                    {{ $rel->category_icon }} {{ $rel->category_label }}
                                </span>
                                <h4 class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-blue-600 transition line-clamp-2">
                                    {{ $rel->title }}
                                </h4>
                            </div>
                        </div>
                        <div class="px-4 pb-4 pt-1 text-[11px] text-slate-400 flex items-center justify-between border-t border-slate-50">
                            <span>{{ $rel->published_at ? $rel->published_at->format('d M Y') : $rel->created_at->format('d M Y') }}</span>
                            <span class="text-blue-600 font-semibold">Baca ➔</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
    function salinTautan() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Tautan artikel berhasil disalin ke papan klip (clipboard)!');
        }).catch(function() {
            prompt('Salin tautan ini secara manual:', window.location.href);
        });
    }
</script>
@endpush
@endsection
