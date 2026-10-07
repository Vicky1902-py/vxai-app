@extends('layouts.public')

@section('title', 'Profil Penulis & Inovator: ' . $author['name'] . ' - ' . ($settings['app_name'] ?? 'VxAI Coding Lab'))
@section('meta_description', 'Profil resmi ' . $author['name'] . ', pendidik vokasi SMKN 1 Kupang Barat dan pengembang Sistem Perangkat Ajar SMK 2026 (guru.vxai.online) serta platform VxAI Coding Lab.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 space-y-12">

    <!-- Hero Card Profil Penulis (E-E-A-T) -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-blue-50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row items-center md:items-start gap-8 relative z-10">
            <!-- Avatar / Foto Profil -->
            <div class="shrink-0 relative">
                <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-4xl shadow-xl shadow-blue-500/25 border-4 border-white">
                    VK
                </div>
                <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white p-1.5 rounded-full shadow-md" title="Penulis Terverifikasi">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </div>
            </div>

            <!-- Detail Info Penulis -->
            <div class="space-y-4 text-center md:text-left flex-1">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold mb-2 shadow-sm">
                        <span>🎓 Pendidik Vokasi & Penulis Terverifikasi (E-E-A-T)</span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        {{ $author['name'] }}
                    </h1>
                    <p class="text-sm sm:text-base font-semibold text-blue-600 mt-1">
                        {{ $author['title'] }} • {{ $author['institution'] }}
                    </p>
                </div>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-3xl">
                    {{ $author['bio'] }}
                </p>

                <!-- Keahlian & Kredensial -->
                <div class="pt-2 flex flex-wrap justify-center md:justify-start gap-2">
                    @foreach($author['skills'] as $skill)
                        <span class="px-3 py-1 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold">
                            ✓ {{ $skill }}
                        </span>
                    @endforeach
                </div>

                <!-- Kontak & Portofolio Tautan -->
                <div class="pt-4 border-t border-slate-100 flex flex-wrap justify-center md:justify-start items-center gap-4 text-xs font-bold">
                    <a href="{{ $author['social']['website'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-500/20 transition flex items-center gap-1.5">
                        <span>🌐</span> <span>guru.vxai.online</span> <span>↗</span>
                    </a>
                    <a href="{{ $author['social']['github'] }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white transition flex items-center gap-1.5">
                        <span>💻</span> <span>GitHub Profile</span> <span>↗</span>
                    </a>
                    <a href="mailto:{{ $author['social']['email'] }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition flex items-center gap-1.5">
                        <span>✉️</span> <span>Hubungi via Email</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Ekosistem Karya & Inovasi Nyata -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Karya 1: guru.vxai.online -->
        <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg border border-indigo-800/80 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-full bg-indigo-500/30 text-indigo-300 text-xs font-bold border border-indigo-400/30 inline-block">
                    Inovasi Kurikulum Merdeka
                </span>
                <h3 class="text-xl font-black">Sistem Perangkat Ajar SMK 2026</h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Platform otomasi administrasi guru kejuruan berbasis <em>Pure Expert System</em> & <em>Deep Learning 3M</em>. Kepatuhan mutlak regulasi resmi BSKAP No. 046/H/KR/2025 dan Permendikdasmen No. 13/2025 dengan fitur Smart Soal 8 Kolom.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-indigo-800/60 flex items-center justify-between">
                <span class="text-xs text-indigo-300 font-semibold">100% Karya Mandiri</span>
                <a href="https://guru.vxai.online" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-sky-300 hover:text-white transition flex items-center gap-1">
                    <span>Buka Sistem</span> ➔
                </a>
            </div>
        </div>

        <!-- Karya 2: vxai.online -->
        <div class="bg-gradient-to-br from-blue-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg border border-blue-800/80 flex flex-col justify-between">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-full bg-blue-500/30 text-blue-300 text-xs font-bold border border-blue-400/30 inline-block">
                    Laboratorium Koding Browser
                </span>
                <h3 class="text-xl font-black">VxAI Coding Lab</h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Lingkungan belajar pemrograman interaktif tanpa instalasi. Membimbing siswa SMKN 1 Kupang Barat dan publik menguasai HTML5, CSS3, JavaScript, dan eksplorasi asisten AI modern langsung di browser.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-blue-800/60 flex items-center justify-between">
                <span class="text-xs text-blue-300 font-semibold">10 Tingkat Latihan</span>
                <a href="{{ route('public.playground') }}" class="text-xs font-bold text-sky-300 hover:text-white transition flex items-center gap-1">
                    <span>Buka Playground</span> ➔
                </a>
            </div>
        </div>
    </div>

    <!-- Daftar Publikasi Artikel Edukasi & Riset Teknologi -->
    <div class="space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">Artikel & Wawasan yang Ditulis</h2>
                <p class="text-xs text-slate-500 mt-1">Total {{ $articles->count() }} publikasi edukatif terkurasi dan mendalam</p>
            </div>
            <a href="{{ route('public.news') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                Portal Berita ➔
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $art)
                <article class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold border {{ $art->category_badge_classes }}">
                                {{ $art->category_icon }} {{ $art->category_label }}
                            </span>
                            <span class="text-[11px] text-slate-400">• {{ $art->formatted_date }}</span>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900 group-hover:text-blue-600 transition leading-snug line-clamp-2">
                            <a href="{{ route('public.news.detail', $art->slug) }}">
                                {{ $art->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                            {{ $art->summary ?? strip_tags($art->content) }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium text-[11px]">{{ $art->reading_time }}</span>
                        <a href="{{ route('public.news.detail', $art->slug) }}" class="font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                            <span>Baca</span> ➔
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>

</div>
@endsection
