@extends('layouts.public')

@section('title', 'Tentang Kami (About Us) - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-200 shadow-sm space-y-6 text-gray-700 leading-relaxed text-sm">
        
        <h1 class="text-3xl font-black text-gray-900 border-b pb-4">Tentang Kami</h1>

        <p class="text-base text-gray-800 font-medium">
            <strong>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</strong> adalah platform edukasi teknologi dan laboratorium koding digital yang dirancang untuk mempercepat literasi pemrograman di era kecerdasan buatan.
        </p>

        <div class="my-6 p-6 bg-blue-50 border-l-4 border-blue-600 rounded-r-2xl">
            <h3 class="text-lg font-bold text-blue-900 mb-2">Visi Kami</h3>
            <p class="text-blue-800 text-sm">
                Membuka akses pembelajaran pemrograman berkualitas, mudah, cepat, dan tanpa hambatan teknis bagi seluruh pelajar dan masyarakat Indonesia, dimulai dari ruang-ruang kelas hingga eksplorasi mandiri.
            </p>
        </div>

        <h2 class="text-xl font-bold text-gray-900 pt-2">Misi Utama Platform:</h2>
        <ul class="space-y-3">
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-bold">✓</span>
                <span><strong>Akses Tanpa Hambatan:</strong> Menyediakan lingkungan eksekusi kode (HTML, CSS, JS) secara langsung di browser tanpa perlu spesifikasi komputer tinggi atau instalasi perangkat lunak berat.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-bold">✓</span>
                <span><strong>Kurikulum Terarah:</strong> Membantu siswa memahami konsep dasar pemrograman web mulai dari tata letak semantik hingga manipulasi data interaktif.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-bold">✓</span>
                <span><strong>Monitoring Guru & Kolaborasi:</strong> Memungkinkan para pendidik memantau karya koding siswa secara terpusat, memberikan umpan balik langsung, dan mengukur perkembangan keahlian secara objektif.</span>
            </li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 pt-4">Komitmen Keberlanjutan</h2>
        <p>
            Platform ini terus dikembangkan secara berkelanjutan untuk mendukung ekosistem pendidikan vokasi dan umum di Indonesia. Segala masukan dan kolaborasi selalu terbuka untuk menciptakan generasi talenta digital yang unggul.
        </p>

    </div>
</div>
@endsection
