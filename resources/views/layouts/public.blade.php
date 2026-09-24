<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($settings['app_name'] ?? 'VxAI Coding Lab') . ' - Platform Belajar Koding & AI')</title>
    <meta name="description" content="@yield('meta_description', 'Platform belajar koding, HTML, CSS, JavaScript gratis dan interaktif untuk talenta digital masa depan.')">
    
    <!-- Favicon -->
    @if(!empty($settings['app_favicon']))
        <link rel="icon" href="{{ asset($settings['app_favicon']) }}">
    @endif

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

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
            border-bottom: 1px solid rgba(219, 234, 254, 0.9);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Decorative Top Accent Bar -->
    <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500 fixed top-0 z-[60]"></div>

    <!-- Header / Navbar Publik -->
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
                        <span class="font-extrabold text-lg tracking-tight text-slate-900 group-hover:text-blue-600 transition block leading-tight">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                        <span class="text-[10px] text-blue-600 font-bold uppercase tracking-wider block">Modern Coding & AI Lab</span>
                    </div>
                </a>

                <!-- Navigasi Menu Tengah -->
                <div class="hidden lg:flex items-center space-x-7 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Beranda</a>
                    <a href="{{ route('public.playground') }}" class="{{ request()->is('playground*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition flex items-center gap-1.5">
                        <span class="text-blue-600">⚡</span>
                        <span>Live Playground</span>
                    </a>
                    <a href="{{ route('public.tutorials') }}" class="{{ request()->is('panduan*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition flex items-center gap-1.5">
                        <span>📖</span>
                        <span>Panduan Koding</span>
                    </a>
                    <a href="{{ route('public.news') }}" class="{{ request()->is('berita*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition flex items-center gap-1.5">
                        <span>📰</span>
                        <span>Berita & Tips</span>
                    </a>
                    <a href="{{ route('about') }}" class="{{ request()->is('about*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="{{ request()->is('contact*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Kontak</a>
                </div>

                <!-- Tombol Aksi Kanan (Login / Dashboard) -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->role_id == 1)
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-md shadow-blue-500/20">
                                Panel Admin 📊
                            </a>
                        @elseif(Auth::user()->role_id == 2)
                            <a href="{{ route('guru.dashboard') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-md shadow-emerald-500/20">
                                Dashboard Guru 👨‍🏫
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-md shadow-blue-500/20">
                                Ruang Belajar 🎒
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-md shadow-blue-600/20 hover:shadow-blue-600/30 hover:scale-[1.02] flex items-center gap-1.5">
                            <span>Masuk / Login</span>
                            <span>→</span>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <div class="flex-grow pt-20">
        @yield('content')
    </div>

    <!-- Banner AdSense di Footer (Jika Aktif) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <div class="max-w-5xl mx-auto px-4 my-6 text-center">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="1234567890"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    @endif

    <!-- Footer Publik (Wajib AdSense & Legalitas) -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-12 mt-16 border-t border-slate-800">
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
                        <li><a href="{{ route('public.tutorials') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>📖</span> Panduan HTML, CSS & JS</a></li>
                        <li><a href="{{ route('public.news') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>📰</span> Warta & Tips Teknologi</a></li>
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

                <!-- Kolom 4: Kontak -->
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Kontak Resmi</h4>
                    <p class="mb-2 leading-relaxed">Pertanyaan kurikulum, kerjasama institusi sekolah, atau kemitraan periklanan:</p>
                    <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="text-blue-400 font-bold hover:underline break-all">
                        {{ $settings['contact_email'] ?? 'admin@vxai.online' }}
                    </a>
                </div>

            </div>

            <div class="border-t border-slate-800/80 pt-6 flex flex-col md:flex-row justify-between items-center text-slate-500 gap-2">
                <p>&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}. Hak Cipta Dilindungi Undang-Undang.</p>
                <p>Platform Edukasi Koding & Akses Terbuka Pembelajar Seluruh Indonesia.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
