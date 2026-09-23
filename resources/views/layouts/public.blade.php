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

    <!-- Google AdSense Script (Otomatis Aktif jika Dikonfigurasi di Admin) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}"
             crossorigin="anonymous"></script>
    @endif

    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.8);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar Publik -->
    <nav class="glass-nav fixed top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        @if(!empty($settings['app_logo']))
                            <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="h-9 w-auto">
                        @else
                            <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center font-extrabold text-lg shadow">Vx</div>
                        @endif
                        <span class="font-extrabold text-xl tracking-tight text-gray-900">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                    </a>
                </div>

                <!-- Navigasi Menu Tengah -->
                <div class="hidden md:flex items-center space-x-6 text-sm font-semibold text-gray-600">
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'text-blue-600' : 'hover:text-blue-600' }} transition">Beranda</a>
                    <a href="{{ route('public.playground') }}" class="{{ request()->is('playground*') ? 'text-blue-600' : 'hover:text-blue-600' }} transition flex items-center gap-1">
                        <span>⚡ Live Playground</span>
                    </a>
                    <a href="{{ route('public.tutorials') }}" class="{{ request()->is('panduan*') ? 'text-blue-600' : 'hover:text-blue-600' }} transition">Panduan Koding</a>
                    <a href="{{ route('about') }}" class="{{ request()->is('about*') ? 'text-blue-600' : 'hover:text-blue-600' }} transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="{{ request()->is('contact*') ? 'text-blue-600' : 'hover:text-blue-600' }} transition">Kontak</a>
                </div>

                <!-- Tombol Aksi Kanan (Login / Dashboard) -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->role_id == 1)
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow">
                                Panel Admin 📊
                            </a>
                        @elseif(Auth::user()->role_id == 2)
                            <a href="{{ route('guru.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow">
                                Dashboard Guru 👨‍🏫
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow">
                                Ruang Belajar 🎒
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600 px-3 py-2 transition">
                            Masuk
                        </a>
                        <a href="{{ route('public.playground') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow">
                            Coba Koding Sekarang
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <div class="flex-grow pt-16">
        @yield('content')
    </div>

    <!-- Banner AdSense di Footer (Jika Aktif) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true')
        <div class="max-w-7xl mx-auto px-4 py-4 my-6 text-center bg-gray-100 border border-gray-200 rounded-xl overflow-hidden">
            <span class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold block mb-2">Advertisements</span>
            <!-- Slot Iklan Responsive -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] ?? '' }}"
                 data-ad-slot="1234567890"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    @endif

    <!-- Footer Publik (Wajib AdSense) -->
    <footer class="bg-gray-900 text-gray-400 text-sm mt-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <!-- Kolom 1: Brand Info -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2 text-white font-bold text-lg">
                        <span class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold">Vx</span>
                        <span>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        Platform edukasi koding dan teknologi modern interaktif yang dapat diakses langsung melalui peramban web dari perangkat apa pun.
                    </p>
                </div>

                <!-- Kolom 2: Fitur Utama -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Fitur Edukasi</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('public.playground') }}" class="hover:text-white transition">Live Code Playground</a></li>
                        <li><a href="{{ route('public.tutorials') }}" class="hover:text-white transition">Tutorial HTML & CSS</a></li>
                        <li><a href="{{ route('public.tutorials') }}" class="hover:text-white transition">Panduan JavaScript</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Akses Siswa & Guru</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Legalitas AdSense (Wajib) -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Kebijakan & Legalitas</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('privacy') }}" class="hover:text-white transition">Kebijakan Privasi (Privacy Policy)</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition">Syarat & Ketentuan (Terms of Service)</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang Kami (About Us)</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">Hubungi Kami (Contact)</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Hubungi -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Kontak Pengelola</h4>
                    <p class="text-xs text-gray-400 mb-2">Punya pertanyaan, kritik, atau saran pengembangan kurikulum?</p>
                    <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="text-blue-400 text-xs font-semibold hover:underline">
                        {{ $settings['contact_email'] ?? 'admin@vxai.online' }}
                    </a>
                </div>

            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="mt-2 md:mt-0">Didesain untuk Pembelajaran Digital Berkelanjutan.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
