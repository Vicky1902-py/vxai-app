@extends('layouts.admin')

@section('title', 'Manajemen Berita & Artikel - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl">📰</span>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Manajemen Berita & Artikel</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Kelola konten edukasi, warta koding, tips AI, komputer, dan Android untuk mendongkrak trafik SEO & AdSense.
            </p>
        </div>

        <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-3 rounded-2xl transition-all shadow-md shadow-blue-500/20 hover:scale-105 flex items-center gap-2">
            <span>+ Tulis Artikel Baru</span>
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm">
        <form method="GET" action="{{ route('admin.articles') }}" class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <a href="{{ route('admin.articles') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request('kategori') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('admin.articles', ['kategori' => 'coding']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'coding' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    💻 Coding
                </a>
                <a href="{{ route('admin.articles', ['kategori' => 'ai']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'ai' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    🤖 Tips AI
                </a>
                <a href="{{ route('admin.articles', ['kategori' => 'teknologi']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'teknologi' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    🌐 Teknologi
                </a>
                <a href="{{ route('admin.articles', ['kategori' => 'komputer']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'komputer' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    🖥️ Komputer
                </a>
                <a href="{{ route('admin.articles', ['kategori' => 'android']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('kategori') === 'android' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    📱 Android
                </a>
            </div>

            <!-- Search Form -->
            <div class="relative w-full md:w-72">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel..." 
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/70">
                <span class="absolute left-3 top-2.5 text-xs text-slate-400">🔍</span>
                @if(request('q'))
                    <a href="{{ route('admin.articles') }}" class="absolute right-3 top-2 text-xs text-slate-400 hover:text-slate-600">✕</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Artikel -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200/90 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-4 px-6">Artikel & Judul</th>
                        <th class="py-4 px-4">Kategori</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4 text-center">Tayangan (Views)</th>
                        <th class="py-4 px-4">Tanggal Terbit</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($articles as $art)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <!-- Judul & Thumbnail -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $art->safe_thumbnail }}" alt="Thumb" class="w-14 h-10 object-cover rounded-xl border border-slate-200 shrink-0">
                                    <div class="max-w-md">
                                        <div class="flex items-center gap-2">
                                            @if($art->is_featured)
                                                <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 text-[9px] font-extrabold border border-amber-200">⭐ Featured</span>
                                            @endif
                                            <a href="{{ route('public.news.detail', $art->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-blue-600 transition line-clamp-1 text-sm">
                                                {{ $art->title }}
                                            </a>
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">
                                            {{ $art->summary ?? strip_tags($art->content) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $art->category_badge_classes }}">
                                    {{ $art->category_icon }} {{ $art->category_label }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($art->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Tayang
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <!-- Views -->
                            <td class="py-4 px-4 text-center font-bold text-slate-700 whitespace-nowrap">
                                {{ number_format($art->views_count) }} 👁️
                            </td>

                            <!-- Tanggal -->
                            <td class="py-4 px-4 whitespace-nowrap text-slate-500 text-[11px]">
                                {{ $art->created_at->format('d M Y, H:i') }}
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('public.news.detail', $art->slug) }}" target="_blank" class="p-2 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition" title="Lihat Tampilan Pembaca">
                                        🔗
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $art->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition" title="Edit Artikel">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.articles.delete', $art->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition" title="Hapus Artikel">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="text-3xl mb-2">📰</div>
                                <div class="font-bold text-sm text-slate-600">Belum ada artikel yang sesuai kriteria.</div>
                                <p class="text-xs text-slate-400 mt-1">Mulai tulis artikel berita, coding tutorial, atau tips AI sekarang!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
