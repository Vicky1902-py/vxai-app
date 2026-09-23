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
        .bg-argentina {
            background: repeating-linear-gradient(
                90deg,
                #FFFFFF,
                #FFFFFF 80px,
                #74ACDF 80px,
                #74ACDF 160px
            );
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.8);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.7);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-argentina text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar Publik -->
    <nav class="glass-nav fixed top-0 w-full z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    @if(!empty($settings['app_logo']))
                        <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="h-9 w-auto">
                    @else
                        <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-lg shadow">Vx</div>
                    @endif
                    <span class="font-extrabold text-xl tracking-tight text-gray-900">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                </a>

                <!-- Navigasi Menu Tengah -->
                <div class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-gray-700">
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Beranda</a>
                    <a href="{{ route('public.playground') }}" class="{{ request()->is('playground*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition flex items-center gap-1">
                        <span>⚡ Live Playground</span>
                    </a>
                    <a href="{{ route('public.tutorials') }}" class="{{ request()->is('panduan*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">📖 Panduan Koding</a>
                    <a href="{{ route('about') }}" class="{{ request()->is('about*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="{{ request()->is('contact*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Kontak</a>
                </div>

                <!-- Tombol Aksi Kanan (Login / Dashboard) -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->role_id == 1)
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-5 py-2 rounded-full transition shadow">
                                Panel Admin 📊
                            </a>
                        @elseif(Auth::user()->role_id == 2)
                            <a href="{{ route('guru.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold px-5 py-2 rounded-full transition shadow">
                                Dashboard Guru 👨‍🏫
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-5 py-2 rounded-full transition shadow">
                                Ruang Belajar 🎒
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-6 py-2.5 rounded-full transition shadow hover:scale-105">
                            Masuk / Login
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

    <!-- Footer Publik (Wajib AdSense) -->
    <footer class="bg-gray-900 text-gray-400 text-xs py-10 mt-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <!-- Kolom 1 -->
                <div>
                    <div class="flex items-center gap-2 text-white font-bold text-sm mb-3">
                        <span class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center font-bold">Vx</span>
                        <span>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Platform edukasi koding dan kecerdasan buatan interaktif. Membangun keahlian teknologi praktis untuk generasi masa depan.
                    </p>
                </div>

                <!-- Kolom 2: Akses Belajar -->
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Akses Pembelajaran</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('public.playground') }}" class="hover:text-white transition">⚡ Live Code Editor</a></li>
                        <li><a href="{{ route('public.tutorials') }}" class="hover:text-white transition">📖 Panduan HTML, CSS & JS</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">🎒 Portal Siswa & Guru</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Halaman Wajib AdSense -->
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Kepatuhan & Legalitas</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Kebijakan Privasi (Privacy Policy)</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition">Syarat & Ketentuan Layanan</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang Platform (About Us)</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">Hubungi Pengelola (Contact)</a></li>
                        <li><a href="{{ route('ads.txt') }}" target="_blank" class="hover:text-white transition">Verifikasi ads.txt</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Kontak -->
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Kontak Resmi</h4>
                    <p class="mb-2">Pertanyaan kurikulum, kerjasama institusi, atau periklanan:</p>
                    <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="text-blue-400 font-bold hover:underline">
                        {{ $settings['contact_email'] ?? 'admin@vxai.online' }}
                    </a>
                </div>

            </div>

            <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center text-gray-500">
                <p>&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="mt-2 md:mt-0">Dirancang untuk SMKN 1 Kupang Barat & Akses Terbuka Seluruh Indonesia.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
