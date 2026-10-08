@extends('layouts.admin')

@section('title', 'Hasil Koding Masuk - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Hasil Koding & Evaluasi Tugas')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-wrap justify-between items-center gap-3">
        <div>
            <h3 class="text-base font-extrabold text-slate-900">Daftar Submisi Koding Siswa & Pengunjung</h3>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau kode dari siswa dan pengunjung publik, uji live secara berdampingan, dan berikan evaluasi nilai serta catatan</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3.5 py-1.5 rounded-xl border border-slate-200">
                Total: {{ count($submissions) }} Tugas
            </span>
            @if(count($submissions) > 0)
                <button type="button" onclick="bukaModalHapusSemua()" class="text-xs font-bold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 px-3 py-1.5 rounded-xl border border-rose-200 hover:border-rose-600 transition flex items-center gap-1.5 shadow-sm active:scale-95" title="Hapus semua submisi & reset level siswa">
                    <span>🗑️</span> <span>Reset Semua</span>
                </button>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs divide-y divide-slate-100">
            <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Pengirim</th>
                    <th class="px-6 py-4">Tantangan / Latihan</th>
                    <th class="px-6 py-4">Waktu Pengiriman</th>
                    <th class="px-6 py-4">Status & Nilai</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($submissions as $sub)
                <tr class="hover:bg-slate-50/80 transition">
                    <!-- Pengirim -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            @if(str_contains($sub->student_name, '[Tamu'))
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-600 text-white flex items-center justify-center font-black text-xs shadow-sm">
                                    👤
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                        <span>{{ $sub->student_name }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">Tamu</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-mono">{{ $sub->student_email ?? 'Pengunjung Publik' }}</div>
                                </div>
                            @else
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-xs shadow-sm">
                                    {{ strtoupper(substr($sub->student_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                        <span>{{ $sub->student_name }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">Siswa (Lv. {{ $sub->student_level ?? 1 }})</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-mono flex items-center gap-2">
                                        <span>{{ $sub->student_email }}</span>
                                        @if(isset($sub->student_xp))
                                            <span class="text-blue-600 font-bold">• {{ number_format($sub->student_xp) }} XP</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </td>

                    <!-- Tantangan -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-xl text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 inline-flex items-center gap-1.5">
                            <span>🎯</span> <span>{{ $sub->challenge_title ?? 'Latihan Koding' }}</span>
                        </span>
                    </td>

                    <!-- Waktu -->
                    <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-medium">
                        <div>{{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}</div>
                        <div class="text-[10px] text-slate-400 font-mono">{{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M Y, H:i') }}</div>
                    </td>

                    <!-- Status & Nilai -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($sub->score > 0)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Skor: {{ $sub->score }} / 100
                            </span>
                            @if(!empty($sub->feedback))
                                <div class="text-[11px] text-slate-500 mt-1 italic max-w-xs truncate" title="{{ $sub->feedback }}">"{{ $sub->feedback }}"</div>
                            @endif
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                ⏳ Belum Dinilai
                            </span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="lihatDanUjiKode(this)" 
                                    data-id="{{ $sub->id }}"
                                    data-name="{{ $sub->student_name }}"
                                    data-challenge="{{ $sub->challenge_title ?? 'Latihan Koding' }}"
                                    data-score="{{ $sub->score ?? 0 }}"
                                    data-feedback="{{ $sub->feedback ?? '' }}"
                                    data-time="{{ \Carbon\Carbon::parse($sub->created_at)->translatedFormat('d M Y, H:i') }}"
                                    data-html="{{ base64_encode($sub->html_code ?? '') }}"
                                    data-css="{{ base64_encode($sub->css_code ?? '') }}"
                                    data-js="{{ base64_encode($sub->js_code ?? '') }}"
                                    class="inline-flex items-center gap-1.5 text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 px-3.5 py-2 rounded-xl text-xs font-bold transition duration-150 shadow-sm active:scale-95">
                                <span>🔍</span> <span>Periksa & Uji</span>
                            </button>
                            
                            <button type="button" 
                                    onclick="bukaModalHapusSubmisi('{{ $sub->id }}', '{{ addslashes($sub->student_name) }}', '{{ addslashes($sub->challenge_title ?? 'Latihan Koding') }}', '{{ route('admin.submissions.delete', $sub->id) }}')" 
                                    class="inline-flex items-center gap-1 text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 px-3 py-2 rounded-xl text-xs font-bold transition duration-150 border border-rose-200 hover:border-rose-600 shadow-sm active:scale-95"
                                    title="Hapus hasil koding & reset level pada akun siswa">
                                <span>🗑️</span> <span>Hapus</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-slate-400 font-medium">
                        <div class="text-3xl mb-2">📬</div>
                        Belum ada yang mengirimkan kode dari Live Playground.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL EKSPANSIF & LEGA: INSPEKSI KODE, LIVE OUTPUT & PENILAIAN -->
<!-- ======================================================== -->
<div id="modal-kode" class="fixed inset-0 bg-slate-950/85 z-[100] hidden flex items-center justify-center p-2 sm:p-4 backdrop-blur-md">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-[97vw] h-[94vh] max-h-[94vh] flex flex-col overflow-hidden border border-slate-300">
        
        <!-- Header Modal & Mode Tampilan Switcher -->
        <div class="p-4 sm:px-6 sm:py-3.5 border-b border-slate-200 bg-slate-50 flex flex-wrap justify-between items-center gap-3 shrink-0">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-lg font-bold shadow-md shadow-blue-500/20">
                    🔬
                </span>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-black text-slate-900 text-base" id="modal-title">Inspeksi Kode Siswa</h3>
                        <span id="modal-challenge-badge" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            -
                        </span>
                    </div>
                    <span class="text-xs text-slate-500" id="modal-subtitle">Waktu: -</span>
                </div>
            </div>

            <!-- Mode View Switcher: Split (Dampingan) vs Full Preview vs Full Code -->
            <div class="flex items-center gap-2">
                <div class="flex items-center bg-slate-200 p-1 rounded-xl text-xs font-bold border border-slate-300">
                    <button type="button" id="view-mode-split" onclick="setViewMode('split')" class="px-3.5 py-1.5 rounded-lg bg-white text-slate-900 shadow-sm transition flex items-center gap-1.5" title="Tampilkan Kode & Live Output berdampingan">
                        <span>🌓</span> <span>Dampingan (Split)</span>
                    </button>
                    <button type="button" id="view-mode-preview" onclick="setViewMode('preview')" class="px-3.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5" title="Layar penuh live output hasil render">
                        <span>⚡</span> <span>Preview Penuh</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </button>
                    <button type="button" id="view-mode-code" onclick="setViewMode('code')" class="px-3.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5" title="Layar penuh kode sintaksis">
                        <span>💻</span> <span>Kode Penuh</span>
                    </button>
                </div>

                <!-- Simulator Ukuran Layar untuk Preview -->
                <div id="device-simulator-bar" class="hidden sm:flex items-center bg-slate-200 p-1 rounded-xl text-[11px] font-bold border border-slate-300">
                    <button type="button" onclick="setFrameDevice('desktop')" id="dev-btn-desktop" class="px-2.5 py-1 rounded-lg bg-white text-slate-800 shadow-xs transition" title="Lebar Layar Desktop">💻 100%</button>
                    <button type="button" onclick="setFrameDevice('tablet')" id="dev-btn-tablet" class="px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-800 transition" title="Lebar Tablet (768px)">📱 Tablet</button>
                    <button type="button" onclick="setFrameDevice('mobile')" id="dev-btn-mobile" class="px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-800 transition" title="Lebar Smartphone (375px)">📱 Mobile</button>
                    <button type="button" onclick="reloadPreviewFrame()" class="px-2 py-1 text-slate-600 hover:text-blue-600 transition" title="Muat Ulang Frame">🔄</button>
                    <button type="button" onclick="openPreviewInNewTab()" class="px-2 py-1 text-slate-600 hover:text-blue-600 transition" title="Buka di Tab Baru">↗</button>
                </div>

                <button onclick="tutupModal()" class="text-slate-400 hover:text-rose-500 font-bold text-3xl leading-none px-2 transition">&times;</button>
            </div>
        </div>
        
        <!-- Main Workspace: Fleksibel & Menempati Seluruh Sisa Layar Modal (Tinggi Lega) -->
        <div id="modal-workspace" class="flex-1 min-h-0 flex flex-col md:flex-row bg-slate-950 overflow-hidden relative">
            
            <!-- Panel Kiri: Editor Sintaksis (HTML, CSS, JS) -->
            <div id="panel-code" class="flex-1 flex flex-col md:flex-row gap-2 p-3 overflow-y-auto custom-scrollbar bg-slate-950 border-r border-slate-800 transition-all duration-200">
                
                <!-- Box HTML5 -->
                <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                    <div class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 flex justify-between items-center text-xs font-mono font-bold text-orange-400">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                            <span>HTML5 Markup</span>
                        </span>
                        <span class="text-[10px] text-slate-500">index.html</span>
                    </div>
                    <pre id="modal-html" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                </div>
                
                <!-- Box CSS3 -->
                <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                    <div class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 flex justify-between items-center text-xs font-mono font-bold text-blue-400">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span>CSS3 Styling</span>
                        </span>
                        <span class="text-[10px] text-slate-500">style.css</span>
                    </div>
                    <pre id="modal-css" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                </div>
                
                <!-- Box JavaScript -->
                <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                    <div class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 flex justify-between items-center text-xs font-mono font-bold text-yellow-400">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span>JavaScript Logic</span>
                        </span>
                        <span class="text-[10px] text-slate-500">script.js</span>
                    </div>
                    <pre id="modal-js" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                </div>

            </div>

            <!-- Panel Kanan: Live Preview Interaktif -->
            <div id="panel-preview" class="flex-1 flex flex-col bg-slate-200 transition-all duration-200 overflow-hidden relative">
                <div class="px-4 py-2 bg-slate-100 border-b border-slate-300 text-xs font-bold text-slate-700 flex justify-between items-center shrink-0">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Hasil Tampilan Langsung (Live Rendered Sandbox)</span>
                    </span>
                    <span class="text-[11px] text-slate-500 font-mono" id="preview-dimension-label">100% Lebar Layar</span>
                </div>
                <div class="flex-1 bg-slate-300 p-2 sm:p-3 overflow-auto flex items-center justify-center">
                    <iframe id="modal-preview-frame" class="w-full h-full bg-white rounded-2xl border border-slate-300 shadow-xl transition-all duration-200" sandbox="allow-scripts allow-modals"></iframe>
                </div>
            </div>

        </div>
        
        <!-- Footer Form: Form Beri Nilai, Preset & Masukan -->
        <form id="form-grade" method="POST" class="p-4 sm:px-6 sm:py-3.5 border-t border-slate-200 bg-slate-50 shrink-0">
            @csrf
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
                
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 flex-1">
                    <!-- Skor Input -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Skor (0-100)</label>
                        <input type="number" id="input-score" name="score" min="0" max="100" class="w-20 sm:w-24 px-3 py-2 border border-slate-300 rounded-xl text-base font-extrabold text-center focus:ring-2 focus:ring-blue-500 bg-white" required>
                    </div>

                    <!-- Preset Cepat Skor -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pilih Cepat</label>
                        <div class="flex flex-wrap items-center gap-1">
                            <button type="button" onclick="setPresetScore(100)" class="px-2 py-1.5 rounded-lg bg-emerald-100 text-emerald-800 text-[11px] font-bold hover:bg-emerald-200 transition">100 Sempurna</button>
                            <button type="button" onclick="setPresetScore(95)" class="px-2 py-1.5 rounded-lg bg-blue-100 text-blue-800 text-[11px] font-bold hover:bg-blue-200 transition">95 Hebat</button>
                            <button type="button" onclick="setPresetScore(85)" class="px-2 py-1.5 rounded-lg bg-indigo-100 text-indigo-800 text-[11px] font-bold hover:bg-indigo-200 transition">85 Bagus</button>
                            <button type="button" onclick="setPresetScore(75)" class="px-2 py-1.5 rounded-lg bg-amber-100 text-amber-800 text-[11px] font-bold hover:bg-amber-200 transition">75 Cukup</button>
                        </div>
                    </div>

                    <!-- Catatan / Umpan Balik Guru -->
                    <div class="flex-1 min-w-[240px]">
                        <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Catatan Evaluasi / Bimbingan</label>
                        <input type="text" id="input-feedback" name="feedback" placeholder="Misal: Struktur tag HTML rapi, perbaiki jarak CSS flexbox..." class="w-full px-4 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 bg-white">
                    </div>
                </div>
                
                <!-- Tombol Aksi Simpan, Hapus & Batal -->
                <div class="flex items-center gap-2.5 justify-end shrink-0">
                    <button type="button" onclick="hapusSubmisiDariModal()" class="bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 hover:border-rose-600 px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm active:scale-95" title="Hapus tugas ini dan kurangi level siswa">
                        <span>🗑️</span> <span>Hapus Tugas</span>
                    </button>
                    <button type="button" onclick="tutupModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-xl text-xs font-bold transition active:scale-95">
                        Tutup
                    </button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 sm:px-6 py-2.5 rounded-xl text-xs font-black shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5 active:scale-95">
                        <span>💾</span> <span>Simpan Nilai & Feedback</span>
                    </button>
                </div>

            </div>
        </form>
        
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL KONFIRMASI HAPUS SUBMISI TUNGGAL                   -->
<!-- ======================================================== -->
<div id="modal-konfirmasi-hapus" class="fixed inset-0 bg-slate-950/85 z-[150] hidden flex items-center justify-center p-4 backdrop-blur-md">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md flex flex-col border border-slate-200 overflow-hidden transform transition-all duration-300">
        
        <div class="p-6 text-center space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-3xl mx-auto border border-rose-200 shadow-sm animate-bounce">
                🗑️
            </div>
            
            <h3 class="font-extrabold text-slate-900 text-lg">Hapus Hasil Koding & Level Siswa?</h3>
            
            <p class="text-xs text-slate-600 leading-relaxed">
                Anda akan menghapus tugas <strong id="hapus-nama-latihan" class="text-slate-900">-</strong> milik siswa <strong id="hapus-nama-siswa" class="text-blue-600">-</strong>.
            </p>

            <div class="p-4 bg-rose-50 rounded-2xl border border-rose-200 text-left text-xs text-rose-900 space-y-2">
                <span class="font-black text-rose-700 flex items-center gap-1.5 text-[11px] uppercase tracking-wider">
                    <span>⚠️</span> <span>Dampak Pada Akun Siswa:</span>
                </span>
                <ul class="list-disc list-inside space-y-1 text-slate-700 text-[11px]">
                    <li>Hasil koding akan <strong>dihapus permanen</strong> dari server.</li>
                    <li>Poin XP siswa dikurangi <strong>(-25 XP)</strong> dan <strong>Level siswa otomatis dihitung ulang</strong>.</li>
                    <li>Status level pada akun siswa (di Playground & Dashboard) <strong>otomatis terhapus / kembali belum dikerjakan</strong>.</li>
                </ul>
            </div>
        </div>

        <form id="form-hapus-submisi" method="POST" action="" class="p-4 bg-slate-50 border-t border-slate-100 flex items-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="tutupModalHapusSubmisi()" class="flex-1 py-2.5 px-4 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition active:scale-95">
                Batal
            </button>
            <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-md shadow-rose-600/30 transition flex items-center justify-center gap-1.5 active:scale-95">
                <span>🗑️</span> <span>Ya, Hapus Sekarang</span>
            </button>
        </form>

    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL KONFIRMASI RESET / HAPUS SEMUA SUBMISI             -->
<!-- ======================================================== -->
<div id="modal-konfirmasi-hapus-semua" class="fixed inset-0 bg-slate-950/85 z-[150] hidden flex items-center justify-center p-4 backdrop-blur-md">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md flex flex-col border border-slate-200 overflow-hidden transform transition-all duration-300">
        
        <div class="p-6 text-center space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-3xl mx-auto border border-rose-200 shadow-sm">
                ⚠️
            </div>
            
            <h3 class="font-extrabold text-slate-900 text-lg">Reset Seluruh Hasil Koding?</h3>
            
            <p class="text-xs text-slate-600 leading-relaxed">
                Tindakan ini akan <strong>menghapus seluruh hasil koding siswa dan tamu</strong> yang ada di database.
            </p>

            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 text-left text-xs text-amber-900 space-y-1.5">
                <span class="font-black text-amber-800 flex items-center gap-1.5 text-[11px] uppercase tracking-wider">
                    <span>⚡</span> <span>Perhatian Penting:</span>
                </span>
                <p class="text-slate-700 text-[11px] leading-relaxed">
                    Seluruh riwayat tugas akan dikosongkan. Seluruh level dan XP siswa yang terdampak akan <strong>di-reset ke kondisi awal (0 XP, Level 1)</strong>.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.submissions.delete_all') }}" class="p-4 bg-slate-50 border-t border-slate-100 flex items-center gap-3">
            @csrf
            <button type="button" onclick="tutupModalHapusSemua()" class="flex-1 py-2.5 px-4 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition active:scale-95">
                Batal
            </button>
            <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-md shadow-rose-600/30 transition flex items-center justify-center gap-1.5 active:scale-95">
                <span>⚠️</span> <span>Ya, Reset Semua</span>
            </button>
        </form>

    </div>
</div>

<script>
    let currentRawHtml = '';
    let currentRawCss = '';
    let currentRawJs = '';
    let currentLayoutMode = 'split'; // 'split', 'preview', 'code'
    let activeSubmissionData = null;

    function lihatDanUjiKode(btn) {
        const id = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');
        const challenge = btn.getAttribute('data-challenge') || 'Latihan Koding';
        const score = btn.getAttribute('data-score');
        const feedback = btn.getAttribute('data-feedback');
        const time = btn.getAttribute('data-time') || '-';

        activeSubmissionData = {
            id: id,
            name: name,
            challenge: challenge
        };

        currentRawHtml = decodeURIComponent(escape(atob(btn.getAttribute('data-html'))));
        currentRawCss = decodeURIComponent(escape(atob(btn.getAttribute('data-css'))));
        currentRawJs = decodeURIComponent(escape(atob(btn.getAttribute('data-js'))));

        document.getElementById('modal-title').textContent = 'Pratinjau Kode: ' + name;
        document.getElementById('modal-challenge-badge').textContent = challenge;
        document.getElementById('modal-subtitle').textContent = 'Waktu Pengiriman: ' + time;

        document.getElementById('modal-html').textContent = currentRawHtml || '<!-- Kosong -->';
        document.getElementById('modal-css').textContent = currentRawCss || '/* Kosong */';
        document.getElementById('modal-js').textContent = currentRawJs || '/* Kosong */';

        // Render preview ke iframe
        renderFrameDoc();

        document.getElementById('input-score').value = score || 0;
        document.getElementById('input-feedback').value = feedback || '';

        document.getElementById('form-grade').action = '/admin/submissions/' + id + '/grade';

        // Default ke Split View di desktop, atau Preview di layar sempit
        if (window.innerWidth < 768) {
            setViewMode('preview');
        } else {
            setViewMode('split');
        }

        document.getElementById('modal-kode').classList.remove('hidden');
    }

    function renderFrameDoc() {
        const frameDoc = `<!DOCTYPE html><html><head><meta charset="utf-8"><style>${currentRawCss}</style></head><body>${currentRawHtml}<script>${currentRawJs}<\/script></body></html>`;
        document.getElementById('modal-preview-frame').srcdoc = frameDoc;
    }

    function reloadPreviewFrame() {
        renderFrameDoc();
    }

    function openPreviewInNewTab() {
        const frameDoc = `<!DOCTYPE html><html><head><meta charset="utf-8"><title>Pratinjau Tugas Siswa</title><style>${currentRawCss}</style></head><body>${currentRawHtml}<script>${currentRawJs}<\/script></body></html>`;
        const blob = new Blob([frameDoc], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        window.open(url, '_blank');
    }

    function setViewMode(mode) {
        currentLayoutMode = mode;
        const panelCode = document.getElementById('panel-code');
        const panelPreview = document.getElementById('panel-preview');
        const btnSplit = document.getElementById('view-mode-split');
        const btnPreview = document.getElementById('view-mode-preview');
        const btnCode = document.getElementById('view-mode-code');

        // Reset tombol styles
        [btnSplit, btnPreview, btnCode].forEach(b => {
            b.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
            b.classList.add('text-slate-600');
        });

        if (mode === 'split') {
            btnSplit.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
            btnSplit.classList.remove('text-slate-600');

            panelCode.classList.remove('hidden');
            panelCode.classList.add('flex', 'md:w-1/2');
            panelCode.classList.remove('md:w-full');

            panelPreview.classList.remove('hidden');
            panelPreview.classList.add('flex', 'md:w-1/2');
            panelPreview.classList.remove('md:w-full');

        } else if (mode === 'preview') {
            btnPreview.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
            btnPreview.classList.remove('text-slate-600');

            panelCode.classList.add('hidden');
            panelCode.classList.remove('flex');

            panelPreview.classList.remove('hidden');
            panelPreview.classList.add('flex', 'w-full');
            panelPreview.classList.remove('md:w-1/2');

        } else if (mode === 'code') {
            btnCode.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
            btnCode.classList.remove('text-slate-600');

            panelPreview.classList.add('hidden');
            panelPreview.classList.remove('flex');

            panelCode.classList.remove('hidden');
            panelCode.classList.add('flex', 'w-full');
            panelCode.classList.remove('md:w-1/2');
        }
    }

    function setFrameDevice(device) {
        const iframe = document.getElementById('modal-preview-frame');
        const dimLabel = document.getElementById('preview-dimension-label');
        const btnDesk = document.getElementById('dev-btn-desktop');
        const btnTab = document.getElementById('dev-btn-tablet');
        const btnMob = document.getElementById('dev-btn-mobile');

        [btnDesk, btnTab, btnMob].forEach(b => {
            b.classList.remove('bg-white', 'text-slate-800', 'shadow-xs');
            b.classList.add('text-slate-600');
        });

        if (device === 'tablet') {
            btnTab.classList.add('bg-white', 'text-slate-800', 'shadow-xs');
            btnTab.classList.remove('text-slate-600');
            iframe.style.width = '768px';
            iframe.style.maxWidth = '100%';
            dimLabel.textContent = 'Mode Tablet (768px)';
        } else if (device === 'mobile') {
            btnMob.classList.add('bg-white', 'text-slate-800', 'shadow-xs');
            btnMob.classList.remove('text-slate-600');
            iframe.style.width = '375px';
            iframe.style.maxWidth = '100%';
            dimLabel.textContent = 'Mode Smartphone (375px)';
        } else {
            btnDesk.classList.add('bg-white', 'text-slate-800', 'shadow-xs');
            btnDesk.classList.remove('text-slate-600');
            iframe.style.width = '100%';
            dimLabel.textContent = '100% Layar Penuh';
        }
    }

    function setPresetScore(score) {
        document.getElementById('input-score').value = score;
    }

    function tutupModal() {
        document.getElementById('modal-kode').classList.add('hidden');
    }

    function bukaModalHapusSubmisi(id, name, challenge, deleteUrl) {
        document.getElementById('hapus-nama-siswa').textContent = name;
        document.getElementById('hapus-nama-latihan').textContent = challenge;
        document.getElementById('form-hapus-submisi').action = deleteUrl;
        document.getElementById('modal-konfirmasi-hapus').classList.remove('hidden');
    }

    function tutupModalHapusSubmisi() {
        document.getElementById('modal-konfirmasi-hapus').classList.add('hidden');
    }

    function bukaModalHapusSemua() {
        document.getElementById('modal-konfirmasi-hapus-semua').classList.remove('hidden');
    }

    function tutupModalHapusSemua() {
        document.getElementById('modal-konfirmasi-hapus-semua').classList.add('hidden');
    }

    function hapusSubmisiDariModal() {
        if (!activeSubmissionData) return;
        const sub = activeSubmissionData;
        tutupModal();
        bukaModalHapusSubmisi(
            sub.id, 
            sub.name, 
            sub.challenge, 
            '/admin/submissions/' + sub.id
        );
    }
</script>
@endsection