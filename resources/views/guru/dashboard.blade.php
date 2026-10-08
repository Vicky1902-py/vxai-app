<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Guru - {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</title>
    
    <!-- Favicon -->
    @if(!empty($settings['app_favicon']))
        <link rel="icon" href="{{ asset($settings['app_favicon']) }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre, .font-mono { font-family: 'JetBrains Mono', monospace; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar Guru -->
    <header class="h-20 bg-white border-b border-slate-200/90 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center font-black text-lg shadow-md shadow-emerald-500/20">
                G
            </div>
            <div>
                <h1 class="font-extrabold text-base text-slate-900 tracking-tight">Portal Pengajar - {{ $settings['app_name'] ?? 'VxAI' }}</h1>
                <span class="text-xs text-slate-400">Ruang Evaluasi Tugas & Penilaian Hasil Koding Siswa</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-xs text-slate-600 font-bold hidden sm:inline-flex items-center gap-2 bg-slate-100 px-3.5 py-1.5 rounded-full">
                <span>👨‍🏫</span> <span>{{ Auth::user()->name ?? 'Bapak/Ibu Guru' }}</span>
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-xs font-bold px-4 py-2 rounded-xl transition duration-150">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-6 sm:p-8 space-y-6">
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-semibold flex items-center gap-3 shadow-sm">
                <span class="text-emerald-500 font-bold text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa Terdaftar</span>
                <div class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $totalSiswa }}</div>
                <div class="text-xs text-blue-600 font-semibold mt-1 flex items-center gap-1">
                    <span>👥</span> <span>Akun Siswa Aktif</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tugas Dinilai</span>
                <div class="text-3xl font-extrabold text-emerald-600 mt-2 tracking-tight">{{ $gradedCount }}</div>
                <div class="text-xs text-slate-400 mt-1">Dari {{ $totalSubmissions }} Total Submisi Masuk</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Penilaian</span>
                <div class="text-3xl font-extrabold text-amber-500 mt-2 tracking-tight">{{ $ungradedCount }}</div>
                <div class="text-xs text-amber-600 font-semibold mt-1 flex items-center gap-1">
                    <span>⚡</span> <span>Perlu Ditinjau & Dinilai</span>
                </div>
            </div>
        </div>

        <!-- Tabel Submisi Siswa -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Submisi Koding Siswa</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Periksa kode, uji live output, dan beri umpan balik edukatif</p>
                </div>
                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-xl">
                    Total: {{ count($recentSubmissions) }} Tugas
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs divide-y divide-slate-100">
                    <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">Waktu Kirim</th>
                            <th class="px-6 py-4">Status / Nilai</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($recentSubmissions as $sub)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                            {{ substr($sub->student_name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-900 text-sm">{{ $sub->student_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500 font-medium">
                                    {{ \Carbon\Carbon::parse($sub->created_at)->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($sub->score > 0)
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Skor: {{ $sub->score }}/100
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                            Belum Dinilai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="lihatKode(this)"
                                                data-id="{{ $sub->id }}"
                                                data-name="{{ $sub->student_name }}"
                                                data-score="{{ $sub->score ?? 0 }}"
                                                data-feedback="{{ $sub->feedback ?? '' }}"
                                                data-html="{{ base64_encode($sub->html_code ?? '') }}"
                                                data-css="{{ base64_encode($sub->css_code ?? '') }}"
                                                data-js="{{ base64_encode($sub->js_code ?? '') }}"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition duration-150 shadow-md shadow-emerald-600/20 inline-flex items-center gap-1.5 active:scale-95">
                                            <span>🔍</span> <span>Periksa & Nilai</span>
                                        </button>
                                        <button type="button" 
                                                onclick="bukaModalHapusSubmisiGuru('{{ $sub->id }}', '{{ addslashes($sub->student_name) }}', '{{ route('guru.submissions.delete', $sub->id) }}')" 
                                                class="text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 hover:border-rose-600 font-bold text-xs px-3 py-2 rounded-xl transition duration-150 inline-flex items-center gap-1 active:scale-95"
                                                title="Hapus tugas siswa & sesuaikan level">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium">
                                    <div class="text-3xl mb-2">📬</div>
                                    Belum ada tugas siswa yang dikirimkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Modal Periksa, Live Preview & Beri Nilai -->
    <div id="modal-eval" class="fixed inset-0 bg-slate-950/85 z-[100] hidden flex items-center justify-center p-2 sm:p-4 backdrop-blur-md">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-[97vw] h-[94vh] max-h-[94vh] flex flex-col overflow-hidden border border-slate-300">
            
            <div class="p-4 sm:px-6 sm:py-3.5 border-b border-slate-200 flex flex-wrap justify-between items-center bg-slate-50 gap-3 shrink-0">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-lg font-bold shadow-md shadow-emerald-500/20">
                        🔬
                    </span>
                    <div>
                        <h3 class="font-black text-slate-900 text-base" id="eval-title">Evaluasi Koding Siswa</h3>
                        <span class="text-xs text-slate-500">Tinjau kode HTML, CSS, JS dan uji hasil tampilan website</span>
                    </div>
                </div>

                <!-- Mode Switcher -->
                <div class="flex items-center gap-2">
                    <div class="flex items-center bg-slate-200 p-1 rounded-xl text-xs font-bold border border-slate-300">
                        <button type="button" id="tab-btn-guru-split" onclick="switchEvalMode('split')" class="px-3.5 py-1.5 rounded-lg bg-white text-slate-900 shadow-sm transition flex items-center gap-1.5">
                            <span>🌓</span> <span>Dampingan (Split)</span>
                        </button>
                        <button type="button" id="tab-btn-guru-preview" onclick="switchEvalMode('preview')" class="px-3.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5">
                            <span>⚡</span> <span>Preview Penuh</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        </button>
                        <button type="button" id="tab-btn-guru-code" onclick="switchEvalMode('code')" class="px-3.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5">
                            <span>💻</span> <span>Kode Penuh</span>
                        </button>
                    </div>

                    <button onclick="tutupModal()" class="text-slate-400 hover:text-rose-500 font-bold text-3xl leading-none px-2 transition">&times;</button>
                </div>
            </div>
            
            <!-- Main Workspace: Tinggi Lega -->
            <div id="eval-workspace" class="flex-1 min-h-0 flex flex-col md:flex-row bg-slate-950 overflow-hidden relative">
                
                <!-- Panel Kode -->
                <div id="eval-panel-code" class="flex-1 flex flex-col md:flex-row gap-2 p-3 overflow-y-auto custom-scrollbar bg-slate-950 border-r border-slate-800 transition-all duration-200">
                    <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                        <span class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 text-orange-400 text-xs font-mono font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                            <span>HTML5 Markup</span>
                        </span>
                        <pre id="code-html" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                    </div>
                    <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                        <span class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 text-blue-400 text-xs font-mono font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span>CSS3 Styling</span>
                        </span>
                        <pre id="code-css" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                    </div>
                    <div class="flex-1 flex flex-col bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-inner min-h-[160px]">
                        <span class="px-3.5 py-2 bg-slate-950/80 border-b border-slate-800 text-yellow-400 text-xs font-mono font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span>JavaScript Logic</span>
                        </span>
                        <pre id="code-js" class="p-3 text-slate-300 text-xs font-mono overflow-auto whitespace-pre-wrap flex-1 custom-scrollbar leading-relaxed"></pre>
                    </div>
                </div>

                <!-- Panel Live Output -->
                <div id="eval-panel-preview" class="flex-1 flex flex-col bg-slate-200 transition-all duration-200 overflow-hidden relative">
                    <div class="px-4 py-2 bg-slate-100 border-b border-slate-300 text-xs font-bold text-slate-700 flex justify-between items-center shrink-0">
                        <span class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Tampilan Hasil Langsung (Live Output)</span>
                        </span>
                        <span class="text-[11px] text-slate-500 font-mono">Real-time Sandbox</span>
                    </div>
                    <div class="flex-1 bg-slate-300 p-2 sm:p-3 overflow-auto flex items-center justify-center">
                        <iframe id="eval-preview-frame" class="w-full h-full bg-white rounded-2xl border border-slate-300 shadow-xl transition-all duration-200" sandbox="allow-scripts allow-modals"></iframe>
                    </div>
                </div>

            </div>

            <!-- Form Nilai -->
            <form id="form-eval" method="POST" class="p-4 sm:px-6 sm:py-3.5 border-t border-slate-200 bg-slate-50 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 shrink-0">
                @csrf
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 flex-1">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Skor (0-100)</label>
                        <input type="number" id="eval-score" name="score" min="0" max="100" class="w-20 sm:w-24 px-3 py-2 border border-slate-300 rounded-xl text-base font-extrabold text-center focus:ring-2 focus:ring-emerald-500 bg-white" required>
                    </div>

                    <!-- Preset Skor -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pilih Cepat</label>
                        <div class="flex flex-wrap items-center gap-1">
                            <button type="button" onclick="setPresetScore(100)" class="px-2.5 py-1.5 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-bold hover:bg-emerald-200 transition">100 Sempurna</button>
                            <button type="button" onclick="setPresetScore(90)" class="px-2.5 py-1.5 rounded-lg bg-blue-100 text-blue-800 text-xs font-bold hover:bg-blue-200 transition">90 Hebat</button>
                            <button type="button" onclick="setPresetScore(80)" class="px-2.5 py-1.5 rounded-lg bg-indigo-100 text-indigo-800 text-xs font-bold hover:bg-indigo-200 transition">80 Baik</button>
                            <button type="button" onclick="setPresetScore(70)" class="px-2.5 py-1.5 rounded-lg bg-amber-100 text-amber-800 text-xs font-bold hover:bg-amber-200 transition">70 Cukup</button>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[240px]">
                        <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Catatan Evaluasi / Masukan Guru</label>
                        <input type="text" id="eval-feedback" name="feedback" placeholder="Misal: Struktur HTML rapi, perbaiki responsive..." class="w-full px-4 py-2 border border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>
                </div>

                <div class="flex items-center gap-2.5 shrink-0 justify-end">
                    <button type="button" onclick="tutupModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs px-6 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                        <span>💾</span> <span>Simpan Nilai Siswa</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Submisi Guru -->
    <div id="modal-guru-konfirmasi-hapus" class="fixed inset-0 bg-slate-950/85 z-[150] hidden flex items-center justify-center p-4 backdrop-blur-md">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md flex flex-col border border-slate-200 overflow-hidden">
            <div class="p-6 text-center space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-3xl mx-auto border border-rose-200 shadow-sm animate-bounce">
                    🗑️
                </div>
                <h3 class="font-extrabold text-slate-900 text-lg">Hapus Tugas Siswa Ini?</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Tugas koding milik siswa <strong id="guru-hapus-nama-siswa" class="text-emerald-700">-</strong> akan dihapus permanen.
                </p>
                <div class="p-3.5 bg-rose-50 rounded-2xl border border-rose-200 text-left text-xs text-rose-900 space-y-1.5">
                    <span class="font-black text-rose-700 flex items-center gap-1 text-[11px] uppercase">
                        <span>⚠️</span> <span>Pengaruh Level & XP:</span>
                    </span>
                    <p class="text-slate-700 text-[11px] leading-relaxed">
                        Poin XP siswa dikurangi (-25 XP), level siswa dihitung ulang, dan status penyelesaian level tugas ini pada akun siswa otomatis terhapus / kembali terbuka.
                    </p>
                </div>
            </div>
            <form id="form-guru-hapus-submisi" method="POST" action="" class="p-4 bg-slate-50 border-t border-slate-100 flex items-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="tutupModalHapusSubmisiGuru()" class="flex-1 py-2.5 px-4 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition active:scale-95">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-md shadow-rose-600/30 transition flex items-center justify-center gap-1.5 active:scale-95">
                    <span>🗑️</span> <span>Ya, Hapus Tugas</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        let currentHtml = '';
        let currentCss = '';
        let currentJs = '';

        function bukaModalHapusSubmisiGuru(id, name, deleteUrl) {
            document.getElementById('guru-hapus-nama-siswa').textContent = name;
            document.getElementById('form-guru-hapus-submisi').action = deleteUrl;
            document.getElementById('modal-guru-konfirmasi-hapus').classList.remove('hidden');
        }

        function tutupModalHapusSubmisiGuru() {
            document.getElementById('modal-guru-konfirmasi-hapus').classList.add('hidden');
        }

        function setPresetScore(val) {
            document.getElementById('eval-score').value = val;
        }

        function switchEvalMode(mode) {
            const btnSplit = document.getElementById('tab-btn-guru-split');
            const btnPreview = document.getElementById('tab-btn-guru-preview');
            const btnCode = document.getElementById('tab-btn-guru-code');
            const panelCode = document.getElementById('eval-panel-code');
            const panelPreview = document.getElementById('eval-panel-preview');

            [btnSplit, btnPreview, btnCode].forEach(b => {
                b.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                b.classList.add('text-slate-600');
            });

            if (mode === 'split') {
                btnSplit.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btnSplit.classList.remove('text-slate-600');

                panelCode.classList.remove('hidden');
                panelCode.classList.add('flex', 'md:w-1/2');

                panelPreview.classList.remove('hidden');
                panelPreview.classList.add('flex', 'md:w-1/2');

            } else if (mode === 'preview') {
                btnPreview.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btnPreview.classList.remove('text-slate-600');

                panelCode.classList.add('hidden');
                panelCode.classList.remove('flex');

                panelPreview.classList.remove('hidden');
                panelPreview.classList.add('flex', 'w-full');

            } else if (mode === 'code') {
                btnCode.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btnCode.classList.remove('text-slate-600');

                panelPreview.classList.add('hidden');
                panelPreview.classList.remove('flex');

                panelCode.classList.remove('hidden');
                panelCode.classList.add('flex', 'w-full');
            }
        }

        function lihatKode(btn) {
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            const score = btn.getAttribute('data-score');
            const feedback = btn.getAttribute('data-feedback');

            currentHtml = decodeURIComponent(escape(atob(btn.getAttribute('data-html')))) || '';
            currentCss = decodeURIComponent(escape(atob(btn.getAttribute('data-css')))) || '';
            currentJs = decodeURIComponent(escape(atob(btn.getAttribute('data-js')))) || '';

            document.getElementById('eval-title').textContent = 'Pekerjaan: ' + name;
            document.getElementById('code-html').textContent = currentHtml || '<!-- Kosong -->';
            document.getElementById('code-css').textContent = currentCss || '/* Kosong */';
            document.getElementById('code-js').textContent = currentJs || '/* Kosong */';

            // Render ke Iframe
            const frameDoc = `<!DOCTYPE html><html><head><style>${currentCss}</style></head><body>${currentHtml}<script>${currentJs}<\/script></body></html>`;
            document.getElementById('eval-preview-frame').srcdoc = frameDoc;

            document.getElementById('eval-score').value = score || 0;
            document.getElementById('eval-feedback').value = feedback || '';
            document.getElementById('form-eval').action = '/guru/submissions/' + id + '/grade';

            if (window.innerWidth < 768) {
                switchEvalMode('preview');
            } else {
                switchEvalMode('split');
            }

            document.getElementById('modal-eval').classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('modal-eval').classList.add('hidden');
        }
    </script>
</body>
</html>

