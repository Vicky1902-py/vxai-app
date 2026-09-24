@extends('layouts.admin')

@section('title', 'Manajemen Modul Playground - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎮</span>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Manajemen Modul Playground</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Atur kurikulum tantangan koding berjenjang, pilih tingkat kesulitan, kategori materi, atau tambah latihan koding baru.
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <form action="{{ route('admin.playground.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset seluruh latihan kembali ke 10 modul bawaan? Modul kustom yang ditambahkan manual akan diatur ulang.')">
                @csrf
                <button type="submit" class="bg-slate-150 hover:bg-slate-200 text-slate-700 font-bold text-xs px-4 py-3 rounded-2xl transition border border-slate-300/80 flex items-center gap-2 shadow-sm">
                    <span>↺</span> <span>Reset ke 10 Modul Bawaan</span>
                </button>
            </form>

            <a href="{{ route('admin.playground.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-3 rounded-2xl transition-all shadow-md shadow-blue-500/20 hover:scale-105 flex items-center gap-2">
                <span>+ Tambah Latihan Baru</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between">
            <span class="flex items-center gap-2">
                <span class="text-emerald-500 text-base">✓</span>
                <span>{{ session('success') }}</span>
            </span>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 font-extrabold hover:text-emerald-800">&times;</button>
        </div>
    @endif

    <!-- Kartu Statistik Modul -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3.5">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Latihan</div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $counts['total'] }}</div>
            <div class="text-[10px] text-blue-600 font-semibold mt-0.5">{{ $counts['active'] }} modul aktif di publik</div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">🟢 Pemula (HTML5)</div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $counts['pemula'] }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Tingkat 1 Dasar</div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">🔵 Menengah (CSS3)</div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $counts['menengah'] }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Tingkat 2 Layout & Style</div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold text-purple-600 uppercase tracking-wider">🟣 Mahir (JS & AI)</div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $counts['mahir'] }}</div>
            <div class="text-[10px] text-slate-400 mt-0.5">Tingkat 3 Logika & Interaksi</div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm col-span-2 md:col-span-1">
            <div class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">⚡ Live Playground</div>
            <a href="{{ route('public.playground') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-2 text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-xl transition">
                <span>Buka Playground</span> <span>↗</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
        <form method="GET" action="{{ route('admin.playground') }}" class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <!-- Filter Level & Kategori -->
            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <a href="{{ route('admin.playground') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('level') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Tingkat
                </a>
                <a href="{{ route('admin.playground', ['level' => 'pemula']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('level') === 'pemula' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    🟢 Pemula
                </a>
                <a href="{{ route('admin.playground', ['level' => 'menengah']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('level') === 'menengah' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    🔵 Menengah
                </a>
                <a href="{{ route('admin.playground', ['level' => 'mahir']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('level') === 'mahir' ? 'bg-purple-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    🟣 Mahir
                </a>
            </div>

            <!-- Search Form -->
            <div class="relative w-full md:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul latihan..." 
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/70">
                <span class="absolute left-3 top-2.5 text-xs text-slate-400">🔍</span>
                @if(request('search'))
                    <a href="{{ route('admin.playground') }}" class="absolute right-3 top-2 text-xs text-slate-400 hover:text-slate-600">✕</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Modul Tantangan -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200/90 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-4 px-4 text-center w-12">No</th>
                        <th class="py-4 px-6">Modul & Judul Latihan</th>
                        <th class="py-4 px-4">Tingkatan (Level)</th>
                        <th class="py-4 px-4">Kategori Materi</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($challenges as $ch)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <!-- Urutan -->
                            <td class="py-4 px-4 text-center font-mono font-bold text-slate-400">
                                {{ $ch->order_num }}
                            </td>

                            <!-- Judul & Deskripsi -->
                            <td class="py-4 px-6">
                                <div class="max-w-md">
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                        <span>{{ $ch->title }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">
                                        {{ $ch->desc }}
                                    </p>
                                    @if(is_array($ch->instructions) && count($ch->instructions) > 0)
                                        <div class="text-[10px] text-blue-500 font-semibold mt-1 flex items-center gap-1">
                                            <span>📋</span> <span>{{ count($ch->instructions) }} Langkah Instruksi</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Level Badge -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $ch->level_badge_color }}">
                                    {{ $ch->level_badge }}
                                </span>
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $ch->category_label }}
                                </span>
                            </td>

                            <!-- Toggle Status Aktif -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('admin.playground.toggle', $ch->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Klik untuk beralih status" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold transition {{ $ch->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $ch->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $ch->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.playground.edit', $ch->id) }}" class="p-2 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Edit Modul">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.playground.delete', $ch->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus latihan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Modul">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="text-3xl mb-2">🎮</div>
                                <div class="font-bold text-sm text-slate-700">Belum ada modul latihan di tingkat ini</div>
                                <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Tambah Latihan Baru" atau "Reset ke 10 Modul Bawaan".</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($challenges->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $challenges->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
