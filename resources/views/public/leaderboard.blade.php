@extends('layouts.public')

@section('title', 'Papan Peringkat Siswa (Leaderboard) - ' . ($settings['app_name'] ?? 'VxAI Coding Lab'))
@section('meta_description', 'Papan peringkat talenta koding siswa SMK dan pembelajar vokasi teraktif di platform VxAI Coding Lab berdasarkan akumulasi skor XP dan Level.')

@section('content')
<div class="min-h-screen bg-slate-900 text-slate-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto space-y-10">

        <!-- Header Banner -->
        <div class="text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold tracking-wide">
                <span>🏆</span>
                <span>PAPAN PERINGKAT KODING SISWA SMK</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white">
                Hall of Fame <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-amber-300">Talenta Digital</span>
            </h1>
            <p class="max-w-2xl mx-auto text-sm sm:text-base text-slate-400 leading-relaxed">
                Peringkat bergengsi siswa pembelajar aktif yang telah menyelesaikan tantangan live coding HTML5, CSS3, dan JavaScript interaktif. Setiap tantangan berhasil disubmit menyumbang +25 XP!
            </p>

            <!-- Statistik Singkat -->
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2 text-xs font-semibold">
                <div class="px-4 py-2 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center gap-2">
                    <span class="text-blue-400 text-base">👥</span>
                    <span>Total Siswa: <strong class="text-white">{{ number_format($totalStudents) }}</strong></span>
                </div>
                <div class="px-4 py-2 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center gap-2">
                    <span class="text-emerald-400 text-base">💻</span>
                    <span>Total Submisi: <strong class="text-white">{{ number_format($totalSubmissions) }}</strong></span>
                </div>
                <a href="{{ route('public.playground') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white flex items-center gap-2 transition shadow-lg shadow-blue-600/20">
                    <span>⚡ Mulai Koding Sekarang &rarr;</span>
                </a>
            </div>
        </div>

        @if($topStudents->isEmpty())
            <div class="bg-slate-800/50 border border-slate-700/60 rounded-3xl p-12 text-center space-y-4">
                <div class="text-5xl">🎯</div>
                <h3 class="text-xl font-bold text-white">Belum Ada Siswa di Papan Peringkat</h3>
                <p class="text-sm text-slate-400 max-w-md mx-auto">
                    Jadilah yang pertama menyelesaikan modul koding dan kumpulkan poin XP Anda untuk memuncaki daftar juara!
                </p>
                <a href="{{ route('public.playground') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:from-blue-500 hover:to-indigo-500 transition shadow-xl">
                    Buka Live Playground &rarr;
                </a>
            </div>
        @else

            <!-- Podium Top 3 (Jika Minimal Ada Siswa) -->
            @php
                $podium = $topStudents->take(3);
                $first = $podium->get(0);
                $second = $podium->get(1);
                $third = $podium->get(2);
            @endphp

            @if($podium->count() >= 1)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-end pt-6">
                
                <!-- Juara 2 -->
                @if($second)
                <div class="order-2 sm:order-1 bg-gradient-to-b from-slate-800/90 to-slate-900/90 border border-slate-700/80 rounded-3xl p-6 text-center space-y-3 relative overflow-hidden shadow-xl">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-slate-300 text-slate-900 font-black text-sm flex items-center justify-center shadow-lg border-2 border-slate-700">
                        2
                    </div>
                    <div class="pt-3">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-700 flex items-center justify-center text-2xl font-bold text-slate-200 shadow-inner">
                            🥈
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-white truncate">{{ $second->name }}</h4>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full bg-slate-700 text-slate-300 text-[11px] font-semibold">
                            Level {{ $second->level ?? 1 }}
                        </span>
                    </div>
                    <div class="pt-2 border-t border-slate-700/60">
                        <span class="text-xl font-black text-blue-400">{{ number_format($second->xp ?? 0) }}</span>
                        <span class="text-xs text-slate-400 font-semibold ml-1">XP</span>
                    </div>
                </div>
                @endif

                <!-- Juara 1 (Emas / Paling Tinggi) -->
                @if($first)
                <div class="order-1 sm:order-2 bg-gradient-to-b from-amber-500/20 via-slate-800/95 to-slate-900 border-2 border-amber-400/50 rounded-3xl p-8 text-center space-y-4 relative overflow-hidden shadow-2xl shadow-amber-500/10 sm:-translate-y-4">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 font-black text-xs flex items-center gap-1 shadow-lg">
                        <span>👑</span> JUARA 1
                    </div>
                    <div class="pt-2">
                        <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-tr from-amber-400 to-amber-200 flex items-center justify-center text-3xl font-bold text-slate-900 shadow-lg shadow-amber-500/20">
                            🥇
                        </div>
                    </div>
                    <div>
                        <h3 class="font-black text-lg text-white truncate">{{ $first->name }}</h3>
                        <span class="inline-block mt-1 px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold">
                            ⭐ Level {{ $first->level ?? 1 }} Master
                        </span>
                    </div>
                    <div class="pt-2 border-t border-slate-700/60">
                        <span class="text-3xl font-black text-amber-300">{{ number_format($first->xp ?? 0) }}</span>
                        <span class="text-xs text-amber-200/80 font-bold ml-1">XP</span>
                    </div>
                </div>
                @endif

                <!-- Juara 3 -->
                @if($third)
                <div class="order-3 sm:order-3 bg-gradient-to-b from-slate-800/90 to-slate-900/90 border border-slate-700/80 rounded-3xl p-6 text-center space-y-3 relative overflow-hidden shadow-xl">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-amber-700 text-amber-100 font-black text-sm flex items-center justify-center shadow-lg border-2 border-slate-700">
                        3
                    </div>
                    <div class="pt-3">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-amber-900/40 border border-amber-700/50 flex items-center justify-center text-2xl font-bold text-amber-400 shadow-inner">
                            🥉
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-white truncate">{{ $third->name }}</h4>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full bg-slate-700 text-slate-300 text-[11px] font-semibold">
                            Level {{ $third->level ?? 1 }}
                        </span>
                    </div>
                    <div class="pt-2 border-t border-slate-700/60">
                        <span class="text-xl font-black text-amber-500">{{ number_format($third->xp ?? 0) }}</span>
                        <span class="text-xs text-slate-400 font-semibold ml-1">XP</span>
                    </div>
                </div>
                @endif

            </div>
            @endif

            <!-- Tabel Peringkat Lengkap (Top 50) -->
            <div class="bg-slate-800/70 border border-slate-700/70 rounded-3xl overflow-hidden shadow-xl">
                <div class="p-6 border-b border-slate-700/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span>📊</span> Daftar Lengkap Peringkat
                        </h3>
                        <p class="text-xs text-slate-400">Diperbarui secara real-time setiap submisi kode berhasil dievaluasi.</p>
                    </div>
                    <div class="text-xs text-slate-400">
                        Menampilkan <span class="text-white font-bold">{{ $topStudents->count() }}</span> Siswa Teraktif
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-900/80 text-slate-400 text-xs uppercase tracking-wider border-b border-slate-700/80">
                            <tr>
                                <th class="py-4 px-6 text-center w-16">Rank</th>
                                <th class="py-4 px-6">Nama Siswa / Pembelajar</th>
                                <th class="py-4 px-6 text-center">Level</th>
                                <th class="py-4 px-6 text-right">Total XP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/60 text-slate-200">
                            @foreach($topStudents as $index => $student)
                            @php
                                $rank = $index + 1;
                                $isTop3 = $rank <= 3;
                            @endphp
                            <tr class="hover:bg-slate-700/40 transition {{ $isTop3 ? 'bg-slate-800/40' : '' }}">
                                <td class="py-4 px-6 text-center font-bold">
                                    @if($rank === 1)
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-400/20 text-amber-300 font-black text-xs border border-amber-400/40">🥇 1</span>
                                    @elseif($rank === 2)
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-300/20 text-slate-200 font-black text-xs border border-slate-300/40">🥈 2</span>
                                    @elseif($rank === 3)
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-700/20 text-amber-400 font-black text-xs border border-amber-700/40">🥉 3</span>
                                    @else
                                        <span class="text-slate-400 font-medium">#{{ $rank }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-semibold">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xs font-black shadow">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="text-white">{{ $student->name }}</span>
                                            <span class="block text-[11px] text-slate-400 font-normal">Siswa Pembelajar Vokasi</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-300 border border-blue-500/20 text-xs font-bold">
                                        Lv. {{ $student->level ?? 1 }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <span class="font-black text-white text-base">{{ number_format($student->xp ?? 0) }}</span>
                                    <span class="text-xs text-blue-400 font-semibold ml-1">XP</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @endif

        <!-- Banner Motivasi Bawah -->
        <div class="p-8 rounded-3xl bg-gradient-to-r from-blue-900/60 via-indigo-900/60 to-purple-900/60 border border-blue-500/30 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-6 shadow-2xl">
            <div class="space-y-1">
                <h4 class="text-lg font-bold text-white">Ingin Naik Level & Mengasah Koding?</h4>
                <p class="text-xs sm:text-sm text-blue-200">
                    Buka 10 modul tantangan koding berjenjang dari HTML5 pemula hingga JavaScript logika murni!
                </p>
            </div>
            <a href="{{ route('public.playground') }}" class="whitespace-nowrap px-6 py-3 rounded-2xl bg-white text-slate-950 hover:bg-slate-100 font-bold text-xs uppercase tracking-wider transition shadow-xl">
                Buka Live Playground &rarr;
            </a>
        </div>

    </div>
</div>
@endsection
