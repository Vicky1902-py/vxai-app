@extends('layouts.admin')

@section('title', 'Hasil Koding Masuk - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Hasil Koding & Evaluasi Tugas')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-extrabold text-slate-900">Daftar Submisi Koding</h3>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau kode dari siswa dan pengunjung publik, uji live, dan berikan evaluasi nilai</p>
        </div>
        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-xl">
            Total: {{ count($submissions) }} Tugas
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs divide-y divide-slate-100">
            <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Pengirim</th>
                    <th class="px-6 py-4">Waktu Pengiriman</th>
                    <th class="px-6 py-4">Status & Nilai</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($submissions as $sub)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-xs shadow-sm">
                                {{ substr($sub->student_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">{{ $sub->student_name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $sub->student_email ?? 'Pengunjung Publik (Tamu)' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-medium">
                        {{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($sub->score > 0)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Skor: {{ $sub->score }} / 100
                            </span>
                            @if(!empty($sub->feedback))
                                <div class="text-[11px] text-slate-500 mt-1 italic max-w-xs truncate">"{{ $sub->feedback }}"</div>
                            @endif
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                Belum Dinilai
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                        <button onclick="lihatDanUjiKode(this)" 
                                data-id="{{ $sub->id }}"
                                data-name="{{ $sub->student_name }}"
                                data-score="{{ $sub->score ?? 0 }}"
                                data-feedback="{{ $sub->feedback ?? '' }}"
                                data-html="{{ base64_encode($sub->html_code ?? '') }}"
                                data-css="{{ base64_encode($sub->css_code ?? '') }}"
                                data-js="{{ base64_encode($sub->js_code ?? '') }}"
                                class="inline-flex items-center gap-1.5 text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 px-4 py-2 rounded-xl text-xs font-bold transition duration-150 shadow-sm">
                            <span>🔍</span> <span>Periksa & Uji Live</span>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center text-slate-400 font-medium">
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
<!-- MODAL INSPEKSI KODE, LIVE OUTPUT & PENILAIAN LENGKAP -->
<!-- ======================================================== -->
<div id="modal-kode" class="fixed inset-0 bg-slate-950/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl max-h-[92vh] flex flex-col overflow-hidden border border-slate-200">
        
        <!-- Header Modal & Tab Navigasi -->
        <div class="p-5 border-b border-slate-200 bg-slate-50 flex flex-wrap justify-between items-center gap-3">
            <div>
                <h3 class="font-black text-slate-900 text-base" id="modal-title">Inspeksi Kode Siswa</h3>
                <span class="text-xs text-slate-500">Periksa sintaksis kode dan uji hasil tampilannya secara interaktif</span>
            </div>

            <!-- Tab Switcher (Kode vs Live Output) -->
            <div class="flex items-center bg-slate-200 p-1 rounded-xl text-xs font-bold">
                <button type="button" id="tab-btn-code" onclick="switchModalView('code')" class="px-4 py-1.5 rounded-lg bg-white text-slate-900 shadow-sm transition">
                    💻 Lihat Sintaksis (HTML/CSS/JS)
                </button>
                <button type="button" id="tab-btn-preview" onclick="switchModalView('preview')" class="px-4 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5">
                    <span>⚡ Pratinjau Tampilan (Live)</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </button>
            </div>

            <button onclick="tutupModal()" class="text-slate-400 hover:text-rose-500 font-bold text-2xl leading-none transition">&times;</button>
        </div>
        
        <!-- Area 1: 3 Kolom Kode Sintaksis -->
        <div id="modal-view-code" class="flex-1 p-5 overflow-y-auto grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-950 min-h-[350px]">
            
            <!-- Box HTML -->
            <div class="bg-slate-900 rounded-2xl p-4 border border-slate-800 flex flex-col shadow-inner">
                <div class="flex justify-between items-center text-orange-400 font-mono font-bold text-xs mb-2 pb-2 border-b border-slate-800">
                    <span>HTML5</span>
                    <span class="text-[10px] text-slate-500">Markup</span>
                </div>
                <pre id="modal-html" class="text-slate-300 text-xs overflow-x-auto whitespace-pre-wrap font-mono flex-1 custom-scrollbar"></pre>
            </div>
            
            <!-- Box CSS -->
            <div class="bg-slate-900 rounded-2xl p-4 border border-slate-800 flex flex-col shadow-inner">
                <div class="flex justify-between items-center text-blue-400 font-mono font-bold text-xs mb-2 pb-2 border-b border-slate-800">
                    <span>CSS3</span>
                    <span class="text-[10px] text-slate-500">Styling</span>
                </div>
                <pre id="modal-css" class="text-slate-300 text-xs overflow-x-auto whitespace-pre-wrap font-mono flex-1 custom-scrollbar"></pre>
            </div>
            
            <!-- Box JS -->
            <div class="bg-slate-900 rounded-2xl p-4 border border-slate-800 flex flex-col shadow-inner">
                <div class="flex justify-between items-center text-yellow-400 font-mono font-bold text-xs mb-2 pb-2 border-b border-slate-800">
                    <span>JavaScript</span>
                    <span class="text-[10px] text-slate-500">Logic</span>
                </div>
                <pre id="modal-js" class="text-slate-300 text-xs overflow-x-auto whitespace-pre-wrap font-mono flex-1 custom-scrollbar"></pre>
            </div>
            
        </div>

        <!-- Area 2: Live Preview Frame -->
        <div id="modal-view-preview" class="hidden flex-1 bg-slate-100 p-4 min-h-[350px]">
            <iframe id="modal-preview-frame" class="w-full h-full bg-white rounded-2xl border-2 border-slate-300 shadow-inner" sandbox="allow-scripts"></iframe>
        </div>
        
        <!-- Footer Form Beri Nilai & Masukan -->
        <form id="form-grade" method="POST" class="p-5 border-t border-slate-200 bg-slate-50">
            @csrf
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                
                <!-- Input Nilai & Preset -->
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Skor (0-100)</label>
                        <input type="number" id="input-score" name="score" min="0" max="100" class="w-24 px-3 py-2 border border-slate-300 rounded-xl text-base font-extrabold text-center focus:ring-2 focus:ring-blue-500 bg-white" required>
                    </div>

                    <!-- Preset Cepat -->
                    <div class="flex items-center gap-1.5 pt-4">
                        <button type="button" onclick="setPresetScore(100)" class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-[11px] font-bold hover:bg-emerald-200 transition">100 Sempurna</button>
                        <button type="button" onclick="setPresetScore(90)" class="px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800 text-[11px] font-bold hover:bg-blue-200 transition">90 Bagus</button>
                        <button type="button" onclick="setPresetScore(80)" class="px-2.5 py-1 rounded-lg bg-indigo-100 text-indigo-800 text-[11px] font-bold hover:bg-indigo-200 transition">80 Baik</button>
                        <button type="button" onclick="setPresetScore(70)" class="px-2.5 py-1 rounded-lg bg-amber-100 text-amber-800 text-[11px] font-bold hover:bg-amber-200 transition">70 Cukup</button>
                    </div>

                    <!-- Catatan Feedback -->
                    <div class="flex-1 min-w-[280px]">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Catatan Evaluasi / Masukan</label>
                        <input type="text" id="input-feedback" name="feedback" placeholder="Beri catatan apresiasi atau perbaikan koding..." class="w-full px-4 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 bg-white">
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="flex gap-2.5 w-full lg:w-auto justify-end">
                    <button type="button" onclick="tutupModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-xl text-xs font-bold transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-xs font-extrabold shadow-md shadow-emerald-600/20 transition">
                        Simpan Nilai & Feedback
                    </button>
                </div>

            </div>
        </form>
        
    </div>
</div>

<script>
    let currentRawHtml = '';
    let currentRawCss = '';
    let currentRawJs = '';

    function lihatDanUjiKode(btn) {
        const id = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');
        const score = btn.getAttribute('data-score');
        const feedback = btn.getAttribute('data-feedback');

        currentRawHtml = decodeURIComponent(escape(atob(btn.getAttribute('data-html'))));
        currentRawCss = decodeURIComponent(escape(atob(btn.getAttribute('data-css'))));
        currentRawJs = decodeURIComponent(escape(atob(btn.getAttribute('data-js'))));

        document.getElementById('modal-title').textContent = 'Pratinjau Kode: ' + name;
        document.getElementById('modal-html').textContent = currentRawHtml || '<!-- Kosong -->';
        document.getElementById('modal-css').textContent = currentRawCss || '/* Kosong */';
        document.getElementById('modal-js').textContent = currentRawJs || '/* Kosong */';

        // Render preview ke iframe
        const frameDoc = `<!DOCTYPE html><html><head><meta charset="utf-8"><style>${currentRawCss}</style></head><body>${currentRawHtml}<script>${currentRawJs}<\/script></body></html>`;
        document.getElementById('modal-preview-frame').srcdoc = frameDoc;

        document.getElementById('input-score').value = score || 0;
        document.getElementById('input-feedback').value = feedback || '';

        document.getElementById('form-grade').action = '/admin/submissions/' + id + '/grade';

        // Reset ke tab code
        switchModalView('code');

        document.getElementById('modal-kode').classList.remove('hidden');
    }

    function switchModalView(mode) {
        const viewCode = document.getElementById('modal-view-code');
        const viewPreview = document.getElementById('modal-view-preview');
        const btnCode = document.getElementById('tab-btn-code');
        const btnPreview = document.getElementById('tab-btn-preview');

        if (mode === 'preview') {
            viewCode.classList.add('hidden');
            viewPreview.classList.remove('hidden');

            btnPreview.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
            btnPreview.classList.remove('text-slate-600');

            btnCode.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
            btnCode.classList.add('text-slate-600');
        } else {
            viewPreview.classList.add('hidden');
            viewCode.classList.remove('hidden');

            btnCode.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
            btnCode.classList.remove('text-slate-600');

            btnPreview.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
            btnPreview.classList.add('text-slate-600');
        }
    }

    function setPresetScore(score) {
        document.getElementById('input-score').value = score;
    }

    function tutupModal() {
        document.getElementById('modal-kode').classList.add('hidden');
    }
</script>
@endsection