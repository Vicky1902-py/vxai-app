@extends('layouts.admin')

@section('title', ($article->exists ? 'Edit Artikel' : 'Tulis Artikel Baru') . ' - ' . ($settings['app_name'] ?? 'VxAI'))

@push('styles')
<!-- Quill.js Rich Text Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        border-color: #e2e8f0;
        background-color: #f8fafc;
        padding: 12px;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
        border-color: #e2e8f0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14.5px;
        min-height: 380px;
        background-color: #ffffff;
    }
    .ql-editor {
        min-height: 380px;
        line-height: 1.75;
        color: #1e293b;
    }
    .ql-editor pre.ql-syntax {
        background-color: #0f172a;
        color: #38bdf8;
        font-family: 'JetBrains Mono', monospace;
        border-radius: 0.75rem;
        padding: 1rem;
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header & Tombol Kembali -->
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.articles') }}" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center font-bold transition">
                ←
            </a>
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">
                    {{ $article->exists ? 'Edit Artikel Berita' : 'Tulis Artikel & Warta Baru' }}
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Mendukung format teks lengkap, gambar resolusi tinggi, dan sematan video responsif.
                </p>
            </div>
        </div>

        @if($article->exists && $article->status === 'published')
            <a href="{{ route('public.news.detail', $article->slug) }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-3.5 py-2 rounded-xl border border-blue-200 flex items-center gap-1.5 transition">
                <span>👁️</span> <span>Pratinjau Publik</span>
            </a>
        @endif
    </div>

    <!-- Alert Validasi Error -->
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-xs font-semibold space-y-1">
            <div class="font-bold flex items-center gap-2 text-rose-800">
                <span>⚠️</span> <span>Mohon perbaiki kesalahan berikut:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 pl-2 text-rose-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Utama -->
    <form id="article-form" action="{{ $article->exists ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" method="POST" class="space-y-6">
        @csrf
        @if($article->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- KOLOM KIRI (KONTEN UTAMA & EDITOR) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Judul Artikel -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider" for="title">
                        Judul Artikel <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" 
                           class="w-full px-4 py-3.5 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition text-base font-bold text-slate-900 placeholder-slate-400" 
                           placeholder="Contoh: 7 Trik Prompt Engineering untuk Memaksimalkan Coding dengan AI Assistant" required>
                </div>

                <!-- Ringkasan Singkat / Excerpt -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider" for="summary">
                            Ringkasan Singkat (Meta Description / Cuplikan Kartu)
                        </label>
                        <span class="text-[11px] text-slate-400">1 - 2 kalimat pengantar</span>
                    </div>
                    <textarea name="summary" id="summary" rows="3" 
                              class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition text-xs text-slate-700 placeholder-slate-400 leading-relaxed" 
                              placeholder="Tuliskan ringkasan 1-2 kalimat yang menarik untuk muncul di kartu berita dan hasil pencarian Google...">{{ old('summary', $article->summary) }}</textarea>
                </div>

                <!-- Modern WYSIWYG Editor + Video Support -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-3">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Konten Lengkap Artikel <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] text-slate-400">Gunakan toolbar untuk format teks, gambar, heading, dan kode program.</span>
                        </div>

                        <!-- Tombol Cepat Sisipkan Video -->
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="openVideoEmbedModal()" class="px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs border border-red-200 flex items-center gap-1.5 transition active:scale-95 shadow-sm">
                                <span>🎬</span> <span>Sisipkan Video YouTube</span>
                            </button>
                            <button type="button" onclick="toggleRawHtmlMode()" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center gap-1 transition">
                                <span>&lt;/&gt;</span> <span id="btn-toggle-raw-text">HTML Mentah</span>
                            </button>
                        </div>
                    </div>

                    <!-- Quill Editor Container -->
                    <div id="editor-container" class="rounded-2xl overflow-hidden border border-slate-200">
                        <div id="quill-editor">{!! old('content', $article->content ?? '<p>Tuliskan isi artikel Anda di sini...</p>') !!}</div>
                    </div>

                    <!-- Raw HTML Mode Textarea (Tersembunyi secara default) -->
                    <textarea name="content" id="content-textarea" class="hidden w-full h-96 p-4 font-mono text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500" required>{{ old('content', $article->content) }}</textarea>
                </div>

            </div>

            <!-- KOLOM KANAN (PENGATURAN, KATEGORI, THUMBNAIL) -->
            <div class="space-y-6">
                
                <!-- Status & Publikasi -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-5">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>⚙️</span> <span>Status Penerbitan</span>
                    </h3>

                    <!-- Status Radio -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700">Status Tayang</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/60 transition">
                                <input type="radio" name="status" value="published" {{ old('status', $article->status ?? 'published') === 'published' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                <span class="text-xs font-bold text-slate-800">🚀 Tayang</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/60 transition">
                                <input type="radio" name="status" value="draft" {{ old('status', $article->status) === 'draft' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                <span class="text-xs font-bold text-slate-800">📝 Draft</span>
                            </label>
                        </div>
                    </div>

                    <!-- Featured Checkbox -->
                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">⭐ Artikel Sorotan (Featured)</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">Tampilkan sebagai banner besar di atas halaman warta.</span>
                            </div>
                        </label>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-2xl transition-all shadow-lg shadow-blue-500/25 active:scale-[0.99] text-sm flex items-center justify-center gap-2">
                            <span>💾</span>
                            <span>{{ $article->exists ? 'Simpan Perubahan' : 'Terbitkan Artikel Sekarang' }}</span>
                        </button>
                    </div>
                </div>

                <!-- Kategori Artikel -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>🏷️</span> <span>Kategori Konten</span>
                    </h3>

                    <div>
                        <select name="category" id="category" class="w-full px-4 py-3 rounded-2xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white">
                            <option value="coding" {{ old('category', $article->category) === 'coding' ? 'selected' : '' }}>💻 Coding & Web Development</option>
                            <option value="ai" {{ old('category', $article->category) === 'ai' ? 'selected' : '' }}>🤖 Tips & Trik AI (Kecerdasan Artifisial)</option>
                            <option value="teknologi" {{ old('category', $article->category) === 'teknologi' ? 'selected' : '' }}>🌐 Tren Teknologi & Inovasi Digital</option>
                            <option value="komputer" {{ old('category', $article->category) === 'komputer' ? 'selected' : '' }}>🖥️ Komputer, Hardware & PC</option>
                            <option value="android" {{ old('category', $article->category) === 'android' ? 'selected' : '' }}>📱 Tips & Trik Android</option>
                        </select>
                    </div>
                </div>

                <!-- Gambar Sampul (Thumbnail) -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>🖼️</span> <span>Gambar Sampul (Thumbnail)</span>
                    </h3>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="thumbnail_url">URL Gambar</label>
                        <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url', $article->thumbnail_url) }}" 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-xs text-slate-800 placeholder-slate-400" 
                               placeholder="https://images.unsplash.com/..." oninput="updateThumbnailPreview(this.value)">
                    </div>

                    <!-- Preset Gambar Cepat Unsplash -->
                    <div>
                        <span class="block text-[11px] font-bold text-slate-500 mb-2">Pilih Preset Gambar Keren:</span>
                        <div class="grid grid-cols-2 gap-2 text-[10px]">
                            <button type="button" onclick="setPresetThumbnail('https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80')" class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-left font-semibold truncate text-slate-700">
                                💻 Coding Matrix
                            </button>
                            <button type="button" onclick="setPresetThumbnail('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=1200&q=80')" class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-left font-semibold truncate text-slate-700">
                                🤖 AI Futuristic
                            </button>
                            <button type="button" onclick="setPresetThumbnail('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80')" class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-left font-semibold truncate text-slate-700">
                                🌐 Teknologi Chip
                            </button>
                            <button type="button" onclick="setPresetThumbnail('https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=1200&q=80')" class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-left font-semibold truncate text-slate-700">
                                🖥️ Hardware PC
                            </button>
                            <button type="button" onclick="setPresetThumbnail('https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=1200&q=80')" class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-left font-semibold truncate text-slate-700">
                                📱 Android Smartphone
                            </button>
                            <button type="button" onclick="setPresetThumbnail('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80')" class="p-1.5 border border-slate-200 rounded-lg hover:bg-slate-50 text-left font-semibold truncate text-slate-700">
                                🔒 Cloud & Cyber Tech
                            </button>
                        </div>
                    </div>

                    <!-- Pratinjau Gambar -->
                    <div class="mt-3">
                        <span class="block text-[11px] font-bold text-slate-500 mb-1.5">Pratinjau Sampul:</span>
                        <div class="w-full h-36 rounded-2xl border border-slate-200 overflow-hidden bg-slate-100 flex items-center justify-center relative">
                            <img id="thumbnail-preview-img" src="{{ $article->safe_thumbnail }}" alt="Pratinjau" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

<!-- ======================================================== -->
<!-- MODAL SISIPKAN VIDEO RESPONSIP (YOUTUBE / MP4) -->
<!-- ======================================================== -->
<div id="modal-video-embed" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-slate-200 space-y-5 animate-scale-up">
        
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎬</span>
                <h3 class="text-base font-black text-slate-900">Sisipkan Video Responsif</h3>
            </div>
            <button type="button" onclick="closeVideoEmbedModal()" class="text-slate-400 hover:text-slate-600 font-bold text-lg">✕</button>
        </div>

        <p class="text-xs text-slate-600 leading-relaxed">
            Tempelkan link video YouTube Anda (contoh: <code class="bg-slate-100 px-1 py-0.5 rounded text-blue-600">https://www.youtube.com/watch?v=XXXX</code> atau <code class="bg-slate-100 px-1 py-0.5 rounded text-blue-600">https://youtu.be/XXXX</code>). Video otomatis dirangkai responsif 16:9 yang pas di layar HP maupun laptop.
        </p>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tautan URL Video YouTube:</label>
            <input type="text" id="input-video-url" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="https://www.youtube.com/watch?v=...">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Keterangan / Judul Video (Opsional):</label>
            <input type="text" id="input-video-caption" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Video Tutorial Praktis Prompt Engineering">
        </div>

        <div class="flex justify-end gap-2.5 pt-2">
            <button type="button" onclick="closeVideoEmbedModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200 transition">
                Batal
            </button>
            <button type="button" onclick="insertResponsiveVideo()" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs transition shadow-md shadow-red-500/20">
                Sisipkan ke Artikel
            </button>
        </div>

    </div>
</div>

@push('scripts')
<!-- Quill.js Library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    // Inisialisasi Quill Editor dengan Toolbar Lengkap
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tuliskan konten artikel secara detail dan menarik...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    var isRawMode = false;
    var quillEditorContainer = document.getElementById('editor-container');
    var rawTextarea = document.getElementById('content-textarea');

    // Toggle Mode Edit HTML Mentah vs Visual Quill
    function toggleRawHtmlMode() {
        var btnText = document.getElementById('btn-toggle-raw-text');
        if (!isRawMode) {
            // Pindah ke mode HTML Mentah
            rawTextarea.value = quill.root.innerHTML;
            quillEditorContainer.classList.add('hidden');
            rawTextarea.classList.remove('hidden');
            btnText.innerText = 'Mode Visual';
            isRawMode = true;
        } else {
            // Pindah kembali ke Quill Visual
            quill.root.innerHTML = rawTextarea.value;
            rawTextarea.classList.add('hidden');
            quillEditorContainer.classList.remove('hidden');
            btnText.innerText = 'HTML Mentah';
            isRawMode = false;
        }
    }

    // Modal Video Embed Functions
    function openVideoEmbedModal() {
        document.getElementById('modal-video-embed').classList.remove('hidden');
        document.getElementById('input-video-url').focus();
    }

    function closeVideoEmbedModal() {
        document.getElementById('modal-video-embed').classList.add('hidden');
    }

    // Ekstrak ID YouTube dari berbagai variasi URL
    function extractYouTubeID(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }

    // Sisipkan Video Responsif ke Posisi Kursor Quill
    function insertResponsiveVideo() {
        var url = document.getElementById('input-video-url').value.trim();
        var caption = document.getElementById('input-video-caption').value.trim();

        if (!url) {
            alert('Mohon masukkan tautan video YouTube terlebih dahulu!');
            return;
        }

        var youtubeId = extractYouTubeID(url);
        var embedUrl = youtubeId ? 'https://www.youtube.com/embed/' + youtubeId : url;

        var videoHtml = `
            <div class="my-6 rounded-2xl overflow-hidden shadow-lg border border-slate-200">
                <div class="relative w-full" style="padding-bottom: 56.25%;">
                    <iframe class="absolute top-0 left-0 w-full h-full" src="${embedUrl}" title="Video Player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                ${caption ? `<p class="text-xs text-center text-slate-500 py-2.5 bg-slate-50">${caption}</p>` : ''}
            </div>
            <p><br></p>
        `;

        if (isRawMode) {
            rawTextarea.value += videoHtml;
        } else {
            var range = quill.getSelection(true);
            quill.clipboard.dangerouslyPasteHTML(range.index, videoHtml);
        }

        document.getElementById('input-video-url').value = '';
        document.getElementById('input-video-caption').value = '';
        closeVideoEmbedModal();
    }

    // Sinkronisasi Konten Quill ke Textarea saat Form disubmit
    document.getElementById('article-form').addEventListener('submit', function(e) {
        if (!isRawMode) {
            rawTextarea.value = quill.root.innerHTML;
        }
    });

    // Preview Thumbnail
    function updateThumbnailPreview(url) {
        var img = document.getElementById('thumbnail-preview-img');
        if (url) {
            img.src = url;
        }
    }

    function setPresetThumbnail(url) {
        document.getElementById('thumbnail_url').value = url;
        updateThumbnailPreview(url);
    }
</script>
@endpush
@endsection
