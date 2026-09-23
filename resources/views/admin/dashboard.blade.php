@extends('layouts.admin')

@section('title', 'Dashboard & Monitoring Trafik - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Ringkasan Monitoring & Analitik Real-Time')

@section('content')
<!-- Baris 1: Kartu Metrik Utama -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    
    <!-- Kunjungan Hari Ini -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kunjungan Hari Ini</span>
            <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">📈</span>
        </div>
        <div class="text-3xl font-black text-gray-900 mt-2">{{ number_format($todayVisits) }}</div>
        <div class="text-[11px] text-green-600 font-semibold mt-1 flex items-center gap-1">
            <span>● Trafik Real-time</span>
        </div>
    </div>

    <!-- Kunjungan 7 Hari -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Trafik 7 Hari Terakhir</span>
            <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">🗓️</span>
        </div>
        <div class="text-3xl font-black text-gray-900 mt-2">{{ number_format($weeklyVisits) }}</div>
        <div class="text-[11px] text-gray-500 font-medium mt-1">Total Kunjungan Akumulasi</div>
    </div>

    <!-- Total Submisi Koding -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kode Disimpan/Dikirim</span>
            <span class="w-8 h-8 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center font-bold text-sm">⚡</span>
        </div>
        <div class="text-3xl font-black text-gray-900 mt-2">{{ number_format($totalSubmissions) }}</div>
        <div class="text-[11px] text-gray-500 font-medium mt-1">Dari Siswa & Pengunjung</div>
    </div>

    <!-- Total Pengguna Terdaftar -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Siswa & Guru</span>
            <span class="w-8 h-8 rounded-xl bg-green-50 text-green-600 flex items-center justify-center font-bold text-sm">👥</span>
        </div>
        <div class="text-3xl font-black text-gray-900 mt-2">{{ number_format($totalSiswa + $totalGuru) }}</div>
        <div class="text-[11px] text-gray-500 font-medium mt-1">{{ $totalSiswa }} Siswa • {{ $totalGuru }} Guru</div>
    </div>

</div>

<!-- Baris 2: Analisis Perangkat & Halaman Terpopuler -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Halaman Terpopuler -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
            <span>🔥</span> <span>Halaman Paling Banyak Dikunjungi (Top Visited Pages)</span>
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 font-semibold uppercase">
                        <th class="pb-3">URL Halaman</th>
                        <th class="pb-3 text-right">Total Tayangan (Views)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($topPages as $page)
                        <tr>
                            <td class="py-3 font-mono text-blue-600 font-semibold">
                                /{{ ltrim($page->page_url, '/') }}
                            </td>
                            <td class="py-3 text-right font-black text-gray-900">
                                {{ number_format($page->total) }} kali
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-6 text-center text-gray-400">Belum ada data kunjungan yang tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Proporsi Perangkat Pengunjung -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                <span>📱</span> <span>Perangkat Pengunjung</span>
            </h3>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span>Desktop / Laptop</span>
                        <span>{{ $deviceDesktop }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalVisits > 0 ? ($deviceDesktop / $totalVisits) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span>Smartphone / HP</span>
                        <span>{{ $deviceMobile }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalVisits > 0 ? ($deviceMobile / $totalVisits) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span>Tablet</span>
                        <span>{{ $deviceTablet }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $totalVisits > 0 ? ($deviceTablet / $totalVisits) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 mt-6 text-center">
            <span class="text-xs text-gray-400">Total Keseluruhan Log Kunjungan: <strong class="text-gray-700">{{ number_format($totalVisits) }}</strong></span>
        </div>
    </div>

</div>

<!-- Baris 3: Tabel Kunjungan Trafik Terbaru (Live Log) -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
            <span>🌐</span> <span>Log 10 Kunjungan Pengunjung Terkini</span>
        </h3>
        <span class="text-xs text-gray-400">Pembaruan otomatis via middleware</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 font-semibold">
                <tr>
                    <th class="px-6 py-3">Waktu Kunjungan</th>
                    <th class="px-6 py-3">Alamat IP</th>
                    <th class="px-6 py-3">Halaman</th>
                    <th class="px-6 py-3">Perangkat</th>
                    <th class="px-6 py-3">Peramban (Browser)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentTraffic as $traffic)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-gray-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($traffic->visited_at)->diffForHumans() }}
                        </td>
                        <td class="px-6 py-3 font-mono text-gray-600">
                            {{ $traffic->ip_address }}
                        </td>
                        <td class="px-6 py-3 font-mono font-semibold text-blue-600">
                            /{{ ltrim($traffic->page_url, '/') }}
                        </td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $traffic->device == 'Mobile' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $traffic->device }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">
                            {{ $traffic->browser }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada kunjungan terbaru yang tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Baris 4: 5 Submisi Koding Terakhir -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
            <span>💻</span> <span>5 Submisi Koding Terakhir</span>
        </h3>
        <a href="{{ route('admin.submissions') }}" class="text-xs font-bold text-blue-600 hover:underline">
            Lihat Semua Submisi ➔
        </a>
    </div>

    <div class="divide-y divide-gray-100">
        @forelse($recentSubmissions as $sub)
            <div class="p-5 flex items-center justify-between hover:bg-gray-50 transition">
                <div>
                    <div class="font-bold text-gray-900 text-sm">{{ $sub->student_name }}</div>
                    <div class="text-xs text-gray-400 mt-0.5">
                        Dikirim {{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if($sub->score > 0)
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                            Nilai: {{ $sub->score }}/100
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                            Belum Dinilai
                        </span>
                    @endif
                    <a href="{{ route('admin.submissions') }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-3 py-1.5 rounded-lg transition">
                        Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-400 text-sm">
                Belum ada kode yang dikirimkan.
            </div>
        @endforelse
    </div>
</div>
@endsection