<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }} - Platform Belajar Koding, AI & Inovasi Teknologi</title>
    <meta name="description" content="Platform pembelajaran interaktif koding HTML, CSS, JavaScript dan Kecerdasan Artifisial langsung dari browser untuk talenta digital masa depan.">

    <!-- Favicon -->
    @if(!empty($settings['app_favicon']))
        <link rel="icon" href="{{ asset($settings['app_favicon']) }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- URL Kanonikal SEO -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph Protocol (WhatsApp, Facebook, LinkedIn, Telegram) -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }} - Platform Belajar Koding, AI & Inovasi Teknologi">
    <meta property="og:description" content="Platform pembelajaran interaktif koding HTML, CSS, JavaScript dan Kecerdasan Artifisial langsung dari browser untuk talenta digital masa depan.">
    @php
        $homeOgImage = !empty($settings['app_logo']) ? asset($settings['app_logo']) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80';
    @endphp
    <meta property="og:image" content="{{ $homeOgImage }}">
    <meta property="og:image:secure_url" content="{{ $homeOgImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}">
    <link rel="image_src" href="{{ $homeOgImage }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }} - Platform Belajar Koding, AI & Inovasi Teknologi">
    <meta name="twitter:description" content="Platform pembelajaran interaktif koding HTML, CSS, JavaScript dan Kecerdasan Artifisial langsung dari browser untuk talenta digital masa depan.">
    <meta name="twitter:image" content="{{ $homeOgImage }}">

    <!-- JSON-LD Structured Data Schema.org (Google SEO & E-E-A-T) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "EducationalOrganization",
          "@id": "{{ url('/') }}#organization",
          "name": "{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}",
          "url": "{{ url('/') }}",
          "logo": "{{ !empty($settings['app_logo']) ? asset($settings['app_logo']) : url('/favicon.ico') }}",
          "description": "Platform pembelajaran interaktif pemrograman web, riset AI, dan kurikulum vokasi SMK.",
          "founder": {
            "@type": "Person",
            "name": "Vicky Koroh",
            "jobTitle": "Pendidik Vokasi & Lead Developer",
            "worksFor": {
              "@type": "EducationalOrganization",
              "name": "SMKN 1 Kupang Barat"
            },
            "url": "{{ route('public.author') }}"
          },
          "contactPoint": {
            "@type": "ContactPoint",
            "email": "{{ $settings['contact_email'] ?? 'admin@vxai.online' }}",
            "contactType": "Customer Support"
          }
        },
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}#website",
          "url": "{{ url('/') }}",
          "name": "{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}",
          "publisher": {
            "@id": "{{ url('/') }}#organization"
          }
        }
      ]
    }
    </script>

    <!-- Google Search Console & Webmaster Verification -->
    @if(!empty($settings['google_site_verification']))
        @if(\Illuminate\Support\Str::startsWith(trim($settings['google_site_verification']), '<meta'))
            {!! $settings['google_site_verification'] !!}
        @else
            <meta name="google-site-verification" content="{{ trim($settings['google_site_verification']) }}">
        @endif
    @endif

    @if(!empty($settings['custom_meta_tags']))
        {!! $settings['custom_meta_tags'] !!}
    @endif

    <!-- Google AdSense Script (Otomatis Aktif jika Dikonfigurasi di Admin) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}"
             crossorigin="anonymous"></script>
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre, .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(219, 234, 254, 0.85);
        }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#dbeafe 1.2px, transparent 1.2px);
            background-size: 24px 24px;
        }
        .text-gradient-blue {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans antialiased hero-pattern selection:bg-blue-600 selection:text-white">
    
    <!-- Decorative Top Accent Bar -->
    <div class="h-1.5 w-full bg-gradient-to-r from-blue-700 via-blue-600 to-sky-400 fixed top-0 z-[60]"></div>

    <!-- Navbar Utama -->
    <nav class="glass-nav fixed top-1.5 w-full z-50 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @if(!empty($settings['app_logo']))
                        <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="h-9 w-auto">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-600 text-white rounded-xl flex items-center justify-center font-black text-lg shadow-md shadow-blue-500/25 group-hover:scale-105 transition">Vx</div>
                    @endif
                    <div>
                        <span class="font-black text-lg tracking-tight text-slate-900 group-hover:text-blue-600 transition block leading-tight">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                        <span class="text-[10px] text-blue-600 font-extrabold uppercase tracking-wider block">Modern Coding & AI Lab</span>
                    </div>
                </a>

                <!-- Navigasi Menu Lengkap Publik -->
                <div class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="text-blue-600 font-bold transition">Beranda</a>
                    
                    <!-- Menu Utama: Pembelajaran Coding -->
                    <a href="{{ route('public.learning') }}" class="hover:text-blue-600 hover:bg-blue-50/80 px-3 py-1.5 rounded-xl border border-transparent hover:border-blue-200 transition flex items-center gap-1.5 group">
                        <span class="text-base group-hover:scale-110 transition">🎓</span>
                        <span>Pembelajaran Coding</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-extrabold bg-blue-600 text-white rounded-full">Baru</span>
                    </a>

                    <a href="{{ route('public.playground') }}" class="hover:text-blue-600 transition flex items-center gap-1.5">
                        <span class="text-blue-600">⚡</span>
                        <span>Live Playground</span>
                    </a>
                    
                    <a href="{{ route('public.news') }}" class="hover:text-blue-600 transition flex items-center gap-1.5">
                        <span>📰</span>
                        <span>Berita & Tips</span>
                    </a>
                    
                    <a href="{{ route('about') }}" class="hover:text-blue-600 transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Kontak</a>
                </div>

                <!-- Tombol Masuk / Dashboard + Mobile Menu Button -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->role_id == 1)
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-5 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md shadow-blue-500/20">
                                Panel Admin 📊
                            </a>
                        @elseif(Auth::user()->role_id == 2)
                            <a href="{{ route('guru.dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 sm:px-5 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md shadow-emerald-500/20">
                                Dashboard Guru 👨‍🏫
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-5 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md shadow-blue-500/20">
                                Ruang Belajar 🎒
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-5 py-2.5 rounded-xl font-bold text-xs transition-all shadow-md shadow-blue-600/20 hover:shadow-blue-600/30 hover:scale-[1.02] flex items-center gap-1.5">
                            <span>Masuk</span>
                            <span class="hidden sm:inline">/ Login</span>
                            <span>→</span>
                        </a>
                    @endauth

                    <!-- Mobile Menu Hamburger Button -->
                    <button type="button" onclick="document.getElementById('mobile-nav-welcome').classList.toggle('hidden')" class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 border border-slate-200 focus:outline-none" aria-label="Buka Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-nav-welcome" class="hidden lg:hidden border-t border-slate-200/80 bg-white/95 backdrop-blur-md px-4 pt-3 pb-5 space-y-2 shadow-xl">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-bold bg-blue-50 text-blue-600">
                🏠 Beranda
            </a>
            <a href="{{ route('public.learning') }}" class="block px-3 py-2 rounded-xl text-sm font-bold text-blue-700 bg-blue-50/70 hover:bg-blue-100 flex items-center justify-between">
                <span class="flex items-center gap-2">🎓 Pembelajaran Coding</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-600 text-white">Lengkap</span>
            </a>
            <a href="{{ route('public.playground') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
                ⚡ Live Playground Koding
            </a>
            <a href="{{ route('public.news') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50">
                📰 Berita & Tips Teknologi
            </a>
            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 px-3">
                <a href="{{ route('about') }}" class="hover:text-blue-600">Tentang Kami</a>
                <span>•</span>
                <a href="{{ route('contact') }}" class="hover:text-blue-600">Kontak</a>
                <span>•</span>
                <a href="{{ route('privacy') }}" class="hover:text-blue-600">Privasi</a>
            </div>
        </div>
    </nav>

    <!-- ======================================================== -->
    <!-- HERO SECTION: Kuasai Koding & Inovasi AI Modern -->
    <!-- ======================================================== -->
    <main class="flex-grow pt-24">
        
        <!-- Hero Header -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 sm:pb-16 text-center">
            
            <!-- Badge Platform Koding & AI -->
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-blue-100/90 border border-blue-200 text-blue-800 text-xs font-bold mb-6 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span>🚀 Laboratorium Koding & AI Interaktif Generasi Masa Depan</span>
                <span class="text-blue-400">•</span>
                <span class="text-blue-900 font-extrabold">VxAI Tech Portal</span>
            </div>

            <!-- Judul Utama (High Contrast & Clear Typography) -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 mb-6 leading-tight sm:leading-none tracking-tight max-w-5xl mx-auto">
                Kuasai Pemrograman Web & <br class="hidden sm:block">
                <span class="text-gradient-blue">Kecerdasan Artifisial</span> Langsung di Browser
            </h1>

            <!-- Deskripsi Jelas & Nyaman Terbaca -->
            <p class="text-base sm:text-lg md:text-xl text-slate-600 mb-8 max-w-3xl mx-auto leading-relaxed font-normal">
                Platform laboratorium koding dan teknologi komprehensif. Tulis HTML5, tata letak CSS3, logika JavaScript, dan jelajahi asisten AI modern tanpa hambatan instalasi.
            </p>
            
            <!-- Tombol Navigasi Utama -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="{{ route('public.playground') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-bold text-base shadow-xl shadow-blue-500/25 transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2.5">
                    <span>⚡ Buka Live Playground</span>
                    <span class="text-blue-200 text-xs font-semibold px-2 py-0.5 rounded-md bg-blue-700/60">10 Tingkatan</span>
                </a>
                <a href="{{ route('public.learning') }}" class="w-full sm:w-auto bg-white hover:bg-blue-50/60 text-slate-800 hover:text-blue-700 border-2 border-slate-200 hover:border-blue-300 px-8 py-4 rounded-2xl font-bold text-base shadow-sm transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <span>🎓 Kurikulum & Modul Belajar</span>
                </a>
            </div>

            <!-- ======================================================== -->
            <!-- HERO SHOWCASE: UI Screenshot Otentik Live Playground VxAI  -->
            <!-- ======================================================== -->
            <div class="relative max-w-5xl mx-auto rounded-3xl overflow-hidden shadow-2xl border-4 border-slate-800 bg-slate-950 text-left font-mono">
                <!-- Mac-Style Window Header -->
                <div class="bg-slate-900 px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                        <span class="ml-2 text-[11px] text-slate-400 font-sans font-semibold hidden sm:inline">VxAI Interactive Sandbox • vxai.online/playground</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="px-2.5 py-1 rounded-lg bg-blue-900/50 text-blue-300 border border-blue-800 text-[10px] font-sans font-bold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                            <span>Live Browser Engine</span>
                        </span>
                        <a href="{{ route('public.playground') }}" class="px-3 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-sans font-bold transition">
                            Uji Coba ➔
                        </a>
                    </div>
                </div>

                <!-- Window Content (Split Editor & Live Preview) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[300px] sm:min-h-[360px]">
                    <!-- Sisi Kiri: Multi-tab Code Editor Mockup -->
                    <div class="lg:col-span-7 bg-slate-950 p-4 sm:p-6 border-b lg:border-b-0 lg:border-r border-slate-800 flex flex-col justify-between">
                        <div>
                            <!-- Tabs File -->
                            <div class="flex items-center gap-2 border-b border-slate-800 pb-3 mb-4 text-xs font-sans">
                                <span class="px-3 py-1 rounded-lg bg-slate-850 text-orange-400 border border-slate-700 font-bold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span> index.html
                                </span>
                                <span class="px-3 py-1 rounded-lg text-slate-400 hover:text-white flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span> style.css
                                </span>
                                <span class="px-3 py-1 rounded-lg text-slate-400 hover:text-white flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span> script.js
                                </span>
                            </div>

                            <!-- Baris Kode Realistis Sintaks HTML5 -->
                            <div class="space-y-1.5 text-[11px] sm:text-xs text-slate-300 leading-relaxed font-mono overflow-x-auto">
                                <p><span class="text-slate-500">01</span> <span class="text-purple-400">&lt;div</span> <span class="text-sky-300">class</span>=<span class="text-emerald-300">"kartu-belajar"</span><span class="text-purple-400">&gt;</span></p>
                                <p><span class="text-slate-500">02</span>   <span class="text-purple-400">&lt;h3&gt;</span>Halo Siswa SMKN 1 Kupang Barat!<span class="text-purple-400">&lt;/h3&gt;</span></p>
                                <p><span class="text-slate-500">03</span>   <span class="text-purple-400">&lt;p&gt;</span>Mulai koding interaktif langsung dari browser kamu.<span class="text-purple-400">&lt;/p&gt;</span></p>
                                <p><span class="text-slate-500">04</span>   <span class="text-purple-400">&lt;button</span> <span class="text-sky-300">onclick</span>=<span class="text-emerald-300">"tambahSkor()"</span><span class="text-purple-400">&gt;</span>⚡ Klik Saya!<span class="text-purple-400">&lt;/button&gt;</span></p>
                                <p><span class="text-slate-500">05</span> <span class="text-purple-400">&lt;/div&gt;</span></p>
                            </div>
                        </div>

                        <!-- Footer Editor: Info Level Tantangan -->
                        <div class="mt-4 pt-3 border-t border-slate-900 flex items-center justify-between text-[11px] font-sans text-slate-400">
                            <span class="flex items-center gap-1.5 text-emerald-400 font-bold">
                                <span>🎯</span> <span>Tantangan Aktif: Level 1 (Struktur HTML Semantik)</span>
                            </span>
                            <span class="text-slate-500">UTF-8 • Real-time Compiler</span>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Live Render Preview Panel -->
                    <div class="lg:col-span-5 bg-white p-5 sm:p-6 flex flex-col justify-between text-slate-900 font-sans">
                        <div>
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Pratinjau Nyata (Live Output)</span>
                                </span>
                                <span class="text-[10px] px-2 py-0.5 rounded bg-blue-100 text-blue-700 font-bold">Responsive</span>
                            </div>

                            <!-- Komponen Hasil Render -->
                            <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200/80 shadow-sm space-y-3 text-left">
                                <div class="inline-block px-2.5 py-0.5 rounded-full bg-blue-600 text-white text-[10px] font-bold">
                                    Demo Interaktif
                                </div>
                                <h4 class="font-black text-sm text-slate-900 leading-tight">
                                    Selamat Datang di Laboratorium Koding VxAI!
                                </h4>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Setiap baris kode yang kamu ketik di editor sebelah kiri langsung diterjemahkan seketika tanpa perlu memuat ulang halaman.
                                </p>
                                <div class="pt-1">
                                    <a href="{{ route('public.playground') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-bold shadow-md hover:bg-blue-700 transition">
                                        <span>⚡ Coba Langsung di Playground</span> ➔
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>⏱️ Latensi Render: <strong>0 ms</strong></span>
                            <span class="text-emerald-600 font-bold">✓ 100% Sandbox Aman</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Bar Berbasis Bukti & Angka Nyata -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mt-8">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center hover:shadow-md transition">
                    <div class="text-2xl font-black text-blue-600">150+</div>
                    <div class="text-xs font-semibold text-slate-600 mt-0.5">Siswa & Pembelajar</div>
                    <div class="text-[10px] text-slate-400">SMKN 1 Kupang Barat & Umum</div>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center hover:shadow-md transition">
                    <div class="text-2xl font-black text-blue-600">10 Level</div>
                    <div class="text-xs font-semibold text-slate-600 mt-0.5">Tantangan Koding</div>
                    <div class="text-[10px] text-slate-400">HTML, CSS hingga JS DOM</div>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center hover:shadow-md transition">
                    <div class="text-2xl font-black text-blue-600">{{ $totalArticles > 0 ? $totalArticles : '30+' }} Modul</div>
                    <div class="text-xs font-semibold text-slate-600 mt-0.5">Artikel & Riset Terkini</div>
                    <div class="text-[10px] text-slate-400">Kaya Kode & Standar 2026</div>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-center hover:shadow-md transition">
                    <div class="text-2xl font-black text-blue-600">100% Bebas</div>
                    <div class="text-xs font-semibold text-slate-600 mt-0.5">Akses Terbuka Edukasi</div>
                    <div class="text-[10px] text-slate-400">Tanpa Biaya & Tanpa Instalasi</div>
                </div>
            </div>

        </section>

        <!-- ======================================================== -->
        <!-- SECTION 2: 4 Pilar Utama Teknologi & Kecerdasan Artifisial Modern -->
        <!-- ======================================================== -->
        <section class="bg-gradient-to-b from-blue-900 via-slate-900 to-blue-950 text-white py-16 sm:py-24 border-y border-blue-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Header Section 4 Pilar -->
                <div class="text-center max-w-3xl mx-auto mb-14">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-sky-300 text-xs font-bold mb-4">
                        <span>🚀 Roadmap & Ekosistem Pembelajaran</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        4 Pilar Utama Teknologi, Koding & Kecerdasan Artifisial
                    </h2>
                    <p class="text-sm sm:text-base text-slate-300 mt-4 leading-relaxed">
                        Dirancang untuk mempercepat penguasaan teknologi Anda melalui perpaduan teori terstruktur, simulasi langsung di browser, dan wawasan perkembangan industri terkini.
                    </p>
                </div>

                <!-- 4 Bento Cards Pilar Teknologi dengan Status Badge Transparan -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Card 1: AI & Deep Learning -->
                    <div class="bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-700/80 hover:border-sky-400/60 transition-all duration-300 hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-slate-900">
                                <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=800&q=80" 
                                     alt="Kecerdasan Artifisial & AI Generatif" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-3 left-3 bg-emerald-950/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-emerald-300 border border-emerald-700/60 flex items-center gap-1 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>🟢 Lab Asisten AI Aktif</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-base text-white mb-2 group-hover:text-sky-300 transition">Kecerdasan Artifisial & AI Generatif</h3>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    Memahami prinsip Large Language Models (LLM), prompt engineering, dan asisten koding interaktif langsung di browser.
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('public.playground') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-700/60 hover:bg-sky-600 text-[11px] font-bold text-sky-300 hover:text-white transition flex items-center justify-between border border-slate-600/50">
                                <span>Coba Asisten di Playground</span>
                                <span>➔</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Web & Full-Stack Engineering -->
                    <div class="bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-700/80 hover:border-emerald-400/60 transition-all duration-300 hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-slate-900">
                                <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=800&q=80" 
                                     alt="Pemrograman Web & Clean Code" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-3 left-3 bg-emerald-950/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-emerald-300 border border-emerald-700/60 flex items-center gap-1 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>🟢 Live Code Lab Aktif</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-base text-white mb-2 group-hover:text-emerald-300 transition">Rekayasa Web & Clean Code</h3>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    Fondasi kokoh struktur HTML5 semantik, CSS Flexbox/Grid, serta JavaScript DOM interaktif dengan 10 level latihan terstruktur.
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('public.learning') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-700/60 hover:bg-emerald-600 text-[11px] font-bold text-emerald-300 hover:text-white transition flex items-center justify-between border border-slate-600/50">
                                <span>Buka Modul HTML, CSS & JS</span>
                                <span>➔</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Cloud & Cyber Security -->
                    <div class="bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-700/80 hover:border-blue-400/60 transition-all duration-300 hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-slate-900">
                                <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80" 
                                     alt="Cloud Infrastructure & Cyber Security" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-3 left-3 bg-amber-950/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-amber-300 border border-amber-700/60 flex items-center gap-1 shadow-sm">
                                    <span>🟡 Modul Teori Tersedia</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-base text-white mb-2 group-hover:text-blue-300 transition">Infrastruktur Cloud & Keamanan Siber</h3>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    Menyelami arsitektur Zero Trust, enkripsi data pasca-kuantum, komputasi awan, dan proteksi dari kerentanan siber.
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('public.news.detail', 'arsitektur-zero-trust-kriptografi-pasca-kuantum-pqc') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-700/60 hover:bg-blue-600 text-[11px] font-bold text-blue-300 hover:text-white transition flex items-center justify-between border border-slate-600/50">
                                <span>Baca Panduan Zero Trust</span>
                                <span>➔</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 4: Mobile & Hardware Innovation -->
                    <div class="bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-700/80 hover:border-indigo-400/60 transition-all duration-300 hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-slate-900">
                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80" 
                                     alt="Ekosistem Mobile & Komputasi Cerdas" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-3 left-3 bg-amber-950/90 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-bold text-amber-300 border border-amber-700/60 flex items-center gap-1 shadow-sm">
                                    <span>🟡 Modul Teori Tersedia</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-base text-white mb-2 group-hover:text-indigo-300 transition">Ekosistem Mobile & Komputasi Cerdas</h3>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    Pengembangan aplikasi Android modern, arsitektur multi-modul, Baseline Profiles AOT, dan revolusi komputasi kuantum hardware.
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('public.news.detail', 'navigasi-declarative-arsitektur-multi-modul-android-2026') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-700/60 hover:bg-indigo-600 text-[11px] font-bold text-indigo-300 hover:text-white transition flex items-center justify-between border border-slate-600/50">
                                <span>Baca Panduan Android</span>
                                <span>➔</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- ======================================================== -->
        <!-- SECTION: SHOWCASE EKOSISTEM TERPADU VxAI (PRODUK KAMI)   -->
        <!-- ======================================================== -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 border-b border-slate-200/80">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold mb-3 shadow-sm">
                    <span>⚡ Ekosistem Pendidikan Vokasi Terpadu</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Dua Inovasi Teknologi Karya Anak Bangsa untuk Negeri
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                    Menghubungkan ruang praktik koding siswa dengan otomatisasi administrasi guru kejuruan dalam satu payung ekosistem digital terintegrasi.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Produk 1: VxAI Coding Lab (vxai.online) -->
                <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-10 border border-slate-800 shadow-xl flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-blue-600/20 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full bg-blue-600 text-white font-mono text-xs font-bold shadow">
                                vxai.online
                            </span>
                            <span class="text-xs text-sky-300 font-semibold flex items-center gap-1">
                                <span>🎒</span> <span>Platform Siswa & Publik</span>
                            </span>
                        </div>

                        <h3 class="text-2xl font-black text-white group-hover:text-sky-300 transition">
                            VxAI Coding Lab & Sandbox
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Laboratorium koding mandiri langsung di browser tanpa perlu instalasi perangkat lunak. Dirancang khusus bagi siswa SMK dan pemula untuk menguasai HTML5, CSS3, JavaScript interaktif, dan eksplorasi asisten AI.
                        </p>

                        <div class="space-y-2 pt-2 text-xs text-slate-300">
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>10 Level Tantangan Koding dari Dasar hingga Proyek Game</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Live Code Compiler 0 ms dengan Sandbox Keamanan Tinggi</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Sertifikat Digital Resmi Kelulusan 10 Level Terverifikasi</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 mt-6 border-t border-slate-800 flex items-center justify-between flex-wrap gap-3 relative z-10">
                        <a href="{{ route('public.playground') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                            <span>⚡ Buka Live Playground</span> ➔
                        </a>
                        <a href="{{ route('public.learning') }}" class="text-xs font-bold text-sky-300 hover:text-white transition">
                            Lihat Kurikulum Web
                        </a>
                    </div>
                </div>

                <!-- Produk 2: guru.vxai.online -->
                <div class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white rounded-3xl p-8 sm:p-10 border border-slate-800 shadow-xl flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-indigo-600/20 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full bg-indigo-600 text-white font-mono text-xs font-bold shadow">
                                guru.vxai.online
                            </span>
                            <span class="text-xs text-indigo-300 font-semibold flex items-center gap-1">
                                <span>👨‍🏫</span> <span>Platform Pendidik Vokasi</span>
                            </span>
                        </div>

                        <h3 class="text-2xl font-black text-white group-hover:text-indigo-300 transition">
                            Sistem Perangkat Ajar SMK 2026
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Inovasi perangkat ajar otomatis berbasis <em>Pure Expert System</em> dan <em>Deep Learning 3M</em> karya Vicky Koroh. Membantu guru SMK menyusun dokumen ajar resmi Kurikulum Merdeka dalam hitungan menit.
                        </p>

                        <div class="space-y-2 pt-2 text-xs text-slate-300">
                            <div class="flex items-center gap-2">
                                <span class="text-indigo-400 font-bold">✓</span>
                                <span>Kepatuhan Penuh Regulasi BSKAP 046/2025 & Permendikdasmen 13/2025</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-indigo-400 font-bold">✓</span>
                                <span>Generator Smart Soal & Kisi-Kisi Resmi Matriks 8 Kolom Standar</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-indigo-400 font-bold">✓</span>
                                <span>Ekspor Dokumen Siap Cetak Word (.docx) & PDF Lengkap Kop Sekolah</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 mt-6 border-t border-slate-800 flex items-center justify-between flex-wrap gap-3 relative z-10">
                        <a href="https://guru.vxai.online" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                            <span>🌐 Kunjungi guru.vxai.online</span> <span>↗</span>
                        </a>
                        <a href="https://guru.vxai.online/generator" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-indigo-300 hover:text-white transition">
                            Coba Generator Gratis 2x
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- ======================================================== -->
        <!-- SECTION: Warta & Tips Teknologi Terkini (Coding, AI, Komputer, Android) -->
        <!-- ======================================================== -->
        <!-- ======================================================== -->
        <!-- SECTION: Warta, Berita & Wawasan Teknologi Terkini -->
        <!-- ======================================================== -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 border-b border-slate-200/80">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-extrabold uppercase tracking-wider mb-3 shadow-sm">
                        <span>📰</span>
                        <span>Warta Edukasi & Berita Teknologi</span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Wawasan Koding, Tips AI & Inovasi Digital
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
                        Kumpulan ulasan teknologi mendalam, panduan praktis pemrograman, dan tips hardware dari para praktisi untuk mempercepat perjalanan belajar Anda.
                    </p>
                </div>

                <a href="{{ route('public.news') }}" class="text-xs font-bold text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 px-5 py-3 rounded-2xl border border-blue-200 hover:border-blue-600 shadow-sm transition-all duration-200 flex items-center gap-2 shrink-0 group">
                    <span>Lihat Semua Artikel (20+ Topik)</span>
                    <span class="group-hover:translate-x-1 transition">➔</span>
                </a>
            </div>

            <!-- Category Filter Pills Bar -->
            <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-10 no-scrollbar text-xs">
                <a href="{{ route('public.news') }}" class="px-4 py-2 rounded-xl font-bold bg-slate-900 text-white shadow-sm hover:bg-blue-600 transition shrink-0">
                    Semua Warta
                </a>
                <a href="{{ route('public.news', ['kategori' => 'web']) }}" class="px-4 py-2 rounded-xl font-semibold bg-white hover:bg-blue-50 text-slate-700 hover:text-blue-600 border border-slate-200 transition shrink-0 flex items-center gap-1.5">
                    <span>💻</span> <span>Coding & Web</span>
                </a>
                <a href="{{ route('public.news', ['kategori' => 'ai']) }}" class="px-4 py-2 rounded-xl font-semibold bg-white hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 border border-slate-200 transition shrink-0 flex items-center gap-1.5">
                    <span>🤖</span> <span>AI & Deep Learning</span>
                </a>
                <a href="{{ route('public.news', ['kategori' => 'komputer']) }}" class="px-4 py-2 rounded-xl font-semibold bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-600 border border-slate-200 transition shrink-0 flex items-center gap-1.5">
                    <span>🖥️</span> <span>Komputer & Hardware</span>
                </a>
                <a href="{{ route('public.news', ['kategori' => 'android']) }}" class="px-4 py-2 rounded-xl font-semibold bg-white hover:bg-teal-50 text-slate-700 hover:text-teal-600 border border-slate-200 transition shrink-0 flex items-center gap-1.5">
                    <span>📱</span> <span>Android & Mobile</span>
                </a>
                <a href="{{ route('public.news', ['kategori' => 'teknologi']) }}" class="px-4 py-2 rounded-xl font-semibold bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-600 border border-slate-200 transition shrink-0 flex items-center gap-1.5">
                    <span>🌐</span> <span>Cloud & Keamanan</span>
                </a>
            </div>

            @if(isset($latestArticles) && $latestArticles->count() > 0)
                @php
                    $featuredArticle = $latestArticles->first();
                    $gridArticles = $latestArticles->slice(1);
                @endphp

                <!-- 1. SPOTLIGHT HERO ARTICLE CARD (ARTIKEL PILIHAN UTAMA) -->
                @if($featuredArticle)
                    <div class="mb-12">
                        <article class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden group flex flex-col lg:flex-row">
                            <!-- Image Left -->
                            <div class="lg:w-1/2 relative min-h-[260px] sm:min-h-[340px] overflow-hidden bg-slate-900">
                                <img src="{{ $featuredArticle->safe_thumbnail }}" alt="{{ $featuredArticle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent lg:hidden"></div>
                                <div class="absolute top-4 left-4 flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-blue-600 text-white shadow-md flex items-center gap-1">
                                        <span>🔥</span> <span>Artikel Pilihan</span>
                                    </span>
                                    <span class="px-3 py-1 rounded-xl text-xs font-bold border backdrop-blur-md bg-white/95 text-slate-800 shadow-sm {{ $featuredArticle->category_badge_classes }}">
                                        {{ $featuredArticle->category_icon }} {{ $featuredArticle->category_label }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content Right -->
                            <div class="lg:w-1/2 p-6 sm:p-10 flex flex-col justify-between space-y-6">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                                        <span>{{ $featuredArticle->formatted_full_date }}</span>
                                        <span>•</span>
                                        <span>⏱️ {{ $featuredArticle->reading_time }}</span>
                                    </div>

                                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 group-hover:text-blue-600 transition leading-snug tracking-tight">
                                        <a href="{{ route('public.news.detail', $featuredArticle->slug) }}">
                                            {{ $featuredArticle->title }}
                                        </a>
                                    </h3>

                                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed line-clamp-3">
                                        {{ $featuredArticle->summary ?? strip_tags($featuredArticle->content) }}
                                    </p>
                                </div>

                                <div class="pt-6 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-black text-sm shadow">
                                            {{ substr($featuredArticle->author_name ?? 'V', 0, 1) }}
                                        </div>
                                        <div>
                                            <a href="{{ $featuredArticle->author_url }}" class="font-bold text-xs text-slate-900 hover:text-blue-600 transition block">
                                                {{ $featuredArticle->author_name }}
                                            </a>
                                            <div class="text-[11px] text-slate-400">Pendidik Vokasi Terverifikasi (E-E-A-T)</div>
                                        </div>
                                    </div>

                                    <a href="{{ route('public.news.detail', $featuredArticle->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-500/20 transition active:scale-95">
                                        <span>Baca Ulasan Lengkap</span>
                                        <span>➔</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endif

                <!-- 2. GRID ARTIKEL TERBARU LAINNYA -->
                @if($gridArticles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($gridArticles as $art)
                            <article class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden group">
                                <div>
                                    <div class="relative h-48 overflow-hidden bg-slate-100">
                                        <img src="{{ $art->safe_thumbnail }}" alt="{{ $art->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        <div class="absolute top-3 left-3">
                                            <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold border backdrop-blur-md bg-white/95 shadow-sm {{ $art->category_badge_classes }}">
                                                {{ $art->category_icon }} {{ $art->category_label }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center gap-2 text-[11px] text-slate-400 mb-2.5 font-medium">
                                            <span>{{ $art->formatted_date }}</span>
                                            <span>•</span>
                                            <span>⏱️ {{ $art->reading_time }}</span>
                                        </div>
                                        <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition leading-snug line-clamp-2">
                                            <a href="{{ route('public.news.detail', $art->slug) }}">
                                                {{ $art->title }}
                                            </a>
                                        </h3>
                                        <p class="text-xs text-slate-600 mt-2.5 leading-relaxed line-clamp-2">
                                            {{ $art->summary ?? strip_tags($art->content) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="px-6 pb-5 pt-2 flex items-center justify-between border-t border-slate-50">
                                    <a href="{{ $art->author_url }}" class="text-[11px] font-semibold text-slate-500 hover:text-blue-600 transition">
                                        ✍️ {{ $art->author_name }}
                                    </a>
                                    <a href="{{ route('public.news.detail', $art->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1 group-hover:translate-x-0.5">
                                        <span>Baca</span>
                                        <span>➔</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

            @endif
        </section>

        <!-- ======================================================== -->
        <!-- SECTION: TESTIMONI SISWA & GURU SMKN 1 KUPANG BARAT      -->
        <!-- ======================================================== -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 border-b border-slate-200/80">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold mb-3 shadow-sm">
                    <span>💬 Suara Nyata Pembelajar & Pendidik</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Bukti Nyata Dampak VxAI di Ruang Belajar Vokasi
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                    Pengalaman langsung siswa dan guru SMKN 1 Kupang Barat, Nusa Tenggara Timur dalam mengakselerasi literasi koding dan rekayasa perangkat lunak.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimoni 1 -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 text-sm mb-4">
                            ★★★★★
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                            "Dulu belajar koding terasa berat karena di rumah saya hanya punya smartphone dan laptop di lab sekolah sering dipakai bergantian. Dengan VxAI Coding Lab, saya bisa latihan HTML dan CSS langsung dari browser HP tanpa instalasi apapun. Fitur Live Playground menampilkan hasil seketika!"
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow">
                            MS
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Mario Da Silva</h4>
                            <p class="text-[11px] text-slate-400">Siswa Kelas XI RPL • SMKN 1 Kupang Barat</p>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 2 -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 text-sm mb-4">
                            ★★★★★
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                            "Tantangan 10 level kodingnya sangat seru seperti bermain game bertingkat! Mulai dari membuat kartu profil sederhana, formulir kontak, hingga kalkulator interaktif. Setiap selesai level, pemahaman logika JavaScript DOM saya berkembang pesat."
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow">
                            NL
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Novita Lodia Kase</h4>
                            <p class="text-[11px] text-slate-400">Siswi Kelas XII TKJ • SMKN 1 Kupang Barat</p>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 3 -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 text-sm mb-4">
                            ★★★★★
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                            "Integrasi antara vxai.online untuk praktikum koding siswa dan guru.vxai.online untuk otomatisasi perangkat ajar BSKAP 046/2025 adalah kombinasi luar biasa. Beban administrasi saya berkurang drastis, sehingga waktu saya fokus membimbing siswa di ruang praktik."
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shadow">
                            YN
                        </div>
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Yohanis B. Ndun, S.Pd</h4>
                            <p class="text-[11px] text-slate-400">Guru Produktif Kejuruan • SMKN 1 Kupang Barat</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- SECTION: MANFAAT MEMILIKI AKUN & GAMIFIKASI VXAI -->
        <!-- ======================================================== -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 border-b border-slate-200/80">
            <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-8 sm:p-12 text-white border border-slate-800 shadow-2xl relative overflow-hidden">
                <!-- Background Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -top-20 w-80 h-80 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="max-w-3xl mb-12">
                        <span class="px-3.5 py-1.5 rounded-full bg-blue-500/20 text-sky-300 text-xs font-bold border border-blue-400/30 inline-block mb-3">
                            🎮 Ekosistem Gamifikasi & Akun Pembelajar
                        </span>
                        <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                            Mengapa Anda Perlu Masuk & Memiliki Akun di VxAI?
                        </h2>
                        <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed">
                            Meskipun Anda bebas mencoba modul dan live editor tanpa login, memiliki akun siswa membuka fitur lengkap untuk memantau kemajuan, portofolio karya, dan bukti kompetensi resmi.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                        <!-- Card 1: Simpan Progres Cloud -->
                        <div class="bg-slate-800/70 backdrop-blur-md p-6 rounded-2xl border border-slate-700/80 hover:border-sky-400/60 transition group">
                            <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-sky-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                ☁️
                            </div>
                            <h3 class="font-bold text-base text-white mb-2 group-hover:text-sky-300 transition">Simpan Progres Cloud</h3>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Seluruh baris kode latihan dan level tantangan tersimpan otomatis di awan. Lanjutkan koding kapan saja dari ponsel maupun laptop sekolah.
                            </p>
                        </div>

                        <!-- Card 2: Sertifikat Resmi 10 Level -->
                        <div class="bg-slate-800/70 backdrop-blur-md p-6 rounded-2xl border border-slate-700/80 hover:border-emerald-400/60 transition group">
                            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                📜
                            </div>
                            <h3 class="font-bold text-base text-white mb-2 group-hover:text-emerald-300 transition">Sertifikat Kelulusan</h3>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Selesaikan 10 level tantangan dan cetak Sertifikat Kelulusan Digital resmi ber-ID unik yang siap dibagikan ke LinkedIn, WhatsApp, dan portofolio.
                            </p>
                            <a href="{{ route('public.certificate') }}" class="mt-3 inline-flex items-center gap-1 text-[11px] font-bold text-emerald-400 hover:text-emerald-300">
                                <span>Lihat Format Sertifikat</span> ➔
                            </a>
                        </div>

                        <!-- Card 3: Leaderboard & Poin XP -->
                        <div class="bg-slate-800/70 backdrop-blur-md p-6 rounded-2xl border border-slate-700/80 hover:border-amber-400/60 transition group">
                            <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                🏆
                            </div>
                            <h3 class="font-bold text-base text-white mb-2 group-hover:text-amber-300 transition">Poin XP & Peringkat</h3>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Dapatkan poin pengalaman (XP) setiap kali berhasil mengeksekusi tantangan tanpa error dan raih posisi teratas di Leaderboard kelas Anda.
                            </p>
                        </div>

                        <!-- Card 4: Umpan Balik Guru Terpadu -->
                        <div class="bg-slate-800/70 backdrop-blur-md p-6 rounded-2xl border border-slate-700/80 hover:border-purple-400/60 transition group">
                            <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                                👨‍🏫
                            </div>
                            <h3 class="font-bold text-base text-white mb-2 group-hover:text-purple-300 transition">Evaluasi Guru Pengampu</h3>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Tugas koding Anda langsung terhubung ke dashboard guru SMKN 1 Kupang Barat untuk dinilai dan diberi catatan perbaikan kode secara interaktif.
                            </p>
                        </div>
                    </div>

                    <!-- CTA Bar Login / Register -->
                    <div class="p-4 sm:p-6 rounded-2xl bg-blue-900/40 border border-blue-700/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                            <span class="text-xs sm:text-sm text-blue-200">
                                Sudah punya akun siswa atau pengajar? Masuk untuk melanjutkan tantangan Anda.
                            </span>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-lg shadow-blue-500/30 transition flex items-center gap-1.5">
                                <span>Masuk ke Akun Saya</span> ➔
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- SECTION: PUSAT PEMBELAJARAN CODING (INTERACTIVE LEARNING TRACK) -->
        <!-- ======================================================== -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 border-b border-slate-200/80">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-extrabold uppercase tracking-wider border border-blue-200 inline-block mb-3">
                    🎓 Kurikulum Terstruktur & Interaktif
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Pusat Pembelajaran Coding: Mulai dari Nol Sampai Mahir
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                    Dirancang dengan kurikulum berjenjang dan praktis. Kuasai fondasi HTML5, tata letak modern CSS3, serta interaktivitas JavaScript dengan editor kode langsung di browser Anda.
                </p>
            </div>

            <!-- Grid 4 Modul Pembelajaran Coding -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                <!-- Track 1: HTML5 Fondasi -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center font-black text-xl mb-4 group-hover:scale-110 transition shadow-sm">
                            1
                        </div>
                        <span class="text-[11px] font-extrabold text-orange-600 uppercase tracking-wider">Tingkat 1 • Struktur Web</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-1 mb-2 group-hover:text-orange-600 transition">HTML5 Semantik</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Mempelajari kerangka dokumen standar, elemen semantik (header, nav, main, article), formulir input, tabel data, dan media multimedia.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('public.learning') }}#modul-html" class="text-xs font-bold text-orange-600 hover:text-orange-800 transition flex items-center gap-1">
                            <span>Buka Modul</span> ➔
                        </a>
                        <a href="{{ route('public.playground') }}?challenge=html_struktur" class="text-[11px] font-semibold text-slate-500 hover:text-orange-600 transition">
                            ⚡ Uji Kode
                        </a>
                    </div>
                </div>

                <!-- Track 2: CSS3 Tata Letak & Desain -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xl mb-4 group-hover:scale-110 transition shadow-sm">
                            2
                        </div>
                        <span class="text-[11px] font-extrabold text-blue-600 uppercase tracking-wider">Tingkat 2 • Desain Visual</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-1 mb-2 group-hover:text-blue-600 transition">CSS3 Modern Layout</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Kuasai CSS Flexbox, Grid 2 Dimensi, warna gradien, tipografi responsif, Glassmorphism, dan transisi animasi halus di berbagai ukuran layar.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('public.learning') }}#modul-css" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                            <span>Buka Modul</span> ➔
                        </a>
                        <a href="{{ route('public.playground') }}?challenge=css_flexbox" class="text-[11px] font-semibold text-slate-500 hover:text-blue-600 transition">
                            ⚡ Uji Kode
                        </a>
                    </div>
                </div>

                <!-- Track 3: JavaScript Interaktif -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-black text-xl mb-4 group-hover:scale-110 transition shadow-sm">
                            3
                        </div>
                        <span class="text-[11px] font-extrabold text-amber-600 uppercase tracking-wider">Tingkat 3 • Logika & DOM</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-1 mb-2 group-hover:text-amber-600 transition">JavaScript Interaktif</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Membangun logika aplikasi web, manipulasi elemen HTML via DOM, event listener klik & ketik, validasi form, dan pengambilan data API asinkron.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('public.learning') }}#modul-js" class="text-xs font-bold text-amber-600 hover:text-amber-800 transition flex items-center gap-1">
                            <span>Buka Modul</span> ➔
                        </a>
                        <a href="{{ route('public.playground') }}?challenge=js_dom" class="text-[11px] font-semibold text-slate-500 hover:text-amber-600 transition">
                            ⚡ Uji Kode
                        </a>
                    </div>
                </div>

                <!-- Track 4: 10 Level Tantangan & Proyek -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-black text-xl mb-4 group-hover:scale-110 transition shadow-sm">
                            4
                        </div>
                        <span class="text-[11px] font-extrabold text-purple-600 uppercase tracking-wider">Tingkat 4 • Proyek Mandiri</span>
                        <h3 class="text-lg font-bold text-slate-900 mt-1 mb-2 group-hover:text-purple-600 transition">10 Level Tantangan</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Uji kemampuan koding dengan 10 level tantangan berjenjang: dari "Halo Dunia", Kartu Profil, Form Kontak, hingga Kalkulator Canggih & Mini Game.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('public.learning') }}#modul-proyek" class="text-xs font-bold text-purple-600 hover:text-purple-800 transition flex items-center gap-1">
                            <span>Buka Modul</span> ➔
                        </a>
                        <a href="{{ route('public.playground') }}" class="text-[11px] font-semibold text-slate-500 hover:text-purple-600 transition">
                            ⚡ Uji Kode
                        </a>
                    </div>
                </div>

            </div>

            <!-- Call to Action Banner Pembelajaran Coding -->
            <div class="bg-gradient-to-br from-blue-700 via-indigo-700 to-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-xl flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center lg:text-left">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-sky-300">Siap Mulai Belajar?</span>
                    <h3 class="text-2xl sm:text-3xl font-black">Mulai Perjalanan Koding Anda Hari Ini</h3>
                    <p class="text-xs sm:text-sm text-blue-100 max-w-xl">
                        Akses modul lengkap panduan pemrograman secara gratis tanpa registrasi yang rumit, atau langsung coba editor kode live interaktif.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto shrink-0">
                    <a href="{{ route('public.learning') }}" class="px-6 py-3.5 rounded-2xl bg-white text-blue-700 font-bold text-xs sm:text-sm hover:bg-blue-50 transition shadow-lg text-center flex items-center justify-center gap-2">
                        <span>🎓 Masuk ke Pembelajaran Coding</span>
                        <span>➔</span>
                    </a>
                    <a href="{{ route('public.playground') }}" class="px-6 py-3.5 rounded-2xl bg-blue-600/80 hover:bg-blue-600 border border-white/20 text-white font-bold text-xs sm:text-sm transition text-center flex items-center justify-center gap-2">
                        <span>⚡ Buka Live Playground</span>
                    </a>
                </div>
                </div>
            </div>

            <!-- Tautan Navigasi Cepat AdSense & Legalitas -->
            <div class="mt-14 pt-8 border-t border-slate-200/90 flex flex-wrap justify-center items-center gap-6 text-xs font-semibold text-slate-600">
                <a href="{{ route('about') }}" class="hover:text-blue-600 transition">Tentang Kami (About Us)</a>
                <span>•</span>
                <a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Hubungi Pengelola (Contact)</a>
                <span>•</span>
                <a href="{{ route('privacy') }}" class="hover:text-blue-600 transition">Kebijakan Privasi (Privacy Policy)</a>
                <span>•</span>
                <a href="{{ route('terms') }}" class="hover:text-blue-600 transition">Syarat & Ketentuan (Terms)</a>
                <span>•</span>
                <a href="{{ route('ads.txt') }}" target="_blank" class="hover:text-blue-600 transition">File ads.txt Resmi</a>
            </div>

        </section>

    </main>

    <!-- Banner AdSense di Halaman Utama (Hanya jika slot resmi telah dikonfigurasi) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']) && !empty($settings['adsense_slot_main']) && $settings['adsense_slot_main'] !== '1234567890')
        <div class="max-w-5xl mx-auto px-4 my-6 text-center">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="{{ $settings['adsense_slot_main'] }}"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    @endif

    <!-- Footer Lengkap Pendukung AdSense -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <!-- Kolom 1 -->
                <div>
                    <div class="flex items-center gap-2.5 text-white font-bold text-sm mb-3">
                        <span class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center font-black text-xs text-white">Vx</span>
                        <span>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                    </div>
                    <p class="text-slate-400 leading-relaxed text-xs">
                        Platform edukasi koding dan kecerdasan buatan interaktif. Membangun keahlian rekayasa perangkat lunak generasi masa depan untuk Indonesia dan dunia.
                    </p>
                    <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-800/60 text-blue-300 text-[11px] font-semibold">
                        <span>⚡</span>
                        <span>Inovasi Koding & AI Terbuka</span>
                    </div>
                </div>

                <!-- Kolom 2: Akses Belajar & Berita -->
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Akses & Warta</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('public.playground') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>⚡</span> Live Code Playground</a></li>
                        <li><a href="{{ route('public.learning') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>🎓</span> Pusat Pembelajaran Coding</a></li>
                        <li><a href="{{ route('public.certificate') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>📜</span> Sertifikat 10 Level</a></li>
                        <li><a href="{{ route('public.author') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>✍️</span> Profil Penulis & Tim Ahli</a></li>
                        <li><a href="{{ route('public.news') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>📰</span> Warta & Riset Terkini</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>🎒</span> Portal Siswa & Pengajar</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Halaman Wajib AdSense -->
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Kepatuhan & Legalitas</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('privacy') }}" class="hover:text-blue-400 transition">Kebijakan Privasi (Privacy Policy)</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-blue-400 transition">Syarat & Ketentuan Layanan</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition">Tentang Platform (About Us)</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-blue-400 transition">Hubungi Pengelola (Contact)</a></li>
                        <li><a href="{{ route('ads.txt') }}" target="_blank" class="hover:text-blue-400 transition">Verifikasi ads.txt</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Kontak & Komunitas -->
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Kontak & Lembaga</h4>
                    <p class="mb-2 leading-relaxed text-slate-400">Pertanyaan kurikulum koding, bimbingan siswa, atau kerjasama institusi sekolah:</p>
                    <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="text-blue-400 font-bold hover:underline break-all block mb-2">
                        {{ $settings['contact_email'] ?? 'admin@vxai.online' }}
                    </a>
                    <div class="space-y-2 pt-2 border-t border-slate-800">
                        <a href="https://wa.me/6282266383444?text=Halo%20Admin%20VxAI%20Coding%20Lab" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-950/80 text-emerald-400 border border-emerald-700/60 font-semibold hover:bg-emerald-600 hover:text-white transition text-xs">
                            <span>💬</span>
                            <span>WhatsApp: +62 822-6638-3444</span>
                        </a>
                        <p class="text-[11px] text-slate-500">📍 Afiliasi SMKN 1 Kupang Barat, NTT</p>
                    </div>
                </div>

            </div>

            <div class="border-t border-slate-800/80 pt-6 flex flex-col md:flex-row justify-between items-center text-slate-500 gap-2">
                <p>&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}. Hak Cipta Dilindungi Undang-Undang.</p>
                <p>Platform Edukasi Koding & Akses Terbuka Pembelajar Seluruh Indonesia.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Help Button -->
    <a href="https://wa.me/6282266383444?text=Halo%20Admin%20VxAI%20Coding%20Lab,%20saya%20ingin%20bertanya%20tentang%20pembelajaran%20koding" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-600 text-white p-3.5 rounded-full shadow-2xl flex items-center gap-2 group transition-all duration-300 hover:scale-105 hover:shadow-emerald-500/30"
       title="Hubungi Kami via WhatsApp">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.35.491 1.199.534 1.286.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.179.181-.077.356.101.173.45 1.054 1.144 1.672.894.796 1.649 1.042 1.88 1.157.231.116.368.101.505-.058.138-.159.592-.693.75-0.931.159-.239.318-.202.534-.116.217.087 1.372.647 1.609.762.237.116.396.173.454.275.058.101.058.592-.086.997z"/>
        </svg>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-500 ease-in-out text-xs font-bold pr-1">
            Konsultasi Belajar
        </span>
    </a>

</body>
</html>