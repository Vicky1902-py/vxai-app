@extends('layouts.admin')

@section('title', 'Hasil Koding Siswa - ' . ($settings['app_name'] ?? 'CMS'))
@section('header_title', 'Hasil Pekerjaan Siswa (Submissions)')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Kirim</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Nilai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($submissions as $sub)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="font-medium text-gray-900">{{ $sub->student_name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if ($sub->score > 0)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $sub->score }} / 100</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Belum Dinilai</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <!-- Tombol untuk membuka Modal (Data di-encode dengan Base64 agar aman) -->
                    <button onclick="lihatKode(this)" 
                            data-html="{{ base64_encode($sub->html_code) }}"
                            data-css="{{ base64_encode($sub->css_code) }}"
                            data-js="{{ base64_encode($sub->js_code) }}"
                            class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded shadow-sm text-xs font-bold transition">
                        🔍 Lihat Kode
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-gray-500 font-medium">
                    Belum ada siswa yang mengirimkan kode dari Playground.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- ========================================== -->
<!-- MODAL POP-UP LIHAT KODE -->
<!-- ========================================== -->
<div id="modal-kode" class="fixed inset-0 bg-black/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden transition-transform">
        
        <!-- Header Modal -->
        <div class="p-4 border-b flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800 text-lg">Pratinjau Kode Siswa</h3>
            <button onclick="tutupModal()" class="text-gray-400 hover:text-red-500 font-bold text-3xl leading-none transition">&times;</button>
        </div>
        
        <!-- Konten 3 Kolom (HTML, CSS, JS) -->
        <div class="flex-1 p-6 overflow-y-auto grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-100">
            
            <!-- Box HTML -->
            <div class="bg-gray-800 rounded-lg p-4 shadow-inner flex flex-col">
                <div class="text-orange-400 font-bold text-xs mb-3 uppercase tracking-wider border-b border-gray-600 pb-2">HTML</div>
                <pre id="modal-html" class="text-gray-300 text-sm overflow-x-auto whitespace-pre-wrap font-mono flex-1"></pre>
            </div>
            
            <!-- Box CSS -->
            <div class="bg-gray-800 rounded-lg p-4 shadow-inner flex flex-col">
                <div class="text-blue-400 font-bold text-xs mb-3 uppercase tracking-wider border-b border-gray-600 pb-2">CSS</div>
                <pre id="modal-css" class="text-gray-300 text-sm overflow-x-auto whitespace-pre-wrap font-mono flex-1"></pre>
            </div>
            
            <!-- Box JS -->
            <div class="bg-gray-800 rounded-lg p-4 shadow-inner flex flex-col">
                <div class="text-yellow-400 font-bold text-xs mb-3 uppercase tracking-wider border-b border-gray-600 pb-2">JavaScript</div>
                <pre id="modal-js" class="text-gray-300 text-sm overflow-x-auto whitespace-pre-wrap font-mono flex-1"></pre>
            </div>
            
        </div>
        
        <!-- Footer Modal -->
        <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
            <p class="text-xs text-gray-500 font-semibold">*Fitur penilaian otomatis dan manual akan ditambahkan pada update berikutnya.</p>
            <div class="flex gap-3">
                <button onclick="tutupModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-bold shadow transition">Tutup</button>
                <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-bold shadow transition">Beri Nilai</button>
            </div>
        </div>
        
    </div>
</div>

<!-- Script untuk Decode Base64 & Tampilkan Modal -->
<script>
    function lihatKode(btn) {
        // Mengambil data Base64 dari tombol, lalu mengubahnya kembali menjadi teks asli (decode)
        const html = decodeURIComponent(escape(atob(btn.getAttribute('data-html'))));
        const css = decodeURIComponent(escape(atob(btn.getAttribute('data-css'))));
        const js = decodeURIComponent(escape(atob(btn.getAttribute('data-js'))));

        // Memasukkan kode ke dalam blok <pre>
        document.getElementById('modal-html').textContent = html || '<!-- Kosong -->';
        document.getElementById('modal-css').textContent = css || '/* Kosong */';
        document.getElementById('modal-js').textContent = js || '/* Kosong */';

        // Tampilkan Modal
        document.getElementById('modal-kode').classList.remove('hidden');
    }

    function tutupModal() {
        document.getElementById('modal-kode').classList.add('hidden');
    }
</script>
@endsection