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
            <!-- Tombol Pilih Tingkatan & Latihan (FITUR BARU) -->
            <button onclick="openChallengeModal()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-3.5 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-extrabold shadow-md shadow-blue-600/30 flex items-center gap-1.5 transition active:scale-95">
                <span>🎯</span> <span>Tingkatan Koding</span>
                <span class="hidden sm:inline-block px-1.5 py-0.5 rounded bg-white/20 text-[10px]">10 Latihan</span>
            </button>

            <!-- Tombol Petunjuk Kode -->
            <button onclick="openHintModal()" class="bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 px-3 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold flex items-center gap-1.5 transition active:scale-95">
                <span>💡</span> <span class="hidden md:inline">Kamus Kode</span>
            </button>
            
            <!-- Tombol Kirim / Uji Kode -->
            <button id="btn-submit" onclick="kirimKode()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold shadow-md shadow-emerald-600/20 active:scale-95 transition flex items-center gap-1.5">
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
                    Semua (10 Latihan)
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

    <!-- CodeMirror Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>

    <script>
        // ========================================================
        // DATABASE 10 TANTANGAN KODING BERJENJANG
        // ========================================================
        const codingChallenges = [
            // TINGKAT 1: PEMULA
            {
                id: 'html_struktur',
                level: 'pemula',
                levelBadge: '🟢 Pemula (HTML5)',
                title: 'Latihan 1: Struktur Web & Format Teks',
                desc: 'Pelajari susunan dasar tag HTML5, judul, paragraf, penekanan teks, dan tautan halaman.',
                instructions: [
                    'Ubah judul `<h1>` menjadi nama lengkap Anda.',
                    'Tuliskan satu paragraf `<p>` yang menceritakan alasan Anda ingin belajar koding.',
                    'Tambahkan tag `<strong>` pada kata kunci penting dan `<em>` untuk teks miring.',
                    'Ubah atribut `href` pada link `<a>` agar mengarah ke website SMKN 1 Kupang Barat atau situs favorit Anda.'
                ],
                html: `<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Programmer Pemula</title>
</head>
<body>
  <header>
    <h1>Halo, Dunia Pemrograman! 🌍</h1>
    <p>Saya sedang memulai perjalanan koding web interaktif bersama <strong>VxAI Platform</strong>.</p>
  </header>
  
  <main>
    <p>Koding itu <em>sangat seru dan melatih logika berpikir</em>.</p>
    <a href="https://vxai.online" target="_blank">Kunjungi Portal Utama VxAI &rarr;</a>
  </main>
</body>
</html>`,
                css: `body {
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  background-color: #0f172a;
  color: #f1f5f9;
  padding: 3rem 1.5rem;
  max-width: 640px;
  margin: 0 auto;
  line-height: 1.6;
}
h1 {
  color: #38bdf8;
  font-size: 2rem;
  margin-bottom: 0.5rem;
}
a {
  display: inline-block;
  margin-top: 1.25rem;
  color: #60a5fa;
  text-decoration: none;
  font-weight: bold;
}
a:hover {
  text-decoration: underline;
}`,
                js: `console.log("Latihan 1 siap dijalankan!");`
            },

            {
                id: 'html_formulir',
                level: 'pemula',
                levelBadge: '🟢 Pemula (HTML5)',
                title: 'Latihan 2: Formulir Pendaftaran Siswa',
                desc: 'Membangun form kontak interaktif dengan validasi input teks, email, dan respon submit.',
                instructions: [
                    'Lengkapi form dengan kolom input nama dan email.',
                    'Tambahkan atribut `required` agar form tidak bisa dikirim jika kolom kosong.',
                    'Tekan tombol "Kirim Pendaftaran" dan amati respon ucapan selamat di bawahnya.'
                ],
                html: `<div class="form-card">
  <h2>Pendaftaran Siswa Baru 🎓</h2>
  <p>Lengkapi formulir singkat di bawah ini:</p>
  
  <form id="form-daftar">
    <div class="form-group">
      <label for="nama">Nama Lengkap Siswa</label>
      <input type="text" id="nama" placeholder="Misal: Vicky Sanjaya" required>
    </div>

    <div class="form-group">
      <label for="email">Alamat Email / NISN</label>
      <input type="email" id="email" placeholder="siswa@sekolah.sch.id" required>
    </div>

    <button type="submit" id="btn-submit-form">Kirim Pendaftaran &rarr;</button>
  </form>

  <div id="notifikasi-sukses" class="alert-box"></div>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #090d16;
  color: #f8fafc;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.form-card {
  background: #1e293b;
  padding: 2rem 2.5rem;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5);
  border: 1px solid #334155;
}
h2 { color: #38bdf8; margin: 0 0 0.5rem 0; font-size: 1.5rem; }
p { color: #94a3b8; font-size: 0.85rem; margin-bottom: 1.5rem; }
.form-group { margin-bottom: 1.25rem; text-align: left; }
label { display: block; font-size: 0.8rem; font-weight: bold; margin-bottom: 0.5rem; color: #cbd5e1; }
input {
  width: 100%;
  box-sizing: border-box;
  padding: 0.75rem 1rem;
  background: #0f172a;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  color: white;
  outline: none;
  font-size: 0.9rem;
}
input:focus { border-color: #38bdf8; ring: 2px #38bdf8; }
button {
  width: 100%;
  padding: 0.85rem;
  background: #2563eb;
  color: white;
  border: none;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
  transition: 0.2s;
  font-size: 0.95rem;
}
button:hover { background: #1d4ed8; }
.alert-box {
  display: none;
  margin-top: 1.25rem;
  padding: 0.85rem;
  background: #064e3b;
  color: #6ee7b7;
  border-radius: 0.75rem;
  font-size: 0.85rem;
  text-align: center;
  border: 1px solid #059669;
}`,
                js: `document.getElementById('form-daftar').addEventListener('submit', function(e) {
  e.preventDefault();
  const nama = document.getElementById('nama').value;
  const alertBox = document.getElementById('notifikasi-sukses');
  
  alertBox.style.display = 'block';
  alertBox.innerHTML = '🎉 Selamat <b>' + nama + '</b>, berkas pendaftaran Anda telah diterima sistem!';
});`
            },

            {
                id: 'html_tabel',
                level: 'pemula',
                levelBadge: '🟢 Pemula (HTML5)',
                title: 'Latihan 3: Tabel Data Nilai Siswa',
                desc: 'Menyusun tabel data terstruktur dengan thead, tbody, baris, kolom, dan badge status.',
                instructions: [
                    'Pelajari struktur tag `<table>`, `<thead>`, `<tbody>`, `<tr>`, `<th>`, dan `<td>`.',
                    'Tambahkan satu baris siswa baru di dalam `<tbody>`.',
                    'Ubah status kelulusan dengan menambahkan class `badge-lulus` atau `badge-remedial`.'
                ],
                html: `<div class="table-container">
  <h2>Rekap Nilai Koding Web 📊</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Materi</th>
        <th>Skor</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Budi Pratama</td>
        <td>HTML5 Dasar</td>
        <td>95</td>
        <td><span class="badge badge-lulus">Lulus</span></td>
      </tr>
      <tr>
        <td>2</td>
        <td>Siti Rahma</td>
        <td>CSS3 Flexbox</td>
        <td>88</td>
        <td><span class="badge badge-lulus">Lulus</span></td>
      </tr>
      <tr>
        <td>3</td>
        <td>Ahmad Dani</td>
        <td>JavaScript DOM</td>
        <td>65</td>
        <td><span class="badge badge-remedial">Remedial</span></td>
      </tr>
    </tbody>
  </table>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #0f172a;
  color: #f8fafc;
  padding: 2.5rem 1.5rem;
}
.table-container {
  max-width: 700px;
  margin: 0 auto;
  background: #1e293b;
  padding: 2rem;
  border-radius: 1.5rem;
  border: 1px solid #334155;
}
h2 { color: #38bdf8; margin-top: 0; }
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
  font-size: 0.9rem;
}
th, td {
  padding: 0.85rem 1rem;
  text-align: left;
  border-bottom: 1px solid #334155;
}
th {
  background: #0f172a;
  color: #94a3b8;
  text-transform: uppercase;
  font-size: 0.75rem;
  letter-spacing: 0.05em;
}
tr:hover { background: #334155/30; }
.badge {
  padding: 0.25rem 0.6rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: bold;
}
.badge-lulus { background: #064e3b; color: #6ee7b7; }
.badge-remedial { background: #7f1d1d; color: #fca5a5; }`,
                js: `console.log("Tabel data berhasil dimuat!");`
            },

            // TINGKAT 2: MENENGAH (CSS3)
            {
                id: 'css_flexbox',
                level: 'menengah',
                levelBadge: '🔵 Menengah (CSS3)',
                title: 'Latihan 4: Tata Letak Flexbox Modern',
                desc: 'Menguasai perataan layout modern: navbar responsif, hero card, dan tombol sejajar rapi.',
                instructions: [
                    'Gunakan `display: flex` pada elemen kontainer navbar.',
                    'Atur perataan horizontal dengan `justify-content: space-between` dan vertikal dengan `align-items: center`.',
                    'Eksplorasi penataan 3 kartu keunggulan sejajar dengan properti `gap: 1.5rem`.'
                ],
                html: `<nav class="navbar">
  <div class="logo">⚡ VxAI Lab</div>
  <div class="nav-links">
    <a href="#">Beranda</a>
    <a href="#">Materi</a>
    <a href="#">Tantangan</a>
  </div>
  <button class="btn-login">Masuk</button>
</nav>

<div class="hero">
  <h1>Kuasai Flexbox Sekarang 🚀</h1>
  <p>Flexbox membuat penataan elemen sejajar menjadi sangat mudah dan presisi.</p>
  
  <div class="cards-container">
    <div class="card">
      <h3>⚡ Cepat</h3>
      <p>Tanpa float atau kalkulasi manual rumit.</p>
    </div>
    <div class="card">
      <h3>📱 Responsif</h3>
      <p>Menyesuaikan otomatis di layar HP dan laptop.</p>
    </div>
    <div class="card">
      <h3>🎯 Presisi</h3>
      <p>Elemen selalu terpusat sempurna di tengah.</p>
    </div>
  </div>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #0b1120;
  color: #f8fafc;
  margin: 0;
  padding: 0;
}
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background: #1e293b;
  border-bottom: 1px solid #334155;
}
.logo { font-weight: 900; font-size: 1.25rem; color: #38bdf8; }
.nav-links { display: flex; gap: 1.5rem; }
.nav-links a { color: #cbd5e1; text-decoration: none; font-size: 0.9rem; font-weight: 600; }
.nav-links a:hover { color: #38bdf8; }
.btn-login {
  background: #2563eb;
  color: white;
  border: none;
  padding: 0.5rem 1.2rem;
  border-radius: 9999px;
  font-weight: bold;
  cursor: pointer;
}
.hero {
  padding: 3rem 2rem;
  text-align: center;
  max-width: 900px;
  margin: 0 auto;
}
.cards-container {
  display: flex;
  gap: 1.5rem;
  margin-top: 2.5rem;
  flex-wrap: wrap;
}
.card {
  flex: 1;
  min-width: 220px;
  background: #1e293b;
  padding: 1.5rem;
  border-radius: 1.25rem;
  border: 1px solid #334155;
  text-align: left;
}
.card h3 { color: #38bdf8; margin-top: 0; }`,
                js: `console.log("Flexbox layout loaded successfully!");`
            },

            {
                id: 'css_grid',
                level: 'menengah',
                levelBadge: '🔵 Menengah (CSS3)',
                title: 'Latihan 5: CSS Grid Portofolio Responsif',
                desc: 'Membuat grid galeri kartu proyek otomatis dengan repeat auto-fit dan minmax.',
                instructions: [
                    'Gunakan `display: grid` pada kontainer galeri.',
                    'Terapkan `grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));` agar kolom otomatis fleksibel.',
                    'Beri jarak antar kartu dengan properti `gap: 1.5rem`.'
                ],
                html: `<div class="container">
  <div class="header">
    <h2>Portofolio Siswa SMKN 1 Kupang Barat 🌟</h2>
    <p>Koleksi karya koding website inovatif</p>
  </div>

  <div class="grid-gallery">
    <div class="project-card">
      <div class="badge">Web App</div>
      <h3>Sistem Perpustakaan</h3>
      <p>Aplikasi peminjaman buku digital dengan pencarian cepat.</p>
    </div>
    <div class="project-card">
      <div class="badge">AI Lab</div>
      <h3>Tutor Pintar AI</h3>
      <p>Asisten belajar mandiri untuk pemula pemrograman.</p>
    </div>
    <div class="project-card">
      <div class="badge">Frontend</div>
      <h3>Kalkulator Fisika</h3>
      <p>Simulasi rumus gerak dan gravitasi interaktif.</p>
    </div>
    <div class="project-card">
      <div class="badge">Game</div>
      <h3>Kuis Trivia Koding</h3>
      <p>Uji ketangkasan logika dengan leaderboard poin.</p>
    </div>
  </div>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #090e17;
  color: #f1f5f9;
  padding: 2.5rem 1.5rem;
  margin: 0;
}
.container { max-width: 1000px; margin: 0 auto; }
.header { text-align: center; margin-bottom: 2.5rem; }
.header h2 { color: #38bdf8; font-size: 1.8rem; margin: 0; }
.header p { color: #94a3b8; }
.grid-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
}
.project-card {
  background: #1e293b;
  padding: 1.75rem;
  border-radius: 1.25rem;
  border: 1px solid #334155;
  transition: transform 0.2s, border-color 0.2s;
}
.project-card:hover {
  transform: translateY(-5px);
  border-color: #38bdf8;
}
.badge {
  display: inline-block;
  background: #0284c7/30;
  color: #38bdf8;
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: bold;
  margin-bottom: 1rem;
}
.project-card h3 { margin: 0 0 0.5rem 0; font-size: 1.15rem; }
.project-card p { color: #94a3b8; font-size: 0.85rem; line-height: 1.5; margin: 0; }`,
                js: `console.log("CSS Grid layout ready!");`
            },

            {
                id: 'css_animation',
                level: 'menengah',
                levelBadge: '🔵 Menengah (CSS3)',
                title: 'Latihan 6: Glassmorphism & Animasi Hover',
                desc: 'Menciptakan efek kaca transparan blur dan animasi hover interaktif modern.',
                instructions: [
                    'Gunakan `backdrop-filter: blur(16px)` untuk efek buram ala kaca transparan.',
                    'Gunakan transisi `transition: all 0.3s cubic-bezier(...)` untuk kehalusan gerakan.',
                    'Tambahkan animasi denyut `@keyframes glow` pada tombol aksi.'
                ],
                html: `<div class="background-scene">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="glass-box">
    <div class="icon">✨</div>
    <h2>Efek Glassmorphism</h2>
    <p>Desain kaca transparan modern yang elegan, lembut di mata, dan memberikan kedalaman visual.</p>
    <button class="btn-glow">Coba Efek Kaca</button>
  </div>
</div>`,
                css: `body {
  margin: 0;
  background: #0f172a;
  font-family: system-ui, sans-serif;
  color: white;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}
.background-scene { position: relative; padding: 2rem; }
.blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(60px);
  z-index: 0;
}
.blob-1 { width: 180px; height: 180px; background: #2563eb; top: -30px; left: -30px; }
.blob-2 { width: 180px; height: 180px; background: #ec4899; bottom: -30px; right: -30px; }
.glass-box {
  position: relative;
  z-index: 1;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1px solid rgba(255, 255, 255, 0.18);
  border-radius: 2rem;
  padding: 3rem 2.5rem;
  max-width: 380px;
  text-align: center;
  box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
  transition: transform 0.3s;
}
.glass-box:hover { transform: translateY(-8px); }
.icon { font-size: 2.5rem; margin-bottom: 1rem; }
h2 { margin: 0 0 0.75rem 0; font-size: 1.5rem; }
p { color: #cbd5e1; font-size: 0.9rem; line-height: 1.6; margin-bottom: 2rem; }
.btn-glow {
  background: linear-gradient(135deg, #38bdf8, #2563eb);
  color: white;
  border: none;
  padding: 0.8rem 1.8rem;
  border-radius: 9999px;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0 10px 20px -5px rgba(56, 189, 248, 0.5);
  transition: 0.2s;
}
.btn-glow:hover { transform: scale(1.05); }`,
                js: `console.log("Glassmorphism effect ready!");`
            },

            // TINGKAT 3: MAHIR (JAVASCRIPT)
            {
                id: 'js_counter_theme',
                level: 'mahir',
                levelBadge: '🟣 Mahir (JavaScript)',
                title: 'Latihan 7: Counter & Pengalih Tema (Dark/Light)',
                desc: 'Manipulasi nilai angka di DOM, event listener klik, dan manipulasi class mode tampilan.',
                instructions: [
                    'Klik tombol `+` dan `-` untuk menambah dan mengurangi nilai counter.',
                    'Periksa logika JavaScript yang membatasi nilai minimum atau mengubah warna angka saat bernilai negatif.',
                    'Gunakan tombol "Alihkan Tema" untuk mengubah warna kartu antara tema terang dan gelap.'
                ],
                html: `<div class="card" id="main-card">
  <div class="top-bar">
    <span class="badge">Aplikasi Interaktif</span>
    <button id="btn-theme" class="theme-btn">☀️ Mode Terang</button>
  </div>

  <h2>Penghitung Angka (Counter) 🔢</h2>
  <div id="counter-value" class="counter-display">0</div>

  <div class="button-group">
    <button id="btn-dec" class="action-btn btn-danger">- Kurang</button>
    <button id="btn-reset" class="action-btn btn-neutral">↺ Reset</button>
    <button id="btn-inc" class="action-btn btn-success">+ Tambah</button>
  </div>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #090e17;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  transition: background 0.3s;
}
.card {
  background: #1e293b;
  color: #f8fafc;
  padding: 2.5rem;
  border-radius: 1.5rem;
  width: 360px;
  text-align: center;
  border: 1px solid #334155;
  box-shadow: 0 20px 25px rgba(0,0,0,0.4);
  transition: all 0.3s;
}
.card.light-mode {
  background: #ffffff;
  color: #0f172a;
  border-color: #cbd5e1;
}
.top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
.badge { font-size: 0.75rem; font-weight: bold; color: #38bdf8; }
.theme-btn {
  background: #334155;
  color: white;
  border: none;
  padding: 0.3rem 0.7rem;
  border-radius: 0.5rem;
  font-size: 0.75rem;
  cursor: pointer;
}
.card.light-mode .theme-btn { background: #e2e8f0; color: #0f172a; }
.counter-display {
  font-size: 4rem;
  font-weight: 900;
  color: #38bdf8;
  margin: 1.5rem 0;
  font-family: monospace;
}
.button-group { display: flex; gap: 0.75rem; justify-content: center; }
.action-btn {
  padding: 0.65rem 1.2rem;
  border-radius: 0.75rem;
  border: none;
  font-weight: bold;
  cursor: pointer;
  font-size: 0.9rem;
}
.btn-danger { background: #ef4444; color: white; }
.btn-neutral { background: #64748b; color: white; }
.btn-success { background: #10b981; color: white; }`,
                js: `let count = 0;
let isLight = false;

const counterDisplay = document.getElementById('counter-value');
const card = document.getElementById('main-card');
const themeBtn = document.getElementById('btn-theme');

document.getElementById('btn-inc').addEventListener('click', () => {
  count++;
  counterDisplay.innerText = count;
});

document.getElementById('btn-dec').addEventListener('click', () => {
  count--;
  counterDisplay.innerText = count;
});

document.getElementById('btn-reset').addEventListener('click', () => {
  count = 0;
  counterDisplay.innerText = count;
});

themeBtn.addEventListener('click', () => {
  isLight = !isLight;
  if (isLight) {
    card.classList.add('light-mode');
    themeBtn.innerText = '🌙 Mode Gelap';
  } else {
    card.classList.remove('light-mode');
    themeBtn.innerText = '☀️ Mode Terang';
  }
});`
            },

            {
                id: 'js_todolist',
                level: 'mahir',
                levelBadge: '🟣 Mahir (JavaScript)',
                title: 'Latihan 8: Aplikasi To-Do List Lengkap',
                desc: 'Membangun aplikasi manajemen kegiatan: tambah tugas baru, coret selesai, dan hapus tugas.',
                instructions: [
                    'Ketik tugas di kolom input dan klik tombol "Tambah".',
                    'Klik pada teks tugas untuk mencoret (menandai selesai).',
                    'Klik ikon hapus (✕) untuk membuang tugas dari daftar.'
                ],
                html: `<div class="todo-app">
  <h2>Daftar Tugas Koding 📝</h2>
  <div class="input-wrapper">
    <input type="text" id="input-todo" placeholder="Tulis tugas baru...">
    <button id="btn-add">Tambah</button>
  </div>

  <ul id="todo-list" class="list">
    <li class="completed"><span>Belajar Dasar HTML5</span><button class="btn-del">&times;</button></li>
    <li><span>Menyusun Tata Letak Flexbox</span><button class="btn-del">&times;</button></li>
  </ul>
  
  <div class="footer-info" id="todo-count">Total: 2 tugas</div>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #0f172a;
  color: #f8fafc;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.todo-app {
  background: #1e293b;
  padding: 2.5rem;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 440px;
  box-shadow: 0 20px 25px rgba(0,0,0,0.5);
  border: 1px solid #334155;
}
h2 { color: #38bdf8; margin: 0 0 1.5rem 0; font-size: 1.4rem; text-align: center; }
.input-wrapper { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
input {
  flex: 1;
  padding: 0.75rem 1rem;
  background: #0f172a;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  color: white;
  outline: none;
}
input:focus { border-color: #38bdf8; }
#btn-add {
  background: #2563eb;
  color: white;
  border: none;
  padding: 0.75rem 1.25rem;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
}
.list { list-style: none; padding: 0; margin: 0; }
.list li {
  background: #0f172a;
  padding: 0.75rem 1rem;
  border-radius: 0.75rem;
  margin-bottom: 0.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  border: 1px solid #334155;
  transition: 0.2s;
}
.list li.completed span { text-decoration: line-through; color: #64748b; }
.btn-del {
  background: #ef4444/20;
  color: #ef4444;
  border: none;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  cursor: pointer;
  font-weight: bold;
}
.footer-info {
  margin-top: 1.25rem;
  font-size: 0.75rem;
  color: #94a3b8;
  text-align: right;
}`,
                js: `const input = document.getElementById('input-todo');
const btnAdd = document.getElementById('btn-add');
const list = document.getElementById('todo-list');
const countInfo = document.getElementById('todo-count');

function updateCount() {
  const items = list.querySelectorAll('li').length;
  countInfo.innerText = 'Total: ' + items + ' tugas';
}

function addTodo() {
  const val = input.value.trim();
  if (!val) return;

  const li = document.createElement('li');
  li.innerHTML = '<span>' + val + '</span><button class="btn-del">&times;</button>';
  
  li.querySelector('span').addEventListener('click', () => {
    li.classList.toggle('completed');
  });

  li.querySelector('.btn-del').addEventListener('click', (e) => {
    e.stopPropagation();
    li.remove();
    updateCount();
  });

  list.appendChild(li);
  input.value = '';
  updateCount();
}

btnAdd.addEventListener('click', addTodo);
input.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') addTodo();
});

// Bind existing
list.querySelectorAll('li').forEach(li => {
  li.querySelector('span').addEventListener('click', () => li.classList.toggle('completed'));
  li.querySelector('.btn-del').addEventListener('click', (e) => {
    e.stopPropagation();
    li.remove();
    updateCount();
  });
});`
            },

            {
                id: 'js_kalkulator',
                level: 'mahir',
                levelBadge: '🟣 Mahir (JavaScript)',
                title: 'Latihan 9: Kalkulator Cepat & Generator Motivasi',
                desc: 'Menerapkan logika perhitungan angka dan memilih data acak (random quote generator).',
                instructions: [
                    'Ketik dua angka dan pilih operasi matematika (Tambah, Kurang, Kali, Bagi).',
                    'Klik tombol "Hitung Hasil" untuk menampilkan kalkulasi di layar.',
                    'Klik tombol "Kutipan Motivasi" untuk merandom kata-kata inspirasi teknologi.'
                ],
                html: `<div class="calc-box">
  <h2>Kalkulator Mini VxAI 🧮</h2>

  <div class="inputs">
    <input type="number" id="num1" value="12" placeholder="Angka 1">
    <select id="operator">
      <option value="+">+</option>
      <option value="-">-</option>
      <option value="*">&times;</option>
      <option value="/">&divide;</option>
    </select>
    <input type="number" id="num2" value="8" placeholder="Angka 2">
  </div>

  <button id="btn-calc" class="btn-primary">Hitung Hasil</button>
  <div class="result" id="output-calc">= 20</div>

  <hr class="divider">

  <button id="btn-quote" class="btn-secondary">💡 Dapatkan Kutipan Koding</button>
  <p id="quote-text" class="quote">"Satu-satunya cara melakukan pekerjaan hebat adalah mencintai apa yang Anda kerjakan."</p>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #0b1120;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.calc-box {
  background: #1e293b;
  padding: 2.5rem;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 380px;
  border: 1px solid #334155;
  text-align: center;
}
h2 { color: #38bdf8; margin: 0 0 1.5rem 0; font-size: 1.35rem; }
.inputs { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
input, select {
  padding: 0.75rem;
  background: #0f172a;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  color: white;
  outline: none;
  font-weight: bold;
}
input { flex: 1; text-align: center; font-size: 1.1rem; }
select { font-size: 1.1rem; }
.btn-primary {
  width: 100%;
  padding: 0.8rem;
  background: #2563eb;
  color: white;
  border: none;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
}
.result {
  font-size: 2rem;
  font-weight: 900;
  color: #38bdf8;
  margin: 1rem 0;
}
.divider { border: none; border-top: 1px solid #334155; margin: 1.5rem 0; }
.btn-secondary {
  background: #334155;
  color: #f8fafc;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 0.75rem;
  font-size: 0.8rem;
  font-weight: bold;
  cursor: pointer;
}
.quote {
  font-style: italic;
  font-size: 0.85rem;
  color: #94a3b8;
  margin-top: 1rem;
  line-height: 1.5;
}`,
                js: `document.getElementById('btn-calc').addEventListener('click', function() {
  const n1 = parseFloat(document.getElementById('num1').value) || 0;
  const n2 = parseFloat(document.getElementById('num2').value) || 0;
  const op = document.getElementById('operator').value;
  let res = 0;

  if (op === '+') res = n1 + n2;
  else if (op === '-') res = n1 - n2;
  else if (op === '*') res = n1 * n2;
  else if (op === '/') res = n2 !== 0 ? (n1 / n2).toFixed(2) : 'Tak Hingga';

  document.getElementById('output-calc').innerText = '= ' + res;
});

const quotes = [
  '"Satu-satunya cara melakukan pekerjaan hebat adalah mencintai apa yang Anda kerjakan." - Steve Jobs',
  '"Koding bukan tentang mengetik sintaks, melainkan tentang menyelesaikan masalah." - Anonim',
  '"Jangan takut berbuat salah saat menulis kode; bug adalah guru terbaik." - Programmer',
  '"Generasi muda SMKN 1 Kupang Barat siap memimpin era Kecerdasan Buatan!" - VxAI'
];

document.getElementById('btn-quote').addEventListener('click', function() {
  const rand = quotes[Math.floor(Math.random() * quotes.length)];
  document.getElementById('quote-text').innerText = rand;
});`
            },

            {
                id: 'js_ai_bot',
                level: 'mahir',
                levelBadge: '🟣 Mahir (JavaScript & AI)',
                title: 'Latihan 10: Simulator Asisten AI Interaktif',
                desc: 'Membuat jendela obrolan chat simulasi AI dengan animasi gelembung percakapan responsif.',
                instructions: [
                    'Ketik pertanyaan di kotak teks (misal: "Apa itu HTML?", "Siapa kamu?", atau "Tips koding").',
                    'Tekan enter atau tombol kirim untuk memunculkan pesan di riwayat obrolan.',
                    'Amati balasan bot cerdas yang disimulasikan melalui logika percabangan JavaScript!'
                ],
                html: `<div class="chat-container">
  <div class="chat-header">
    <div class="avatar">🤖</div>
    <div>
      <div class="bot-name">VxAI Tutor Bot</div>
      <div class="bot-status">● Online & Siap Membantu</div>
    </div>
  </div>

  <div class="chat-messages" id="chat-box">
    <div class="message bot">
      Halo! Saya asisten virtual belajar koding VxAI. Tanyakan apa saja tentang HTML, CSS, atau JavaScript! 👋
    </div>
  </div>

  <form id="chat-form" class="chat-input-bar">
    <input type="text" id="user-input" placeholder="Ketik pertanyaan koding Anda..." required>
    <button type="submit">Kirim &rarr;</button>
  </form>
</div>`,
                css: `body {
  font-family: system-ui, sans-serif;
  background: #0b1120;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.chat-container {
  background: #1e293b;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 440px;
  height: 520px;
  display: flex;
  flex-col;
  flex-direction: column;
  border: 1px solid #334155;
  overflow: hidden;
  box-shadow: 0 25px 50px rgba(0,0,0,0.5);
}
.chat-header {
  background: #0f172a;
  padding: 1rem 1.25rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  border-bottom: 1px solid #334155;
}
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
}
.bot-name { font-weight: bold; font-size: 0.9rem; }
.bot-status { font-size: 0.7rem; color: #10b981; }
.chat-messages {
  flex: 1;
  padding: 1rem;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}
.message {
  max-width: 80%;
  padding: 0.75rem 1rem;
  border-radius: 1rem;
  font-size: 0.85rem;
  line-height: 1.5;
}
.message.bot {
  background: #0f172a;
  color: #f1f5f9;
  align-self: flex-start;
  border-bottom-left-radius: 0.25rem;
  border: 1px solid #334155;
}
.message.user {
  background: #2563eb;
  color: white;
  align-self: flex-end;
  border-bottom-right-radius: 0.25rem;
}
.chat-input-bar {
  display: flex;
  padding: 0.75rem;
  background: #0f172a;
  border-top: 1px solid #334155;
  gap: 0.5rem;
}
.chat-input-bar input {
  flex: 1;
  background: #1e293b;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  padding: 0.65rem 1rem;
  color: white;
  outline: none;
  font-size: 0.85rem;
}
.chat-input-bar button {
  background: #2563eb;
  color: white;
  border: none;
  padding: 0.65rem 1.2rem;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
}`,
                js: `const form = document.getElementById('chat-form');
const input = document.getElementById('user-input');
const chatBox = document.getElementById('chat-box');

function appendMessage(sender, text) {
  const msg = document.createElement('div');
  msg.className = 'message ' + sender;
  msg.innerText = text;
  chatBox.appendChild(msg);
  chatBox.scrollTop = chatBox.scrollHeight;
}

form.addEventListener('submit', function(e) {
  e.preventDefault();
  const query = input.value.trim();
  if (!query) return;

  appendMessage('user', query);
  input.value = '';

  setTimeout(() => {
    let reply = 'Pertanyaan menarik! Cobalah bereksperimen langsung dengan kode di editor kiri.';
    const qLower = query.toLowerCase();

    if (qLower.includes('html')) {
      reply = 'HTML (HyperText Markup Language) adalah kerangka utama halaman web. Setiap konten teks dan tombol dibungkus oleh tag HTML!';
    } else if (qLower.includes('css')) {
      reply = 'CSS (Cascading Style Sheets) berfungsi menghias website agar berwarna, rapi dengan Flexbox/Grid, dan nyaman dipandang.';
    } else if (qLower.includes('javascript') || qLower.includes('js')) {
      reply = 'JavaScript adalah otak dari website! Tanpa JS, web Anda statis. Dengan JS, tombol bisa diklik dan animasi bisa bergerak.';
    } else if (qLower.includes('halo') || qLower.includes('hai')) {
      reply = 'Halo juga sahabat koding! Ada materi yang ingin kamu latih hari ini?';
    }

    appendMessage('bot', reply);
  }, 400);
});`
            }
        ];

        // ========================================================
        // KONTROL EDITOR CODEMIRROR & TAMPILAN
        // ========================================================
        let activeChallenge = null;

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
                if (confirm("Reset kode ke kondisi awal latihan ini?")) {
                    loadChallenge(activeChallenge.id);
                }
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

        function kirimKode() {
            const btn = document.getElementById('btn-submit');
            btn.innerHTML = '<span>⏳</span> <span>Menyimpan...</span>';
            btn.disabled = true;

            fetch('{{ route("public.playground.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    html_code: htmlEditor.getValue(),
                    css_code: cssEditor.getValue(),
                    js_code: jsEditor.getValue()
                })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                btn.innerHTML = '<span>🚀</span> <span>Kirim / Simpan</span>';
                btn.disabled = false;
            })
            .catch(err => {
                alert('Gagal mengirim kode. Periksa koneksi internet Anda.');
                btn.innerHTML = '<span>🚀</span> <span>Kirim / Simpan</span>';
                btn.disabled = false;
            });
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
