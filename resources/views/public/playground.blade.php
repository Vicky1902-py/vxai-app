<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Live Code Playground - {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</title>
    <meta name="description" content="Editor HTML, CSS, dan JavaScript interaktif dengan pratinjau langsung. Terbuka gratis untuk publik dan pelajar.">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- CodeMirror CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/dracula.min.css">
    
    <!-- Google AdSense Script (Otomatis Aktif jika Dikonfigurasi) -->
    @if(isset($settings['adsense_status']) && $settings['adsense_status'] === 'true' && !empty($settings['adsense_client_id']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $settings['adsense_client_id'] }}"
             crossorigin="anonymous"></script>
    @endif

    <style>
        .CodeMirror { height: 100%; position: absolute; top: 0; bottom: 0; left: 0; right: 0; font-family: 'Fira Code', monospace; font-size: 14px; }
        @media (max-width: 767px) {
            .mobile-hidden { display: none !important; }
            .mobile-flex { display: flex !important; }
        }
        .modal-enter { animation: modalFadeIn 0.3s ease-out forwards; }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(-10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-900 text-white font-sans antialiased h-screen flex flex-col overflow-hidden relative">

    <!-- Header Navigation -->
    <header class="h-16 shrink-0 bg-gray-800 border-b border-gray-700 flex items-center justify-between px-4 md:px-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition flex items-center gap-1 text-sm font-semibold">
                ← <span class="hidden sm:inline">Beranda</span>
            </a>
            <h1 class="text-base md:text-lg font-bold text-blue-400 flex items-center gap-2">
                <span>⚡</span> <span>Playground</span>
            </h1>
            
            @auth
                <span class="hidden lg:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-900/60 text-blue-300 text-xs font-semibold border border-blue-700">
                    👤 {{ Auth::user()->name }} (Lvl {{ Auth::user()->level }} • {{ Auth::user()->xp }} XP)
                </span>
            @else
                <span class="hidden lg:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-700/60 text-gray-300 text-xs border border-gray-600">
                    🌐 Mode Publik (Tamu)
                </span>
            @endauth
        </div>

        <div class="flex items-center gap-2 md:gap-3">
            <!-- Tombol Petunjuk Kode -->
            <button onclick="openHintModal()" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-3 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold flex items-center gap-1.5 shadow transition active:scale-95">
                <span>💡</span> <span class="hidden md:inline">Petunjuk Kode</span>
            </button>
            
            <!-- Tombol Kirim / Uji Kode -->
            <button id="btn-submit" onclick="kirimKode()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 md:py-2 rounded-xl text-xs md:text-sm font-bold shadow-lg active:scale-95 transition flex items-center gap-1.5">
                <span>🚀</span> <span>Kirim / Simpan</span>
            </button>

            @guest
                <a href="{{ route('login') }}" class="text-xs text-blue-400 hover:text-blue-300 hidden sm:inline ml-2 font-semibold">
                    Masuk Akun ➔
                </a>
            @endguest
        </div>
    </header>

    <!-- Area Kerja Utama -->
    <main class="flex-1 flex flex-col md:grid md:grid-cols-2 md:gap-3 md:p-3 relative overflow-hidden">
        
        <!-- Mobile Tab Navigation -->
        <div class="md:hidden flex shrink-0 bg-gray-900 border-b border-gray-700 z-10">
            <button onclick="switchTab('html', this)" class="tab-btn flex-1 py-2.5 text-orange-400 border-b-2 border-orange-400 bg-gray-800 text-xs font-bold transition">HTML</button>
            <button onclick="switchTab('css', this)" class="tab-btn flex-1 py-2.5 text-gray-400 border-b-2 border-transparent text-xs font-bold transition">CSS</button>
            <button onclick="switchTab('js', this)" class="tab-btn flex-1 py-2.5 text-gray-400 border-b-2 border-transparent text-xs font-bold transition">JS</button>
            <button onclick="switchTab('preview', this)" class="tab-btn flex-1 py-2.5 text-gray-400 border-b-2 border-transparent text-xs font-bold flex items-center justify-center gap-1 transition">
                Preview <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            </button>
        </div>

        <!-- Panel Kiri: Editor HTML, CSS, JS -->
        <div class="flex-1 flex flex-col md:gap-3 h-full relative z-0 min-h-0">
            <div id="pane-html" class="pane mobile-flex md:flex flex-col flex-1 bg-gray-800 md:rounded-xl overflow-hidden border-0 md:border border-gray-700 relative">
                <div class="hidden md:flex justify-between items-center px-3 py-1 bg-gray-900 text-xs font-bold text-orange-400 border-b border-gray-700">
                    <span>HTML5</span>
                    <span class="text-[10px] text-gray-500 font-mono">index.html</span>
                </div>
                <div class="flex-1 relative"><textarea id="html-code"></textarea></div>
            </div>

            <div id="wrapper-css-js" class="pane mobile-hidden md:flex flex-1 md:grid md:grid-cols-2 md:gap-3 relative min-h-0">
                <div id="pane-css" class="pane mobile-hidden md:flex flex-col flex-1 bg-gray-800 md:rounded-xl overflow-hidden border-0 md:border border-gray-700 relative h-full">
                    <div class="hidden md:flex justify-between items-center px-3 py-1 bg-gray-900 text-xs font-bold text-blue-400 border-b border-gray-700">
                        <span>CSS3</span>
                        <span class="text-[10px] text-gray-500 font-mono">style.css</span>
                    </div>
                    <div class="flex-1 relative"><textarea id="css-code"></textarea></div>
                </div>
                <div id="pane-js" class="pane mobile-hidden md:flex flex-col flex-1 bg-gray-800 md:rounded-xl overflow-hidden border-0 md:border border-gray-700 relative h-full">
                    <div class="hidden md:flex justify-between items-center px-3 py-1 bg-gray-900 text-xs font-bold text-yellow-400 border-b border-gray-700">
                        <span>JavaScript</span>
                        <span class="text-[10px] text-gray-500 font-mono">script.js</span>
                    </div>
                    <div class="flex-1 relative"><textarea id="js-code"></textarea></div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Live Preview -->
        <div id="pane-preview" class="pane mobile-hidden md:flex flex-col bg-white md:rounded-xl shadow-2xl overflow-hidden border-0 md:border-2 border-gray-700 relative z-0 h-full w-full">
            <div class="hidden md:flex px-3 py-1.5 bg-gray-100 text-xs font-bold text-gray-700 border-b border-gray-200 justify-between items-center">
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                    <span class="ml-2 font-mono text-[11px] text-gray-500">Live Preview Output</span>
                </span>
                <span class="text-green-600 font-bold text-[11px] animate-pulse">● Real-time</span>
            </div>
            <iframe id="preview-frame" class="w-full flex-1 bg-white" sandbox="allow-scripts"></iframe>
        </div>
    </main>

    <!-- Modal Pop-up Petunjuk Koding (Cheat Sheet) -->
    <div id="hint-modal" class="fixed inset-0 bg-black/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-gray-800 text-gray-200 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] flex flex-col border border-gray-700 modal-enter">
            
            <div class="p-4 border-b border-gray-700 flex justify-between items-center bg-gray-900 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">💡</span>
                    <h2 class="text-lg font-bold text-yellow-400">Kamus & Referensi Singkat</h2>
                </div>
                <button onclick="closeHintModal()" class="text-gray-400 hover:text-white text-3xl font-bold leading-none">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-6 flex-1 text-sm">
                <!-- HTML -->
                <div>
                    <h3 class="font-bold text-orange-400 mb-2">1. Tag HTML Penting</h3>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>&lt;h1&gt;Judul&lt;/h1&gt;</code> - Judul utama</div>
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>&lt;p&gt;Paragraf&lt;/p&gt;</code> - Teks biasa</div>
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>&lt;button&gt;Klik&lt;/button&gt;</code> - Tombol</div>
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>&lt;img src="url"&gt;</code> - Gambar</div>
                    </div>
                </div>

                <!-- CSS -->
                <div>
                    <h3 class="font-bold text-blue-400 mb-2">2. Properti CSS Populer</h3>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>color: #3b82f6;</code> - Warna teks</div>
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>background: #111827;</code> - Latar belakang</div>
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>border-radius: 12px;</code> - Sudut bulat</div>
                        <div class="bg-gray-900 p-2.5 rounded border border-gray-700"><code>font-size: 20px;</code> - Ukuran huruf</div>
                    </div>
                </div>

                <!-- JS -->
                <div>
                    <h3 class="font-bold text-yellow-400 mb-2">3. JavaScript Dasar</h3>
                    <div class="bg-gray-900 p-3 rounded border border-gray-700 text-xs font-mono text-gray-300">
                        document.getElementById("btn").addEventListener("click", function() {<br>
                        &nbsp;&nbsp;alert("Tombol berhasil diklik!");<br>
                        });
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t border-gray-700 bg-gray-900 rounded-b-2xl text-right">
                <button onclick="closeHintModal()" class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-xl text-xs font-bold text-white transition">Tutup</button>
            </div>
        </div>
    </div>

    <!-- CodeMirror Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>

    <script>
        function openHintModal() { document.getElementById('hint-modal').classList.remove('hidden'); }
        function closeHintModal() { document.getElementById('hint-modal').classList.add('hidden'); }

        const editorConfig = { theme: 'dracula', lineNumbers: true, tabSize: 4 };
        const htmlEditor = CodeMirror.fromTextArea(document.getElementById('html-code'), { ...editorConfig, mode: 'xml' });
        const cssEditor = CodeMirror.fromTextArea(document.getElementById('css-code'), { ...editorConfig, mode: 'css' });
        const jsEditor = CodeMirror.fromTextArea(document.getElementById('js-code'), { ...editorConfig, mode: 'javascript' });

        htmlEditor.setValue('<!-- Ketik HTML di sini -->\n<div class="card">\n  <h1>Halo Dunia! 🚀</h1>\n  <p>Live Code Playground siap digunakan.</p>\n  <button id="btn-aksi">Klik Saya</button>\n</div>');
        cssEditor.setValue('/* Ketik CSS di sini */\nbody {\n  font-family: system-ui, sans-serif;\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  height: 100vh;\n  margin: 0;\n  background: #0f172a;\n  color: #f8fafc;\n}\n.card {\n  text-align: center;\n  padding: 2.5rem;\n  background: #1e293b;\n  border-radius: 1.25rem;\n  box-shadow: 0 10px 25px rgba(0,0,0,0.4);\n  border: 1px solid #334155;\n}\nh1 { color: #38bdf8; margin-bottom: 0.5rem; }\nbutton {\n  margin-top: 1rem;\n  background: #2563eb;\n  color: white;\n  border: none;\n  padding: 0.6rem 1.4rem;\n  border-radius: 0.75rem;\n  font-weight: bold;\n  cursor: pointer;\n  transition: 0.2s;\n}\nbutton:hover { background: #1d4ed8; }');
        jsEditor.setValue('document.getElementById("btn-aksi").addEventListener("click", function() {\n  alert("Hebat! Kode JavaScript Anda berjalan langsung di browser!");\n});');

        function updatePreview() {
            const html = htmlEditor.getValue();
            const css = `<style>${cssEditor.getValue()}</style>`;
            const js = `<script>${jsEditor.getValue()}<\/script>`;
            document.getElementById('preview-frame').srcdoc = `<!DOCTYPE html><html><head><meta charset="utf-8">${css}</head><body>${html}${js}</body></html>`;
        }

        let timeout;
        function debouncePreview() {
            clearTimeout(timeout);
            timeout = setTimeout(updatePreview, 300);
        }

        htmlEditor.on('change', debouncePreview);
        cssEditor.on('change', debouncePreview);
        jsEditor.on('change', debouncePreview);
        updatePreview();

        function switchTab(tabName, btn) {
            if (window.innerWidth >= 768) return;
            document.querySelectorAll('.pane').forEach(el => {
                el.classList.remove('mobile-flex');
                el.classList.add('mobile-hidden');
            });

            if (tabName === 'html') {
                document.getElementById('pane-html').classList.add('mobile-flex');
                document.getElementById('pane-html').classList.remove('mobile-hidden');
            } else if (tabName === 'css' || tabName === 'js') {
                document.getElementById('wrapper-css-js').classList.add('mobile-flex');
                document.getElementById('wrapper-css-js').classList.remove('mobile-hidden');
                document.getElementById('pane-' + tabName).classList.add('mobile-flex');
                document.getElementById('pane-' + tabName).classList.remove('mobile-hidden');
            } else if (tabName === 'preview') {
                document.getElementById('pane-preview').classList.add('mobile-flex');
                document.getElementById('pane-preview').classList.remove('mobile-hidden');
            }

            setTimeout(() => {
                if (tabName === 'html') htmlEditor.refresh();
                if (tabName === 'css') cssEditor.refresh();
                if (tabName === 'js') jsEditor.refresh();
            }, 50);

            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('text-orange-400', 'border-orange-400', 'bg-gray-800');
                b.classList.add('text-gray-400', 'border-transparent');
            });
            btn.classList.remove('text-gray-400', 'border-transparent');
            btn.classList.add('text-orange-400', 'border-orange-400', 'bg-gray-800');
        }

        function kirimKode() {
            const btn = document.getElementById('btn-submit');
            btn.innerHTML = '<span>⏳</span> <span>Menyimpan...</span>';
            btn.disabled = true;

            fetch('{{ route("public.playground.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    html_code: htmlEditor.getValue(),
                    css_code: cssEditor.getValue(),
                    js_code: jsEditor.getValue()
                })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                btn.innerHTML = '<span>🚀</span> <span>Kirim / Simpan</span>';
                btn.disabled = false;
            })
            .catch(err => {
                alert('Gagal mengirim kode. Periksa koneksi internet Anda.');
                btn.innerHTML = '<span>🚀</span> <span>Kirim / Simpan</span>';
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>
