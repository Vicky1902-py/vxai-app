<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Live Code Playground - {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</title>
    <meta name="description" content="Editor HTML, CSS, dan JavaScript interaktif dengan pratinjau langsung. Terbuka gratis untuk publik dan pelajar.">
    
    <!-- Favicon -->
    @if(!empty($settings['app_favicon']))
        <link rel="icon" href="{{ asset($settings['app_favicon']) }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CodeMirror CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/dracula.min.css">
    
    <!-- URL Kanonikal SEO -->
    <link rel="canonical" href="{{ url()->current() }}">

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

    <!-- Google AdSense Script (Otomatis Aktif jika Dikonfigurasi) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}"
             crossorigin="anonymous"></script>
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre, .font-mono, .CodeMirror { font-family: 'JetBrains Mono', monospace !important; font-size: 13.5px; }
        .CodeMirror { height: 100%; position: absolute; top: 0; bottom: 0; left: 0; right: 0; }
        @media (max-width: 767px) {
            .mobile-hidden { display: none !important; }
            .mobile-flex { display: flex !important; }
        }
        .modal-enter { animation: modalFadeIn 0.3s ease-out forwards; }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(-10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased h-screen flex flex-col overflow-hidden relative">

    <!-- Header Navigation -->
    <header class="h-16 shrink-0 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-4 md:px-6 z-20">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition flex items-center gap-1 text-xs font-bold bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-xl">
                <span>←</span> <span class="hidden sm:inline">Beranda</span>
            </a>
            
            <a href="{{ route('public.tutorials') }}" target="_blank" class="hidden md:inline-flex items-center gap-1 text-xs font-bold text-slate-300 hover:text-blue-400 transition bg-slate-800/80 px-3 py-1.5 rounded-xl">
                <span>📖</span> <span>Buka Panduan</span>
            </a>

            <h1 class="text-sm md:text-base font-black text-blue-400 flex items-center gap-1.5 ml-1">
                <span>⚡</span> <span>Playground</span>
            </h1>
            
            @auth
                <span class="hidden xl:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-900/40 text-blue-300 text-xs font-semibold border border-blue-800">
                    👤 {{ Auth::user()->name }} (Lvl {{ Auth::user()->level }} • {{ Auth::user()->xp }} XP)
                </span>
            @else
                <span class="hidden xl:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-800 text-slate-300 text-xs border border-slate-700">
                    🌐 Mode Publik (Tamu)
                </span>
            @endauth
        </div>

        <div class="flex items-center gap-2 md:gap-3">
            <!-- Tombol Asisten Cerdas VxAI Code Tutor -->
            <button onclick="openAiTutorModal()" class="bg-gradient-to-r from-purple-600 via-indigo-600 to-sky-600 hover:from-purple-500 hover:to-sky-500 text-white px-3 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-extrabold shadow-md shadow-purple-600/30 flex items-center gap-1.5 transition active:scale-95 group">
                <span class="group-hover:rotate-12 transition">🤖</span> 
                <span>VxAI Tutor</span>
                <span class="hidden sm:inline-block px-1.5 py-0.5 rounded bg-white/20 text-[10px] font-mono">AI Active</span>
            </button>

            <!-- Tombol Pilih Tingkatan & Latihan -->
            <button onclick="openChallengeModal()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-3 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-extrabold shadow-md shadow-blue-600/30 flex items-center gap-1.5 transition active:scale-95">
                <span>🎯</span> <span class="hidden sm:inline">Tingkatan</span> Koding
                <span class="hidden md:inline-block px-1.5 py-0.5 rounded bg-white/20 text-[10px]">10 Latihan</span>
            </button>

            <!-- Tombol Sertifikat 10 Level -->
            <a href="{{ route('public.certificate') }}" target="_blank" class="hidden xl:inline-flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-slate-700 px-3 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold transition">
                <span>📜</span> <span>Sertifikat</span>
            </a>

            @auth
                <!-- Tombol Nilai & Catatan Guru (Khusus Siswa Login) -->
                <button onclick="openMyGradesModal()" class="bg-slate-800 hover:bg-slate-700 text-sky-400 border border-slate-700 px-3 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold flex items-center gap-1.5 transition active:scale-95" title="Lihat Nilai & Catatan Guru">
                    <span>📊</span> <span class="hidden md:inline">Nilai Saya</span>
                </button>
            @endauth

            <!-- Tombol Petunjuk Kode -->
            <button onclick="openHintModal()" class="bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 px-3 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold flex items-center gap-1.5 transition active:scale-95">
                <span>💡</span> <span class="hidden md:inline">Kamus Kode</span>
            </button>
            
            <!-- Tombol Kirim / Uji Kode -->
            <button id="btn-submit" onclick="kirimKode()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold shadow-md shadow-emerald-600/20 active:scale-95 transition flex items-center gap-1.5">
                <span>🚀</span> <span>Kirim / Simpan</span>
            </button>

            @guest
                <a href="{{ route('login') }}" class="text-xs text-blue-400 hover:text-blue-300 hidden lg:inline ml-1 font-semibold">
                    Masuk ➔
                </a>
            @endguest
        </div>
    </header>

    <!-- Bar Banner Tantangan Aktif (Jika Sedang Mengerjakan Latihan) -->
    <div id="challenge-banner" class="hidden shrink-0 bg-gradient-to-r from-slate-900 via-slate-850 to-slate-900 border-b border-slate-800 px-4 py-2.5 flex items-center justify-between text-xs z-10 transition">
        <div class="flex items-center gap-2.5 overflow-hidden">
            <span id="challenge-banner-badge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold shrink-0"></span>
            <div class="truncate">
                <span id="challenge-banner-title" class="font-extrabold text-white text-xs"></span>
                <span class="text-slate-400 hidden md:inline ml-2 text-[11px]" id="challenge-banner-desc"></span>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0 ml-3">
            <button onclick="openChallengeInstructions()" class="bg-slate-800 hover:bg-slate-700 text-blue-400 px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1 transition">
                <span>📋</span> <span>Lihat Instruksi</span>
            </button>
            <button onclick="resetCurrentChallenge()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-2.5 py-1 rounded-lg text-[11px] font-semibold transition" title="Reset ke kode awal tantangan ini">
                ↺ Reset
            </button>
            <button onclick="closeChallengeBanner()" class="text-slate-500 hover:text-slate-300 font-bold px-1 text-sm leading-none" title="Sembunyikan Banner">&times;</button>
        </div>
    </div>

    <!-- Area Kerja Utama -->
    <main class="flex-1 flex flex-col md:grid md:grid-cols-2 md:gap-3 md:p-3 relative overflow-hidden">
        
        <!-- Mobile Tab Navigation -->
        <div class="md:hidden flex shrink-0 bg-slate-900 border-b border-slate-800 z-10">
            <button onclick="switchTab('html', this)" class="tab-btn flex-1 py-2.5 text-orange-400 border-b-2 border-orange-400 bg-slate-850 text-xs font-bold transition">HTML</button>
            <button onclick="switchTab('css', this)" class="tab-btn flex-1 py-2.5 text-slate-400 border-b-2 border-transparent text-xs font-bold transition">CSS</button>
            <button onclick="switchTab('js', this)" class="tab-btn flex-1 py-2.5 text-slate-400 border-b-2 border-transparent text-xs font-bold transition">JS</button>
            <button onclick="switchTab('preview', this)" class="tab-btn flex-1 py-2.5 text-slate-400 border-b-2 border-transparent text-xs font-bold flex items-center justify-center gap-1 transition">
                Preview <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </button>
        </div>

        <!-- Panel Kiri: Editor HTML, CSS, JS -->
        <div class="flex-1 flex flex-col md:gap-3 h-full relative z-0 min-h-0">
            <div id="pane-html" class="pane mobile-flex md:flex flex-col flex-1 bg-slate-900 md:rounded-2xl overflow-hidden border-0 md:border border-slate-800 relative">
                <div class="hidden md:flex justify-between items-center px-4 py-2 bg-slate-950 text-xs font-bold text-orange-400 border-b border-slate-800">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        <span>HTML5</span>
                    </span>
                    <span class="text-[10px] text-slate-500 font-mono">index.html</span>
                </div>
                <div class="flex-1 relative"><textarea id="html-code"></textarea></div>
            </div>

            <div id="wrapper-css-js" class="pane mobile-hidden md:flex flex-1 md:grid md:grid-cols-2 md:gap-3 relative min-h-0">
                <div id="pane-css" class="pane mobile-hidden md:flex flex-col flex-1 bg-slate-900 md:rounded-2xl overflow-hidden border-0 md:border border-slate-800 relative h-full">
                    <div class="hidden md:flex justify-between items-center px-4 py-2 bg-slate-950 text-xs font-bold text-blue-400 border-b border-slate-800">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span>CSS3</span>
                        </span>
                        <span class="text-[10px] text-slate-500 font-mono">style.css</span>
                    </div>
                    <div class="flex-1 relative"><textarea id="css-code"></textarea></div>
                </div>
                <div id="pane-js" class="pane mobile-hidden md:flex flex-col flex-1 bg-slate-900 md:rounded-2xl overflow-hidden border-0 md:border border-slate-800 relative h-full">
                    <div class="hidden md:flex justify-between items-center px-4 py-2 bg-slate-950 text-xs font-bold text-yellow-400 border-b border-slate-800">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span>JavaScript</span>
                        </span>
                        <span class="text-[10px] text-slate-500 font-mono">script.js</span>
                    </div>
                    <div class="flex-1 relative"><textarea id="js-code"></textarea></div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Live Preview -->
        <div id="pane-preview" class="pane mobile-hidden md:flex flex-col bg-white md:rounded-2xl shadow-2xl overflow-hidden border-0 md:border border-slate-800 relative z-0 h-full w-full">
            <div class="hidden md:flex px-4 py-2 bg-slate-100 text-xs font-bold text-slate-700 border-b border-slate-200 justify-between items-center">
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    <span class="ml-2 font-mono text-[11px] text-slate-600 font-semibold">Tampilan Hasil Langsung (Live Output)</span>
                </span>
                <span class="text-emerald-600 font-bold text-[11px] flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Real-time</span>
                </span>
            </div>
            <iframe id="preview-frame" class="w-full flex-1 bg-white" sandbox="allow-scripts allow-modals"></iframe>
        </div>
    </main>

    <!-- ======================================================== -->
    <!-- MODAL KATALOG TINGKATAN & MODUL LATIHAN KODING (FITUR BARU) -->
    <!-- ======================================================== -->
    <div id="modal-challenges" class="fixed inset-0 bg-slate-950/85 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-slate-800 modal-enter overflow-hidden">
            
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-800 bg-slate-950/80 flex justify-between items-center shrink-0">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-900/60 text-blue-400 text-[11px] font-extrabold uppercase tracking-wider border border-blue-800">
                        Kurikulum Koding Berjenjang
                    </span>
                    <h2 class="text-xl font-black text-white mt-1.5 flex items-center gap-2">
                        <span>🎯</span> <span>Pilih Modul & Tingkat Pelatihan Koding</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih tingkat kesulitan dan muat latihan langsung ke dalam editor interaktif</p>
                </div>
                <button onclick="closeChallengeModal()" class="text-slate-400 hover:text-white text-3xl font-bold leading-none p-1 transition">&times;</button>
            </div>

            <!-- Tab Filter Tingkatan -->
            <div class="p-4 bg-slate-850 border-b border-slate-800 flex items-center gap-2 overflow-x-auto shrink-0">
                <button onclick="filterChallengeTab('all', this)" class="challenge-tab-btn px-4 py-2 rounded-xl text-xs font-bold bg-blue-600 text-white transition">
                    Semua ({{ count($challenges ?? []) }} Latihan)
                </button>
                <button onclick="filterChallengeTab('pemula', this)" class="challenge-tab-btn px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 text-slate-400 hover:text-white transition">
                    🟢 Tingkat 1: Pemula (HTML)
                </button>
                <button onclick="filterChallengeTab('menengah', this)" class="challenge-tab-btn px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 text-slate-400 hover:text-white transition">
                    🔵 Tingkat 2: Menengah (CSS3)
                </button>
                <button onclick="filterChallengeTab('mahir', this)" class="challenge-tab-btn px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 text-slate-400 hover:text-white transition">
                    🟣 Tingkat 3: Mahir (JS & Logic)
                </button>
            </div>
            
            <!-- List Kartu Latihan -->
            <div class="p-6 overflow-y-auto space-y-4 flex-1 custom-scrollbar" id="challenge-list-container">
                <!-- Di-render dinamis oleh JavaScript -->
            </div>
            
            <!-- Modal Footer -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/80 flex justify-between items-center shrink-0">
                <a href="{{ route('public.tutorials') }}" target="_blank" class="text-xs font-bold text-blue-400 hover:underline flex items-center gap-1">
                    <span>📖 Buka Panduan Teori Lengkap</span> <span>↗</span>
                </a>
                <button onclick="closeChallengeModal()" class="bg-slate-800 hover:bg-slate-700 px-5 py-2 rounded-xl text-xs font-bold text-slate-300 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL VXAI CODE TUTOR (AI-POWERED INTERACTIVE ASSISTANT) -->
    <!-- ======================================================== -->
    <div id="modal-ai-tutor" class="fixed inset-0 bg-slate-950/80 z-[120] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[88vh] flex flex-col border border-slate-700/80 modal-enter overflow-hidden">
            <!-- Header Modal -->
            <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-600 to-sky-500 flex items-center justify-center text-xl shadow-lg shadow-purple-500/30">
                        🤖
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-black text-sm md:text-base text-white">VxAI Interactive Code Tutor</h3>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-900/60 text-purple-300 border border-purple-700">v2.6 Aktif</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Asisten cerdas analisis kode, deteksi error sintaks, dan petunjuk logika</p>
                    </div>
                </div>
                <button onclick="closeAiTutorModal()" class="text-slate-400 hover:text-white text-2xl font-bold leading-none p-1">&times;</button>
            </div>

            <!-- Tab Nav AI Tutor -->
            <div class="flex border-b border-slate-800 bg-slate-950/60 px-4 text-xs font-bold">
                <button onclick="switchAiTab('inspect')" id="tab-ai-inspect" class="py-3 px-4 text-sky-400 border-b-2 border-sky-400 transition flex items-center gap-1.5">
                    <span>🔍</span> <span>Audit & Analisis Kode</span>
                </button>
                <button onclick="switchAiTab('hint')" id="tab-ai-hint" class="py-3 px-4 text-slate-400 border-b-2 border-transparent transition flex items-center gap-1.5">
                    <span>💡</span> <span>Petunjuk Tantangan</span>
                </button>
                <button onclick="switchAiTab('best-practice')" id="tab-ai-best-practice" class="py-3 px-4 text-slate-400 border-b-2 border-transparent transition flex items-center gap-1.5">
                    <span>✨</span> <span>Rekomendasi Clean Code</span>
                </button>
            </div>

            <!-- Body Modal -->
            <div class="p-6 overflow-y-auto space-y-4 text-xs custom-scrollbar flex-1 bg-slate-900">
                <!-- Tab Content 1: Audit & Analisis Kode -->
                <div id="ai-content-inspect" class="space-y-4">
                    <div class="flex items-center justify-between bg-slate-950 p-3.5 rounded-2xl border border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-slate-300 font-semibold">Status Analisis Real-Time:</span>
                        </div>
                        <button onclick="runAiInspection()" class="bg-blue-600 hover:bg-blue-500 text-white font-bold px-3 py-1.5 rounded-xl transition text-[11px] flex items-center gap-1">
                            <span>🔄</span> <span>Pindai Ulang Kode</span>
                        </button>
                    </div>

                    <div id="ai-inspection-results" class="space-y-3">
                        <!-- Populated by JS runAiInspection() -->
                    </div>
                </div>

                <!-- Tab Content 2: Petunjuk Tantangan -->
                <div id="ai-content-hint" class="space-y-4 hidden">
                    <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 space-y-3">
                        <h4 class="font-bold text-amber-400 text-xs flex items-center gap-1.5">
                            <span>🎯</span> <span id="ai-hint-challenge-title">Tantangan Aktif</span>
                        </h4>
                        <p class="text-slate-300 leading-relaxed text-xs" id="ai-hint-challenge-body">
                            Pilih latihan terlebih dahulu untuk mendapatkan bimbingan langkah demi langkah dari AI Tutor.
                        </p>
                        <div id="ai-hint-progressive-container" class="space-y-2 pt-2 border-t border-slate-800">
                            <!-- Hints generated dynamically -->
                        </div>
                    </div>
                </div>

                <!-- Tab Content 3: Rekomendasi Clean Code -->
                <div id="ai-content-best-practice" class="space-y-4 hidden">
                    <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 space-y-3">
                        <h4 class="font-bold text-purple-400 text-xs flex items-center gap-1.5">
                            <span>✨</span> <span>Standar Rekayasa Web Modern (W3C & Industry Standards)</span>
                        </h4>
                        <ul class="space-y-2 text-slate-300 leading-relaxed" id="ai-best-practice-list">
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>HTML5 Semantik:</strong> Gunakan tag bermakna seperti <code>&lt;header&gt;</code>, <code>&lt;main&gt;</code>, <code>&lt;footer&gt;</code> daripada membungkus semua konten dengan <code>&lt;div&gt;</code> biasa.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>Aksesibilitas (a11y):</strong> Selalu cantumkan atribut <code>alt="..."</code> pada tag gambar <code>&lt;img&gt;</code> agar ramah bagi pembaca layar tuna netra.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>CSS Mobile-First:</strong> Rancang tata letak fleksibel menggunakan Flexbox atau CSS Grid agar tampilan tetap rapi di smartphone siswa.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span><strong>JavaScript Aman:</strong> Gunakan <code>const</code> dan <code>let</code> ketimbang <code>var</code>, serta manfaatkan <code>addEventListener</code> untuk menangani interaksi pengguna.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="p-4 border-t border-slate-800 bg-slate-950 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-slate-400 text-[11px]">
                    <span>📜 Telah menyelesaikan 10 level?</span>
                    <a href="{{ route('public.certificate') }}" target="_blank" class="text-emerald-400 font-bold hover:underline flex items-center gap-0.5">
                        <span>Cetak Sertifikat Digital</span> ➔
                    </a>
                </div>
                <button onclick="closeAiTutorModal()" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-700 px-5 py-2 rounded-xl font-bold text-white transition">
                    Tutup Asisten
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL INSTRUKSI DETAIL TANTANGAN AKTIF                   -->
    <!-- ======================================================== -->
    <div id="modal-instructions" class="fixed inset-0 bg-slate-950/80 z-[110] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-xl max-h-[85vh] flex flex-col border border-slate-800 modal-enter overflow-hidden">
            <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">📋</span>
                    <div>
                        <h3 class="font-extrabold text-sm text-white" id="instruction-modal-title">Instruksi Tantangan</h3>
                        <span id="instruction-modal-badge" class="text-[10px] font-bold"></span>
                    </div>
                </div>
                <button onclick="closeChallengeInstructions()" class="text-slate-400 hover:text-white text-2xl font-bold leading-none">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-xs">
                <div>
                    <h4 class="font-bold text-blue-400 uppercase tracking-wider mb-1 text-[11px]">Tujuan Pembelajaran:</h4>
                    <p class="text-slate-300 leading-relaxed" id="instruction-modal-desc"></p>
                </div>
                <div>
                    <h4 class="font-bold text-emerald-400 uppercase tracking-wider mb-2 text-[11px]">Langkah & Tugas yang Harus Dikerjakan:</h4>
                    <ul class="space-y-2 list-decimal list-inside text-slate-300 leading-relaxed bg-slate-950 p-4 rounded-2xl border border-slate-800" id="instruction-modal-steps">
                    </ul>
                </div>
                <div class="p-3 bg-blue-950/50 border border-blue-900/80 rounded-xl text-blue-300 text-[11px]">
                    💡 <strong>Tips:</strong> Lihat hasil kode Anda secara langsung di panel pratinjau sebelah kanan. Setelah selesai, klik tombol <strong>"🚀 Kirim / Simpan"</strong> untuk dievaluasi oleh guru!
                </div>
            </div>
            <div class="p-4 border-t border-slate-800 bg-slate-950 text-right">
                <button onclick="closeChallengeInstructions()" class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-xl text-xs font-bold text-white transition">
                    Mulai Kerjakan
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL KAMUS SINTAKSIS CEPAT (CHEAT SHEET)                -->
    <!-- ======================================================== -->
    <div id="hint-modal" class="fixed inset-0 bg-slate-950/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-slate-900 text-slate-200 rounded-3xl shadow-2xl w-full max-w-3xl max-h-[85vh] flex flex-col border border-slate-800 modal-enter overflow-hidden">
            
            <div class="p-5 border-b border-slate-800 flex justify-between items-center bg-slate-950">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">💡</span>
                    <div>
                        <h2 class="text-base font-extrabold text-amber-400">Kamus & Referensi Sintaksis Cepat</h2>
                        <p class="text-[11px] text-slate-400">Panduan kilat atribut HTML, CSS, dan metode JavaScript</p>
                    </div>
                </div>
                <button onclick="closeHintModal()" class="text-slate-400 hover:text-white text-3xl font-bold leading-none">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-6 flex-1 text-sm custom-scrollbar">
                <!-- HTML -->
                <div>
                    <h3 class="font-bold text-orange-400 mb-2.5 text-xs uppercase tracking-wider flex items-center gap-1.5">
                        <span>1. Tag HTML5 Utama</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>&lt;h1&gt;..&lt;/h1&gt;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Judul utama halaman</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>&lt;p&gt;..&lt;/p&gt;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Paragraf teks biasa</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>&lt;a href="..."&gt;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Tautan hyperlink ke halaman lain</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>&lt;img src="..."&gt;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Menyisipkan file gambar</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>&lt;input type="..."&gt;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Kotak isian form pengguna</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>&lt;button&gt;..&lt;/button&gt;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Tombol klik aksi</span></div>
                    </div>
                </div>

                <!-- CSS -->
                <div>
                    <h3 class="font-bold text-blue-400 mb-2.5 text-xs uppercase tracking-wider flex items-center gap-1.5">
                        <span>2. Properti CSS3 Populer</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>display: flex;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Mengaktifkan tata letak fleksibel</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>justify-content: center;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Penyelarasan horizontal</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>align-items: center;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Penyelarasan vertikal</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>border-radius: 1rem;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Lengkungan sudut elemen</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>transition: all 0.3s;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Animasi perpindahan halus</span></div>
                        <div class="bg-slate-950 p-3 rounded-xl border border-slate-800 font-mono"><code>box-shadow: 0 10px 25px;</code> <span class="text-slate-400 text-[11px] font-sans block mt-0.5">Efek bayangan kedalaman</span></div>
                    </div>
                </div>

                <!-- JS -->
                <div>
                    <h3 class="font-bold text-yellow-400 mb-2.5 text-xs uppercase tracking-wider flex items-center gap-1.5">
                        <span>3. Metode JavaScript (DOM)</span>
                    </h3>
                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-xs font-mono text-slate-300 leading-relaxed">
                        <code>// Menangkap elemen & mendengar klik</code><br>
                        const tombol = document.getElementById("btn-id");<br>
                        tombol.addEventListener("click", function() {<br>
                        &nbsp;&nbsp;document.getElementById("output").innerText = "Halo Dunia!";<br>
                        });
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t border-slate-800 bg-slate-950 text-right">
                <button onclick="closeHintModal()" class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-xl text-xs font-bold text-white transition">Tutup Kamus</button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 1. MODAL SUKSES SUBMISI & PROGRESI 10 LEVEL             -->
    <!-- ======================================================== -->
    <div id="modal-submission-success" class="fixed inset-0 bg-slate-950/85 z-[130] hidden flex items-center justify-center p-4 backdrop-blur-md">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-lg flex flex-col border border-emerald-500/40 modal-enter overflow-hidden">
            
            <!-- Header Animasi & Gamifikasi -->
            <div class="p-6 text-center border-b border-slate-800 bg-gradient-to-b from-emerald-950/40 to-slate-900">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white text-3xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-emerald-500/30">
                    🎉
                </div>
                <h3 class="text-xl font-black text-white">Tugas Koding Berhasil Disimpan!</h3>
                <p class="text-xs text-slate-300 mt-1 max-w-sm mx-auto" id="success-modal-message">
                    Hasil kodingan Anda telah masuk ke sistem dan siap dievaluasi oleh guru.
                </p>
                
                <!-- Gamifikasi Badge (XP / Level) -->
                <div id="success-xp-badge-container" class="mt-4 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-950/80 text-emerald-300 text-xs font-black border border-emerald-700 shadow-inner">
                    <span>⭐ +25 XP Diperoleh!</span>
                </div>
            </div>

            <!-- Konten Latihan Berikutnya -->
            <div class="p-6 space-y-4 text-xs bg-slate-900">
                <!-- Info Tantangan Selesai -->
                <div class="p-3.5 bg-slate-950 rounded-2xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Tantangan Diselesaikan:</span>
                        <span class="font-extrabold text-white text-xs" id="success-current-challenge-title">-</span>
                    </div>
                    <span class="text-emerald-400 font-black text-xs">✓ Lolos</span>
                </div>

                <!-- Kartu Tantangan Berikutnya (Jika Ada) -->
                <div id="success-next-level-card" class="p-4 bg-gradient-to-br from-blue-950/60 to-indigo-950/40 rounded-2xl border border-blue-800/80 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-600 text-white font-black text-[10px] uppercase tracking-wider" id="success-next-level-badge">
                            Level Berikutnya
                        </span>
                        <span class="text-blue-300 text-[11px] font-bold">Siap Dikerjakan ➔</span>
                    </div>
                    <h4 class="font-black text-white text-sm" id="success-next-level-title">-</h4>
                    <p class="text-slate-300 text-[11px] leading-relaxed" id="success-next-level-desc">-</p>
                </div>

                <!-- Kartu Selamat Selesai 10 Level (Jika Level 10 Selesai) -->
                <div id="success-all-completed-card" class="hidden p-5 bg-gradient-to-br from-amber-950/60 to-yellow-950/40 rounded-2xl border border-amber-600/80 text-center space-y-3">
                    <span class="text-4xl block">🏆</span>
                    <h4 class="font-black text-amber-300 text-base">LUAR BIASA! 10 LEVEL SELESAI</h4>
                    <p class="text-slate-300 text-xs leading-relaxed">
                        Anda telah menuntaskan seluruh kurikulum koding dari dasar hingga mahir. Anda berhak mendapatkan Sertifikat Digital Resmi!
                    </p>
                    <a href="{{ route('public.certificate') }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs shadow-lg shadow-amber-500/20 transition">
                        <span>🎓</span> <span>Klaim & Cetak Sertifikat Kelulusan</span>
                    </a>
                </div>
            </div>

            <!-- Modal Footer Aksi -->
            <div class="p-4 border-t border-slate-800 bg-slate-950 flex flex-col sm:flex-row items-center justify-end gap-2.5">
                <button type="button" onclick="closeSubmissionSuccessModal()" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition">
                    Tetap di Level Ini
                </button>
                <button type="button" id="btn-next-level-action" onclick="onLanjutNextLevelClicked()" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-extrabold text-xs shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-1.5">
                    <span>🚀</span> <span id="btn-next-level-text">Lanjut ke Level Berikutnya</span>
                </button>
            </div>

        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. MODAL KONFIRMASI NEXT LEVEL: LANJUT ATAU BACA PANDUAN -->
    <!-- ======================================================== -->
    <div id="modal-confirm-next-level" class="fixed inset-0 bg-slate-950/85 z-[140] hidden flex items-center justify-center p-4 backdrop-blur-md">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-md flex flex-col border border-blue-500/50 modal-enter overflow-hidden">
            
            <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <span class="text-2xl">🎯</span>
                    <div>
                        <h3 class="font-black text-sm text-white">Konfirmasi Memulai Latihan</h3>
                        <span class="text-[10px] text-blue-400 font-bold" id="confirm-next-badge">Level Berikutnya</span>
                    </div>
                </div>
                <button onclick="closeConfirmNextLevelModal()" class="text-slate-400 hover:text-white text-2xl font-bold leading-none p-1 transition">&times;</button>
            </div>

            <div class="p-6 space-y-4 text-xs bg-slate-900">
                <div class="text-center space-y-1.5">
                    <h4 class="text-base font-black text-white" id="confirm-next-title">-</h4>
                    <p class="text-slate-400 text-xs" id="confirm-next-desc">-</p>
                </div>

                <div class="p-3.5 bg-blue-950/40 border border-blue-900/60 rounded-2xl text-blue-200 text-center leading-relaxed">
                    Bagaimana Anda ingin memulai level ini? Anda dapat <strong>langsung menulis kode</strong> atau <strong>membaca panduan & instruksi terlebih dahulu</strong>.
                </div>
            </div>

            <div class="p-4 border-t border-slate-800 bg-slate-950 flex flex-col sm:flex-row items-center gap-2.5">
                <button type="button" onclick="actionConfirmNextDirect()" class="w-full flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-extrabold text-xs shadow-md shadow-blue-600/30 transition flex items-center justify-center gap-1.5">
                    <span>🚀</span> <span>Lanjut Koding</span>
                </button>
                <button type="button" onclick="actionConfirmNextWithGuide()" class="w-full flex-1 py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold text-xs shadow-md shadow-indigo-600/30 transition flex items-center justify-center gap-1.5">
                    <span>📖</span> <span>Baca Panduan</span>
                </button>
            </div>

        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. MODAL NILAI & CATATAN GURU SISWA (FITUR 2)            -->
    <!-- ======================================================== -->
    <div id="modal-my-grades" class="fixed inset-0 bg-slate-950/85 z-[125] hidden flex items-center justify-center p-3 sm:p-5 backdrop-blur-md">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[88vh] flex flex-col border border-slate-700 modal-enter overflow-hidden">
            
            <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-lg font-bold shadow-md shadow-blue-500/20">
                        📊
                    </span>
                    <div>
                        <h3 class="font-black text-sm sm:text-base text-white">Nilai & Evaluasi Guru Anda</h3>
                        <p class="text-[11px] text-slate-400">Pantau perkembangan nilai tugas koding dan catatan bimbingan guru</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="refreshMyGrades()" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-blue-400 text-xs font-bold transition" title="Muat Ulang Nilai">
                        🔄
                    </button>
                    <button onclick="closeMyGradesModal()" class="text-slate-400 hover:text-white text-2xl font-bold leading-none p-1 transition">&times;</button>
                </div>
            </div>

            <!-- Konten Daftar Nilai -->
            <div class="p-5 overflow-y-auto space-y-3.5 flex-1 custom-scrollbar" id="my-grades-list-container">
                <!-- Di-render dinamis oleh JavaScript -->
            </div>

            <div class="p-4 border-t border-slate-800 bg-slate-950 flex justify-between items-center shrink-0 text-xs">
                <a href="{{ route('siswa.dashboard') }}" class="text-blue-400 hover:underline font-bold flex items-center gap-1">
                    <span>🏠 Buka Dashboard Siswa</span> ➔
                </a>
                <button onclick="closeMyGradesModal()" class="px-5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold transition">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. CUSTOM ALERT MODAL (PENGGANTI ALERT BROWSER)         -->
    <!-- ======================================================== -->
    <div id="modal-custom-alert" class="fixed inset-0 bg-slate-950/85 z-[150] hidden flex items-center justify-center p-4 backdrop-blur-md">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-sm flex flex-col border border-slate-700 modal-enter overflow-hidden text-center p-6">
            <div id="custom-alert-icon" class="w-14 h-14 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3"></div>
            <h3 class="font-black text-base text-white" id="custom-alert-title">-</h3>
            <p class="text-xs text-slate-300 mt-1.5 leading-relaxed" id="custom-alert-message">-</p>
            <div class="mt-5">
                <button type="button" onclick="closeCustomAlert()" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-extrabold text-xs transition">
                    OK, Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 5. CUSTOM CONFIRM MODAL (PENGGANTI CONFIRM BROWSER)       -->
    <!-- ======================================================== -->
    <div id="modal-custom-confirm" class="fixed inset-0 bg-slate-950/85 z-[150] hidden flex items-center justify-center p-4 backdrop-blur-md">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-sm flex flex-col border border-slate-700 modal-enter overflow-hidden p-6 text-center">
            <div class="w-14 h-14 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3 bg-amber-950/60 text-amber-400 border border-amber-800">
                ⚠️
            </div>
            <h3 class="font-black text-base text-white" id="custom-confirm-title">Konfirmasi</h3>
            <p class="text-xs text-slate-300 mt-1.5 leading-relaxed" id="custom-confirm-message">-</p>
            <div class="mt-5 flex gap-2">
                <button type="button" onclick="resolveCustomConfirm(false)" class="flex-1 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition">
                    Batal
                </button>
                <button type="button" onclick="resolveCustomConfirm(true)" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-extrabold text-xs transition">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-[160] flex flex-col gap-2 pointer-events-none"></div>

    <!-- CodeMirror Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>

    <script>
        // ========================================================
        // DATABASE TANTANGAN KODING BERJENJANG (DINAMIS DARI DATABASE)
        // ========================================================
        const codingChallenges = @json($challenges ?? []);

        // ========================================================
        // KONTROL EDITOR CODEMIRROR & TAMPILAN
        // ========================================================
        let activeChallenge = null;

        // ========================================================
        // KONTROL VXAI INTERACTIVE CODE TUTOR
        // ========================================================
        function openAiTutorModal() {
            document.getElementById('modal-ai-tutor').classList.remove('hidden');
            runAiInspection();
            setupAiChallengeHints();
        }

        function closeAiTutorModal() {
            document.getElementById('modal-ai-tutor').classList.add('hidden');
        }

        function switchAiTab(tabName) {
            const tabs = ['inspect', 'hint', 'best-practice'];
            tabs.forEach(t => {
                const btn = document.getElementById('tab-ai-' + t);
                const content = document.getElementById('ai-content-' + t);
                if (t === tabName) {
                    btn.classList.add('text-sky-400', 'border-sky-400');
                    btn.classList.remove('text-slate-400', 'border-transparent');
                    content.classList.remove('hidden');
                } else {
                    btn.classList.remove('text-sky-400', 'border-sky-400');
                    btn.classList.add('text-slate-400', 'border-transparent');
                    content.classList.add('hidden');
                }
            });
        }

        function setupAiChallengeHints() {
            const titleEl = document.getElementById('ai-hint-challenge-title');
            const bodyEl = document.getElementById('ai-hint-challenge-body');
            const hintsContainer = document.getElementById('ai-hint-progressive-container');

            if (activeChallenge) {
                titleEl.innerText = activeChallenge.title + ' (' + activeChallenge.levelBadge + ')';
                bodyEl.innerText = activeChallenge.desc;
                hintsContainer.innerHTML = '';

                const hints = [
                    { level: 'Level 1: Konsep Dasar', text: 'Periksa instruksi utama: ' + (activeChallenge.instructions[0] || 'Tuliskan elemen HTML sesuai instruksi.') },
                    { level: 'Level 2: Sintaks yang Dibutuhkan', text: 'Gunakan struktur yang tepat. ' + (activeChallenge.instructions[1] || 'Pastikan tag penutup berpasangan dengan benar.') },
                    { level: 'Level 3: Uji Coba & Verifikasi', text: (activeChallenge.instructions[2] || 'Pastikan hasil pratinjau di panel kanan berubah sebelum mengirim/menyimpan kode.') }
                ];

                hints.forEach(h => {
                    const d = document.createElement('div');
                    d.className = 'bg-slate-900 p-3 rounded-xl border border-slate-800 text-xs';
                    d.innerHTML = `<span class="font-bold text-amber-300 block mb-1">💡 ${h.level}:</span><span class="text-slate-300">${h.text}</span>`;
                    hintsContainer.appendChild(d);
                });
            } else {
                titleEl.innerText = 'Pilih Tantangan Koding';
                bodyEl.innerText = 'Buka menu "10 Level Latihan" untuk memilih latihan HTML, CSS, atau JavaScript, lalu kembali ke asisten ini untuk petunjuk khusus.';
                hintsContainer.innerHTML = '';
            }
        }

        function runAiInspection() {
            const html = htmlEditor.getValue();
            const css = cssEditor.getValue();
            const js = jsEditor.getValue();

            const container = document.getElementById('ai-inspection-results');
            container.innerHTML = '';

            const findings = [];

            // 1. Audit HTML
            if (!html || html.trim() === '') {
                findings.push({
                    type: 'warning',
                    title: 'Editor HTML Masih Kosong',
                    detail: 'Tuliskan setidaknya satu tag HTML seperti <h1>, <p>, atau <button> untuk memulai tampilan.'
                });
            } else {
                if (/<img(?![^>]*\balt=)[^>]*>/i.test(html)) {
                    findings.push({
                        type: 'tip',
                        title: 'Aksesibilitas Gambar (a11y)',
                        detail: 'Terdapat tag <img> tanpa atribut alt. Tambahkan atribut alt="deskripsi" agar ramah mesin pencari dan screen reader.'
                    });
                }

                const hasSemantic = /<(header|nav|main|footer|section|article|figure)/i.test(html);
                if (hasSemantic) {
                    findings.push({
                        type: 'success',
                        title: 'Struktur HTML5 Semantik Bagus!',
                        detail: 'Kode Anda menggunakan tag semantik modern yang mempermudah pembacaan mesin pencari (SEO).'
                    });
                } else if (html.length > 150) {
                    findings.push({
                        type: 'tip',
                        title: 'Saran Semantik HTML5',
                        detail: 'Pertimbangkan untuk mengganti pembungkus <div> dengan tag <main>, <section>, atau <article> untuk struktur yang lebih bersih.'
                    });
                }
            }

            // 2. Audit CSS
            if (css && css.trim() !== '') {
                const openBrace = (css.match(/\{/g) || []).length;
                const closeBrace = (css.match(/\}/g) || []).length;
                if (openBrace !== closeBrace) {
                    findings.push({
                        type: 'error',
                        title: 'Kurung Kurawal CSS Tidak Seimbang',
                        detail: `Ditemukan ${openBrace} kurung buka '{' dan ${closeBrace} kurung tutup '}'. Periksa kembali penutupan blok selektor CSS Anda.`
                    });
                } else {
                    findings.push({
                        type: 'success',
                        title: 'Sintaks CSS Valid',
                        detail: 'Semua kurung kurawal CSS berpasangan dengan sempurna.'
                    });
                }

                if (css.includes('display: flex') || css.includes('display: grid')) {
                    findings.push({
                        type: 'success',
                        title: 'Menggunakan Layout CSS Modern',
                        detail: 'Bagus! Anda menerapkan Flexbox / Grid untuk perataan responsif.'
                    });
                }
            }

            // 3. Audit JavaScript
            if (js && js.trim() !== '') {
                try {
                    new Function(js);
                    findings.push({
                        type: 'success',
                        title: 'Sintaks JavaScript Lolos Validasi',
                        detail: 'Tidak terdeteksi kesalahan sintaks dasar pada kode JavaScript Anda.'
                    });
                } catch (err) {
                    findings.push({
                        type: 'error',
                        title: 'Kesalahan Sintaks JavaScript Terdeteksi',
                        detail: `Pesan kesalahan: "${err.message}". Periksa kembali tanda kurung, titik koma, atau penulisan variabel.`
                    });
                }

                if (/\bvar\s+[a-zA-Z_$]/.test(js)) {
                    findings.push({
                        type: 'tip',
                        title: 'Saran ES6 Modern: Hindari "var"',
                        detail: 'Gunakan kata kunci modern "const" untuk nilai tetap atau "let" untuk variabel yang nilainya dapat berubah.'
                    });
                }

                if (js.includes('addEventListener')) {
                    findings.push({
                        type: 'success',
                        title: 'Event Listener Standar Industri',
                        detail: 'Bagus! Anda menggunakan addEventListener untuk memisahkan logika JavaScript dari atribut HTML inline.'
                    });
                }
            }

            // 4. Audit Tantangan Aktif
            if (activeChallenge) {
                let challengeMatch = false;
                if (activeChallenge.id === 'html_struktur' && /<h1/i.test(html) && /<p/i.test(html)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'html_list' && /<(ul|ol)/i.test(html) && /<li/i.test(html)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'html_table' && /<table/i.test(html) && /<tr/i.test(html)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'html_form' && /<form/i.test(html) && /<input/i.test(html)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'css_flexbox' && /display\s*:\s*flex/i.test(css)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'css_grid' && /display\s*:\s*grid/i.test(css)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'css_card' && /border-radius/i.test(css)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'js_dom' && /addEventListener/i.test(js)) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'js_kalkulator' && (js.includes('+') || js.includes('parseInt') || js.includes('Number'))) {
                    challengeMatch = true;
                } else if (activeChallenge.id === 'js_game' && /Math\.random/i.test(js)) {
                    challengeMatch = true;
                }

                if (challengeMatch) {
                    findings.unshift({
                        type: 'congrats',
                        title: `🎉 Kriteria "${activeChallenge.title}" Berhasil Dipenuhi!`,
                        detail: 'Kode Anda memenuhi spesifikasi tantangan ini. Klik tombol "🚀 Kirim / Simpan" untuk mencatatkan poin XP ke akun Anda!'
                    });
                }
            }

            findings.forEach(f => {
                const card = document.createElement('div');
                let borderClass = 'border-slate-800 bg-slate-950';
                let icon = 'ℹ️';
                let titleColor = 'text-white';

                if (f.type === 'congrats') {
                    borderClass = 'border-emerald-600 bg-emerald-950/40';
                    icon = '🏆';
                    titleColor = 'text-emerald-300';
                } else if (f.type === 'success') {
                    borderClass = 'border-emerald-800/80 bg-slate-950';
                    icon = '✅';
                    titleColor = 'text-emerald-400';
                } else if (f.type === 'error') {
                    borderClass = 'border-rose-800/90 bg-rose-950/30';
                    icon = '❌';
                    titleColor = 'text-rose-400';
                } else if (f.type === 'warning') {
                    borderClass = 'border-amber-800/80 bg-slate-950';
                    icon = '⚠️';
                    titleColor = 'text-amber-400';
                } else if (f.type === 'tip') {
                    borderClass = 'border-sky-800/80 bg-slate-950';
                    icon = '💡';
                    titleColor = 'text-sky-300';
                }

                card.className = `p-4 rounded-2xl border ${borderClass} flex items-start gap-3 transition`;
                card.innerHTML = `
                    <span class="text-xl shrink-0 mt-0.5">${icon}</span>
                    <div class="flex-1">
                        <h4 class="font-bold text-xs ${titleColor} mb-1">${f.title}</h4>
                        <p class="text-slate-300 text-[11px] leading-relaxed">${f.detail}</p>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function openHintModal() { document.getElementById('hint-modal').classList.remove('hidden'); }
        function closeHintModal() { document.getElementById('hint-modal').classList.add('hidden'); }

        function openChallengeModal() {
            renderChallengeCards('all');
            document.getElementById('modal-challenges').classList.remove('hidden');
        }
        function closeChallengeModal() { document.getElementById('modal-challenges').classList.add('hidden'); }

        function openChallengeInstructions() {
            if (!activeChallenge) return;
            document.getElementById('instruction-modal-title').innerText = activeChallenge.title;
            document.getElementById('instruction-modal-badge').innerText = activeChallenge.levelBadge;
            document.getElementById('instruction-modal-desc').innerText = activeChallenge.desc;

            const stepsContainer = document.getElementById('instruction-modal-steps');
            stepsContainer.innerHTML = '';
            activeChallenge.instructions.forEach(step => {
                const li = document.createElement('li');
                li.innerHTML = step;
                stepsContainer.appendChild(li);
            });

            document.getElementById('modal-instructions').classList.remove('hidden');
        }
        function closeChallengeInstructions() {
            document.getElementById('modal-instructions').classList.add('hidden');
        }

        function closeChallengeBanner() {
            document.getElementById('challenge-banner').classList.add('hidden');
        }

        function filterChallengeTab(filter, btn) {
            document.querySelectorAll('.challenge-tab-btn').forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white');
                b.classList.add('bg-slate-800', 'text-slate-400');
            });
            btn.classList.add('bg-blue-600', 'text-white');
            btn.classList.remove('bg-slate-800', 'text-slate-400');
            renderChallengeCards(filter);
        }

        function renderChallengeCards(filter) {
            const container = document.getElementById('challenge-list-container');
            container.innerHTML = '';

            const filtered = filter === 'all' 
                ? codingChallenges 
                : codingChallenges.filter(c => c.level === filter);

            filtered.forEach(ch => {
                const card = document.createElement('div');
                card.className = 'bg-slate-950 p-5 rounded-2xl border border-slate-800 hover:border-slate-700 transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4';
                
                let badgeColor = 'bg-emerald-950 text-emerald-400 border-emerald-800';
                if (ch.level === 'menengah') badgeColor = 'bg-blue-950 text-blue-400 border-blue-800';
                if (ch.level === 'mahir') badgeColor = 'bg-purple-950 text-purple-400 border-purple-800';

                card.innerHTML = `
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border ${badgeColor}">
                                ${ch.levelBadge}
                            </span>
                            <h3 class="font-extrabold text-sm text-white">${ch.title}</h3>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">${ch.desc}</p>
                    </div>
                    <button onclick="loadChallenge('${ch.id}')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition shrink-0 inline-flex items-center gap-1.5">
                        <span>⚡</span> <span>Muat Latihan Ini</span>
                    </button>
                `;
                container.appendChild(card);
            });
        }

        function loadChallenge(id) {
            const ch = codingChallenges.find(c => c.id === id);
            if (!ch) return;

            activeChallenge = ch;
            htmlEditor.setValue(ch.html);
            cssEditor.setValue(ch.css);
            jsEditor.setValue(ch.js);
            updatePreview();

            // Setup banner aktif
            const banner = document.getElementById('challenge-banner');
            const badge = document.getElementById('challenge-banner-badge');
            const title = document.getElementById('challenge-banner-title');
            const desc = document.getElementById('challenge-banner-desc');

            badge.innerText = ch.levelBadge;
            if (ch.level === 'pemula') badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-900/80 text-emerald-300 border border-emerald-700';
            else if (ch.level === 'menengah') badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-900/80 text-blue-300 border border-blue-700';
            else badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-900/80 text-purple-300 border border-purple-700';

            title.innerText = ch.title;
            desc.innerText = ch.desc;
            banner.classList.remove('hidden');

            closeChallengeModal();
        }

        function resetCurrentChallenge() {
            if (activeChallenge) {
                showCustomConfirm(
                    "Reset Kode Tantangan?",
                    `Kembalikan kode latihan "${activeChallenge.title}" ke kondisi awal? Seluruh perubahan Anda saat ini akan di-reset.`,
                    (confirmed) => {
                        if (confirmed) {
                            loadChallenge(activeChallenge.id);
                            showToast("Kode telah di-reset ke kondisi awal latihan.", "info");
                        }
                    }
                );
            }
        }

        // ========================================================
        // INISIALISASI EDITOR CODEMIRROR
        // ========================================================
        const editorConfig = { theme: 'dracula', lineNumbers: true, tabSize: 2 };
        const htmlEditor = CodeMirror.fromTextArea(document.getElementById('html-code'), { ...editorConfig, mode: 'xml' });
        const cssEditor = CodeMirror.fromTextArea(document.getElementById('css-code'), { ...editorConfig, mode: 'css' });
        const jsEditor = CodeMirror.fromTextArea(document.getElementById('js-code'), { ...editorConfig, mode: 'javascript' });

        function updatePreview() {
            const html = htmlEditor.getValue();
            const css = `<style>${cssEditor.getValue()}</style>`;
            const js = `<script>${jsEditor.getValue()}<\/script>`;
            document.getElementById('preview-frame').srcdoc = `<!DOCTYPE html><html><head><meta charset="utf-8">${css}</head><body>${html}${js}</body></html>`;
        }

        let timeout;
        function debouncePreview() {
            clearTimeout(timeout);
            timeout = setTimeout(updatePreview, 300);
        }

        htmlEditor.on('change', debouncePreview);
        cssEditor.on('change', debouncePreview);
        jsEditor.on('change', debouncePreview);

        function switchTab(tabName, btn) {
            if (window.innerWidth >= 768) return;
            document.querySelectorAll('.pane').forEach(el => {
                el.classList.remove('mobile-flex');
                el.classList.add('mobile-hidden');
            });

            if (tabName === 'html') {
                document.getElementById('pane-html').classList.add('mobile-flex');
                document.getElementById('pane-html').classList.remove('mobile-hidden');
            } else if (tabName === 'css' || tabName === 'js') {
                document.getElementById('wrapper-css-js').classList.add('mobile-flex');
                document.getElementById('wrapper-css-js').classList.remove('mobile-hidden');
                document.getElementById('pane-' + tabName).classList.add('mobile-flex');
                document.getElementById('pane-' + tabName).classList.remove('mobile-hidden');
            } else if (tabName === 'preview') {
                document.getElementById('pane-preview').classList.add('mobile-flex');
                document.getElementById('pane-preview').classList.remove('mobile-hidden');
            }

            setTimeout(() => {
                if (tabName === 'html') htmlEditor.refresh();
                if (tabName === 'css') cssEditor.refresh();
                if (tabName === 'js') jsEditor.refresh();
            }, 50);

            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('text-orange-400', 'border-orange-400', 'bg-slate-850');
                b.classList.add('text-slate-400', 'border-transparent');
            });
            btn.classList.remove('text-slate-400', 'border-transparent');
            btn.classList.add('text-orange-400', 'border-orange-400', 'bg-slate-850');
        }

        // ========================================================
        // FITUR PROGRESI LEVEL 1-10 & PENGIRIMAN KODE
        // ========================================================
        let pendingNextChallenge = null;
        let studentSubmissions = @json($userSubmissions ?? []);

        function kirimKode() {
            const btn = document.getElementById('btn-submit');
            btn.innerHTML = '<span>⏳</span> <span>Menyimpan...</span>';
            btn.disabled = true;

            const challengeTitle = activeChallenge ? activeChallenge.title : 'Eksplorasi Bebas';

            fetch('{{ route("public.playground.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    html_code: htmlEditor.getValue(),
                    css_code: cssEditor.getValue(),
                    js_code: jsEditor.getValue(),
                    challenge_title: challengeTitle
                })
            })
            .then(async res => {
                let data = null;
                try {
                    data = await res.json();
                } catch (e) {}

                if (!res.ok) {
                    const errorMsg = (data && data.message) ? data.message : ('Server merespons status: ' + res.status);
                    throw new Error(errorMsg);
                }
                return data;
            })
            .then(data => {
                btn.innerHTML = '<span>🚀</span> <span>Kirim / Simpan</span>';
                btn.disabled = false;

                // Hitung level berikutnya dari array 10 tantangan
                let currentIdx = -1;
                if (activeChallenge) {
                    currentIdx = codingChallenges.findIndex(c => c.id === activeChallenge.id);
                } else {
                    currentIdx = 0;
                }

                const nextChallenge = (currentIdx >= 0 && currentIdx < codingChallenges.length - 1)
                    ? codingChallenges[currentIdx + 1]
                    : null;

                // Tambahkan entri submisi baru ke memori siswa
                if (data.is_logged_in) {
                    studentSubmissions.unshift({
                        challenge_title: challengeTitle,
                        score: 0,
                        feedback: '',
                        created_at: 'Baru saja',
                        html_code: htmlEditor.getValue(),
                        css_code: cssEditor.getValue(),
                        js_code: jsEditor.getValue()
                    });
                }

                // Tampilkan Modal Berhasil Custom
                openSubmissionSuccessModal(data, activeChallenge, nextChallenge, currentIdx);
            })
            .catch(err => {
                btn.innerHTML = '<span>🚀</span> <span>Kirim / Simpan</span>';
                btn.disabled = false;
                showCustomAlert('Pemberitahuan Sistem', err.message, 'error');
            });
        }

        function openSubmissionSuccessModal(data, currentCh, nextCh, currentIdx) {
            pendingNextChallenge = nextCh;

            document.getElementById('success-modal-message').textContent = data.message || 'Kode berhasil disimpan ke database!';
            document.getElementById('success-current-challenge-title').textContent = currentCh ? currentCh.title : 'Tantangan Koding';

            // XP Badge
            const xpContainer = document.getElementById('success-xp-badge-container');
            if (data.is_logged_in) {
                xpContainer.className = 'mt-4 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-950/80 text-emerald-300 text-xs font-black border border-emerald-700 shadow-inner';
                xpContainer.innerHTML = `<span>⭐ +${data.xp_earned || 25} XP Diperoleh! Total: ${data.total_xp || 0} XP (Level ${data.level || 1})</span>`;
            } else {
                xpContainer.className = 'mt-4 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-800 text-slate-300 text-xs font-bold border border-slate-700 shadow-inner';
                xpContainer.innerHTML = `<span>🌐 Tersimpan dalam Mode Publik (Tamu)</span>`;
            }

            const nextCard = document.getElementById('success-next-level-card');
            const completedCard = document.getElementById('success-all-completed-card');
            const btnNext = document.getElementById('btn-next-level-action');

            if (nextCh) {
                // Masih ada level berikutnya (Level 1..9)
                nextCard.classList.remove('hidden');
                completedCard.classList.add('hidden');
                btnNext.classList.remove('hidden');

                document.getElementById('success-next-level-badge').textContent = `Level ${currentIdx + 2} (${nextCh.levelBadge})`;
                document.getElementById('success-next-level-title').textContent = nextCh.title;
                document.getElementById('success-next-level-desc').textContent = nextCh.desc;
                document.getElementById('btn-next-level-text').textContent = `Lanjut ke Level ${currentIdx + 2} (${nextCh.title})`;
            } else {
                // Sudah Level 10 (Selesai Seluruh Tantangan)
                nextCard.classList.add('hidden');
                btnNext.classList.add('hidden');
                completedCard.classList.remove('hidden');
            }

            document.getElementById('modal-submission-success').classList.remove('hidden');
        }

        function closeSubmissionSuccessModal() {
            document.getElementById('modal-submission-success').classList.add('hidden');
        }

        // Saat tombol "Lanjut ke Level Berikutnya" diklik, munculkan konfirmasi "Lanjut" & "Baca Panduan"
        function onLanjutNextLevelClicked() {
            if (!pendingNextChallenge) return;
            closeSubmissionSuccessModal();
            openConfirmNextLevelModal(pendingNextChallenge);
        }

        function openConfirmNextLevelModal(nextCh) {
            document.getElementById('confirm-next-badge').textContent = nextCh.levelBadge;
            document.getElementById('confirm-next-title').textContent = nextCh.title;
            document.getElementById('confirm-next-desc').textContent = nextCh.desc;
            document.getElementById('modal-confirm-next-level').classList.remove('hidden');
        }

        function closeConfirmNextLevelModal() {
            document.getElementById('modal-confirm-next-level').classList.add('hidden');
        }

        // Pilihan 1: Lanjut Koding Langsung
        function actionConfirmNextDirect() {
            if (!pendingNextChallenge) return;
            const targetCh = pendingNextChallenge;
            closeConfirmNextLevelModal();
            loadChallenge(targetCh.id);
            showToast(`🚀 Memulai ${targetCh.title}! Selamat berkoding.`, 'success');
        }

        // Pilihan 2: Baca Panduan Dulu
        function actionConfirmNextWithGuide() {
            if (!pendingNextChallenge) return;
            const targetCh = pendingNextChallenge;
            closeConfirmNextLevelModal();
            loadChallenge(targetCh.id);
            openChallengeInstructions();
        }

        // ========================================================
        // FITUR LIHAT NILAI & CATATAN GURU SISWA DI PLAYGROUND
        // ========================================================
        function openMyGradesModal() {
            renderMyGrades();
            document.getElementById('modal-my-grades').classList.remove('hidden');
        }

        function closeMyGradesModal() {
            document.getElementById('modal-my-grades').classList.add('hidden');
        }

        function refreshMyGrades() {
            fetch('{{ route("public.playground.grades") }}')
                .then(r => r.json())
                .then(data => {
                    if (data && data.submissions) {
                        studentSubmissions = data.submissions;
                        renderMyGrades();
                        showToast('Riwayat nilai berhasil diperbarui!', 'success');
                    }
                })
                .catch(() => {
                    showToast('Gagal menyinkronkan nilai.', 'error');
                });
        }

        function renderMyGrades() {
            const container = document.getElementById('my-grades-list-container');
            container.innerHTML = '';

            if (!studentSubmissions || studentSubmissions.length === 0) {
                container.innerHTML = `
                    <div class="py-12 text-center text-slate-400 space-y-2">
                        <div class="text-3xl">📭</div>
                        <h4 class="font-bold text-white text-xs">Belum Ada Tugas Terkirim</h4>
                        <p class="text-[11px] text-slate-400">Kirim kode latihan menggunakan tombol "Kirim / Simpan" untuk mendapatkan evaluasi nilai dari guru.</p>
                    </div>
                `;
                return;
            }

            studentSubmissions.forEach((sub, idx) => {
                const card = document.createElement('div');
                card.className = 'bg-slate-950 p-4 rounded-2xl border border-slate-800 space-y-2.5';

                let scoreBadge = '';
                if (sub.score > 0) {
                    let color = 'bg-emerald-950/80 text-emerald-300 border-emerald-700';
                    if (sub.score < 75) color = 'bg-amber-950/80 text-amber-300 border-amber-700';
                    else if (sub.score < 85) color = 'bg-blue-950/80 text-blue-300 border-blue-700';

                    scoreBadge = `<span class="px-2.5 py-1 rounded-xl text-xs font-black border ${color}">Skor: ${sub.score} / 100</span>`;
                } else {
                    scoreBadge = `<span class="px-2.5 py-1 rounded-xl text-[11px] font-bold bg-amber-950/60 text-amber-300 border border-amber-800">⏳ Belum Dinilai Guru</span>`;
                }

                const feedbackHtml = sub.feedback 
                    ? `<div class="p-3 bg-blue-950/40 border border-blue-900/60 rounded-xl text-xs text-blue-200">
                        <span class="font-extrabold text-[10px] text-blue-300 uppercase block mb-0.5">💬 Catatan & Umpan Balik Guru:</span>
                        <p class="text-slate-200 leading-relaxed font-normal">"${sub.feedback}"</p>
                      </div>`
                    : `<div class="text-[11px] text-slate-500 italic">Belum ada catatan khusus dari guru.</div>`;

                const timeStr = sub.created_at ? sub.created_at : '';

                card.innerHTML = `
                    <div class="flex items-center justify-between gap-2">
                        <div class="truncate">
                            <span class="font-black text-white text-xs block truncate">${sub.challenge_title || ('Tugas Koding #' + (idx + 1))}</span>
                            <span class="text-[10px] text-slate-500 font-mono">${timeStr}</span>
                        </div>
                        ${scoreBadge}
                    </div>
                    ${feedbackHtml}
                `;
                container.appendChild(card);
            });
        }

        // ========================================================
        // SISTEM CUSTOM MODAL POPUP & TOAST (BEBAS DEFAULT BROWSER)
        // ========================================================
        let customConfirmCallback = null;

        function showCustomAlert(title, message, type = 'info') {
            const iconEl = document.getElementById('custom-alert-icon');
            if (type === 'error') {
                iconEl.className = 'w-14 h-14 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3 bg-rose-950/60 text-rose-400 border border-rose-800';
                iconEl.innerHTML = '❌';
            } else if (type === 'success') {
                iconEl.className = 'w-14 h-14 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3 bg-emerald-950/60 text-emerald-400 border border-emerald-800';
                iconEl.innerHTML = '✅';
            } else {
                iconEl.className = 'w-14 h-14 rounded-2xl mx-auto flex items-center justify-center text-2xl mb-3 bg-blue-950/60 text-blue-400 border border-blue-800';
                iconEl.innerHTML = 'ℹ️';
            }
            document.getElementById('custom-alert-title').textContent = title;
            document.getElementById('custom-alert-message').textContent = message;
            document.getElementById('modal-custom-alert').classList.remove('hidden');
        }

        function closeCustomAlert() {
            document.getElementById('modal-custom-alert').classList.add('hidden');
        }

        function showCustomConfirm(title, message, callback) {
            document.getElementById('custom-confirm-title').textContent = title;
            document.getElementById('custom-confirm-message').textContent = message;
            customConfirmCallback = callback;
            document.getElementById('modal-custom-confirm').classList.remove('hidden');
        }

        function resolveCustomConfirm(result) {
            document.getElementById('modal-custom-confirm').classList.add('hidden');
            if (typeof customConfirmCallback === 'function') {
                customConfirmCallback(result);
                customConfirmCallback = null;
            }
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto bg-slate-900 border border-slate-700 text-white px-4 py-2.5 rounded-2xl shadow-2xl text-xs flex items-center gap-2 transform transition-all duration-300 translate-y-2 opacity-0';
            let icon = 'ℹ️';
            if (type === 'success') icon = '✅';
            if (type === 'error') icon = '❌';
            toast.innerHTML = `<span>${icon}</span><span class="font-semibold">${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        // ========================================================
        // LOAD DARI URL PARAMETER (INTEGRASI DENGAN PANDUAN)
        // ========================================================
        window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const challengeParam = params.get('challenge');
            if (challengeParam && codingChallenges.some(c => c.id === challengeParam)) {
                loadChallenge(challengeParam);
            } else {
                // Default ke Latihan 1 jika tidak ada parameter
                loadChallenge('html_struktur');
            }
        });
    </script>
</body>
</html>
