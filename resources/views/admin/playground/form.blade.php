@extends('layouts.admin')

@section('title', ($challenge ? 'Edit Modul Latihan' : 'Tambah Modul Latihan') . ' - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Header Section -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.playground') }}" class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition" title="Kembali ke Daftar">
                <span>&larr;</span>
            </a>
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">
                    {{ $challenge ? 'Edit Modul: ' . $challenge->title : 'Tambah Modul Latihan Koding Baru' }}
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $challenge ? 'Perbarui instruksi, materi, atau kode sumber latihan koding ini' : 'Pilih tingkat kesulitan, jenis pelatihan, atau gunakan template preset siap pakai' }}
                </p>
            </div>
        </div>

        <a href="{{ route('public.playground') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3.5 py-2 rounded-xl transition">
            <span>Uji di Live Playground</span> <span>↗</span>
        </a>
    </div>

    <!-- Error Validation Alert -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <div class="font-bold mb-1">Terdapat kesalahan pada isian formulir:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- TEMPLATE PRESET SIAP PAKAI (FITUR KHUSUS ADMIN) -->
    @if(!$challenge && !empty($templates))
        <div class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white p-6 rounded-3xl shadow-md border border-blue-800/60">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xl">⚡</span>
                <h2 class="text-sm font-black tracking-wide uppercase text-blue-300">Pilih Jenis Pelatihan / Template Siap Pakai</h2>
            </div>
            <p class="text-xs text-blue-200/80 mb-4">
                Klik salah satu template di bawah untuk mengisi formulir, kode starter, dan instruksi latihan secara otomatis:
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2.5">
                @foreach($templates as $key => $tmpl)
                    <button type="button" onclick="applyTemplate('{{ $key }}')" 
                            class="p-3 bg-white/10 hover:bg-white/20 active:bg-blue-600 text-left rounded-2xl border border-white/15 transition group">
                        <div class="text-[10px] font-extrabold text-blue-300 group-hover:text-white uppercase">{{ $tmpl['level'] }}</div>
                        <div class="text-xs font-bold text-white mt-0.5 line-clamp-1">{{ $tmpl['name'] }}</div>
                        <div class="text-[9px] text-blue-200/70 mt-1 line-clamp-2">{{ $tmpl['desc'] }}</div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Form Utama -->
    <form action="{{ $challenge ? route('admin.playground.update', $challenge->id) : route('admin.playground.store') }}" method="POST" class="space-y-6">
        @csrf
        @if($challenge)
            @method('PUT')
        @endif

        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-5">
            
            <h3 class="text-sm font-black text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                <span>🎯</span> <span>Informasi & Pengaturan Tingkat Pelatihan</span>
            </h3>

            <!-- Baris 1: Judul Tantangan & Nomor Urut -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-3">
                    <label for="title" class="block text-xs font-bold text-slate-700 mb-1">
                        Judul Modul Latihan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                           value="{{ old('title', $challenge->title ?? '') }}" 
                           placeholder="Contoh: Latihan 11: Sistem Navigasi Dropdown Interaktif"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
                </div>

                <div>
                    <label for="order_num" class="block text-xs font-bold text-slate-700 mb-1">
                        Urutan Tampil (No)
                    </label>
                    <input type="number" name="order_num" id="order_num" min="1"
                           value="{{ old('order_num', $challenge->order_num ?? $nextOrder) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
                </div>
            </div>

            <!-- Baris 2: Tingkat Kesulitan, Kategori, Badge Text -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Level Dropdown -->
                <div>
                    <label for="level" class="block text-xs font-bold text-slate-700 mb-1">
                        Tingkat Kesulitan (Level) <span class="text-rose-500">*</span>
                    </label>
                    <select name="level" id="level" required onchange="handleLevelChange(this.value)"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
                        <option value="pemula" {{ old('level', $challenge->level ?? '') === 'pemula' ? 'selected' : '' }}>
                            🟢 Tingkat 1: Pemula (Dasar HTML5)
                        </option>
                        <option value="menengah" {{ old('level', $challenge->level ?? '') === 'menengah' ? 'selected' : '' }}>
                            🔵 Tingkat 2: Menengah (Layout & CSS3)
                        </option>
                        <option value="mahir" {{ old('level', $challenge->level ?? '') === 'mahir' ? 'selected' : '' }}>
                            🟣 Tingkat 3: Mahir (JavaScript, DOM & AI)
                        </option>
                    </select>
                </div>

                <!-- Kategori / Jenis Pelatihan -->
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 mb-1">
                        Jenis Pelatihan / Materi <span class="text-rose-500">*</span>
                    </label>
                    <select name="category" id="category" required onchange="handleCategoryChange(this.value)"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
                        <option value="html" {{ old('category', $challenge->category ?? '') === 'html' ? 'selected' : '' }}>
                            HTML Dasar & Dokumen
                        </option>
                        <option value="css" {{ old('category', $challenge->category ?? '') === 'css' ? 'selected' : '' }}>
                            CSS Layout, Flexbox & Desain
                        </option>
                        <option value="javascript" {{ old('category', $challenge->category ?? '') === 'javascript' ? 'selected' : '' }}>
                            JavaScript DOM & Logika Interaktif
                        </option>
                        <option value="ai" {{ old('category', $challenge->category ?? '') === 'ai' ? 'selected' : '' }}>
                            Kecerdasan Buatan (AI Simulator)
                        </option>
                        <option value="responsive" {{ old('category', $challenge->category ?? '') === 'responsive' ? 'selected' : '' }}>
                            Desain Responsif & Mobile
                        </option>
                        <option value="fullstack" {{ old('category', $challenge->category ?? '') === 'fullstack' ? 'selected' : '' }}>
                            Fullstack & Proyek Mini
                        </option>
                    </select>
                </div>

                <!-- Badge Teks -->
                <div>
                    <label for="level_badge" class="block text-xs font-bold text-slate-700 mb-1">
                        Teks Badge Tampilan
                    </label>
                    <input type="text" name="level_badge" id="level_badge"
                           value="{{ old('level_badge', $challenge->level_badge ?? '🟢 Pemula (HTML5)') }}" 
                           placeholder="Misal: 🟢 Pemula (HTML5)"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
                </div>
            </div>

            <!-- Baris 3: Deskripsi Singkat -->
            <div>
                <label for="desc" class="block text-xs font-bold text-slate-700 mb-1">
                    Deskripsi Ringkas Latihan
                </label>
                <input type="text" name="desc" id="desc"
                       value="{{ old('desc', $challenge->desc ?? '') }}" 
                       placeholder="Jelaskan secara ringkas kompetensi yang dipelajari siswa di modul ini"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
            </div>

            <!-- Baris 4: Instruksi Langkah demi Langkah -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="instructions" class="block text-xs font-bold text-slate-700">
                        Daftar Langkah Instruksi (1 Instruksi per Baris)
                    </label>
                    <span class="text-[10px] text-slate-400">Tekan Enter untuk membuat baris baru</span>
                </div>
                @php
                    $instValue = '';
                    if (old('instructions')) {
                        $instValue = old('instructions');
                    } elseif ($challenge) {
                        $instValue = is_array($challenge->instructions) ? implode("\n", $challenge->instructions) : $challenge->instructions;
                    }
                @endphp
                <textarea name="instructions" id="instructions" rows="4"
                          placeholder="Langkah 1: Tambahkan elemen &lt;h1&gt; baru&#10;Langkah 2: Terapkan properti css display: flex&#10;Langkah 3: Pasang event listener click di script JavaScript"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-sans focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 leading-relaxed">{{ $instValue }}</textarea>
            </div>

            <!-- Checkbox Status Aktif -->
            <div class="pt-2">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $challenge ? $challenge->is_active : true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                    <span class="text-xs font-bold text-slate-700">Aktifkan Modul Ini di Live Playground Publik</span>
                </label>
            </div>

        </div>

        <!-- Section 2: Editor Kode Bawaan (HTML, CSS, JS) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-5">
            <h3 class="text-sm font-black text-slate-800 border-b border-slate-100 pb-3 flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <span>💻</span> <span>Starter Code (Kode Awal untuk Siswa)</span>
                </span>
                <span class="text-[11px] font-normal text-slate-400">Kode ini akan langsung muncul saat siswa memilih modul ini</span>
            </h3>

            <!-- Starter HTML -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="html_code" class="text-xs font-extrabold text-orange-600 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        <span>HTML Starter (index.html)</span>
                    </label>
                    <span class="text-[10px] text-slate-400 font-mono">Markup HTML</span>
                </div>
                <textarea name="html_code" id="html_code" rows="8"
                          class="w-full p-4 rounded-2xl bg-slate-900 text-slate-100 font-mono text-xs border border-slate-800 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 leading-relaxed"
                          placeholder="<div><!-- Tulis kode HTML awal di sini --></div>">{{ old('html_code', $challenge->html_code ?? '') }}</textarea>
            </div>

            <!-- Starter CSS -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="css_code" class="text-xs font-extrabold text-blue-600 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span>CSS3 Starter (style.css)</span>
                    </label>
                    <span class="text-[10px] text-slate-400 font-mono">Stylesheet CSS</span>
                </div>
                <textarea name="css_code" id="css_code" rows="8"
                          class="w-full p-4 rounded-2xl bg-slate-900 text-slate-100 font-mono text-xs border border-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 leading-relaxed"
                          placeholder="body { margin: 0; font-family: sans-serif; }">{{ old('css_code', $challenge->css_code ?? '') }}</textarea>
            </div>

            <!-- Starter JavaScript -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="js_code" class="text-xs font-extrabold text-yellow-600 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                        <span>JavaScript Starter (script.js)</span>
                    </label>
                    <span class="text-[10px] text-slate-400 font-mono">Logika JavaScript</span>
                </div>
                <textarea name="js_code" id="js_code" rows="6"
                          class="w-full p-4 rounded-2xl bg-slate-900 text-slate-100 font-mono text-xs border border-slate-800 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 leading-relaxed"
                          placeholder="// console.log('Script dimulai');">{{ old('js_code', $challenge->js_code ?? '') }}</textarea>
            </div>

        </div>

        <!-- Tombol Aksi Bawah -->
        <div class="flex items-center justify-between p-4 bg-white rounded-3xl border border-slate-200/90 shadow-sm">
            <a href="{{ route('admin.playground') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                Batal & Kembali
            </a>

            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition-all hover:scale-105">
                {{ $challenge ? 'Simpan Perubahan Modul' : 'Tambahkan Modul ke Playground' }}
            </button>
        </div>

    </form>

</div>

@push('scripts')
<script>
    const starterTemplates = @json($templates ?? []);

    function applyTemplate(key) {
        if (!starterTemplates[key]) return;
        const tmpl = starterTemplates[key];

        document.getElementById('title').value = tmpl.name;
        document.getElementById('level').value = tmpl.level;
        document.getElementById('category').value = tmpl.category;
        document.getElementById('level_badge').value = tmpl.level_badge;
        document.getElementById('desc').value = tmpl.desc;
        document.getElementById('instructions').value = tmpl.instructions;
        document.getElementById('html_code').value = tmpl.html;
        document.getElementById('css_code').value = tmpl.css;
        document.getElementById('js_code').value = tmpl.js;

        // Visual feedback
        const el = document.getElementById('title');
        el.focus();
        el.classList.add('ring-2', 'ring-blue-500');
        setTimeout(() => el.classList.remove('ring-2', 'ring-blue-500'), 1000);
    }

    function handleLevelChange(val) {
        const cat = document.getElementById('category').value.toUpperCase();
        const badgeInput = document.getElementById('level_badge');
        
        if (val === 'pemula') {
            badgeInput.value = '🟢 Pemula (' + cat + ')';
        } else if (val === 'menengah') {
            badgeInput.value = '🔵 Menengah (' + cat + ')';
        } else if (val === 'mahir') {
            badgeInput.value = '🟣 Mahir (' + (cat === 'AI' ? 'JavaScript & AI' : 'JavaScript') + ')';
        }
    }

    function handleCategoryChange(val) {
        const level = document.getElementById('level').value;
        const badgeInput = document.getElementById('level_badge');
        const cat = val.toUpperCase();

        if (level === 'pemula') {
            badgeInput.value = '🟢 Pemula (' + cat + ')';
        } else if (level === 'menengah') {
            badgeInput.value = '🔵 Menengah (' + cat + ')';
        } else if (level === 'mahir') {
            badgeInput.value = '🟣 Mahir (' + (val === 'ai' ? 'JavaScript & AI' : 'JavaScript') + ')';
        }
    }
</script>
@endpush
@endsection
