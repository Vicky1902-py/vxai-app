@extends('layouts.admin')

@section('title', 'Dashboard Real-Time & Pemantau Sistem - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Ringkasan Monitoring & Analitik Real-Time')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- BARIS 1: AAPANEL SYSTEM STATUS & LIVE STREAM SWITCH -->
    <!-- ======================================================== -->
    <div class="bg-slate-900 text-white p-5 sm:p-6 rounded-3xl shadow-xl border border-slate-800 space-y-4">
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 border-b border-slate-800/80 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-xl shadow-lg shadow-blue-500/25">
                    ⚡
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-black tracking-tight text-white">aaPanel System Monitor & Real-Time Traffic</h2>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">v4.5 PRO</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Pemantau kinerja server, alokasi memori, kapasitas penyimpanan, dan arus lalu lintas pengunjung langsung.
                    </p>
                </div>
            </div>

            <!-- Tombol Switch Auto-Refresh Real-Time -->
            <div class="flex items-center gap-3 bg-slate-800/90 px-4 py-2 rounded-2xl border border-slate-700/80">
                <div class="flex items-center gap-2">
                    <span id="live-indicator-dot" class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span id="live-indicator-text" class="text-xs font-bold text-emerald-400">● LIVE STREAM</span>
                </div>
                <div class="h-4 w-px bg-slate-700"></div>
                <button type="button" onclick="toggleAutoRefresh()" id="btn-toggle-refresh" class="text-xs font-bold text-slate-300 hover:text-white transition">
                    Jeda Otomatis
                </button>
                <span class="text-[10px] text-slate-500 font-mono" id="live-last-sync">Sync: {{ now()->format('H:i:s') }}</span>
            </div>
        </div>

        <!-- 4 AAPANEL CIRCULAR RESOURCE GAUGES -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
            
            <!-- GAUGE 1: CPU / SERVER LOAD -->
            <div class="bg-slate-800/60 p-4 rounded-2xl border border-slate-700/60 flex items-center gap-4 hover:border-slate-600 transition">
                <div class="relative w-20 h-20 shrink-0 flex items-center justify-center">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-700" stroke-width="3.5" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="{{ $cpuPercent > 75 ? 'text-rose-500' : 'text-blue-500' }} transition-all duration-1000 ease-out" 
                              stroke-dasharray="{{ $cpuPercent }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute flex flex-col items-center justify-center text-center">
                        <span class="text-sm font-black text-white">{{ $cpuPercent }}%</span>
                        <span class="text-[8px] font-bold text-slate-400">CPU</span>
                    </div>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Beban Server</span>
                    <span class="text-xs font-bold {{ $cpuPercent > 75 ? 'text-rose-400' : 'text-emerald-400' }}">
                        {{ $cpuPercent > 75 ? 'Tinggi' : 'Lancar (Normal)' }}
                    </span>
                    <span class="text-[10px] text-slate-400 block mt-0.5 font-mono">Load: {{ $loadAvgStr }}</span>
                </div>
            </div>

            <!-- GAUGE 2: RAM MEMORY -->
            <div class="bg-slate-800/60 p-4 rounded-2xl border border-slate-700/60 flex items-center gap-4 hover:border-slate-600 transition">
                <div class="relative w-20 h-20 shrink-0 flex items-center justify-center">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-700" stroke-width="3.5" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="text-indigo-500 transition-all duration-1000 ease-out" 
                              stroke-dasharray="{{ $ramPercent }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute flex flex-col items-center justify-center text-center">
                        <span class="text-sm font-black text-white">{{ $ramPercent }}%</span>
                        <span class="text-[8px] font-bold text-slate-400">RAM</span>
                    </div>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Memori RAM</span>
                    <span class="text-xs font-bold text-indigo-300 font-mono">{{ $ramUsedMb }} MB</span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">dari total {{ $ramTotalMb }} MB</span>
                </div>
            </div>

            <!-- GAUGE 3: STORAGE DISK -->
            <div class="bg-slate-800/60 p-4 rounded-2xl border border-slate-700/60 flex items-center gap-4 hover:border-slate-600 transition">
                <div class="relative w-20 h-20 shrink-0 flex items-center justify-center">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-700" stroke-width="3.5" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="text-sky-500 transition-all duration-1000 ease-out" 
                              stroke-dasharray="{{ $diskPercent }}, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute flex flex-col items-center justify-center text-center">
                        <span class="text-sm font-black text-white">{{ $diskPercent }}%</span>
                        <span class="text-[8px] font-bold text-slate-400">DISK</span>
                    </div>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Penyimpanan Harddisk</span>
                    <span class="text-xs font-bold text-sky-300 font-mono">{{ $diskUsedGb }} GB / {{ $diskTotalGb }} GB</span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">Sisa bebas {{ $diskFreeGb }} GB</span>
                </div>
            </div>

            <!-- GAUGE 4: REAL-TIME AUDIENCE (ONLINE NOW) -->
            <div class="bg-slate-800/60 p-4 rounded-2xl border border-slate-700/60 flex items-center gap-4 hover:border-slate-600 transition">
                <div class="relative w-20 h-20 shrink-0 flex items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-500/10 border-2 border-emerald-500/40 flex items-center justify-center relative">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-ping absolute"></span>
                        <span class="text-2xl">👥</span>
                    </div>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Online Saat Ini</span>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-lg font-black text-emerald-400" id="live-online-count">{{ number_format($onlineVisitors) }}</span>
                        <span class="text-xs font-bold text-slate-300">Pengunjung</span>
                    </div>
                    <span class="text-[10px] text-emerald-400/90 block font-semibold">● Aktif 5 Menit Terakhir</span>
                </div>
            </div>

        </div>

        <!-- SYSTEM SPECS FOOTER BAR -->
        <div class="flex flex-wrap items-center justify-between text-[11px] text-slate-400 pt-3 border-t border-slate-800/80 gap-3">
            <div class="flex flex-wrap items-center gap-4">
                <span>🖥️ <strong>OS:</strong> {{ $serverOs }}</span>
                <span>⚡ <strong>Web Engine:</strong> {{ $serverSoftware }}</span>
                <span>🐘 <strong>PHP:</strong> {{ $phpVersion }}</span>
                <span>🗄️ <strong>Database:</strong> {{ strtoupper($dbDriver) }} (Connected ● Normal)</span>
            </div>
            <div class="text-slate-500">
                Host: <span class="font-mono text-slate-400">{{ request()->getHost() }}</span>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- BARIS 2: STATUS ADSENSE & GOOGLE SEARCH CONSOLE -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- Status Google AdSense -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl {{ ($settings['adsense_status'] ?? 'false') === 'true' ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center text-2xl font-bold shadow-sm">
                    💰
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-sm font-bold text-slate-900">Google AdSense</h4>
                        @if(($settings['adsense_status'] ?? 'false') === 'true')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">● Tayang Aktif</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">Nonaktif</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5 font-mono">
                        {{ !empty($settings['adsense_client_id']) ? $settings['adsense_client_id'] : 'ID Penayang belum diset' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.settings') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3.5 py-2 rounded-xl transition">
                Atur AdSense ⚙️
            </a>
        </div>

        <!-- Status Google Search Console & Sitemap -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold shadow-sm">
                    🔍
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-sm font-bold text-slate-900">Google Search Console & SEO</h4>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">● Terhubung</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5 font-mono">
                        Sitemap: <a href="{{ url('/sitemap.xml') }}" target="_blank" class="text-blue-600 hover:underline">/sitemap.xml</a>
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.settings') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition">
                Kelola SEO Hub
            </a>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- BARIS 3: 6 KARTU METRIK UTAMA REAL-TIME -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        
        <!-- Kunjungan Hari Ini -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kunjungan Hari Ini</span>
                <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">📈</span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-2 tracking-tight" id="live-today-visits">{{ number_format($todayVisits) }}</div>
            <div class="text-[10px] text-emerald-600 font-bold mt-1.5 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Hit Pengunjung Riil</span>
            </div>
        </div>

        <!-- Trafik 7 Hari -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Trafik 7 Hari</span>
                <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">🗓️</span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ number_format($weeklyVisits) }}</div>
            <div class="text-[10px] text-slate-400 font-medium mt-1.5">Akumulasi Kunjungan</div>
        </div>

        <!-- Total Pembaca Berita Riil (Tanpa Data Dummy) -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pembaca Berita</span>
                <span class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xs font-bold">👁️</span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-2 tracking-tight" id="live-total-views">{{ number_format($totalArticleViews) }}</div>
            <div class="text-[10px] text-emerald-600 font-bold mt-1.5">
                ● 100% Pembaca Asli
            </div>
        </div>

        <!-- Total Submisi Koding -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Submisi Koding</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xs font-bold">⚡</span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-2 tracking-tight" id="live-total-submissions">{{ number_format($totalSubmissions) }}</div>
            <div class="text-[10px] text-slate-400 font-medium mt-1.5">Siswa & Tamu Publik</div>
        </div>

        <!-- Modul Playground -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Modul Playground</span>
                <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xs font-bold">🎮</span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ number_format($totalChallenges ?? 0) }}</div>
            <div class="text-[10px] text-purple-600 font-bold mt-1.5">
                <a href="{{ route('admin.playground') }}" class="hover:underline">Kelola Modul ➔</a>
            </div>
        </div>

        <!-- Pengguna Terdaftar -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Akun</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">👥</span>
            </div>
            <div class="text-2xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ number_format($totalSiswa + $totalGuru) }}</div>
            <div class="text-[10px] text-slate-500 font-medium mt-1.5">{{ $totalSiswa }} Siswa • {{ $totalGuru }} Guru</div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- BARIS 4: LIVE TRAFFIC STREAM & TOP READ ARTICLES (REAL) -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KOLOM KIRI (2/3): LIVE TRAFFIC STREAM (REAL-TIME LOG) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                            <span>🌐</span> <span>Log 10 Kunjungan Terkini (Live Traffic Stream)</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Mencatat aktivitas pengunjung asli secara real-time dari setiap klik halaman</p>
                    </div>
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200/80 px-3 py-1 rounded-full flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <span>Auto-Tracking Real-Time</span>
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="px-5 py-3.5">Waktu</th>
                                <th class="px-5 py-3.5">Alamat IP</th>
                                <th class="px-5 py-3.5">Halaman Dituju</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5">Perangkat</th>
                                <th class="px-5 py-3.5">Browser</th>
                            </tr>
                        </thead>
                        <tbody id="traffic-stream-tbody" class="divide-y divide-slate-100 bg-white">
                            @forelse($recentTraffic as $traffic)
                                <tr class="hover:bg-slate-50/80 transition duration-150">
                                    <td class="px-5 py-3.5 text-slate-500 whitespace-nowrap text-[11px]">
                                        {{ \Carbon\Carbon::parse($traffic->visited_at)->diffForHumans() }}
                                    </td>
                                    <td class="px-5 py-3.5 font-mono text-slate-700 font-semibold text-[11px]">
                                        🛡️ {{ $traffic->ip_address }}
                                    </td>
                                    <td class="px-5 py-3.5 font-mono font-bold text-blue-600 truncate max-w-xs">
                                        /{{ ltrim($traffic->page_url, '/') }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            200 OK
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold {{ $traffic->device == 'Mobile' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $traffic->device }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-600 font-medium">
                                        {{ $traffic->browser }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-400">Belum ada kunjungan terbaru yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-4 bg-slate-50/70 border-t border-slate-100 text-center text-[11px] text-slate-400">
                Menampilkan 10 jejak kunjungan paling mutakhir • Total sesi tercatat: <strong class="text-slate-800">{{ number_format($totalVisits) }}</strong>
            </div>
        </div>

        <!-- KOLOM KANAN (1/3): BERITA PALING RAMAI DIBACA (REAL VIEWS) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                            <span>🔥</span> <span>Berita Terpopuler</span>
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Peringkat artikel berdasarkan pembaca asli murni</p>
                    </div>
                    <a href="{{ route('admin.articles') }}" class="text-[11px] font-bold text-blue-600 hover:underline">Semua ➔</a>
                </div>

                @php $maxViews = $topArticles->max('views_count') ?: 1; @endphp
                <div class="space-y-4 pt-3">
                    @forelse($topArticles as $topArt)
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <a href="{{ route('public.news.detail', $topArt->slug) }}" target="_blank" class="text-xs font-bold text-slate-800 hover:text-blue-600 line-clamp-1">
                                    {{ $topArt->title }}
                                </a>
                                <span class="text-xs font-extrabold text-blue-600 whitespace-nowrap">
                                    {{ number_format($topArt->views_count) }} 👁️
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-700" style="width: {{ $maxViews > 0 ? ($topArt->views_count / $maxViews) * 100 : 0 }}%"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-400">
                                <span>Kategori: <strong class="text-slate-600 uppercase">{{ $topArt->category }}</strong></span>
                                <span>Murni Real-Time</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-slate-400 text-xs">
                            Belum ada artikel berita yang diterbitkan.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 text-center">
                <span class="text-[11px] text-slate-400 block mb-2">Total Pembaca Terakumulasi: <strong class="text-slate-800">{{ number_format($totalArticleViews) }} views</strong></span>
                <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition">
                    <span>+ Tulis Artikel Baru</span>
                </a>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- BARIS 5: ANALISIS PERANGKAT & HALAMAN PALING RAMAI -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Halaman Terpopuler (Top Visited Pages) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm">
            <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <span>📊</span> <span>Halaman Paling Banyak Dikunjungi (Top Pages)</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Analisis rute yang paling sering dibuka oleh audiens</p>
                </div>
                <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2.5 py-1 rounded-lg">Real-time</span>
            </div>

            <div class="space-y-3.5">
                @php $maxVisits = $topPages->max('total') ?: 1; @endphp
                @forelse($topPages as $page)
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5 font-semibold">
                            <span class="font-mono text-blue-600">/{{ ltrim($page->page_url, '/') }}</span>
                            <span class="text-slate-900 font-bold">{{ number_format($page->total) }} tayangan</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2.5 rounded-full" style="width: {{ ($page->total / $maxVisits) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-400 text-xs">
                        Belum ada data kunjungan yang tercatat di sistem.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Proporsi Perangkat Pengunjung -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2 mb-1">
                    <span>📱</span> <span>Perangkat Pengunjung</span>
                </h3>
                <p class="text-xs text-slate-400 mb-6">Persentase akses desktop vs smartphone</p>

                @php $totalDevice = ($deviceDesktop + $deviceMobile + $deviceTablet) ?: 1; @endphp
                <div class="space-y-4">
                    <!-- Desktop -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span class="flex items-center gap-1.5">💻 Desktop / Laptop</span>
                            <span>{{ round(($deviceDesktop / $totalDevice) * 100) }}% ({{ $deviceDesktop }})</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($deviceDesktop / $totalDevice) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Mobile -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span class="flex items-center gap-1.5">📱 Smartphone (HP)</span>
                            <span>{{ round(($deviceMobile / $totalDevice) * 100) }}% ({{ $deviceMobile }})</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ ($deviceMobile / $totalDevice) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Tablet -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span class="flex items-center gap-1.5">📟 Tablet</span>
                            <span>{{ round(($deviceTablet / $totalDevice) * 100) }}% ({{ $deviceTablet }})</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ ($deviceTablet / $totalDevice) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-slate-100 mt-6 text-center text-xs text-slate-400">
                Total Sesi Kunjungan: <strong class="text-slate-800">{{ number_format($totalVisits) }}</strong>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- BARIS 6: SUBMISI KODING TERBARU -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <span>💻</span> <span>Hasil Koding Masuk Terkini</span>
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Tinjau dan berikan evaluasi nilai untuk kode siswa/tamu</p>
            </div>
            <a href="{{ route('admin.submissions') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-xl transition">
                Lihat Semua Submisi ➔
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($recentSubmissions as $sub)
                <div class="p-5 flex items-center justify-between hover:bg-slate-50 transition">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black text-sm shadow-sm">
                            {{ substr($sub->student_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">{{ $sub->student_name }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                Dikirim {{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($sub->score > 0)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                Nilai: {{ $sub->score }}/100
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                Belum Dinilai
                            </span>
                        @endif
                        <a href="{{ route('admin.submissions') }}" class="text-xs bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 font-bold px-3.5 py-1.5 rounded-xl transition">
                            Periksa Kode
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-slate-400 text-xs">
                    Belum ada submisi koding yang masuk dari Playground.
                </div>
            @endforelse
        </div>
    </div>

</div>

@push('scripts')
<script>
    var isLiveActive = true;
    var liveTimer = null;

    function toggleAutoRefresh() {
        var btn = document.getElementById('btn-toggle-refresh');
        var dot = document.getElementById('live-indicator-dot');
        var text = document.getElementById('live-indicator-text');

        if (isLiveActive) {
            isLiveActive = false;
            clearInterval(liveTimer);
            btn.innerText = 'Mulai Live';
            dot.classList.remove('animate-ping');
            dot.classList.add('bg-slate-500');
            text.innerText = '● JEDA';
            text.className = 'text-xs font-bold text-slate-400';
        } else {
            isLiveActive = true;
            btn.innerText = 'Jeda Otomatis';
            dot.classList.add('animate-ping');
            dot.classList.remove('bg-slate-500');
            dot.classList.add('bg-emerald-500');
            text.innerText = '● LIVE STREAM';
            text.className = 'text-xs font-bold text-emerald-400';
            pollLiveStats();
            startPolling();
        }
    }

    function pollLiveStats() {
        if (!isLiveActive) return;

        fetch('{{ route('admin.api.live_stats') }}')
            .then(function(res) { return res.json(); })
            .then(function(data) {
                // Update counter numbers
                if (data.online_visitors !== undefined) {
                    document.getElementById('live-online-count').innerText = data.online_visitors.toLocaleString();
                }
                if (data.today_visits !== undefined) {
                    document.getElementById('live-today-visits').innerText = data.today_visits.toLocaleString();
                }
                if (data.total_article_views !== undefined) {
                    document.getElementById('live-total-views').innerText = data.total_article_views.toLocaleString();
                }
                if (data.total_submissions !== undefined) {
                    document.getElementById('live-total-submissions').innerText = data.total_submissions.toLocaleString();
                }
                if (data.timestamp) {
                    document.getElementById('live-last-sync').innerText = 'Sync: ' + data.timestamp;
                }

                // Update recent traffic table if available
                if (data.recent_traffic && data.recent_traffic.length > 0) {
                    var tbody = document.getElementById('traffic-stream-tbody');
                    var html = '';
                    data.recent_traffic.forEach(function(item) {
                        var badgeClass = item.device === 'Mobile' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800';
                        html += `
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="px-5 py-3.5 text-slate-500 whitespace-nowrap text-[11px]">${item.time_ago}</td>
                                <td class="px-5 py-3.5 font-mono text-slate-700 font-semibold text-[11px]">🛡️ ${item.ip}</td>
                                <td class="px-5 py-3.5 font-mono font-bold text-blue-600 truncate max-w-xs">${item.page}</td>
                                <td class="px-5 py-3.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">200 OK</span></td>
                                <td class="px-5 py-3.5"><span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold ${badgeClass}">${item.device}</span></td>
                                <td class="px-5 py-3.5 text-slate-600 font-medium">${item.browser}</td>
                            </tr>
                        `;
                    });
                    tbody.innerHTML = html;
                }
            })
            .catch(function(err) {
                console.log('Live sync paused momentarily:', err);
            });
    }

    function startPolling() {
        if (liveTimer) clearInterval(liveTimer);
        liveTimer = setInterval(pollLiveStats, 5000); // Polling setiap 5 detik
    }

    document.addEventListener('DOMContentLoaded', function() {
        startPolling();
    });
</script>
@endpush
@endsection