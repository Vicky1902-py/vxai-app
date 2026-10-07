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

    <!-- URL Kanonikal SEO -->
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <!-- Open Graph Protocol (WhatsApp, Facebook, LinkedIn, Telegram) -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', ($settings['app_name'] ?? 'VxAI Coding Lab') . ' - Platform Belajar Koding & AI')">
    <meta property="og:description" content="@yield('meta_description', 'Platform belajar koding, HTML, CSS, JavaScript gratis dan interaktif untuk talenta digital masa depan.')">
    @php
        $defaultOgImage = !empty($settings['app_logo']) ? asset($settings['app_logo']) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80';
    @endphp
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">
    <meta property="og:image:secure_url" content="@yield('og_image', $defaultOgImage)">
    <meta property="og:image:type" content="@yield('og_image_type', 'image/jpeg')">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta property="og:image:alt" content="@yield('og_title', $settings['app_name'] ?? 'VxAI')">
    <link rel="image_src" href="@yield('og_image', $defaultOgImage)">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:url" content="@yield('canonical_url', url()->current())">
    <meta name="twitter:title" content="@yield('og_title', ($settings['app_name'] ?? 'VxAI Coding Lab') . ' - Platform Belajar Koding & AI')">
    <meta name="twitter:description" content="@yield('meta_description', 'Platform belajar koding, HTML, CSS, JavaScript gratis dan interaktif untuk talenta digital masa depan.')">
    <meta name="twitter:image" content="@yield('og_image', $defaultOgImage)">

    @yield('extra_meta')

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
                <div class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Beranda</a>
                    
                    <!-- Menu Utama: Pembelajaran Coding -->
                    <a href="{{ route('public.learning') }}" class="{{ request()->is('belajar*') || request()->is('panduan*') ? 'text-blue-600 font-bold bg-blue-50/80 border-blue-200' : 'hover:text-blue-600 hover:bg-slate-50 border-transparent' }} px-3 py-1.5 rounded-xl border transition flex items-center gap-1.5 group">
                        <span class="text-base group-hover:scale-110 transition">🎓</span>
                        <span>Pembelajaran Coding</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-extrabold bg-blue-600 text-white rounded-full">Baru</span>
                    </a>

                    <a href="{{ route('public.playground') }}" class="{{ request()->is('playground*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition flex items-center gap-1.5">
                        <span class="text-blue-600">⚡</span>
                        <span>Live Playground</span>
                    </a>
                    
                    <a href="{{ route('public.news') }}" class="{{ request()->is('berita*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition flex items-center gap-1.5">
                        <span>📰</span>
                        <span>Berita & Tips</span>
                    </a>
                    
                    <a href="{{ route('about') }}" class="{{ request()->is('about*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="{{ request()->is('contact*') ? 'text-blue-600 font-bold' : 'hover:text-blue-600' }} transition">Kontak</a>
                </div>

                <!-- Tombol Aksi Kanan (Login / Dashboard) + Mobile Menu Button -->
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
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 sm:px-5 py-2.5 rounded-xl transition-all shadow-md shadow-blue-600/20 hover:shadow-blue-600/30 hover:scale-[1.02] flex items-center gap-1.5">
                            <span>Masuk</span>
                            <span class="hidden sm:inline">/ Login</span>
                            <span>→</span>
                        </a>
                    @endauth

                    <!-- Mobile Menu Hamburger Button -->
                    <button type="button" onclick="document.getElementById('mobile-nav-drawer').classList.toggle('hidden')" class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 border border-slate-200 focus:outline-none" aria-label="Buka Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-nav-drawer" class="hidden lg:hidden border-t border-slate-200/80 bg-white/95 backdrop-blur-md px-4 pt-3 pb-5 space-y-2 shadow-xl">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-bold {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50' }}">
                🏠 Beranda
            </a>
            <a href="{{ route('public.learning') }}" class="block px-3 py-2 rounded-xl text-sm font-bold {{ request()->is('belajar*') || request()->is('panduan*') ? 'bg-blue-600 text-white' : 'text-blue-700 bg-blue-50/70 hover:bg-blue-100' }} flex items-center justify-between">
                <span class="flex items-center gap-2">🎓 Pembelajaran Coding</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full {{ request()->is('belajar*') || request()->is('panduan*') ? 'bg-white text-blue-600' : 'bg-blue-600 text-white' }}">Lengkap</span>
            </a>
            <a href="{{ route('public.playground') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('playground*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                ⚡ Live Playground Koding
            </a>
            <a href="{{ route('public.news') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold {{ request()->is('berita*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
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

    <!-- Konten Halaman -->
    <div class="flex-grow pt-20">
        @yield('content')
    </div>

    <!-- Banner AdSense di Footer (Hanya jika slot resmi telah dikonfigurasi) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']) && !empty($settings['adsense_slot_footer']) && $settings['adsense_slot_footer'] !== '1234567890')
        <div class="max-w-5xl mx-auto px-4 my-6 text-center">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="{{ $settings['adsense_client_id'] }}"
                 data-ad-slot="{{ $settings['adsense_slot_footer'] }}"
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
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Akses & Pembelajaran</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('public.playground') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>⚡</span> Live Code Playground</a></li>
                        <li><a href="{{ route('public.learning') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>🎓</span> Kurikulum & Modul Belajar</a></li>
                        <li><a href="{{ route('public.certificate') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>📜</span> Sertifikat 10 Level</a></li>
                        <li><a href="{{ route('public.author') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>👨‍🏫</span> Profil Penulis (E-E-A-T)</a></li>
                        <li><a href="{{ route('public.news') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span>📰</span> Warta & Tips Teknologi</a></li>
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
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">Kontak & Komunitas</h4>
                    <p class="mb-2 leading-relaxed">Pertanyaan materi, bimbingan siswa, atau kerjasama sekolah SMKN 1 Kupang Barat:</p>
                    <div class="space-y-2">
                        <a href="https://wa.me/6282266383444?text={{ urlencode('Halo Admin VxAI, saya ingin bertanya tentang pembelajaran koding:') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition">
                            <span>📱</span> <span>Chat WhatsApp Resmi</span>
                        </a>
                        <div class="block">
                            <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="text-blue-400 font-bold hover:underline break-all text-xs">
                                {{ $settings['contact_email'] ?? 'admin@vxai.online' }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-t border-slate-800/80 pt-6 flex flex-col md:flex-row justify-between items-center text-slate-500 gap-2">
                <p>&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI Coding Lab' }} • Karya Vicky Koroh (SMKN 1 Kupang Barat, NTT).</p>
                <p>Platform Edukasi Koding & Akses Terbuka Pembelajar Seluruh Indonesia.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Help Button (Akses Kontak Cepat Pelajar) -->
    <a href="https://wa.me/6282266383444?text={{ urlencode('Halo Admin VxAI, saya ingin bertanya seputar pembelajaran koding:') }}" target="_blank" rel="noopener noreferrer" class="fixed bottom-5 right-5 z-40 bg-emerald-600 hover:bg-emerald-500 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-300 border-2 border-white/40 group" title="Hubungi Kami via WhatsApp">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-500 ease-in-out font-bold text-xs pl-0 group-hover:pl-2">Chat WhatsApp</span>
    </a>

    @stack('scripts')
</body>
</html>
