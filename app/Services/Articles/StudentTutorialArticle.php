<?php

namespace App\Services\Articles;

class StudentTutorialArticle
{
    /**
     * Dapatkan artikel panduan lengkap langkah demi langkah bagi siswa VxAI Coding Lab.
     */
    public static function getArticles(): array
    {
        $now = now();

        return [
            [
                'title' => 'Panduan Lengkap Siswa Belajar Koding di VxAI Coding Lab: Dari Login, Mengerjakan 10 Level Playground, hingga Mendapatkan Nilai',
                'slug' => 'panduan-lengkap-siswa-belajar-koding-vxai-playground-sampai-selesai',
                'category' => 'coding',
                'summary' => 'Panduan resmi dan tutorial terlengkap bagi siswa dalam menggunakan platform VxAI Coding Lab. Pelajari alur menyeluruh mulai dari membuka website, login akun siswa, memahami dashboard & sistem XP, menjelajahi 10 level tantangan di Live Playground, trik pengerjaan dengan editor interaktif dan bantuan VxAI Tutor, pengujian real-time, pengiriman tugas dengan konfirmasi cerdas, mekanisme deteksi level otomatis & opsi mengulang, hingga memantau nilai serta umpan balik dari guru.',
                'content' => '<p>Dunia teknologi dan rekayasa perangkat lunak berkembang sangat pesat. Bagi siswa dan pelajar generasi masa depan, keterampilan menulis baris kode (<em>coding</em>) bukan lagi sekadar hobi sampingan, melainkan kompetensi esensial yang membuka gerbang karier di industri digital global. Namun, banyak siswa sering kali merasa bingung saat pertama kali belajar: <em>Dari mana saya harus memulai? Perlukah saya menginstal aplikasi yang rumit? Bagaimana cara saya menguji kode saya? Dan bagaimana guru mengevaluasi hasil karya saya?</em></p>

<p>Kini, Anda tidak perlu lagi khawatir! Melalui platform <strong>VxAI Coding Lab</strong> (<a href="https://vxai.online" target="_blank" rel="noopener noreferrer"><strong>https://vxai.online</strong></a>), seluruh proses belajar pemrograman web dirancang 100% interaktif, langsung di peramban web (browser) tanpa instalasi aplikasi tambahan apa pun, dan diperkaya dengan sistem gamifikasi seru (Poin XP, Leveling, dan Papan Skor Leaderboard).</p>

<img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80" alt="Siswa sedang belajar koding web di laptop dengan editor interaktif modern" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Mengapa Siswa Wajib Belajar di VxAI Coding Lab?</h2>
<p>VxAI Coding Lab diciptakan secara khusus untuk mendukung siswa SMK, SMA, dan pembelajar mandiri di seluruh Indonesia dengan keunggulan berikut:</p>
<ul>
    <li><strong>Nol Instalasi (Zero Setup):</strong> Anda tidak perlu menginstal XAMPP, VS Code, Node.js, atau konfigurasi compiler rumit. Cukup buka browser dan Anda langsung siap koding.</li>
    <li><strong>Pratinjau Langsung (Live Instant Preview):</strong> Setiap baris kode HTML, styling CSS, dan script JavaScript yang Anda ketik langsung dirender secara real-time pada panel di samping editor.</li>
    <li><strong>Kurikulum Berjenjang 10 Level:</strong> Materi disusun bertahap mulai dari pemula (HTML dasar), menengah (CSS Flexbox &amp; Grid), hingga mahir (JavaScript interaktif &amp; Proyek Mini Web App).</li>
    <li><strong>Sistem Gamifikasi Motivatif:</strong> Setiap kali Anda berhasil menyelesaikan tugas dan mengirim kode, Anda memperoleh <strong>+25 XP (Experience Points)</strong> untuk menaikkan Level akun dan bersaing di Papan Peringkat.</li>
    <li><strong>Evaluasi &amp; Catatan Bimbingan Langsung dari Guru:</strong> Guru dan instruktur dapat meninjau kode Anda secara mendalam, memberikan skor nilai (0–100), dan menuliskan masukan personal agar pemahaman Anda terus berkembang.</li>
    <li><strong>Sertifikat Digital Resmi:</strong> Siswa yang berhasil menuntaskan seluruh 10 tingkatan tantangan berhak mengklaim sertifikat kelulusan digital resmi ber-QR Code validasi.</li>
</ul>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 1: Mengakses Website Resmi VxAI Coding Lab</h2>
<p>Langkah pertama sangatlah mudah. Buka aplikasi peramban web di laptop, komputer lab, atau ponsel Anda (disarankan Google Chrome, Microsoft Edge, atau Mozilla Firefox), lalu ketikkan alamat resmi:</p>
<p style="text-align:center;margin:16px 0;">
    <a href="https://vxai.online" target="_blank" rel="noopener noreferrer" style="display:inline-block;background:#2563eb;color:#ffffff;padding:12px 24px;border-radius:12px;font-weight:bold;text-decoration:none;box-shadow:0 4px 12px rgba(37,99,235,0.3);">
        🌐 Kunjungi https://vxai.online
    </a>
</p>
<p>Saat halaman utama terbuka, Anda akan disambut oleh antarmuka modern yang bersih. Di bilah navigasi atas (navbar), terdapat menu-menu penting:</p>
<ul>
    <li><strong>Beranda:</strong> Ringkasan fitur platform, modul pembelajaran, dan statistik komunitas koding.</li>
    <li><strong>Tutorial &amp; Berita:</strong> Pusat artikel edukasi, panduan sintaksis, dan kabar inovasi teknologi terkini.</li>
    <li><strong>Papan Peringkat (Leaderboard):</strong> Daftar peringkat siswa dengan perolehan XP dan level tertinggi.</li>
    <li><strong>Live Playground:</strong> Laboratorium koding interaktif tempat Anda mengasah keterampilan praktis.</li>
    <li><strong>Cek Sertifikat:</strong> Halaman verifikasi dan pencetakan sertifikat kelulusan bagi siswa yang telah menyelesaikan tantangan.</li>
    <li><strong>Tombol Masuk / Login:</strong> Pintu gerbang masuk ke akun ruang belajar siswa Anda.</li>
</ul>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 2: Melakukan Login ke Akun Siswa</h2>
<p>Meskipun pengunjung umum (tamu) dapat mencoba menulis kode secara bebas di Playground, <strong>siswa sangat diwajibkan untuk login menggunakan akun siswa resmi</strong> agar seluruh aktivitas dan karya Anda tercatat dalam buku rapor digital sekolah.</p>

<img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1100&q=80" alt="Antarmuka login aman pada platform edukasi digital" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h3>Cara Masuk ke Akun:</h3>
<ol>
    <li>Klik tombol <strong>"Masuk"</strong> pada bilah navigasi kanan atas atau buka langsung tautan: <a href="https://vxai.online/login" target="_blank" rel="noopener noreferrer"><strong>https://vxai.online/login</strong></a>.</li>
    <li>Ketikkan <strong>Alamat Email Akun Siswa</strong> Anda (misal: <code>nama.siswa@sekolah.sch.id</code> atau email yang telah didaftarkan oleh guru).</li>
    <li>Ketikkan <strong>Kata Sandi (Password)</strong> akun Anda dengan cermat.</li>
    <li>Klik tombol <strong>"Masuk Sekarang"</strong>.</li>
</ol>

<blockquote style="background:#0f172a;border-left:4px solid #3b82f6;padding:16px 20px;border-radius:8px;margin:20px 0;color:#cbd5e1;">
    <strong style="color:#60a5fa;">💡 Mengapa Wajib Login dengan Akun Siswa?</strong><br>
    Jika Anda mengerjakan dalam mode tamu (tanpa login), hasil koding hanya tercatat sebagai data anonim dan nilai Anda tidak akan masuk ke buku nilai guru Anda. Dengan login, setiap submisi otomatis mengalirkan <strong>+25 XP</strong> ke akun Anda, menaikkan level koding, menyimpan nilai serta catatan evaluasi guru secara permanen, dan mengamankan sertifikat atas nama resmi Anda.
</blockquote>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 3: Menjelajahi Ruang Belajar &amp; Dashboard Siswa</h2>
<p>Setelah proses login berhasil, sistem akan mengarahkan Anda ke <strong>Ruang Belajar Siswa</strong> (<a href="https://vxai.online/siswa" target="_blank" rel="noopener noreferrer"><code>https://vxai.online/siswa</code></a>). Ini adalah pusat kendali pribadi tempat Anda memantau seluruh kemajuan belajar Anda.</p>

<img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1100&q=80" alt="Siswa memantau dashboard capaian belajar dan progres nilai koding" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h3>1. Kartu Status Profil &amp; Statistik Gamifikasi</h3>
<p>Di bagian atas dashboard, Anda akan melihat 4 kartu indikator utama:</p>
<ul>
    <li><strong>Status Keahlian (Level Siswa):</strong> Menampilkan level Anda saat ini (misalnya <em>Level 1</em>, <em>Level 2</em>, dst.) lengkap dengan bilah progress bar XP menuju level berikutnya (100 XP untuk setiap kenaikan 1 level).</li>
    <li><strong>Total Pengalaman (XP):</strong> Total akumulasi poin pengalaman yang telah Anda kumpulkan dari seluruh penugasan koding.</li>
    <li><strong>Tugas Terkirim:</strong> Jumlah total tugas yang telah Anda serahkan dari Playground beserta keterangan berapa tugas yang sudah dinilai oleh guru.</li>
    <li><strong>Rata-Rata Nilai:</strong> Rata-rata skor akademik koding Anda (skala 0–100) dari semua tugas yang telah diperiksa guru.</li>
</ul>

<h3>2. Daftar Riwayat Hasil Evaluasi, Nilai &amp; Catatan Guru</h3>
<p>Di bawah kartu statistik, terdapat daftar riwayat seluruh tugas koding yang pernah Anda kirimkan. Setiap kartu tugas memuat informasi mendalam:</p>
<ul>
    <li><strong>Nama Latihan:</strong> Judul modul level yang Anda kerjakan (misal: <em>Latihan 1: Struktur Web &amp; Format Teks</em>).</li>
    <li><strong>Waktu Pengerjaan:</strong> Tanggal dan jam presisi saat Anda mengirimkan tugas beserta durasi relatif (misal: <em>2 jam yang lalu</em>).</li>
    <li><strong>Status &amp; Badge Nilai:</strong>
        <ul>
            <li>Jika guru belum memeriksa: Ditandai dengan badge kuning <code>⏳ Menunggu Penilaian Guru / Admin</code>.</li>
            <li>Jika sudah dinilai: Muncul skor nilai resmi dalam kotak hijau/biru (misal: <code>🎯 Nilai: 95 / 100</code>) lengkap dengan predikat <strong>Sangat Baik</strong>, <strong>Baik</strong>, atau <strong>Cukup Baik</strong>.</li>
        </ul>
    </li>
    <li><strong>Kotak Catatan &amp; Umpan Balik Guru (Feedback Box):</strong> Bagian terpenting dari evaluasi! Di sini guru menuliskan pesan masukan, saran perbaikan penulisan tag, atau apresiasi atas kreativitas desain Anda.</li>
    <li><strong>Tombol "🔍 Lihat Kode &amp; Tampilan":</strong> Fitur canggih yang membuka jendela inspeksi modal ekspansif layar penuh. Anda dapat meninjau kembali kode HTML, CSS, dan JavaScript yang pernah Anda kirimkan sekaligus melihat kembali tampilan visualnya secara live kapan pun Anda butuhkan.</li>
</ul>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 4: Masuk ke Ruang Live Playground Koding</h2>
<p>Kini saatnya mulai menulis kode! Dari Dashboard Siswa, Anda cukup mengklik tombol utama berwarna biru gradasi <strong>"⚡ Buka Live Playground"</strong> atau mengaksesnya melalui menu navigasi atas.</p>

<h3>Anatomi Ruang Kerja (Workspace) Playground:</h3>
<p>Playground VxAI dirancang mirip dengan lingkungan kerja pengembang profesional (IDE modern) yang terbagi menjadi beberapa zona ergonomis:</p>
<ol>
    <li><strong>Topbar Atas:</strong>
        <ul>
            <li>Status Akun: Menampilkan nama Anda, level, dan XP aktif.</li>
            <li>Tombol <strong>🤖 VxAI Tutor</strong>: Membuka asisten kecerdasan buatan cerdas untuk memandu koding jika Anda mengalami kendala atau kode error.</li>
            <li>Tombol <strong>🎯 Tingkatan Koding (10 Latihan)</strong>: Menu untuk memilih dan beralih tingkatan latihan.</li>
            <li>Tombol <strong>📊 Nilai Saya</strong>: Pintasan cepat untuk melihat nilai dan catatan guru langsung di dalam Playground tanpa harus meninggalkan ruang kerja.</li>
            <li>Tombol <strong>💡 Kamus Kode</strong>: Lembar referensi cepat sintaksis HTML, CSS, dan JavaScript.</li>
            <li>Tombol <strong>🚀 Kirim / Simpan</strong>: Tombol untuk menyerahkan hasil pengerjaan koding Anda ke guru.</li>
        </ul>
    </li>
    <li><strong>Banner Tantangan Aktif:</strong> Terletak tepat di bawah header, menampilkan nama latihan yang sedang Anda kerjakan beserta ringkasan instruksi singkat.</li>
    <li><strong>Panel Editor Kode (Sisi Kiri):</strong> Tempat Anda mengetik baris kode program. Tersedia tab terpisah yang rapi:
        <ul>
            <li><code>HTML</code>: Untuk menulis kerangka elemen, teks, gambar, dan formulir.</li>
            <li><code>CSS</code>: Untuk mengatur warna, gaya huruf, tata letak Flexbox/Grid, dan animasi visual.</li>
            <li><code>JS</code>: Untuk menulis logika interaktif, manipulasi DOM, dan respon klik tombol.</li>
        </ul>
    </li>
    <li><strong>Panel Pratinjau Langsung / Live Preview (Sisi Kanan):</strong> Jendela browser simulasi yang langsung menampilkan hasil nyata kode Anda saat itu juga secara real-time. Anda dapat langsung melihat perubahan warna, teks, tombol, maupun interaksi tanpa perlu menunggu refresh!</li>
</ol>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 5: Memahami Kurikulum Berjenjang 10 Tingkatan Koding</h2>
<p>Untuk memastikan siswa belajar dengan fondasi yang kokoh, materi koding di VxAI disusun dalam <strong>10 Tingkatan Latihan Berjenjang</strong> yang saling berkesinambungan:</p>

<table style="width:100%;border-collapse:collapse;margin:24px 0;font-size:13px;border:1px solid #334155;">
    <thead>
        <tr style="background:#1e293b;color:#f8fafc;text-align:left;">
            <th style="padding:12px;border:1px solid #334155;">Level</th>
            <th style="padding:12px;border:1px solid #334155;">Nama Modul Tantangan</th>
            <th style="padding:12px;border:1px solid #334155;">Kategori</th>
            <th style="padding:12px;border:1px solid #334155;">Kompetensi Utama yang Dipelajari</th>
        </tr>
    </thead>
    <tbody>
        <tr style="background:#0f172a;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#38bdf8;">Level 1</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Struktur Web &amp; Format Teks</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#1e3a8a;color:#93c5fd;padding:2px 8px;border-radius:6px;font-size:11px;">HTML5</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Anatomi dokumen web, tag heading (&lt;h1&gt;–&lt;h6&gt;), paragraf (&lt;p&gt;), format tebal/miring, dan hyperlink (&lt;a&gt;).</td>
        </tr>
        <tr style="background:#1e293b;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#38bdf8;">Level 2</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Formulir Pendaftaran Siswa</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#1e3a8a;color:#93c5fd;padding:2px 8px;border-radius:6px;font-size:11px;">HTML5</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Elemen &lt;form&gt;, kolom teks, email, tombol kirim, dan atribut validasi wajib isi (required).</td>
        </tr>
        <tr style="background:#0f172a;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#60a5fa;">Level 3</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Tata Letak Kartu Modern Flexbox</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#065f46;color:#a7f3d0;padding:2px 8px;border-radius:6px;font-size:11px;">CSS3</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Penyelarasan 1 dimensi (Flexbox), justify-content, align-items, border-radius, dan bayangan kartu (box-shadow).</td>
        </tr>
        <tr style="background:#1e293b;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#60a5fa;">Level 4</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Grid Galeri Portofolio Responsif</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#065f46;color:#a7f3d0;padding:2px 8px;border-radius:6px;font-size:11px;">CSS3</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Tata letak 2 dimensi (CSS Grid), grid-template-columns, gap, dan penataan kartu galeri otomatis responsif.</td>
        </tr>
        <tr style="background:#0f172a;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#60a5fa;">Level 5</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Animasi &amp; Efek Hover Modern</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#065f46;color:#a7f3d0;padding:2px 8px;border-radius:6px;font-size:11px;">CSS3</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Transisi CSS (transition), transformasi 2D (scale, rotate), dan pseudo-class :hover interaktif.</td>
        </tr>
        <tr style="background:#1e293b;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#fbbf24;">Level 6</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Tombol Interaktif &amp; Counter Klik</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#78350f;color:#fde68a;padding:2px 8px;border-radius:6px;font-size:11px;">JavaScript</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Pengenalan DOM (Document Object Model), seleksi elemen document.getElementById(), dan event listener click.</td>
        </tr>
        <tr style="background:#0f172a;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#fbbf24;">Level 7</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Kalkulator Nilai Siswa Sederhana</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#78350f;color:#fde68a;padding:2px 8px;border-radius:6px;font-size:11px;">JavaScript</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Operasi aritmatika variabel, konversi tipe data (parseFloat), logika percabangan if/else, dan penentuan kelulusan.</td>
        </tr>
        <tr style="background:#1e293b;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#fbbf24;">Level 8</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">To-Do List / Catatan Tugas Interaktif</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#78350f;color:#fde68a;padding:2px 8px;border-radius:6px;font-size:11px;">JavaScript</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Manipulasi array data, pembuatan elemen dinamis (createElement), appendChild, dan fungsi hapus elemen.</td>
        </tr>
        <tr style="background:#0f172a;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#fbbf24;">Level 9</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Jam Digital &amp; Deteksi Waktu Nyata</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#78350f;color:#fde68a;padding:2px 8px;border-radius:6px;font-size:11px;">JavaScript</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Objek waktu bawaan new Date(), method getHours()/getMinutes(), dan fungsi pewaktu berulang setInterval().</td>
        </tr>
        <tr style="background:#0f172a;color:#cbd5e1;">
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;color:#a855f7;">Level 10</td>
            <td style="padding:10px 12px;border:1px solid #334155;font-weight:bold;">Mini Web App Proyek Akhir Lengkap</td>
            <td style="padding:10px 12px;border:1px solid #334155;"><span style="background:#581c87;color:#e9d5ff;padding:2px 8px;border-radius:6px;font-size:11px;">Full Project</span></td>
            <td style="padding:10px 12px;border:1px solid #334155;">Integrasi utuh HTML semantik, CSS modern responsif, dan logika JS terpadu sebagai karya portofolio kelulusan.</td>
        </tr>
    </tbody>
</table>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Fitur Cerdas: Deteksi Level Otomatis &amp; Opsi Memulai Ulang</h2>
<p>Platform VxAI Coding Lab dilengkapi dua kecerdasan alur sistem yang menjamin pengalaman belajar Anda tetap mulus dan adil:</p>

<h3>1. Sistem Deteksi Level Otomatis (Anti-Bingung)</h3>
<p>Setiap kali Anda membuka Playground, sistem di balik layar akan memeriksa daftar tugas yang telah Anda kirimkan sebelumnya. Jika Anda telah menuntaskan Level 1, sistem secara otomatis mengarahkan dan merekomendasikan Anda untuk langsung mengerjakan <strong>Level 2</strong>. Anda tidak perlu lagi mengingat-ingat manual level mana yang belum selesai!</p>

<h3>2. Opsi Memulai Ulang &amp; Reset Nilai (Peluang Perbaikan)</h3>
<p>Bagaimana jika Anda sudah pernah mengerjakan Level 1, namun nilainya masih kurang memuaskan dan Anda ingin memperbaikinya?</p>
<p>Sistem VxAI sangat fleksibel dan mendukung semangat belajar berkelanjutan! Saat Anda memilih kembali level yang sudah selesai, sistem akan menampilkan <strong>Modal Konfirmasi Cerdas</strong> dengan dua pilihan:</p>
<ul>
    <li><strong>Beralih ke Level Belum Dikerjakan:</strong> Menjaga alur belajar normal ke level selanjutnya.</li>
    <li><strong>Ganti Hasil Lama &amp; Reset Nilai:</strong> Jika Anda memilih opsi ini, kode baru Anda akan menimpa kode lama di server. Status tugas akan di-reset menjadi <em>"Menunggu Penilaian Baru"</em>, sehingga guru dapat menguji kembali kode perbaikan Anda dan memberikan nilai baru yang lebih tinggi. Poin XP tidak diduplikasi agar kompetisi di papan peringkat tetap jujur dan adil.</li>
</ul>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 6: Mengerjakan Tugas dengan Fasilitas Bantuan</h2>
<p>Saat lembar kerja koding terbuka, Anda tidak dibiarkan sendirian! Manfaatkan 3 fitur pendukung resmi berikut:</p>

<ol>
    <li>
        <strong>Membaca Instruksi Soal:</strong><br>
        Klik banner latihan di bawah header untuk membaca tujuan pembelajaran dan daftar langkah teknis yang wajib dikerjakan.
    </li>
    <li>
        <strong>Memanfaatkan Kamus Kode (Cheat Sheet):</strong><br>
        Lupa apa nama tag untuk menyisipkan gambar? Atau lupa sintaksis Flexbox? Klik tombol kuning <strong>"💡 Kamus Kode"</strong>. Pop-up referensi cepat akan muncul merangkum tag HTML penting, selektor CSS, dan perintah JavaScript tanpa perlu membuka tab pencarian lain.
    </li>
    <li>
        <strong>Berkonsultasi dengan Asisten Cerdas VxAI Code Tutor:</strong><br>
        Jika kode Anda tidak berjalan semestinya atau muncul tulisan error, klik tombol gradasi ungu <strong>"🤖 VxAI Tutor"</strong>. Asisten AI edukasi ini siap menganalisis logika kode Anda dan memberikan petunjuk perbaikan layaknya mentor privat yang sabar mendampingi Anda di samping meja.
    </li>
</ol>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 7: Menguji Kode &amp; Mengirimkan Hasil Tugas</h2>
<p>Ketika Anda telah menyelesaikan seluruh instruksi latihan pada editor, ikuti prosedur pengiriman berikut:</p>

<ol>
    <li><strong>Uji Tampilan &amp; Fungsi:</strong> Periksa jendela pratinjau di sisi kanan. Pastikan teks sudah terbaca rapi, warna sesuai target, formulir dapat diisi, atau tombol sudah merespon klik dengan benar.</li>
    <li><strong>Klik Tombol "🚀 Kirim / Simpan":</strong> Tombol hijau di pojok kanan atas header.</li>
    <li><strong>Tunggu Proses Komputasi 1-2 Detik:</strong> Sistem memvalidasi kelengkapan kode dan mencatatnya ke database guru.</li>
    <li>
        <strong>Muncul Pop-Up Berhasil Eksklusif (Custom Modal):</strong><br>
        Sebuah modal bertema gelap futuristik akan muncul di layar mengucapkan selamat atas keberhasilan Anda, mengonfirmasi perolehan <strong>+25 XP</strong>, dan menampilkan kartu ringkasan level berikutnya yang siap dibuka.
    </li>
    <li>
        <strong>Konfirmasi Lanjut Level Berikutnya:</strong><br>
        Saat Anda mengklik tombol <em>"Lanjut ke Level Berikutnya"</em>, sistem akan memunculkan pop-up konfirmasi dua arah:
        <ul>
            <li><strong>"🚀 Lanjut Koding":</strong> Jika Anda sudah percaya diri dan ingin langsung melompat ke lembar kerja editor level selanjutnya dengan kode kerangka awal siap pakai.</li>
            <li><strong>"📖 Baca Panduan":</strong> Jika Anda ingin membuka dan membaca modul petunjuk materi terlebih dahulu sebelum mulai mengetik kode.</li>
        </ul>
    </li>
</ol>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 8: Memantau Nilai, Catatan Masukan Guru, dan Leaderboard</h2>
<p>Setelah tugas Anda terkirim, guru mata pelajaran atau instruktur di sekolah akan memeriksa hasil koding Anda melalui panel guru/admin. Guru akan menguji logika kode, estetika tata letak, dan kepatuhan instruksi.</p>

<img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1100&q=80" alt="Guru dan siswa berdiskusi mengenai capaian hasil evaluasi tugas koding" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h3>Dua Cara Memeriksa Nilai Anda:</h3>
<ul>
    <li><strong>Cara Cepat (Dari dalam Playground):</strong> Klik tombol <strong>"📊 Nilai Saya"</strong> pada header Playground. Anda dapat melihat daftar seluruh tugas yang sudah dinilai secara instan dalam jendela pop-up ringkas.</li>
    <li><strong>Cara Lengkap (Dari Dashboard Siswa):</strong> Buka halaman <a href="https://vxai.online/siswa" target="_blank" rel="noopener noreferrer"><strong>Dashboard Siswa</strong></a>. Di sini Anda bisa membaca catatan ulasan guru secara utuh, melihat nilai rata-rata keseluruhan, dan mempratinjau kode yang telah diarsipkan.</li>
</ul>

<h3>Memantau Posisi di Papan Peringkat (Leaderboard):</h3>
<p>Kunjungi menu <a href="https://vxai.online/leaderboard" target="_blank" rel="noopener noreferrer"><strong>🏆 Papan Peringkat</strong></a>. Setiap tugas yang Anda selesaikan menyumbang poin XP yang mendorong posisi Anda naik di papan peringkat sekolah. Ini adalah sarana kompetisi positif yang mengasyikkan bersama rekan-rekan sekelas!</p>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Langkah 9: Kelulusan 10 Level &amp; Mengklaim Sertifikat Digital</h2>
<p>Momen yang paling ditunggu-tunggu oleh setiap siswa adalah ketika berhasil menyelesaikan hingga <strong>Level 10 (Mini Web App Proyek Akhir)</strong>!</p>

<img src="https://images.unsplash.com/photo-1606326608606-aa0b62935f2b?auto=format&fit=crop&w=1100&q=80" alt="Sertifikat penghargaan digital atas capaian kompetensi keahlian koding" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<ol>
    <li>Begitu tugas Level 10 berhasil dikirim, pop-up sukses akan menampilkan lencana emas: <strong>"🏆 LUAR BIASA! 10 LEVEL SELESAI"</strong>.</li>
    <li>Klik tombol <strong>"🎓 Klaim &amp; Cetak Sertifikat Kelulusan"</strong> atau akses langsung halaman: <a href="https://vxai.online/sertifikat" target="_blank" rel="noopener noreferrer"><strong>https://vxai.online/sertifikat</strong></a>.</li>
    <li>Masukkan ID Siswa atau Nama Lengkap Anda sesuai akun yang terdaftar.</li>
    <li>Sistem akan menerbitkan <strong>Sertifikat Digital Resmi</strong> berdesain profesional yang memuat nama Anda, capaian kompetensi pemrograman web terstandar, nomor sertifikat unik, dan kode verifikasi QR yang sah.</li>
    <li>Anda dapat mengunduh sertifikat dalam format PDF beresolusi tinggi untuk dicetak atau dilampirkan sebagai portofolio keahlian saat melamar magang industri (PKL).</li>
</ol>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>5 Tips Emas Sukses Menjadi Siswa Programmer Andal</h2>
<p>Sebelum Anda memulai petualangan koding Anda di VxAI Coding Lab, berikut adalah 5 pesan kunci dari para praktisi industri:</p>
<ol>
    <li><strong>Pahami Logika, Jangan Sekadar Menghafal Sintaksis:</strong> Koding adalah seni memecahkan masalah. Yang terpenting adalah mengerti urutan langkah bagaimana komputer mengeksekusi instruksi Anda.</li>
    <li><strong>Rangkul Pesan Error sebagai Guru Terbaik:</strong> Jangan panik saat kode Anda tidak berjalan atau tombol tidak berfungsi. Pesan error di console adalah petunjuk berharga yang memberitahu di baris mana Anda perlu melakukan perbaikan.</li>
    <li><strong>Tulis Kode yang Rapi &amp; Berindentasi:</strong> Selalu berikan spasi atau tab yang konsisten pada elemen bersarang agar kode mudah dibaca oleh diri sendiri dan guru yang memeriksa.</li>
    <li><strong>Eksplorasi &amp; Modifikasi Warna Sendiri:</strong> Setelah memenuhi instruksi wajib latihan, jangan ragu untuk berkreasi mengubah warna latar, ukuran font, atau menambahkan animasi kreatif Anda sendiri.</li>
    <li><strong>Konsisten Berlatih Setiap Hari:</strong> Menulis kode 20 menit setiap hari jauh lebih efektif daripada belajar maraton 5 jam hanya sekali dalam sebulan.</li>
</ol>

<hr style="border:none;border-top:1px solid #e2e8f0;margin:32px 0;">

<h2>Kesimpulan &amp; Tautan Cepat Memulai</h2>
<p>Platform <strong>VxAI Coding Lab</strong> hadir untuk membuktikan bahwa belajar koding bisa dilakukan oleh siapa saja, di mana saja, dengan suasana yang menggembirakan, interaktif, dan penuh penghargaan atas setiap baris karya Anda.</p>

<p>Kini giliran Anda untuk membuktikan kemampuan! Segera masuk ke akun Anda dan mulailah perjalanan menaklukkan 10 tingkatan koding melalui tautan resmi di bawah ini:</p>

<ul>
    <li>🌐 <strong>Portal Utama:</strong> <a href="https://vxai.online" target="_blank" rel="noopener noreferrer">https://vxai.online</a></li>
    <li>🔑 <strong>Masuk Akun Siswa:</strong> <a href="https://vxai.online/login" target="_blank" rel="noopener noreferrer">https://vxai.online/login</a></li>
    <li>🏠 <strong>Dashboard &amp; Nilai Siswa:</strong> <a href="https://vxai.online/siswa" target="_blank" rel="noopener noreferrer">https://vxai.online/siswa</a></li>
    <li>⚡ <strong>Live Playground Koding:</strong> <a href="https://vxai.online/playground" target="_blank" rel="noopener noreferrer">https://vxai.online/playground</a></li>
    <li>🏆 <strong>Papan Skor Peringkat:</strong> <a href="https://vxai.online/leaderboard" target="_blank" rel="noopener noreferrer">https://vxai.online/leaderboard</a></li>
    <li>📜 <strong>Cek &amp; Cetak Sertifikat:</strong> <a href="https://vxai.online/sertifikat" target="_blank" rel="noopener noreferrer">https://vxai.online/sertifikat</a></li>
</ul>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
