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
        // DATABASE TANTANGAN KODING BERJENJANG (DINAMIS DARI DATABASE)
        // ========================================================
        const codingChallenges = @json($challenges ?? []);

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
