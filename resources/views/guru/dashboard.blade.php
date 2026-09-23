<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar Guru -->
    <header class="h-16 bg-white border-b border-gray-200 px-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-xl bg-green-600 text-white flex items-center justify-center font-bold">G</span>
            <div>
                <h1 class="font-extrabold text-base text-gray-900">Portal Guru - {{ $settings['app_name'] ?? 'VxAI' }}</h1>
                <span class="text-xs text-gray-400">Ruang Evaluasi Tugas & Submisi Siswa</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-600 font-semibold hidden sm:inline">
                👨‍🏫 {{ Auth::user()->name ?? 'Bapak/Ibu Guru' }}
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-6 space-y-6">
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl text-sm font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase">Total Siswa Terdaftar</span>
                <div class="text-3xl font-black text-gray-900 mt-2">{{ $totalSiswa }}</div>
                <div class="text-xs text-blue-600 font-semibold mt-1">Akun Siswa Aktif</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase">Tugas Dinilai</span>
                <div class="text-3xl font-black text-green-600 mt-2">{{ $gradedCount }}</div>
                <div class="text-xs text-gray-400 mt-1">Dari {{ $totalSubmissions }} Total Submisi</div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase">Menunggu Penilaian</span>
                <div class="text-3xl font-black text-yellow-600 mt-2">{{ $ungradedCount }}</div>
                <div class="text-xs text-yellow-600 font-semibold mt-1">Perlu Ditinjau</div>
            </div>
        </div>

        <!-- Tabel Submisi Siswa -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 text-sm">Submisi Koding Terbaru Siswa</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-gray-500 font-semibold uppercase">
                        <tr>
                            <th class="px-6 py-3">Nama Siswa</th>
                            <th class="px-6 py-3">Waktu Kirim</th>
                            <th class="px-6 py-3">Status / Nilai</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($recentSubmissions as $sub)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900 text-sm">
                                    {{ $sub->student_name }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($sub->score > 0)
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                            {{ $sub->score }}/100
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Dinilai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button onclick="lihatKode(this)"
                                            data-id="{{ $sub->id }}"
                                            data-name="{{ $sub->student_name }}"
                                            data-score="{{ $sub->score ?? 0 }}"
                                            data-feedback="{{ $sub->feedback ?? '' }}"
                                            data-html="{{ base64_encode($sub->html_code ?? '') }}"
                                            data-css="{{ base64_encode($sub->css_code ?? '') }}"
                                            data-js="{{ base64_encode($sub->js_code ?? '') }}"
                                            class="bg-green-600 hover:bg-green-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition">
                                        Periksa & Nilai
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada tugas siswa yang dikirimkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Modal Periksa & Beri Nilai -->
    <div id="modal-eval" class="fixed inset-0 bg-black/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-900" id="eval-title">Evaluasi Koding Siswa</h3>
                <button onclick="tutupModal()" class="text-gray-400 hover:text-red-500 font-bold text-2xl">&times;</button>
            </div>
            
            <div class="flex-1 p-4 overflow-y-auto grid grid-cols-1 md:grid-cols-3 gap-3 bg-gray-900 text-white">
                <div class="flex flex-col">
                    <span class="text-orange-400 text-xs font-bold mb-1">HTML</span>
                    <pre id="code-html" class="text-xs font-mono bg-gray-950 p-3 rounded-lg overflow-x-auto flex-1"></pre>
                </div>
                <div class="flex flex-col">
                    <span class="text-blue-400 text-xs font-bold mb-1">CSS</span>
                    <pre id="code-css" class="text-xs font-mono bg-gray-950 p-3 rounded-lg overflow-x-auto flex-1"></pre>
                </div>
                <div class="flex flex-col">
                    <span class="text-yellow-400 text-xs font-bold mb-1">JavaScript</span>
                    <pre id="code-js" class="text-xs font-mono bg-gray-950 p-3 rounded-lg overflow-x-auto flex-1"></pre>
                </div>
            </div>

            <form id="form-eval" method="POST" class="p-4 border-t bg-gray-50 flex items-center justify-between gap-4">
                @csrf
                <div class="flex items-center gap-3 flex-1">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600">Nilai (0-100)</label>
                        <input type="number" id="eval-score" name="score" min="0" max="100" class="w-20 px-3 py-1.5 border rounded-lg text-center font-bold" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[11px] font-bold text-gray-600">Catatan Masukan Guru</label>
                        <input type="text" id="eval-feedback" name="feedback" placeholder="Beri masukan membangun untuk siswa..." class="w-full px-3 py-1.5 border rounded-lg text-xs">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="tutupModal()" class="px-4 py-2 bg-gray-200 text-gray-700 text-xs font-bold rounded-lg">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg shadow">Simpan Nilai</button>
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

            document.getElementById('eval-title').textContent = 'Pekerjaan: ' + name;
            document.getElementById('code-html').textContent = decodeURIComponent(escape(atob(btn.getAttribute('data-html')))) || '<!-- Kosong -->';
            document.getElementById('code-css').textContent = decodeURIComponent(escape(atob(btn.getAttribute('data-css')))) || '/* Kosong */';
            document.getElementById('code-js').textContent = decodeURIComponent(escape(atob(btn.getAttribute('data-js')))) || '/* Kosong */';

            document.getElementById('eval-score').value = score || 0;
            document.getElementById('eval-feedback').value = feedback || '';
            document.getElementById('form-eval').action = '/guru/submissions/' + id + '/grade';

            document.getElementById('modal-eval').classList.remove('hidden');
        }
        function tutupModal() {
            document.getElementById('modal-eval').classList.add('hidden');
        }
    </script>
</body>
</html>
