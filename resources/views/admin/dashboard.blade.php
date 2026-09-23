@extends('layouts.admin')

@section('title', 'Dashboard & Trafik Real-Time - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Ringkasan Monitoring & Analitik Real-Time')

@section('content')

<!-- BARIS 0: WIDGET STATUS CEPAT (ADSENSE & PEMELIHARAAN) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    
    <!-- Status Google AdSense -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm flex items-center justify-between">
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

    <!-- Status Pemeliharaan Situs -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }} flex items-center justify-center text-2xl font-bold shadow-sm">
                {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? '🚧' : '🌐' }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold text-slate-900">Akses Publik Website</h4>
                    @if(($settings['maintenance_mode'] ?? 'false') === 'true')
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Dalam Pemeliharaan</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">● Publik Normal</span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'Siswa dialihkan ke halaman pemeliharaan' : 'Siswa & pengunjung dapat mengakses bebas' }}
                </p>
            </div>
        </div>
        <a href="{{ route('admin.settings') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition">
            Ubah Status
        </a>
    </div>

</div>

<!-- BARIS 1: 4 KARTU METRIK UTAMA -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    
    <!-- Kunjungan Hari Ini -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kunjungan Hari Ini</span>
            <span class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">📈</span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">{{ number_format($todayVisits) }}</div>
        <div class="text-[11px] text-emerald-600 font-bold mt-2 flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Tercatat Otomatis</span>
        </div>
    </div>

    <!-- Trafik 7 Hari -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Trafik 7 Hari Terakhir</span>
            <span class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm font-bold">🗓️</span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">{{ number_format($weeklyVisits) }}</div>
        <div class="text-[11px] text-slate-400 font-medium mt-2">Akumulasi Kunjungan Pengunjung</div>
    </div>

    <!-- Total Submisi Koding -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Submisi Koding</span>
            <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">⚡</span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">{{ number_format($totalSubmissions) }}</div>
        <div class="text-[11px] text-slate-400 font-medium mt-2">Dari Siswa & Pengunjung Publik</div>
    </div>

    <!-- Pengguna Terdaftar -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Akun Terdaftar</span>
            <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">👥</span>
        </div>
        <div class="text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">{{ number_format($totalSiswa + $totalGuru) }}</div>
        <div class="text-[11px] text-slate-500 font-medium mt-2">{{ $totalSiswa }} Siswa • {{ $totalGuru }} Guru</div>
    </div>

</div>

<!-- BARIS 2: ANALISIS PERANGKAT & HALAMAN PALING RAMAI -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Halaman Terpopuler (Top Visited Pages) -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 p-6 shadow-sm">
        <div class="flex justify-between items-center mb-5">
            <div>
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <span>🔥</span> <span>Halaman Paling Banyak Dikunjungi (Top Pages)</span>
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
    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-sm flex flex-col justify-between">
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

<!-- BARIS 3: TABEL LOG 10 KUNJUNGAN TERAKHIR (LIVE STREAM) -->
<div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span>🌐</span> <span>Log 10 Kunjungan Terkini (Live Traffic Stream)</span>
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">Mencatat aktivitas pengunjung secara real-time</p>
        </div>
        <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">● Auto Tracking</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">Waktu</th>
                    <th class="px-6 py-3.5">Alamat IP</th>
                    <th class="px-6 py-3.5">Halaman Dituju</th>
                    <th class="px-6 py-3.5">Perangkat</th>
                    <th class="px-6 py-3.5">Peramban (Browser)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($recentTraffic as $traffic)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-3.5 text-slate-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($traffic->visited_at)->diffForHumans() }}
                        </td>
                        <td class="px-6 py-3.5 font-mono text-slate-700">
                            {{ $traffic->ip_address }}
                        </td>
                        <td class="px-6 py-3.5 font-mono font-bold text-blue-600">
                            /{{ ltrim($traffic->page_url, '/') }}
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $traffic->device == 'Mobile' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $traffic->device }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-slate-600 font-medium">
                            {{ $traffic->browser }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada kunjungan terbaru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- BARIS 4: SUBMISI KODING TERBARU -->
<div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
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
@endsection