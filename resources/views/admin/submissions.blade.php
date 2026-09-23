@extends('layouts.admin')

@section('title', 'Hasil Koding Siswa & Tamu - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Hasil Pekerjaan & Submisi Koding')

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
        <span class="text-xs font-bold text-gray-500 uppercase">Riwayat Submisi Kode ({{ count($submissions) }})</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-500 font-semibold uppercase">
                <tr>
                    <th class="px-6 py-3">Nama Pengirim</th>
                    <th class="px-6 py-3">Waktu Kirim</th>
                    <th class="px-6 py-3">Nilai & Umpan Balik</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($submissions as $sub)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-gray-900 text-sm">{{ $sub->student_name }}</div>
                        <div class="text-[11px] text-gray-400 font-mono">{{ $sub->student_email ?? 'Pengunjung Tamu' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                        {{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($sub->score > 0)
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                {{ $sub->score }} / 100
                            </span>
                            @if(!empty($sub->feedback))
                                <div class="text-[11px] text-gray-500 mt-1 italic max-w-xs truncate">"{{ $sub->feedback }}"</div>
                            @endif
                        @else
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                Belum Dinilai
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Tombol Lihat Kode -->
                            <button onclick="lihatKode(this)" 
                                    data-id="{{ $sub->id }}"
                                    data-name="{{ $sub->student_name }}"
                                    data-score="{{ $sub->score ?? 0 }}"
                                    data-feedback="{{ $sub->feedback ?? '' }}"
                                    data-html="{{ base64_encode($sub->html_code ?? '') }}"
                                    data-css="{{ base64_encode($sub->css_code ?? '') }}"
                                    data-js="{{ base64_encode($sub->js_code ?? '') }}"
                                    class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                🔍 Lihat & Uji
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-medium">
                        Belum ada yang mengirimkan kode dari Playground.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL POP-UP LIHAT KODE & PENILAIAN -->
<!-- ========================================== -->
<div id="modal-kode" class="fixed inset-0 bg-black/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[92vh] flex flex-col overflow-hidden">
        
        <!-- Header Modal -->
        <div class="p-4 border-b flex justify-between items-center bg-gray-50">
            <div>
                <h3 class="font-bold text-gray-900 text-base" id="modal-title">Pratinjau Kode</h3>
                <span class="text-xs text-gray-500">Inspeksi sintaksis HTML, CSS, JavaScript dan pemberian nilai</span>
            </div>
            <button onclick="tutupModal()" class="text-gray-400 hover:text-red-500 font-bold text-2xl leading-none">&times;</button>
        </div>
        
        <!-- Konten 3 Kolom Kode -->
        <div class="flex-1 p-5 overflow-y-auto grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-100">
            
            <!-- Box HTML -->
            <div class="bg-gray-900 rounded-xl p-3 shadow-inner flex flex-col">
                <div class="text-orange-400 font-bold text-xs mb-2 uppercase border-b border-gray-700 pb-1">HTML</div>
                <pre id="modal-html" class="text-gray-300 text-xs overflow-x-auto whitespace-pre-wrap font-mono flex-1"></pre>
            </div>
            
            <!-- Box CSS -->
            <div class="bg-gray-900 rounded-xl p-3 shadow-inner flex flex-col">
                <div class="text-blue-400 font-bold text-xs mb-2 uppercase border-b border-gray-700 pb-1">CSS</div>
                <pre id="modal-css" class="text-gray-300 text-xs overflow-x-auto whitespace-pre-wrap font-mono flex-1"></pre>
            </div>
            
            <!-- Box JS -->
            <div class="bg-gray-900 rounded-xl p-3 shadow-inner flex flex-col">
                <div class="text-yellow-400 font-bold text-xs mb-2 uppercase border-b border-gray-700 pb-1">JavaScript</div>
                <pre id="modal-js" class="text-gray-300 text-xs overflow-x-auto whitespace-pre-wrap font-mono flex-1"></pre>
            </div>
            
        </div>
        
        <!-- Footer Form Beri Nilai -->
        <form id="form-grade" method="POST" class="p-4 border-t bg-gray-50">
            @csrf
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Skor Nilai (0-100)</label>
                        <input type="number" id="input-score" name="score" min="0" max="100" class="w-24 px-3 py-1.5 border rounded-lg text-sm font-bold text-center" required>
                    </div>
                    <div class="flex-1 sm:w-72">
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Catatan Evaluasi / Umpan Balik</label>
                        <input type="text" id="input-feedback" name="feedback" placeholder="Contoh: Kerja bagus! Rapikan tag penutup." class="w-full px-3 py-1.5 border rounded-lg text-xs">
                    </div>
                </div>
                
                <div class="flex gap-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="tutupModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl text-xs font-semibold transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl text-xs font-bold shadow transition">
                        Simpan Nilai
                    </button>
                </div>
            </div>
        </form>
        
    </div>
</div>

<script>
    function lihatKode(btn) {
        const id = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');
        const score = btn.getAttribute('data-score');
        const feedback = btn.getAttribute('data-feedback');

        const html = decodeURIComponent(escape(atob(btn.getAttribute('data-html'))));
        const css = decodeURIComponent(escape(atob(btn.getAttribute('data-css'))));
        const js = decodeURIComponent(escape(atob(btn.getAttribute('data-js'))));

        document.getElementById('modal-title').textContent = 'Pratinjau Kode: ' + name;
        document.getElementById('modal-html').textContent = html || '<!-- Kosong -->';
        document.getElementById('modal-css').textContent = css || '/* Kosong */';
        document.getElementById('modal-js').textContent = js || '/* Kosong */';

        document.getElementById('input-score').value = score || 0;
        document.getElementById('input-feedback').value = feedback || '';

        // Pasang action URL untuk penilaian
        document.getElementById('form-grade').action = '/admin/submissions/' + id + '/grade';

        document.getElementById('modal-kode').classList.remove('hidden');
    }

    function tutupModal() {
        document.getElementById('modal-kode').classList.add('hidden');
    }
</script>
@endsection