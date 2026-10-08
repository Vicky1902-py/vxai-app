<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ruang Belajar & Nilai Siswa - {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</title>
    
    <!-- Favicon -->
    @if(!empty($settings['app_favicon']))
        <link rel="icon" href="{{ asset($settings['app_favicon']) }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre, .font-mono { font-family: 'JetBrains Mono', monospace !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(15, 23, 42, 0.6); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(51, 65, 85, 0.8); border-radius: 9999px; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <!-- ======================================================== -->
    <!-- TOP NAVIGATION BAR (RESPONSIF DESKTOP & MOBILE)           -->
    <!-- ======================================================== -->
    <header class="h-16 shrink-0 bg-slate-900/90 backdrop-blur-md border-b border-slate-800 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-blue-500/20 group-hover:scale-105 transition">Vx</span>
                <div>
                    <span class="font-extrabold text-sm text-white tracking-tight block leading-none">Ruang Siswa</span>
                    <span class="text-[10px] text-blue-400 font-medium">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                </div>
            </a>
        </div>

        <!-- Menu Desktop -->
        <nav class="hidden md:flex items-center gap-2">
            <a href="{{ route('public.playground') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-600/30 transition flex items-center gap-1.5">
                <span>⚡</span> <span>Live Coding Lab</span>
            </a>
            <a href="{{ route('public.leaderboard') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-800 transition flex items-center gap-1.5">
                <span>🏆</span> <span>Papan Peringkat</span>
            </a>
            <a href="{{ route('public.learning') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-800 transition flex items-center gap-1.5">
                <span>📖</span> <span>Panduan</span>
            </a>
            <a href="{{ route('public.certificate') }}" target="_blank" class="px-3 py-1.5 rounded-xl text-xs font-bold text-emerald-400 hover:bg-emerald-950/40 border border-emerald-800/60 transition flex items-center gap-1.5">
                <span>📜</span> <span>Sertifikat</span>
            </a>
        </nav>

        <!-- Profil & Logout -->
        <div class="flex items-center gap-3">
            <div class="hidden sm:flex items-center gap-2.5 bg-slate-850 px-3 py-1.5 rounded-xl border border-slate-800 text-xs">
                <span class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-[11px]">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
                <span class="font-bold text-white max-w-[120px] truncate">{{ $user->name }}</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-900/60 text-blue-300 border border-blue-700 font-bold">
                    Lv. {{ $user->level }}
                </span>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-rose-400 hover:text-white hover:bg-rose-950/50 border border-rose-900/60 px-3 py-1.5 rounded-xl transition flex items-center gap-1">
                    <span>🚪</span> <span class="hidden sm:inline">Keluar</span>
                </button>
            </form>
        </div>
    </header>

    <!-- ======================================================== -->
    <!-- KONTEN UTAMA RUANG BELAJAR                               -->
    <!-- ======================================================== -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- 1. Hero Card: Status XP, Level & Progres Gamifikasi -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-950 via-slate-900 to-slate-950 border border-blue-900/40 p-6 sm:p-8 shadow-2xl">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-900/60 text-blue-300 text-xs font-bold border border-blue-700/80 mb-3">
                        <span>🚀</span> <span>Selamat Datang Kembali</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-2">
                        <span>Halo, {{ $user->name }}!</span>
                        <span class="inline-block animate-wave">👋</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 max-w-xl leading-relaxed">
                        Pantau riwayat pengerjaan tugas koding Anda, tinjau masukan dan evaluasi guru secara real-time, serta terus tingkatkan level keahlian koding Anda.
                    </p>
                </div>

                <!-- Tombol Aksi Cepat Masuk Playground & Panduan -->
                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                    <a href="{{ route('public.playground') }}" class="flex-1 md:flex-initial inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-500 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-sm shadow-lg shadow-blue-600/30 active:scale-95 transition">
                        <span>⚡</span> <span>Buka Live Playground</span>
                    </a>
                    <a href="{{ route('public.news.detail', 'panduan-lengkap-siswa-belajar-koding-vxai-playground-sampai-selesai') }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-indigo-950/80 hover:bg-indigo-900 text-indigo-300 border border-indigo-700/60 text-xs font-bold transition">
                        <span>📖</span> <span>Panduan Koding</span>
                    </a>
                    <a href="{{ route('public.leaderboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-bold transition">
                        <span>🏆</span> <span>Papan Skor</span>
                    </a>
                </div>
            </div>

            <!-- Kartu Statistik Siswa -->
            @php
                $xpCurrent = $user->xp ?? 0;
                $levelCurrent = $user->level ?? 1;
                $xpInCurrentLevel = $xpCurrent % 100;
                $xpPercent = min(100, max(5, $xpInCurrentLevel));
            @endphp
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-6 pt-6 border-t border-slate-800/80">
                <!-- Stat 1: Keahlian & Level -->
                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Status Keahlian</span>
                    <div class="text-xl sm:text-2xl font-black text-blue-400 flex items-center gap-1.5">
                        <span>Level {{ $levelCurrent }}</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full mt-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-full rounded-full transition-all duration-500" style="width: {{ $xpPercent }}%"></div>
                    </div>
                    <span class="text-[10px] text-slate-500 mt-1 block font-mono">{{ $xpInCurrentLevel }}/100 XP ke Lv. {{ $levelCurrent + 1 }}</span>
                </div>

                <!-- Stat 2: Total XP -->
                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Pengalaman</span>
                    <div class="text-xl sm:text-2xl font-black text-amber-400 flex items-center gap-1.5">
                        <span>⭐ {{ number_format($xpCurrent) }}</span>
                        <span class="text-xs text-amber-500/80 font-normal">XP</span>
                    </div>
                    <span class="text-[10px] text-slate-500 mt-2 block">+25 XP setiap kirim tugas</span>
                </div>

                <!-- Stat 3: Tugas Terkirim -->
                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Tugas Dikirim</span>
                    <div class="text-xl sm:text-2xl font-black text-white">
                        {{ $totalSubmissions }} <span class="text-xs text-slate-400 font-normal">Tugas</span>
                    </div>
                    <span class="text-[10px] text-emerald-400 mt-2 block">
                        ✅ {{ $gradedSubmissions }} Sudah Dinilai Guru
                    </span>
                </div>

                <!-- Stat 4: Rata-Rata Nilai -->
                <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-800">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Rata-Rata Nilai</span>
                    <div class="text-xl sm:text-2xl font-black {{ $averageScore >= 80 ? 'text-emerald-400' : ($averageScore >= 70 ? 'text-blue-400' : 'text-amber-400') }}">
                        @if($gradedSubmissions > 0)
                            {{ $averageScore }} <span class="text-xs text-slate-400 font-normal">/ 100</span>
                        @else
                            <span class="text-sm text-slate-400 font-normal">Belum ada nilai</span>
                        @endif
                    </div>
                    <span class="text-[10px] text-slate-500 mt-2 block">
                        {{ $totalSubmissions - $gradedSubmissions }} Tugas menunggu evaluasi
                    </span>
                </div>
            </div>
        </div>

        <!-- 2. Section: Riwayat Tugas, Nilai, dan Catatan Guru -->
        <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-950/60">
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>📊</span> <span>Hasil Evaluasi & Nilai Tugas Koding Siswa</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Berikut adalah daftar tugas yang telah Anda kirimkan dari Playground beserta nilai dan catatan bimbingan guru.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold border border-slate-700">
                        Total: {{ $totalSubmissions }} Submisi
                    </span>
                </div>
            </div>

            <!-- Daftar Submisi Siswa -->
            <div class="p-4 sm:p-6 space-y-4">
                @forelse ($mySubmissions as $sub)
                    <div class="bg-slate-950 rounded-2xl p-5 border border-slate-800 hover:border-slate-700 transition flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5">
                        
                        <!-- Info Submisi -->
                        <div class="flex-1 space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-900/60 text-blue-300 border border-blue-700">
                                    {{ !empty($sub->challenge_title) ? $sub->challenge_title : 'Latihan Koding Interaktif' }}
                                </span>
                                <span class="text-xs text-slate-500 font-mono">
                                    🕒 {{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M Y, H:i') }} ({{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }})
                                </span>
                            </div>

                            <!-- Nilai & Status Badge -->
                            <div class="flex items-center gap-3 pt-1">
                                @if ($sub->score > 0)
                                    @php
                                        $badgeBg = 'bg-emerald-950/80 text-emerald-300 border-emerald-700';
                                        $labelGrade = 'Sangat Baik';
                                        if ($sub->score < 75) {
                                            $badgeBg = 'bg-amber-950/80 text-amber-300 border-amber-700';
                                            $labelGrade = 'Cukup Baik';
                                        } elseif ($sub->score < 85) {
                                            $badgeBg = 'bg-blue-950/80 text-blue-300 border-blue-700';
                                            $labelGrade = 'Baik';
                                        }
                                    @endphp
                                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl border {{ $badgeBg }}">
                                        <span class="text-sm font-black">🎯 Nilai: {{ $sub->score }} / 100</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded bg-black/30">({{ $labelGrade }})</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-950/60 text-amber-300 border border-amber-800 text-xs font-bold">
                                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                        <span>⏳ Menunggu Penilaian Guru / Admin</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Kotak Catatan / Feedback Guru -->
                            @if (!empty($sub->feedback))
                                <div class="mt-3 p-3.5 bg-blue-950/40 border border-blue-900/70 rounded-2xl text-xs text-slate-200 flex items-start gap-3">
                                    <span class="text-xl shrink-0 mt-0.5">💬</span>
                                    <div class="flex-1">
                                        <span class="font-extrabold text-[11px] text-blue-300 uppercase tracking-wider block mb-0.5">
                                            Catatan & Umpan Balik Guru:
                                        </span>
                                        <p class="text-slate-300 leading-relaxed font-normal">
                                            "{{ $sub->feedback }}"
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="text-[11px] text-slate-500 italic mt-1">
                                    💬 Belum ada catatan khusus dari guru untuk tugas ini.
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Aksi Inspeksi Kode -->
                        <div class="flex items-center gap-2.5 shrink-0 w-full lg:w-auto">
                            <button onclick="bukaModalLihatKode(this)"
                                    data-title="{{ !empty($sub->challenge_title) ? $sub->challenge_title : 'Tugas Koding Siswa' }}"
                                    data-score="{{ $sub->score ?? 0 }}"
                                    data-feedback="{{ $sub->feedback ?? '' }}"
                                    data-time="{{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M Y, H:i') }}"
                                    data-html="{{ base64_encode($sub->html_code ?? '') }}"
                                    data-css="{{ base64_encode($sub->css_code ?? '') }}"
                                    data-js="{{ base64_encode($sub->js_code ?? '') }}"
                                    class="flex-1 lg:flex-initial inline-flex items-center justify-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-blue-400 hover:text-white px-4 py-2.5 rounded-xl text-xs font-bold border border-slate-700 transition">
                                <span>🔍</span> <span>Lihat Kode & Tampilan</span>
                            </button>

                            <a href="{{ route('public.playground') }}" class="inline-flex items-center justify-center gap-1 bg-blue-600/20 hover:bg-blue-600 text-blue-300 hover:text-white px-3.5 py-2.5 rounded-xl text-xs font-bold border border-blue-600/40 transition" title="Lanjut koding">
                                <span>⚡</span>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="py-16 text-center text-slate-400 space-y-3">
                        <div class="text-5xl">💻</div>
                        <h3 class="text-base font-bold text-white">Belum Ada Tugas yang Dikirimkan</h3>
                        <p class="text-xs text-slate-400 max-w-md mx-auto">
                            Anda belum pernah mengirim kode dari Playground. Mulai selesaikan 10 tingkatan tantangan koding sekarang untuk mengumpulkan XP dan nilai!
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('public.playground') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-md transition">
                                <span>🚀</span> <span>Mulai Tantangan Level 1</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

    <!-- ======================================================== -->
    <!-- MODAL EKSPANSIF: INSPEKSI KODE SISWA, LIVE PREVIEW & HASIL -->
    <!-- ======================================================== -->
    <div id="modal-siswa-kode" class="fixed inset-0 bg-slate-950/85 z-[100] hidden flex items-center justify-center p-2 sm:p-4 backdrop-blur-md">
        <div class="bg-slate-900 text-slate-100 rounded-3xl shadow-2xl w-full max-w-[97vw] h-[94vh] max-h-[94vh] flex flex-col overflow-hidden border border-slate-700/80">
            
            <!-- Modal Header -->
            <div class="p-4 sm:px-6 sm:py-3.5 border-b border-slate-800 bg-slate-950 flex flex-wrap justify-between items-center gap-3 shrink-0">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-lg font-bold shadow-md shadow-blue-500/20">
                        🔬
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-black text-white text-base" id="modal-code-title">Tinjau Kode & Hasil Live Tugas</h3>
                            <span id="modal-code-challenge-badge" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-900/60 text-blue-300 border border-blue-700">
                                -
                            </span>
                        </div>
                        <span class="text-xs text-slate-400" id="modal-code-subtitle">Dikirim pada: -</span>
                    </div>
                </div>

                <!-- Mode View Switcher: Split (Dampingan) vs Full Preview vs Full Code -->
                <div class="flex items-center gap-2">
                    <div class="flex items-center bg-slate-850 p-1 rounded-xl text-xs font-bold border border-slate-800">
                        <button type="button" id="tab-btn-siswa-split" onclick="switchSiswaModalView('split')" class="px-3.5 py-1.5 rounded-lg bg-blue-600 text-white shadow-sm transition flex items-center gap-1.5" title="Tampilkan Kode & Live Output berdampingan">
                            <span>🌓</span> <span>Dampingan (Split)</span>
                        </button>
                        <button type="button" id="tab-btn-siswa-preview" onclick="switchSiswaModalView('preview')" class="px-3.5 py-1.5 rounded-lg text-slate-400 hover:text-white transition flex items-center gap-1.5" title="Layar penuh live output hasil render">
                            <span>⚡</span> <span>Preview Penuh</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        </button>
                        <button type="button" id="tab-btn-siswa-code" onclick="switchSiswaModalView('code')" class="px-3.5 py-1.5 rounded-lg text-slate-400 hover:text-white transition flex items-center gap-1.5" title="Layar penuh kode sintaksis">
                            <span>💻</span> <span>Kode Penuh</span>
                        </button>
                    </div>

                    <!-- Simulator Ukuran Layar untuk Preview -->
                    <div id="device-simulator-siswa" class="hidden sm:flex items-center bg-slate-850 p-1 rounded-xl text-[11px] font-bold border border-slate-800">
                        <button type="button" onclick="setSiswaFrameDevice('desktop')" id="dev-siswa-desktop" class="px-2.5 py-1 rounded-lg bg-blue-600 text-white shadow-xs transition" title="Lebar Desktop">💻 100%</button>
                        <button type="button" onclick="setSiswaFrameDevice('tablet')" id="dev-siswa-tablet" class="px-2.5 py-1 rounded-lg text-slate-400 hover:text-white transition" title="Lebar Tablet (768px)">📱 Tablet</button>
                        <button type="button" onclick="setSiswaFrameDevice('mobile')" id="dev-siswa-mobile" class="px-2.5 py-1 rounded-lg text-slate-400 hover:text-white transition" title="Lebar Smartphone (375px)">📱 Mobile</button>
                        <button type="button" onclick="reloadSiswaFrame()" class="px-2 py-1 text-slate-400 hover:text-blue-400 transition" title="Muat Ulang Frame">🔄</button>
                        <button type="button" onclick="openSiswaPreviewInNewTab()" class="px-2 py-1 text-slate-400 hover:text-blue-400 transition" title="Buka di Tab Baru">↗</button>
                    </div>

                    <button onclick="tutupModalSiswaKode()" class="text-slate-400 hover:text-white font-bold text-3xl leading-none px-2 transition">&times;</button>
                </div>
            </div>

            <!-- Main Workspace: Fleksibel & Menempati Seluruh Sisa Layar Modal (Tinggi Lega) -->
            <div id="modal-siswa-workspace" class="flex-1 min-h-0 flex flex-col md:flex-row bg-slate-950 overflow-hidden relative">
                
                <!-- Panel Kiri: Editor Sintaksis (HTML, CSS, JS) -->
                <div id="panel-siswa-code" class="flex-1 flex flex-col md:flex-row gap-2 p-3 overflow-y-auto custom-scrollbar bg-slate-950 border-r border-slate-800 transition-all duration-200">
                    <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                        <div class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 flex justify-between items-center text-xs font-mono font-bold text-orange-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                <span>HTML5 Markup</span>
                            </span>
                            <span class="text-[10px] text-slate-500">index.html</span>
                        </div>
                        <pre id="siswa-code-html" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                    </div>
                    
                    <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                        <div class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 flex justify-between items-center text-xs font-mono font-bold text-blue-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span>CSS3 Styling</span>
                            </span>
                            <span class="text-[10px] text-slate-500">style.css</span>
                        </div>
                        <pre id="siswa-code-css" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                    </div>
                    
                    <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                        <div class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 flex justify-between items-center text-xs font-mono font-bold text-yellow-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                <span>JavaScript Logic</span>
                            </span>
                            <span class="text-[10px] text-slate-500">script.js</span>
                        </div>
                        <pre id="siswa-code-js" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                    </div>
                </div>

                <!-- Panel Kanan: Live Preview Frame -->
                <div id="panel-siswa-preview" class="flex-1 flex flex-col bg-slate-900 transition-all duration-200 overflow-hidden relative">
                    <div class="px-4 py-2 bg-slate-950 border-b border-slate-800 text-xs font-bold text-slate-300 flex justify-between items-center shrink-0">
                        <span class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-white">Hasil Tampilan Langsung (Live Rendered)</span>
                        </span>
                        <span class="text-[11px] text-slate-400 font-mono" id="preview-siswa-dimension-label">100% Layar Penuh</span>
                    </div>
                    <div class="flex-1 bg-slate-950 p-2 sm:p-3 overflow-auto flex items-center justify-center">
                        <iframe id="siswa-preview-frame" class="w-full h-full bg-white rounded-2xl border border-slate-800 shadow-2xl transition-all duration-200" sandbox="allow-scripts allow-modals"></iframe>
                    </div>
                </div>

            </div>

            <!-- Modal Footer: Nilai, Feedback Guru & Tombol Aksi -->
            <div class="p-4 sm:px-6 sm:py-3.5 border-t border-slate-800 bg-slate-950 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 shrink-0">
                <div id="modal-code-grade-info" class="text-xs">
                    <!-- Dinamis -->
                </div>
                <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                    <button type="button" onclick="muatKodeKePlayground()" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-extrabold text-xs shadow-md shadow-blue-600/30 transition flex items-center gap-1.5">
                        <span>⚡</span> <span>Buka & Edit di Playground</span>
                    </button>
                    <button onclick="tutupModalSiswaKode()" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Kontrol Modal Siswa -->
    <script>
        let modalRawHtml = '';
        let modalRawCss = '';
        let modalRawJs = '';
        let currentSiswaLayoutMode = 'split';

        function bukaModalLihatKode(btn) {
            const title = btn.getAttribute('data-title');
            const score = parseInt(btn.getAttribute('data-score') || '0', 10);
            const feedback = btn.getAttribute('data-feedback');
            const time = btn.getAttribute('data-time');

            modalRawHtml = decodeURIComponent(escape(atob(btn.getAttribute('data-html'))));
            modalRawCss = decodeURIComponent(escape(atob(btn.getAttribute('data-css'))));
            modalRawJs = decodeURIComponent(escape(atob(btn.getAttribute('data-js'))));

            document.getElementById('modal-code-title').textContent = title;
            document.getElementById('modal-code-challenge-badge').textContent = title;
            document.getElementById('modal-code-subtitle').textContent = 'Dikirim pada: ' + time;

            document.getElementById('siswa-code-html').textContent = modalRawHtml || '<!-- Kosong -->';
            document.getElementById('siswa-code-css').textContent = modalRawCss || '/* Kosong */';
            document.getElementById('siswa-code-js').textContent = modalRawJs || '/* Kosong */';

            renderSiswaPreviewFrame();

            // Info nilai & feedback di footer
            let gradeHtml = '';
            if (score > 0) {
                gradeHtml = `<span class="text-emerald-400 font-black text-sm">🎯 Nilai: ${score}/100</span>`;
                if (feedback) {
                    gradeHtml += `<span class="text-slate-300 ml-2 bg-slate-850 px-3 py-1 rounded-xl border border-slate-700">💬 Catatan Guru: "${feedback}"</span>`;
                }
            } else {
                gradeHtml = `<span class="text-amber-400 font-bold bg-amber-950/60 px-3 py-1 rounded-xl border border-amber-800">⏳ Status: Belum dinilai guru</span>`;
            }
            document.getElementById('modal-code-grade-info').innerHTML = gradeHtml;

            // Default ke Split di desktop, atau Preview di layar sempit (< 768px)
            if (window.innerWidth < 768) {
                switchSiswaModalView('preview');
            } else {
                switchSiswaModalView('split');
            }

            document.getElementById('modal-siswa-kode').classList.remove('hidden');
        }

        function renderSiswaPreviewFrame() {
            const doc = `<!DOCTYPE html><html><head><meta charset="utf-8"><style>${modalRawCss}</style></head><body>${modalRawHtml}<script>${modalRawJs}<\/script></body></html>`;
            document.getElementById('siswa-preview-frame').srcdoc = doc;
        }

        function reloadSiswaFrame() {
            renderSiswaPreviewFrame();
        }

        function openSiswaPreviewInNewTab() {
            const doc = `<!DOCTYPE html><html><head><meta charset="utf-8"><title>Hasil Koding Siswa</title><style>${modalRawCss}</style></head><body>${modalRawHtml}<script>${modalRawJs}<\/script></body></html>`;
            const blob = new Blob([doc], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            window.open(url, '_blank');
        }

        function switchSiswaModalView(mode) {
            currentSiswaLayoutMode = mode;
            const panelCode = document.getElementById('panel-siswa-code');
            const panelPreview = document.getElementById('panel-siswa-preview');
            const btnSplit = document.getElementById('tab-btn-siswa-split');
            const btnPreview = document.getElementById('tab-btn-siswa-preview');
            const btnCode = document.getElementById('tab-btn-siswa-code');

            [btnSplit, btnPreview, btnCode].forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                b.classList.add('text-slate-400');
            });

            if (mode === 'split') {
                btnSplit.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
                btnSplit.classList.remove('text-slate-400');

                panelCode.classList.remove('hidden');
                panelCode.classList.add('flex', 'md:w-1/2');
                panelCode.classList.remove('md:w-full');

                panelPreview.classList.remove('hidden');
                panelPreview.classList.add('flex', 'md:w-1/2');
                panelPreview.classList.remove('md:w-full');

            } else if (mode === 'preview') {
                btnPreview.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
                btnPreview.classList.remove('text-slate-400');

                panelCode.classList.add('hidden');
                panelCode.classList.remove('flex');

                panelPreview.classList.remove('hidden');
                panelPreview.classList.add('flex', 'w-full');
                panelPreview.classList.remove('md:w-1/2');

            } else if (mode === 'code') {
                btnCode.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
                btnCode.classList.remove('text-slate-400');

                panelPreview.classList.add('hidden');
                panelPreview.classList.remove('flex');

                panelCode.classList.remove('hidden');
                panelCode.classList.add('flex', 'w-full');
                panelCode.classList.remove('md:w-1/2');
            }
        }

        function setSiswaFrameDevice(device) {
            const iframe = document.getElementById('siswa-preview-frame');
            const dimLabel = document.getElementById('preview-siswa-dimension-label');
            const btnDesk = document.getElementById('dev-siswa-desktop');
            const btnTab = document.getElementById('dev-siswa-tablet');
            const btnMob = document.getElementById('dev-siswa-mobile');

            [btnDesk, btnTab, btnMob].forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white', 'shadow-xs');
                b.classList.add('text-slate-400');
            });

            if (device === 'tablet') {
                btnTab.classList.add('bg-blue-600', 'text-white', 'shadow-xs');
                btnTab.classList.remove('text-slate-400');
                iframe.style.width = '768px';
                iframe.style.maxWidth = '100%';
                dimLabel.textContent = 'Mode Tablet (768px)';
            } else if (device === 'mobile') {
                btnMob.classList.add('bg-blue-600', 'text-white', 'shadow-xs');
                btnMob.classList.remove('text-slate-400');
                iframe.style.width = '375px';
                iframe.style.maxWidth = '100%';
                dimLabel.textContent = 'Mode Smartphone (375px)';
            } else {
                btnDesk.classList.add('bg-blue-600', 'text-white', 'shadow-xs');
                btnDesk.classList.remove('text-slate-400');
                iframe.style.width = '100%';
                dimLabel.textContent = '100% Layar Penuh';
            }
        }

        function muatKodeKePlayground() {
            sessionStorage.setItem('vxai_load_html', modalRawHtml);
            sessionStorage.setItem('vxai_load_css', modalRawCss);
            sessionStorage.setItem('vxai_load_js', modalRawJs);
            window.location.href = '{{ route("public.playground") }}?load=custom';
        }

        function tutupModalSiswaKode() {
            document.getElementById('modal-siswa-kode').classList.add('hidden');
        }
    </script>
</body>
</html>