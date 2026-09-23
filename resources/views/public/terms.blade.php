@extends('layouts.public')

@section('title', 'Syarat dan Ketentuan (Terms of Service) - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-200 shadow-sm space-y-6 text-gray-700 leading-relaxed text-sm">
        
        <h1 class="text-3xl font-black text-gray-900 border-b pb-4">Syarat dan Ketentuan Layanan</h1>
        <p class="text-xs text-gray-400">Terakhir diperbarui: {{ date('d F Y') }}</p>

        <p>
            Selamat datang di <strong>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</strong>. Dengan mengakses dan menggunakan platform ini, Anda menyetujui untuk terikat oleh syarat dan ketentuan berikut. Jika Anda tidak menyetujui salah satu bagian dari ketentuan ini, Anda dilarang menggunakan platform ini.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">1. Penggunaan Layanan</h2>
        <p>
            Platform ini disediakan untuk tujuan pembelajaran dan pengembangan keterampilan koding (HTML, CSS, JavaScript). Anda setuju untuk tidak menggunakan editor atau fitur apa pun di platform ini untuk:
        </p>
        <ul class="list-disc pl-6 space-y-1">
            <li>Menjalankan skrip berbahaya, phishing, malware, atau eksploitasi keamanan.</li>
            <li>Melakukan tindakan yang dapat membebani atau merusak infrastruktur server web.</li>
            <li>Menyebarkan konten yang melanggar hukum, SARA, atau pornografi.</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 pt-4">2. Hak Kekayaan Intelektual</h2>
        <p>
            Semua kode, materi ajar, desain antarmuka, dan konten edukatif yang disediakan oleh {{ $settings['app_name'] ?? 'VxAI Coding Lab' }} dilindungi oleh undang-undang hak cipta. Kode yang Anda tulis sendiri di dalam playground tetap menjadi milik Anda secara penuh.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">3. Iklan dan Sponsor Pihak Ketiga</h2>
        <p>
            Platform ini dapat menampilkan iklan yang disediakan oleh mitra resmi kami, termasuk Google AdSense. Keberadaan iklan membantu menjaga keberlangsungan platform ini agar tetap dapat diakses secara gratis oleh masyarakat umum dan pelajar.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">4. Batasan Tanggung Jawab</h2>
        <p>
            Layanan ini disediakan "sebagaimana adanya" (*as is*) tanpa jaminan apa pun. Kami tidak bertanggung jawab atas kehilangan data kode atau gangguan layanan yang terjadi akibat faktor eksternal atau kesalahan teknis yang berada di luar kendali wajar kami.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">5. Perubahan Ketentuan</h2>
        <p>
            Kami berhak untuk memperbarui atau mengubah Syarat dan Ketentuan ini kapan saja. Perubahan akan berlaku segera setelah dipublikasikan pada halaman ini.
        </p>

    </div>
</div>
@endsection
