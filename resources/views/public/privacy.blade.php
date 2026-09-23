@extends('layouts.public')

@section('title', 'Kebijakan Privasi (Privacy Policy) - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-200 shadow-sm space-y-6 text-gray-700 leading-relaxed text-sm">
        
        <h1 class="text-3xl font-black text-gray-900 border-b pb-4">Kebijakan Privasi (Privacy Policy)</h1>
        <p class="text-xs text-gray-400">Terakhir diperbarui: {{ date('d F Y') }}</p>

        <p>
            Di <strong>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</strong> (dapat diakses melalui <a href="{{ route('home') }}" class="text-blue-600 underline">https://vxai.online</a>), salah satu prioritas utama kami adalah privasi pengunjung. Dokumen Kebijakan Privasi ini berisi jenis informasi yang dikumpulkan dan dicatat oleh kami serta bagaimana kami menggunakannya.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">1. Berkas Log (Log Files)</h2>
        <p>
            {{ $settings['app_name'] ?? 'VxAI Coding Lab' }} mengikuti prosedur standar dalam menggunakan berkas log. Berkas ini mencatat pengunjung saat mereka mengunjungi situs web. Informasi yang dikumpulkan meliputi alamat protokol internet (IP), jenis peramban (browser), penyedia layanan internet (ISP), cap tanggal dan waktu, serta halaman rujukan/keluar. Informasi ini tidak ditautkan ke informasi apa pun yang dapat diidentifikasi secara pribadi. Tujuannya adalah untuk menganalisis tren, mengelola situs, melacak pergerakan pengguna, dan mengumpulkan informasi demografis.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">2. Cookie dan Web Beacon</h2>
        <p>
            Seperti situs web lainnya, kami menggunakan 'cookie'. Cookie digunakan untuk menyimpan informasi termasuk preferensi pengunjung, dan halaman-halaman di situs web yang diakses atau dikunjungi pengunjung. Informasi tersebut digunakan untuk mengoptimalkan pengalaman pengguna dengan menyesuaikan konten halaman web kami berdasarkan jenis peramban pengunjung atau informasi lainnya.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">3. Cookie Google DoubleClick DART (Google AdSense)</h2>
        <p>
            Google adalah salah satu vendor pihak ketiga di situs kami. Google juga menggunakan cookie, yang dikenal sebagai cookie DART, untuk menayangkan iklan kepada pengunjung situs kami berdasarkan kunjungan mereka ke situs kami dan situs lain di internet. Pengunjung dapat memilih untuk menolak penggunaan cookie DART dengan mengunjungi Kebijakan Privasi jaringan iklan dan konten Google di URL berikut: <a href="https://policies.google.com/technologies/ads" target="_blank" class="text-blue-600 underline">https://policies.google.com/technologies/ads</a>.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">4. Kebijakan Privasi Mitra Iklan Pihak Ketiga</h2>
        <p>
            Server iklan atau jaringan iklan pihak ketiga menggunakan teknologi seperti cookie, JavaScript, atau Web Beacon yang digunakan dalam iklan dan tautan masing-masing yang muncul di {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}, yang dikirim langsung ke peramban pengguna. Mereka secara otomatis menerima alamat IP Anda saat ini terjadi. Teknologi ini digunakan untuk mengukur efektivitas kampanye iklan mereka atau mempersonalisasi konten iklan yang Anda lihat di situs web yang Anda kunjungi.
        </p>
        <p>
            Harap dicatat bahwa {{ $settings['app_name'] ?? 'VxAI Coding Lab' }} tidak memiliki akses atau kendali atas cookie yang digunakan oleh pengiklan pihak ketiga tersebut.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">5. Informasi Anak</h2>
        <p>
            Bagian lain dari prioritas kami adalah menambahkan perlindungan bagi anak-anak saat menggunakan internet. Kami mendorong orang tua dan wali untuk mengamati, berpartisipasi, atau memantau serta membimbing aktivitas daring mereka. {{ $settings['app_name'] ?? 'VxAI Coding Lab' }} tidak secara sadar mengumpulkan Informasi Identifikasi Pribadi apa pun dari anak-anak di bawah usia 13 tahun.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">6. Persetujuan</h2>
        <p>
            Dengan menggunakan situs web kami, Anda dengan ini menyetujui Kebijakan Privasi kami dan menyetujui syarat-syaratnya.
        </p>

        <h2 class="text-xl font-bold text-gray-900 pt-4">7. Hubungi Kami</h2>
        <p>
            Jika Anda memiliki pertanyaan tambahan atau memerlukan informasi lebih lanjut tentang Kebijakan Privasi kami, jangan ragu untuk menghubungi kami melalui surel di <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="text-blue-600 underline">{{ $settings['contact_email'] ?? 'admin@vxai.online' }}</a>.
        </p>

    </div>
</div>
@endsection
