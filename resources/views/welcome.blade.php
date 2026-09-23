@extends('layouts.public')

@section('title', ($settings['app_name'] ?? 'VxAI Coding Lab') . ' - Platform Belajar Koding Interaktif')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-white to-gray-50 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Kolom Teks Hero -->
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold mb-6">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span>
                    <span>Terbuka untuk Umum & Pelajar</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 tracking-tight leading-tight mb-6">
                    Tulis Kode, Lihat Hasil <span class="text-blue-600">Seketika</span> dari Browser.
                </h1>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Platform pembelajaran pemrograman interaktif modern. Uji kode HTML, CSS, dan JavaScript secara langsung tanpa instalasi aplikasi yang rumit. Didesain untuk pemula, siswa, dan pengembang masa depan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('public.playground') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base shadow-lg shadow-blue-500/20 hover:-translate-y-0.5 transition-all">
                        ⚡ Buka Live Playground (Gratis)
                    </a>
                    <a href="{{ route('public.tutorials') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-white hover:bg-gray-50 text-gray-800 font-bold text-base border border-gray-200 shadow-sm hover:-translate-y-0.5 transition-all">
                        📖 Pelajari Panduan Koding
                    </a>
                </div>

                <!-- Statistik Ringkas -->
                <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                    <div>
                        <div class="text-2xl font-black text-blue-600">{{ number_format($totalSubmissions) }}+</div>
                        <div class="text-xs text-gray-500 font-semibold mt-1">Kode Dieksekusi</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-green-600">{{ number_format($totalStudents) }}+</div>
                        <div class="text-xs text-gray-500 font-semibold mt-1">Siswa Terdaftar</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-purple-600">100%</div>
                        <div class="text-xs text-gray-500 font-semibold mt-1">Gratis Akses</div>
                    </div>
                </div>
            </div>

            <!-- Kolom Interactive Demo Preview -->
            <div class="relative">
                <div class="w-full bg-gray-900 rounded-3xl shadow-2xl border border-gray-800 overflow-hidden">
                    <!-- Window Header -->
                    <div class="bg-gray-800 px-4 py-3 flex items-center justify-between border-b border-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                            <span class="text-xs text-gray-400 font-mono ml-2">demo_live.html</span>
                        </div>
                        <a href="{{ route('public.playground') }}" class="text-[11px] font-bold text-blue-400 hover:text-blue-300">
                            Coba di Editor Penuh ➔
                        </a>
                    </div>
                    
                    <!-- Code Snippet -->
                    <div class="p-4 text-xs font-mono text-gray-300 bg-gray-950 overflow-x-auto">
                        <span class="text-pink-400">&lt;div</span> <span class="text-yellow-300">class=</span><span class="text-green-300">"kartu-belajar"</span><span class="text-pink-400">&gt;</span><br>
                        &nbsp;&nbsp;<span class="text-pink-400">&lt;h2&gt;</span>Selamat Datang di VxAI! 🚀<span class="text-pink-400">&lt;/h2&gt;</span><br>
                        &nbsp;&nbsp;<span class="text-pink-400">&lt;p&gt;</span>Belajar membuat website dari nol.<span class="text-pink-400">&lt;/p&gt;</span><br>
                        &nbsp;&nbsp;<span class="text-pink-400">&lt;button</span> <span class="text-yellow-300">onclick=</span><span class="text-green-300">"alert('Hebat!')"</span><span class="text-pink-400">&gt;</span>Klik Saya<span class="text-pink-400">&lt;/button&gt;</span><br>
                        <span class="text-pink-400">&lt;/div&gt;</span>
                    </div>

                    <!-- Mini Live Preview Box -->
                    <div class="bg-white p-6 border-t border-gray-700 text-center">
                        <span class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full inline-block mb-3">● Live Output Preview</span>
                        <div class="bg-blue-50 border border-blue-200 p-6 rounded-2xl max-w-sm mx-auto shadow-sm">
                            <h3 class="font-black text-gray-800 text-lg">Selamat Datang di VxAI! 🚀</h3>
                            <p class="text-xs text-gray-600 mt-1 mb-4">Belajar membuat website dari nol.</p>
                            <button onclick="alert('Luar biasa! Live Preview di browser Anda berjalan sangat lancar.')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-lg shadow transition">
                                Klik Saya
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Fitur Unggulan -->
<section class="py-16 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-black text-gray-900 mb-4">Mengapa Belajar di VxAI?</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-12 text-sm leading-relaxed">
            Kombinasi antara kemudahan akses langsung di peramban web dan kurikulum praktis yang teruji.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <div class="bg-gray-50 p-8 rounded-3xl border border-gray-200 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6">⚡</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Live Code Playground</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Editor tiga kolom (HTML, CSS, JavaScript) dengan pratinjau instan. Siapa saja dapat langsung berlatih tanpa perlu install compiler.
                </p>
            </div>

            <div class="bg-gray-50 p-8 rounded-3xl border border-gray-200 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6">💡</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kamus & Panduan Koding</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Panduan tag HTML, properti warna CSS, hingga manipulasi DOM JavaScript yang selalu siap saat Anda menemui kesulitan.
                </p>
            </div>

            <div class="bg-gray-50 p-8 rounded-3xl border border-gray-200 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-2xl font-bold mb-6">🏆</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Gamifikasi Siswa</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Siswa terdaftar mendapatkan poin XP dan kenaikan level setiap kali mengumpulkan kode latihan untuk ditinjau oleh guru.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection