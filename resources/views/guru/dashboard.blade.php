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
                                    <button onclick="lihatKode(this)"
                                            data-id="{{ $sub->id }}"
                                            data-name="{{ $sub->student_name }}"
                                            data-score="{{ $sub->score ?? 0 }}"
                                            data-feedback="{{ $sub->feedback ?? '' }}"
                                            data-html="{{ base64_encode($sub->html_code ?? '') }}"
                                            data-css="{{ base64_encode($sub->css_code ?? '') }}"
                                            data-js="{{ base64_encode($sub->js_code ?? '') }}"
                                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition duration-150 shadow-md shadow-emerald-600/20 inline-flex items-center gap-1.5">
                                        <span>🔍</span> <span>Periksa & Nilai</span>
                                    </button>
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
    <div id="modal-eval" class="fixed inset-0 bg-slate-950/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl max-h-[92vh] flex flex-col overflow-hidden border border-slate-200">
            
            <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="font-black text-slate-900 text-base" id="eval-title">Evaluasi Koding Siswa</h3>
                    <span class="text-xs text-slate-500">Tinjau kode HTML, CSS, JS dan uji hasil tampilan website</span>
                </div>

                <!-- Tab Switcher (Kode vs Live Output) -->
                <div class="flex items-center bg-slate-200 p-1 rounded-xl text-xs font-bold">
                    <button type="button" id="tab-btn-code" onclick="switchEvalTab('code')" class="px-4 py-1.5 rounded-lg bg-white text-slate-900 shadow-sm transition">
                        💻 Kode Sintaksis
                    </button>
                    <button type="button" id="tab-btn-preview" onclick="switchEvalTab('preview')" class="px-4 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5">
                        <span>⚡ Live Output</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </button>
                </div>

                <button onclick="tutupModal()" class="text-slate-400 hover:text-rose-500 font-bold text-2xl leading-none">&times;</button>
            </div>
            
            <!-- Tab View 1: Kode -->
            <div id="eval-view-code" class="flex-1 p-5 overflow-y-auto grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-950 min-h-[350px]">
                <div class="bg-slate-900 rounded-2xl p-4 border border-slate-800 flex flex-col">
                    <span class="text-orange-400 text-xs font-mono font-bold mb-2 pb-2 border-b border-slate-800">HTML5</span>
                    <pre id="code-html" class="text-slate-300 text-xs font-mono overflow-x-auto whitespace-pre-wrap flex-1 custom-scrollbar"></pre>
                </div>
                <div class="bg-slate-900 rounded-2xl p-4 border border-slate-800 flex flex-col">
                    <span class="text-blue-400 text-xs font-mono font-bold mb-2 pb-2 border-b border-slate-800">CSS3</span>
                    <pre id="code-css" class="text-slate-300 text-xs font-mono overflow-x-auto whitespace-pre-wrap flex-1 custom-scrollbar"></pre>
                </div>
                <div class="bg-slate-900 rounded-2xl p-4 border border-slate-800 flex flex-col">
                    <span class="text-yellow-400 text-xs font-mono font-bold mb-2 pb-2 border-b border-slate-800">JavaScript</span>
                    <pre id="code-js" class="text-slate-300 text-xs font-mono overflow-x-auto whitespace-pre-wrap flex-1 custom-scrollbar"></pre>
                </div>
            </div>

            <!-- Tab View 2: Live Preview Frame -->
            <div id="eval-view-preview" class="hidden flex-1 bg-slate-100 p-4 min-h-[350px]">
                <iframe id="eval-preview-frame" class="w-full h-full bg-white rounded-2xl border-2 border-slate-300 shadow-inner" sandbox="allow-scripts"></iframe>
            </div>

            <!-- Form Nilai -->
            <form id="form-eval" method="POST" class="p-5 border-t border-slate-200 bg-slate-50 flex flex-col lg:flex-row items-center justify-between gap-4">
                @csrf
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto flex-1">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Skor (0-100)</label>
                        <input type="number" id="eval-score" name="score" min="0" max="100" class="w-24 px-3 py-2 border border-slate-300 rounded-xl text-base font-extrabold text-center focus:ring-2 focus:ring-emerald-500 bg-white" required>
                    </div>

                    <!-- Preset Skor -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pilih Cepat</label>
                        <div class="flex gap-1.5">
                            <button type="button" onclick="setPresetScore(100)" class="px-2.5 py-1.5 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-bold hover:bg-emerald-200 transition">100</button>
                            <button type="button" onclick="setPresetScore(90)" class="px-2.5 py-1.5 rounded-lg bg-blue-100 text-blue-800 text-xs font-bold hover:bg-blue-200 transition">90</button>
                            <button type="button" onclick="setPresetScore(80)" class="px-2.5 py-1.5 rounded-lg bg-indigo-100 text-indigo-800 text-xs font-bold hover:bg-indigo-200 transition">80</button>
                            <button type="button" onclick="setPresetScore(70)" class="px-2.5 py-1.5 rounded-lg bg-amber-100 text-amber-800 text-xs font-bold hover:bg-amber-200 transition">70</button>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Catatan Evaluasi / Masukan</label>
                        <input type="text" id="eval-feedback" name="feedback" placeholder="Misal: Struktur HTML rapi, perbaiki responsive..." class="w-full px-4 py-2 border border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-emerald-500 bg-white">
                    </div>
                </div>

                <div class="flex gap-2.5 shrink-0 w-full lg:w-auto justify-end">
                    <button type="button" onclick="tutupModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 transition">
                        Simpan Nilai Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentHtml = '';
        let currentCss = '';
        let currentJs = '';

        function setPresetScore(val) {
            document.getElementById('eval-score').value = val;
        }

        function switchEvalTab(mode) {
            const btnCode = document.getElementById('tab-btn-code');
            const btnPreview = document.getElementById('tab-btn-preview');
            const viewCode = document.getElementById('eval-view-code');
            const viewPreview = document.getElementById('eval-view-preview');
            const iframe = document.getElementById('eval-preview-frame');

            if (mode === 'code') {
                viewCode.classList.remove('hidden');
                viewPreview.classList.add('hidden');
                btnCode.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btnCode.classList.remove('text-slate-600');
                btnPreview.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                btnPreview.classList.add('text-slate-600');
            } else {
                viewCode.classList.add('hidden');
                viewPreview.classList.remove('hidden');
                btnPreview.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                btnPreview.classList.remove('text-slate-600');
                btnCode.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                btnCode.classList.add('text-slate-600');

                // Render ke Iframe
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                doc.open();
                doc.write(`<!DOCTYPE html><html><head><style>${currentCss}</style></head><body>${currentHtml}<script>${currentJs}<\/script></body></html>`);
                doc.close();
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

            document.getElementById('eval-score').value = score || 0;
            document.getElementById('eval-feedback').value = feedback || '';
            document.getElementById('form-eval').action = '/guru/submissions/' + id + '/grade';

            switchEvalTab('code');
            document.getElementById('modal-eval').classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('modal-eval').classList.add('hidden');
        }
    </script>
</body>
</html>

