@extends('layouts.public')

@section('title', 'Kebijakan Privasi & Kepatuhan UU PDP - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-200 shadow-sm space-y-8 text-gray-700 leading-relaxed text-sm">
        
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold text-xs mb-3 border border-blue-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Kepatuhan UU No. 27 Tahun 2022 (UU PDP) & Standar Keamanan Global
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 border-b pb-4">Kebijakan Privasi (Privacy Policy)</h1>
            <p class="text-xs text-gray-400 mt-2">Terakhir diperbarui: {{ date('d F Y') }} | Berlaku untuk platform resmi <a href="{{ route('home') }}" class="text-blue-600 underline font-medium">https://vxai.online</a></p>
        </div>

        <p>
            Di <strong>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</strong>, kami berkomitmen teguh melindungi privasi setiap pengunjung, peserta didik (siswa SMK), dan tenaga pendidik. Kebijakan Privasi ini menguraikan bagaimana data dikumpulkan, diproses, dan diamankan dengan berlandaskan regulasi resmi <strong>Undang-Undang Republik Indonesia Nomor 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)</strong> serta standar industri teknologi periklanan Google AdSense.
        </p>

        <!-- 1. UU PDP -->
        <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                Landasan Pemrosesan Data & Kepatuhan UU PDP
            </h2>
            <p class="text-slate-600">
                Sesuai dengan Pasal 20 UU No. 27 Tahun 2022, pemrosesan data pribadi di platform kami dilakukan secara sah, transparan, dan terbatas berdasarkan persetujuan eksplisit pengguna serta kepentingan yang sah (<em>legitimate interest</em>) untuk penyelenggaraan layanan edukasi koding dan keamanan siber.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2 text-xs">
                <div class="bg-white p-3 rounded-xl border border-slate-200">
                    <strong class="text-slate-900 block mb-1">Data Siswa / Pengguna Akun:</strong>
                    Nama, alamat surel, catatan perkembangan koding, level kecakapan, dan skor XP untuk keperluan evaluasi pedagogis.
                </div>
                <div class="bg-white p-3 rounded-xl border border-slate-200">
                    <strong class="text-slate-900 block mb-1">Kedaulatan Karya Koding:</strong>
                    Kode sumber (HTML/CSS/JS) yang dikirimkan siswa merupakan kekayaan intelektual pembelajaran siswa dan tidak pernah diperjualbelikan kepada pihak ketiga.
                </div>
            </div>
        </div>

        <!-- 2. Logging & Pencegahan Penyalahgunaan -->
        <h2 class="text-xl font-bold text-gray-900 pt-2">2. Berkas Log, Alamat IP & Pemantauan Keamanan Siber</h2>
        <p>
            {{ $settings['app_name'] ?? 'VxAI Coding Lab' }} menerapkan pencatatan berkas log sistem (<em>system logs</em>) yang mencakup alamat protokol internet (IP Address), jenis peramban (browser), perujuk situs (referer), cap waktu akses, dan agen pengguna (user-agent).
        </p>
        <p>
            <strong>Tujuan Pencatatan IP:</strong> Alamat IP dicatat dan dipelihara secara utuh sebagai instrumen vital pemantauan keamanan siber, mitigasi serangan penolakan layanan (DDoS), penangkalan bot berbahaya, serta audit pencegahan penyalahgunaan sistem (*abuse prevention*) pada fitur Live Code Playground dan API. Data ini disimpan dalam lingkungan database terlindungi dan tidak digunakan untuk tujuan komersial di luar integritas operasional platform.
        </p>

        <!-- 3. Hak Subjek Data -->
        <h2 class="text-xl font-bold text-gray-900 pt-2">3. Hak Anda sebagai Subjek Data Pribadi (Pasal 5 - 13 UU PDP)</h2>
        <p>
            Sebagai pengguna dan pemilik data pribadi, Anda memiliki hak-hak hukum penuh yang dijamin oleh peraturan perundang-undangan:
        </p>
        <ul class="list-disc list-inside space-y-1.5 pl-2 text-slate-700">
            <li><strong>Hak Memperoleh Informasi:</strong> Mengetahui kejelasan identitas pengendali data, dasar hukum, dan tujuan pemrosesan data.</li>
            <li><strong>Hak Mengakses & Memperbaiki:</strong> Meminta salinan data pribadi Anda serta memperbaiki kesalahan atau ketidakakuratan data profil Anda.</li>
            <li><strong>Hak Menghapus (Right to Erasure):</strong> Mengajukan permohonan penghapusan riwayat akun dan submisi kode Anda dari basis data kami.</li>
            <li><strong>Hak Menarik Persetujuan:</strong> Membatalkan persetujuan pemrosesan data sewaktu-waktu melalui komunikasi surel resmi kami.</li>
        </ul>

        <!-- 4. Cookie & Web Beacon -->
        <h2 class="text-xl font-bold text-gray-900 pt-2">4. Cookie & Preferensi Sesi</h2>
        <p>
            Platform kami menggunakan 'cookie' untuk mengingat preferensi antarmuka Anda (misalnya tema editor kode Dracula, status sesi login, dan konfigurasi tampilan). Cookie ini memungkinkan Anda berpindah halaman tanpa harus melakukan autentikasi ulang secara berulang.
        </p>

        <!-- 5. Google AdSense & Vendor Pihak Ketiga -->
        <h2 class="text-xl font-bold text-gray-900 pt-2">5. Google DoubleClick DART & Mitra Iklan Pihak Ketiga</h2>
        <p>
            Google merupakan vendor pihak ketiga independen di situs kami. Google memanfaatkan cookie (termasuk cookie DART) untuk menayangkan iklan kepada pengunjung berdasarkan riwayat kunjungan ke situs ini dan situs lainnya di internet. Pengunjung dapat memilih untuk menolak penggunaan cookie personalisasi iklan DART dengan mengunjungi laman resmi Kebijakan Privasi Google di:
            <a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline font-medium">https://policies.google.com/technologies/ads</a>.
        </p>

        <!-- 6. Perlindungan Anak & Siswa -->
        <h2 class="text-xl font-bold text-gray-900 pt-2">6. Perlindungan Khusus Peserta Didik & Anak</h2>
        <p>
            Mengingat platform ini menjadi sarana belajar bagi siswa SMK dan pelajar vokasi, kami menerapkan standar perlindungan khusus:
        </p>
        <ul class="list-disc list-inside space-y-1.5 pl-2 text-slate-700">
            <li>Tidak ada data pribadi sensitif anak di bawah umur yang dipublikasikan secara terbuka tanpa izin wali atau institusi sekolah.</li>
            <li>Sistem playground dapat digunakan secara anonim (sebagai tamu) tanpa kewajiban menyerahkan nomor telepon atau data kependudukan pribadi.</li>
        </ul>

        <!-- 7. Kontak & Saluran Permohonan Data -->
        <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-2xl space-y-2">
            <h2 class="text-base font-bold text-blue-900">7. Layanan Pengaduan & Hak Subjek Data</h2>
            <p class="text-blue-800 text-xs">
                Untuk pertanyaan, koreksi data, atau permohonan penghapusan akun sesuai hak UU PDP, silakan hubungi Tim Pengendali Data Pribadi VxAI melalui surel resmi kami:
            </p>
            <p class="pt-1">
                <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold text-xs hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Hubungi: {{ $settings['contact_email'] ?? 'admin@vxai.online' }}
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
