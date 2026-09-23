<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Coding Playground - {{ $settings['app_name'] ?? 'VxAI' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CodeMirror CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/theme/dracula.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .CodeMirror { height: 100%; position: absolute; top: 0; bottom: 0; left: 0; right: 0; font-family: 'JetBrains Mono', monospace; font-size: 13.5px; }
        
        @media (max-width: 767px) {
            .mobile-hidden { display: none !important; }
            .mobile-flex { display: flex !important; }
        }
        
        /* Animasi Pop-up Petunjuk */
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
            <a href="{{ route('siswa.dashboard') }}" class="text-gray-400 hover:text-white transition">← Kembali</a>
            <h1 class="text-lg font-bold text-blue-400 hidden md:block">⚡ Workspace</h1>
        </div>
        <div class="flex items-center gap-2 md:gap-3">
            <!-- TOMBOL PETUNJUK BARU -->
            <button onclick="openHintModal()" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-3 py-2 rounded-lg text-sm font-bold flex items-center gap-2 shadow-lg transition active:scale-95">
                <span>💡</span> <span class="hidden md:inline">Petunjuk Kode</span>
            </button>
            <span class="text-sm text-gray-400 hidden md:block border-l border-gray-600 pl-3">Otomatis disimpan</span>
            <button id="btn-submit" onclick="kirimKodeSiswa()" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-semibold shadow-lg active:scale-95 transition">Kirim</button>
        </div>
    </header>

    <!-- Area Kerja Utama -->
    <main class="flex-1 flex flex-col md:grid md:grid-cols-2 md:gap-4 md:p-4 relative overflow-hidden">
        
        <!-- Mobile Tab Navigation -->
        <div class="md:hidden flex shrink-0 bg-gray-900 border-b border-gray-700 z-10">
            <button onclick="switchTab('html', this)" class="tab-btn flex-1 py-3 text-orange-400 border-b-2 border-orange-400 bg-gray-800 text-xs font-bold transition">HTML</button>
            <button onclick="switchTab('css', this)" class="tab-btn flex-1 py-3 text-gray-400 border-b-2 border-transparent text-xs font-bold transition">CSS</button>
            <button onclick="switchTab('js', this)" class="tab-btn flex-1 py-3 text-gray-400 border-b-2 border-transparent text-xs font-bold transition">JS</button>
            <button onclick="switchTab('preview', this)" class="tab-btn flex-1 py-3 text-gray-400 border-b-2 border-transparent text-xs font-bold flex items-center justify-center gap-1 transition">
                Preview <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            </button>
        </div>

        <!-- Panel Kiri: Editor HTML, CSS, JS -->
        <div class="flex-1 flex flex-col md:gap-4 h-full relative z-0 min-h-0">
            <div id="pane-html" class="pane mobile-flex md:flex flex-col flex-1 bg-gray-800 md:rounded-lg overflow-hidden border-0 md:border border-gray-700 relative">
                <div class="hidden md:block px-3 py-1 bg-gray-900 text-xs font-bold text-orange-400 border-b border-gray-700">HTML</div>
                <div class="flex-1 relative"><textarea id="html-code"></textarea></div>
            </div>

            <div id="wrapper-css-js" class="pane mobile-hidden md:flex flex-1 md:grid md:grid-cols-2 md:gap-4 relative min-h-0">
                <div id="pane-css" class="pane mobile-hidden md:flex flex-col flex-1 bg-gray-800 md:rounded-lg overflow-hidden border-0 md:border border-gray-700 relative h-full">
                    <div class="hidden md:block px-3 py-1 bg-gray-900 text-xs font-bold text-blue-400 border-b border-gray-700">CSS</div>
                    <div class="flex-1 relative"><textarea id="css-code"></textarea></div>
                </div>
                <div id="pane-js" class="pane mobile-hidden md:flex flex-col flex-1 bg-gray-800 md:rounded-lg overflow-hidden border-0 md:border border-gray-700 relative h-full">
                    <div class="hidden md:block px-3 py-1 bg-gray-900 text-xs font-bold text-yellow-400 border-b border-gray-700">JS</div>
                    <div class="flex-1 relative"><textarea id="js-code"></textarea></div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Live Preview -->
        <div id="pane-preview" class="pane mobile-hidden md:flex flex-col bg-white md:rounded-lg shadow-inner overflow-hidden border-0 md:border-2 border-gray-700 relative z-0 h-full w-full">
            <div class="hidden md:flex px-3 py-1 bg-gray-200 text-xs font-bold text-gray-700 border-b border-gray-300 justify-between">
                <span>Live Preview</span>
                <span class="text-green-600 animate-pulse">● Live</span>
            </div>
            <iframe id="preview-frame" class="w-full flex-1 bg-white" sandbox="allow-scripts"></iframe>
        </div>
    </main>

    <!-- ========================================== -->
    <!-- MODAL POPUP PETUNJUK KODING (CHEAT SHEET) -->
    <!-- ========================================== -->
    <div id="hint-modal" class="fixed inset-0 bg-black/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-gray-800 text-gray-200 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] flex flex-col border border-gray-700 modal-enter">
            
            <!-- Header Modal -->
            <div class="p-4 border-b border-gray-700 flex justify-between items-center bg-gray-900 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">💡</span>
                    <h2 class="text-lg font-bold text-yellow-400">Kamus & Referensi Koding</h2>
                </div>
                <button onclick="closeHintModal()" class="text-gray-400 hover:text-white text-3xl font-bold leading-none">&times;</button>
            </div>
            
            <!-- Isi Kamus (Bisa di-scroll) -->
            <div class="p-6 overflow-y-auto space-y-8 flex-1 custom-scrollbar">
                
                <!-- Seksi HTML -->
                <section>
                    <h3 class="text-xl font-bold text-orange-400 mb-4 border-b border-gray-700 pb-2">1. Tag HTML Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <code class="text-pink-400 font-bold">&lt;h1&gt; Teks &lt;/h1&gt;</code>
                            <p class="text-sm text-gray-400 mt-1">Membuat Judul Utama (paling besar). Bisa h1 sampai h6.</p>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <code class="text-pink-400 font-bold">&lt;p&gt; Teks &lt;/p&gt;</code>
                            <p class="text-sm text-gray-400 mt-1">Membuat Paragraf biasa.</p>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <code class="text-pink-400 font-bold">&lt;button&gt; Klik &lt;/button&gt;</code>
                            <p class="text-sm text-gray-400 mt-1">Membuat tombol yang bisa diklik.</p>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <code class="text-pink-400 font-bold">&lt;img src="link_foto"&gt;</code>
                            <p class="text-sm text-gray-400 mt-1">Memasukkan gambar.</p>
                        </div>
                    </div>
                </section>

                <!-- Seksi CSS Warna -->
                <section>
                    <h3 class="text-xl font-bold text-blue-400 mb-4 border-b border-gray-700 pb-2">2. Referensi Warna CSS (Gaya Huruf & Latar)</h3>
                    <p class="text-sm text-gray-300 mb-3">Gunakan pada properti <code class="bg-gray-700 px-1 rounded text-green-300">color:</code> untuk teks, atau <code class="bg-gray-700 px-1 rounded text-green-300">background-color:</code> untuk latar belakang.</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-center">
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <div class="w-full h-8 bg-red-500 rounded mb-2"></div>
                            <code class="text-xs text-yellow-300">red</code><br>
                            <code class="text-[10px] text-gray-500">#EF4444</code>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <div class="w-full h-8 bg-blue-500 rounded mb-2"></div>
                            <code class="text-xs text-yellow-300">blue</code><br>
                            <code class="text-[10px] text-gray-500">#3B82F6</code>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <div class="w-full h-8 bg-green-500 rounded mb-2"></div>
                            <code class="text-xs text-yellow-300">green</code><br>
                            <code class="text-[10px] text-gray-500">#22C55E</code>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <div class="w-full h-8 bg-yellow-400 rounded mb-2"></div>
                            <code class="text-xs text-yellow-300">yellow</code><br>
                            <code class="text-[10px] text-gray-500">#FACC15</code>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <div class="w-full h-8 bg-[#8B5CF6] rounded mb-2"></div>
                            <code class="text-xs text-yellow-300">purple</code><br>
                            <code class="text-[10px] text-gray-500">#8B5CF6</code>
                        </div>
                        <div class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <div class="w-full h-8 bg-black rounded mb-2 border border-gray-600"></div>
                            <code class="text-xs text-yellow-300">black</code><br>
                            <code class="text-[10px] text-gray-500">#000000</code>
                        </div>
                    </div>
                </section>

                <!-- Seksi CSS Style -->
                <section>
                    <h3 class="text-xl font-bold text-green-400 mb-4 border-b border-gray-700 pb-2">3. Properti CSS Umum</h3>
                    <ul class="space-y-3">
                        <li class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <code class="text-green-300 font-bold">font-size: 24px;</code>
                            <p class="text-sm text-gray-400 mt-1">Mengubah ukuran teks (bisa pakai px, rem, atau em).</p>
                        </li>
                        <li class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <code class="text-green-300 font-bold">text-align: center;</code>
                            <p class="text-sm text-gray-400 mt-1">Mengatur posisi teks (center, left, right).</p>
                        </li>
                        <li class="bg-gray-900 p-3 rounded-lg border border-gray-700">
                            <code class="text-green-300 font-bold">border-radius: 10px;</code>
                            <p class="text-sm text-gray-400 mt-1">Membuat sudut elemen menjadi melengkung (tidak kaku).</p>
                        </li>
                    </ul>
                </section>
                
            </div>
            
            <!-- Footer Modal -->
            <div class="p-4 border-t border-gray-700 bg-gray-900 rounded-b-2xl text-center">
                <button onclick="closeHintModal()" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-bold text-white transition">Tutup Petunjuk</button>
            </div>
            
        </div>
    </div>
    <!-- END MODAL -->

    <!-- CodeMirror JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>

    <!-- Logika Aplikasi -->
    <script>
        // Logika Modal Petunjuk
        function openHintModal() {
            document.getElementById('hint-modal').classList.remove('hidden');
        }
        function closeHintModal() {
            document.getElementById('hint-modal').classList.add('hidden');
        }

        // Inisialisasi CodeMirror
        const editorConfig = { theme: 'dracula', lineNumbers: true, tabSize: 4 };
        const htmlEditor = CodeMirror.fromTextArea(document.getElementById('html-code'), { ...editorConfig, mode: 'xml' });
        const cssEditor = CodeMirror.fromTextArea(document.getElementById('css-code'), { ...editorConfig, mode: 'css' });
        const jsEditor = CodeMirror.fromTextArea(document.getElementById('js-code'), { ...editorConfig, mode: 'javascript' });

        htmlEditor.setValue('<!-- Ketik HTML di sini -->\n<div class="container">\n  <h1>Halo Tim Hebat! 🚀</h1>\n  <p>Live Preview bekerja dengan sangat baik.</p>\n  <button id="btn-demo">Uji Tombol</button>\n</div>');
        cssEditor.setValue('/* Ketik CSS di sini */\nbody {\n  font-family: sans-serif;\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  height: 100vh;\n  margin: 0;\n  background-color: #111827; /* Coba ganti warnanya dari petunjuk! */\n}\n.container {\n  text-align: center;\n  padding: 2rem;\n  background: #1f2937;\n  border-radius: 1rem;\n  box-shadow: 0 4px 6px rgba(0,0,0,0.3);\n  color: white;\n}\nh1 { color: #60a5fa; }\nbutton {\n  margin-top: 15px;\n  background: #3b82f6; color: white;\n  border: none; padding: 10px 20px;\n  border-radius: 5px; cursor: pointer;\n}\nbutton:hover { background: #2563eb; }');
        jsEditor.setValue('document.getElementById("btn-demo").addEventListener("click", function() {\n  alert("Hebat! Teruslah bereksplorasi.");\n});');
        
        function updatePreview() {
            const html = htmlEditor.getValue();
            const css = `<style>${cssEditor.getValue()}</style>`;
            const js = `<script>${jsEditor.getValue()}<\/script>`;
            
            const fullCode = `
                <!DOCTYPE html>
                <html>
                    <head><meta charset="utf-8">${css}</head>
                    <body>${html}${js}</body>
                </html>
            `;
            document.getElementById('preview-frame').srcdoc = fullCode;
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

        // LOGIKA TAB UNTUK HP
        function switchTab(tabName, btn) {
            if(window.innerWidth >= 768) return;

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
                if(tabName==='html') htmlEditor.refresh();
                if(tabName==='css') cssEditor.refresh();
                if(tabName==='js') jsEditor.refresh();
            }, 50);

            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('text-orange-400', 'border-orange-400', 'bg-gray-800');
                b.classList.add('text-gray-400', 'border-transparent');
            });
            btn.classList.remove('text-gray-400', 'border-transparent');
            btn.classList.add('text-orange-400', 'border-orange-400', 'bg-gray-800');
        }
    </script>
    
    <script>
    function kirimKodeSiswa() {
        const btn = document.getElementById('btn-submit');
        btn.innerHTML = 'Mengirim...';
        btn.disabled = true;

        fetch('{{ route("siswa.playground.submit") }}', {
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
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Tampilkan pop-up sukses
            btn.innerHTML = 'Kirim';
            btn.disabled = false;
        })
        .catch(error => {
            alert('Gagal mengirim kode. Cek koneksi Anda.');
            btn.innerHTML = 'Kirim';
            btn.disabled = false;
        });
    }
    </script>
</body>
</html>