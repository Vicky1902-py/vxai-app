<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }} - Platform Belajar Koding & AI</title>
    <meta name="description" content="Platform pembelajaran interaktif untuk koding HTML, CSS, JavaScript dan Kecerdasan Artifisial langsung dari peramban browser.">

    <!-- Favicon -->
    @if(!empty($settings['app_favicon']))
        <link rel="icon" href="{{ asset($settings['app_favicon']) }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google AdSense Script (Otomatis Aktif jika Dikonfigurasi di Admin) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}"
             crossorigin="anonymous"></script>
    @endif

    <style>
        /* Motif Garis Ikonik Argentina (#74ACDF dan #FFFFFF) */
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
        .glass-effect {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body class="bg-argentina min-h-screen flex flex-col font-sans antialiased">
    
    <!-- Navbar Utama -->
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

                <!-- Navigasi Menu Lengkap Publik -->
                <div class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-gray-700">
                    <a href="{{ route('home') }}" class="text-blue-600 font-bold transition">Beranda</a>
                    <a href="{{ route('public.playground') }}" class="hover:text-blue-600 transition flex items-center gap-1">
                        <span>⚡ Live Playground</span>
                    </a>
                    <a href="{{ route('public.tutorials') }}" class="hover:text-blue-600 transition">📖 Panduan Koding</a>
                    <a href="{{ route('about') }}" class="hover:text-blue-600 transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Kontak</a>
                </div>

                <!-- Tombol Masuk / Dashboard -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->role_id == 1)
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-bold text-sm transition-all shadow-md">
                                Panel Admin 📊
                            </a>
                        @elseif(Auth::user()->role_id == 2)
                            <a href="{{ route('guru.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full font-bold text-sm transition-all shadow-md">
                                Dashboard Guru 👨‍🏫
                            </a>
                        @else
                            <a href="{{ route('siswa.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-bold text-sm transition-all shadow-md">
                                Ruang Belajar 🎒
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full font-bold text-sm transition-all shadow-md hover:scale-105">
                            Masuk / Login
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <!-- Konten Utama (Hero & Akses Terpadu) -->
    <main class="flex-grow flex items-center justify-center pt-24 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="glass-effect rounded-3xl shadow-2xl p-6 sm:p-10 md:p-16 max-w-5xl w-full text-center my-6">
            
            <!-- Badge Status -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold mb-6">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span>
                <span>Terbuka Bebas untuk Publik & Pelajar</span>
            </div>

            <!-- Judul Utama -->
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-gray-900 mb-6 leading-tight tracking-tight">
                Kuasai <span class="text-blue-600">Koding dan Kecerdasan Artifisial</span> Langsung dari Browser
            </h1>

            <!-- Deskripsi -->
            <p class="text-base sm:text-lg md:text-xl text-gray-700 mb-8 max-w-3xl mx-auto leading-relaxed">
                Platform pembelajaran interaktif yang dirancang khusus untuk mencetak talenta digital hebat di SMKN 1 Kupang Barat dan siapa saja yang ingin belajar. Ketik kode HTML, CSS, JS, lihat hasil *real-time*, dan pecahkan tantangan bersama AI Tutor.
            </p>
            
            <!-- Tombol Navigasi Utama -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-14">
                <a href="{{ route('public.playground') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-bold text-base shadow-xl shadow-blue-500/25 transition-transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    <span>⚡ Mulai Koding Sekarang (Playground)</span>
                </a>
                <a href="{{ route('public.tutorials') }}" class="bg-white hover:bg-gray-50 text-blue-600 border-2 border-blue-600 px-8 py-4 rounded-2xl font-bold text-base shadow transition-transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    <span>📖 Buka Panduan & Kurikulum</span>
                </a>
            </div>

            <!-- Kartu Akses Fitur Utama -->
            <div id="fitur" class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                
                <!-- Kartu 1: Live Code Editor -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="text-3xl mb-4">⚡</div>
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Live Code Editor</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                            HTML, CSS, dan JavaScript dieksekusi langsung secara interaktif. Tanpa perlu instalasi compiler tambahan.
                        </p>
                    </div>
                    <a href="{{ route('public.playground') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        Buka Live Playground ➔
                    </a>
                </div>

                <!-- Kartu 2: Panduan Koding & Kurikulum -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="text-3xl mb-4">💡</div>
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Panduan Koding</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                            Kamus sintaksis lengkap dari dasar HTML5, tata letak CSS3 Flexbox, hingga manipulasi DOM JavaScript.
                        </p>
                    </div>
                    <a href="{{ route('public.tutorials') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        Baca Panduan Lengkap ➔
                    </a>
                </div>

                <!-- Kartu 3: Sistem Gamifikasi Siswa -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="text-3xl mb-4">🏆</div>
                        <h3 class="font-bold text-xl mb-2 text-gray-800">Sistem Gamifikasi</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                            Kumpulkan XP, raih lencana (Badge), dan naikkan levelmu di setiap tantangan yang berhasil diselesaikan dan dinilai guru.
                        </p>
                    </div>
                    @auth
                        <a href="{{ route('siswa.dashboard') }}" class="text-xs font-bold text-green-600 hover:text-green-800 flex items-center gap-1">
                            Buka Ruang Belajar ➔
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            Masuk Akun Siswa ➔
                        </a>
                    @endauth
                </div>

            </div>

            <!-- Navigasi Cepat Halaman Pendukung (Tentang, Kontak, Legal) -->
            <div class="mt-12 pt-8 border-t border-gray-200/80 flex flex-wrap justify-center items-center gap-6 text-xs font-semibold text-gray-600">
                <a href="{{ route('about') }}" class="hover:text-blue-600 transition">Tentang Kami (About Us)</a>
                <span>•</span>
                <a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Hubungi Kami (Contact)</a>
                <span>•</span>
                <a href="{{ route('privacy') }}" class="hover:text-blue-600 transition">Kebijakan Privasi (Privacy Policy)</a>
                <span>•</span>
                <a href="{{ route('terms') }}" class="hover:text-blue-600 transition">Syarat & Ketentuan (Terms)</a>
                <span>•</span>
                <a href="{{ route('ads.txt') }}" target="_blank" class="hover:text-blue-600 transition">File ads.txt</a>
            </div>

        </div>
    </main>

    <!-- Banner AdSense di Halaman Utama (Jika Aktif) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <div class="max-w-4xl mx-auto px-4 my-4 text-center">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="1234567890"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    @endif

    <!-- Footer Lengkap Pendukung AdSense -->
    <footer class="bg-gray-900 text-gray-400 text-xs py-10 mt-auto border-t border-gray-800">
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

</body>
</html>