<?php

namespace App\Services\Articles;

class ComputerArticles
{
    public static function getArticles(): array
    {
        $now = now();

        return [
            // ARTIKEL KOMPUTER 1: Panduan Merakit PC
            [
                'title' => 'Panduan Lengkap Merakit Komputer (PC) untuk Koding & AI 2026: Komponen, Spesifikasi CPU/GPU & Estimasi Anggaran',
                'slug' => 'panduan-lengkap-merakit-pc-koding-ai-komponen-spesifikasi',
                'category' => 'komputer',
                'summary' => 'Panduan komprehensif langkah demi langkah merakit komputer desktop berkinerja tinggi untuk kebutuhan pemrograman web, rekayasa perangkat lunak, dan pelatihan model kecerdasan buatan (Machine Learning/AI) di tahun 2026.',
                'content' => '<p>Kebutuhan komputasi seorang programmer modern telah berkembang pesat. Jika dahulu menulis kode HTML, CSS, dan JavaScript dapat dilakukan pada laptop spesifikasi minimal, kini kehadiran kontainer Docker, simulator mobile, kompilasi TypeScript skala besar, hingga eksekusi model kecerdasan buatan lokal (Local LLM / PyTorch) menuntut perangkat keras dengan daya komputasi yang tangguh, stabil, dan memiliki manajemen termal yang prima.</p>
<p>Merakit komputer desktop sendiri (PC Custom) memberikan kebebasan mutlak dalam memilih komponen terbaik sesuai anggaran, kemudahan ekspansi di masa depan (upgradability), serta rasio performa-ke-harga yang jauh lebih unggul dibanding membeli laptop atau komputer jadi bermerek.</p>

<img src="https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=1200&q=80" alt="Komponen motherboard dan perangkat keras komputer desktop rakitan" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Komponen Kunci PC Koding & Machine Learning</h2>
<p>Sebelum membeli komponen di toko komputer, pahami prioritas teknis untuk beban kerja rekayasa perangkat lunak:</p>

<h3>A. Prosesor (CPU - Otak Utama Kompilasi)</h3>
<p>Prosesor bertanggung jawab langsung terhadap kecepatan kompilasi kode (build time), eksekusi tes unit, serta pengoperasian banyak aplikasi secara multitasking (IDE, browser dengan puluhan tab, database engine lokal, dan Discord/Slack).</p>
<ul>
    <li><strong>Rekomendasi Minimal:</strong> 6 Core / 12 Thread (Intel Core i5 generasi ke-13/14 atau AMD Ryzen 5 seri 7000/8000).</li>
    <li><strong>Rekomendasi Ideal AI & Heavy Dev:</strong> 8 Core / 16 Thread ke atas (AMD Ryzen 7 7700X/7800X3D atau Intel Core i7 14700K). Ketersediaan core berlimpah mempercepat proses build proyek multi-thread dan container orchestration.</li>
</ul>

<h3>B. Kartu Grafis (GPU - Akselerator Pelatihan AI)</h3>
<p>Jika fokus Anda murni web development standar, grafis terintegrasi (iGPU) sudah mencukupi. Namun, jika Anda berniat mempelajari dan melatih model Machine Learning, Deep Learning, atau Computer Vision:</p>
<ul>
    <li><strong>Wajib Memilih Nvidia:</strong> Ekosistem AI dunia (PyTorch, TensorFlow, CUDA, TensorRT) dioptimalkan secara mendalam untuk arsitektur Nvidia CUDA dan Tensor Cores.</li>
    <li><strong>Perhatikan VRAM (Video RAM):</strong> Kapasitas VRAM adalah batasan utama ukuran model yang dapat dimuat ke memori kartu grafis. Pilihlah minimal 12 GB hingga 16 GB VRAM (contoh: Nvidia RTX 4060 Ti 16GB atau RTX 4070 Super 12GB).</li>
</ul>

<h3>C. Memori RAM (Ruang Kerja Virtual)</h3>
<p>Kekurangan RAM adalah penyebab utama sistem menjadi lemot (*thrashing*) ketika menjalankan emulator Android bersamaan dengan browser Chromium dan backend server.</p>
<ul>
    <li><strong>Standar Wajib 2026:</strong> 32 GB DDR5 Dual Channel (2x 16 GB). Jangan gunakan konfigurasi single stick karena membatasi lebar pita transfer data (memory bandwidth).</li>
    <li><strong>Pengembang AI & Big Data:</strong> Pertimbangkan 64 GB DDR5 jika Anda sering mengolah dataset besar dalam memori menggunakan Pandas atau PySpark.</li>
</ul>

<h3>D. Media Penyimpanan (SSD NVMe PCIe 4.0)</h3>
<p>Tinggalkan hard disk mekanis (HDD) konvensional untuk partisi sistem operasi dan proyek kerja. Gunakan SSD NVMe M.2 dengan protokol PCIe 4.0 atau 5.0 berkecepatan baca/tulis di atas 5.000 MB/s. Waktu muat direktori <code>node_modules</code> yang berisi puluhan ribu file kecil akan terpangkas dari hitungan menit menjadi hanya beberapa detik.</p>

<h3>E. Power Supply Unit (PSU) & Pendingin (Cooling)</h3>
<p>Jangan pernah berkompromi pada kualitas Power Supply. Pilihlah PSU bersertifikasi minimal <strong>80 Plus Gold</strong> dari merek terpercaya dengan daya 650W hingga 850W bertipe modular. Untuk pendingin CPU, gunakan Air Cooler bertower ganda (dual tower) atau Liquid AIO Cooler 240mm/360mm guna mencegah pelambatan performa akibat panas berlebih (*thermal throttling*).</p>

<h2>2. Panduan Langkah demi Langkah Merakit Komputer</h2>
<ol>
    <li><strong>Persiapan Area Kerja:</strong> Siapkan permukaan meja yang kering, bersih, dan tidak beralaskan karpet statis. Siapkan obeng plus (+) bermagnet dan pasta termal berkualitas.</li>
    <li><strong>Pemasangan CPU, RAM & M.2 pada Motherboard:</strong> Pasang prosesor pada soket motherboard di luar casing terlebih dahulu. Perhatikan tanda segitiga emas di sudut CPU agar terpasang presisi tanpa merusak pin soket. Lanjutkan dengan memasang bilah RAM pada slot 2 dan 4 (mode dual channel) serta SSD NVMe di slot M.2 utama yang dilengkapi heatsink.</li>
    <li><strong>Pemasangan Cooler & I/O Shield:</strong> Pasang bracket pendingin prosesor, oleskan pasta termal sebutir jagung di tengah IHS CPU, lalu kunci cooler dengan tekanan seimbang.</li>
    <li><strong>Pemasangan Motherboard ke Casing:</strong> Pastikan standoff sekrup casing telah terpasang sesuai tata letak ukuran motherboard (ATX/Micro-ATX). Pasang motherboard secara perlahan dan kencangkan sekrup secara diagonal.</li>
    <li><strong>Manajemen Kabel & Sumber Daya:</strong> Pasang kabel daya 24-pin motherboard, 8-pin CPU, serta konektor Front Panel (Power SW, Reset SW, HDD LED, Audio, dan USB). Rapikan kabel di bagian belakang casing menggunakan cable-tie untuk sirkulasi udara optimal.</li>
    <li><strong>Pemasangan GPU:</strong> Buka penutup slot PCIe di casing, masukkan kartu grafis ke slot PCIe x16 utama hingga terdengar bunyi klik pengunci, kencangkan sekrup pengaman, lalu sambungkan kabel daya PCIe 8-pin atau 12VHPWR.</li>
</ol>

<h2>3. Uji Coba Pertama & Konfigurasi BIOS</h2>
<p>Setelah seluruh kabel terhubung, tancapkan kabel monitor ke <strong>port GPU</strong> (bukan port motherboard), lalu nyalakan tombol power. Masuk ke menu BIOS dengan menekan tombol <code>Delete</code> atau <code>F2</code> secara berulang:</p>
<ul>
    <li>Aktifkan profil <strong>XMP (Extreme Memory Profile)</strong> atau <strong>EXPO</strong> agar RAM berjalan pada kecepatan penuh yang diiklankan.</li>
    <li>Pastikan fitur <strong>Virtualization Technology (Intel VT-x atau AMD SVM)</strong> dalam status Enabled untuk mendukung Docker dan emulator Android.</li>
    <li>Atur prioritas boot drive ke USB Flashdisk instalasi Windows 11 atau Linux Ubuntu.</li>
</ul>
<p>Dengan PC rakitan yang terencana matang, produktivitas coding Anda akan melonjak drastis, bebas hambatan lag, dan siap menyongsong revolusi komputasi cerdas di masa depan.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL KOMPUTER 2: Arsitektur Hardware CPU vs GPU vs TPU vs NPU
            [
                'title' => 'Memahami Arsitektur Hardware Komputer Modern: Perbedaan CPU, GPU, TPU, dan NPU dalam Menjalankan Algoritma',
                'slug' => 'memahami-arsitektur-hardware-komputer-modern-cpu-gpu-tpu-npu',
                'category' => 'komputer',
                'summary' => 'Kupas tuntas perbedaan mendasar cara kerja prosesor komputasi masa kini: mengapa CPU unggul dalam logika berurutan, GPU mendominasi paralelisasi grafis/AI, dan bagaimana TPU serta NPU merevolusi perangkat keras modern.',
                'content' => '<p>Dalam beberapa dekade pertama sejarah komputasi personal, kecepatan sebuah komputer hampir seluruhnya diukur dari seberapa cepat Central Processing Unit (CPU) menyelesaikan instruksi. Namun, ledakan data raksasa (Big Data), grafis tiga dimensi fotorealistik, dan akselerasi kecerdasan buatan (Artificial Intelligence) telah mengubah lanskap arsitektur silikon secara fundamental.</p>
<p>Kini, prosesor modern tidak lagi berbentuk tunggal. Komputer, server cloud, hingga smartphone di saku Anda dilengkapi dengan prosesor terspesialisasi: <strong>CPU, GPU, TPU, dan NPU</strong>. Mengapa kita membutuhkan begitu banyak jenis silikon pemroses data, dan bagaimana masing-masing menangani algoritma pemrograman?</p>

<img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80" alt="Sirkuit mikroprosesor terintegrasi berkecepatan tinggi" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. CPU (Central Processing Unit): Sang Dirigen Logika Sekuensial</h2>
<p>CPU sering diibaratkan sebagai beberapa profesor jenius dengan kemampuan matematika tingkat tinggi. CPU dirancang untuk menangani <strong>komputasi sekuensial (berurutan)</strong> yang rumit dengan latensi serendah mungkin.</p>
<ul>
    <li><strong>Karakteristik Arsitektur:</strong> Memiliki jumlah inti (core) yang relatif sedikit (umumnya 4 hingga 32 core), namun masing-masing inti beroperasi pada clock speed sangat tinggi (hingga 5,5+ GHz) dan didukung memori cache (L1, L2, L3) yang sangat besar.</li>
    <li><strong>Branch Prediction Canggih:</strong> CPU sangat lihai menebak alur percabangan kode (struktur <code>if-else</code> dan <code>switch-case</code>) sehingga meminimalkan siklus tunggu instruksi.</li>
    <li><strong>Peruntukan Utama:</strong> Menjalankan sistem operasi, manajemen memori, kompilasi kode, logika bisnis perbankan, dan aplikasi perkantoran umum.</li>
</ul>

<h2>2. GPU (Graphics Processing Unit): Raksasa Komputasi Paralel</h2>
<p>Jika CPU adalah sekelompok kecil profesor jenius, maka GPU adalah pasukan ribuan pekerja terampil yang dapat mengerjakan perhitungan aritmatika sederhana secara bersamaan dalam waktu persis satu detik.</p>
<ul>
    <li><strong>Karakteristik Arsitektur:</strong> GPU memiliki ribuan inti pemroses kecil (CUDA Cores pada Nvidia atau Stream Processors pada AMD). Alih-alih mengutamakan latensi rendah per instruksi, GPU mengutamakan <strong>throughput data masif</strong>.</li>
    <li><strong>SIMD (Single Instruction, Multiple Data):</strong> Satu instruksi yang sama dieksekusi secara serentak pada jutaan piksel atau matriks data angka pecahan (floating-point).</li>
    <li><strong>Peruntukan Utama:</strong> Rendering grafis game 3D, pengeditan video resolusi 8K, simulasi fisika fluida, serta pelatihan jaringan saraf tiruan (Deep Learning).</li>
</ul>

<h2>3. TPU (Tensor Processing Unit): Spesialis Matriks AI Buatan Google</h2>
<p>Dikembangkan secara khusus oleh Google untuk pusat data cloud mereka, TPU adalah silikon berjenis ASIC (Application-Specific Integrated Circuit) yang dirancang untuk satu tujuan utama: <strong>perkalian dan penambahan matriks bilangan (tensor)</strong> yang menjadi dasar seluruh model Machine Learning.</p>
<ul>
    <li><strong>Mekanisme Systolic Array:</strong> Berbeda dari CPU dan GPU yang harus berulang kali membaca dan menulis ke memori register untuk setiap kalkulasi, pada TPU data mengalir melalui kisi-kisi pemroses dua dimensi secara berkesinambungan seperti denyut jantung. Hal ini menghemat energi dan memangkas waktu komputasi secara radikal.</li>
    <li><strong>Presisi Rendah Berkualitas Tinggi:</strong> TPU mengadopsi format angka floating point khusus seperti <code>bfloat16</code> yang memangkas kebutuhan bandwidth memori tanpa mengurangi akurasi hasil prediksi model AI.</li>
</ul>

<h2>4. NPU (Neural Processing Unit): Kecerdasan On-Device Hemat Daya</h2>
<p>NPU hadir menjawab tantangan bagaimana menjalankan fitur AI generatif, pengenalan wajah biometrik, dan pemrosesan suara secara lokal pada perangkat bergerak (laptop bertenaga baterai dan smartphone) tanpa menguras daya baterai.</p>
<ul>
    <li><strong>Efisiensi Energi Ekstrem:</strong> NPU beroperasi pada daya sangat rendah (hanya beberapa watt) namun mampu menghasilkan puluhan TOPS (Trillion Operations Per Second) untuk komputasi inferensi model AI.</li>
    <li><strong>Privasi Data Lebih Terjaga:</strong> Dengan adanya NPU, data biometrik, transkripsi suara, dan pengenalan foto tidak perlu dikirimkan ke server cloud, melainkan diproses instan di perangkat pengguna.</li>
</ul>

<h2>Tabel Matriks Perbandingan Silikon Komputasi</h2>
<table style="width:100%;border-collapse:collapse;margin:20px 0;font-size:13px;border:1px solid #cbd5e1;">
    <thead>
        <tr style="background:#0f172a;color:#fff;">
            <th style="padding:10px;border:1px solid #334155;">Prosesor</th>
            <th style="padding:10px;border:1px solid #334155;">Jumlah Core</th>
            <th style="padding:10px;border:1px solid #334155;">Keunggulan Utama</th>
            <th style="padding:10px;border:1px solid #334155;">Kasus Penggunaan Ideal</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding:10px;border:1px solid #cbd5e1;font-weight:bold;">CPU</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Sedikit (4-32)</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Latensi ultra rendah, logika percabangan kompleks</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Sistem Operasi, Web Server, Kompilasi Kode</td>
        </tr>
        <tr style="background:#f8fafc;">
            <td style="padding:10px;border:1px solid #cbd5e1;font-weight:bold;">GPU</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Banyak (Ribuan)</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Throughput paralel masif, floating-point</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Rendering 3D, Pelatihan Model AI (Training)</td>
        </tr>
        <tr>
            <td style="padding:10px;border:1px solid #cbd5e1;font-weight:bold;">TPU</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Sirkuit Khusus Matriks</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Systolic array tensor matematika hemat energi</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Pelatihan AI Skala Raksasa di Cloud (Google Cloud)</td>
        </tr>
        <tr style="background:#f8fafc;">
            <td style="padding:10px;border:1px solid #cbd5e1;font-weight:bold;">NPU</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Modul Terintegrasi</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Inferensi AI On-Device, konsumsi baterai super irit</td>
            <td style="padding:10px;border:1px solid #cbd5e1;">Smartphone AI, Laptop Copilot+, Kamera Cerdas</td>
        </tr>
    </tbody>
</table>

<p>Memahami arsitektur hardware memungkinkan programmer menulis kode yang lebih efisien dengan memanfaatkan akselerasi perangkat keras yang tepat untuk setiap jenis masalah komputasi.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL KOMPUTER 3: Optimasi Laptop & PC untuk Programmer
            [
                'title' => 'Optimasi Kinerja Laptop & Komputer untuk Programmer: Manajemen RAM, SSD NVMe Health, dan Konfigurasi Dual Boot Linux',
                'slug' => 'optimasi-kinerja-laptop-komputer-programmer-ram-ssd-linux',
                'category' => 'komputer',
                'summary' => 'Trik teknis memaksimalkan performa komputer kerja dan laptop coding: cara memonitor kesehatan SSD NVMe, mengelola alokasi memori Docker & IDE, hingga panduan aman konfigurasi dual-boot Windows dan Linux Ubuntu.',
                'content' => '<p>Sebagai seorang pengembang perangkat lunak, waktu adalah aset paling berharga. Menunggu sepuluh detik setiap kali menekan tombol save atau mendapati laptop membeku (*freeze*) saat menjalankan kontainer database di latar belakang dapat merusak alur konsentrasi (*state of flow*) secara signifikan.</p>
<p>Banyak programmer beranggapan bahwa satu-satunya cara mengatasi komputer lambat adalah membeli perangkat baru berharga puluhan juta. Padahal, melalui serangkaian optimasi sistem operasi, alokasi memori yang tepat, serta pemeliharaan berkala komponen penyimpanan, performa laptop kerja Anda dapat ditingkatkan hingga dua kali lipat.</p>

<img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=80" alt="Ruang kerja bersih dengan laptop performa tinggi untuk pemrograman" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Mengendalikan Rakusnya Memori RAM pada Beban Kerja Dev</h2>
<p>Aplikasi modern berbasis Electron (seperti VS Code, Postman, Slack, dan Teams) serta browser Chromium mengonsumsi memori secara agresif. Berikut langkah pengendaliannya:</p>
<ul>
    <li><strong>Batasi Alokasi Memori WSL2 / Docker Desktop:</strong> Secara default, mesin virtual WSL2 di Windows dapat menghabiskan hingga 50% total RAM sistem. Buatlah file konfigurasi <code>.wslconfig</code> di direktori pengguna (<code>C:\Users\NamaUser\.wslconfig</code>) dengan isi pembatasan yang wajar:
<pre class="ql-syntax">[wsl2]
memory=8GB
processors=4
swap=4GB</pre>
    </li>
    <li><strong>Gunakan Ekstensi VS Code Secara Bijak:</strong> Matikan ekstensi yang tidak relevan dengan bahasa yang sedang Anda kerjakan. VS Code menyediakan profil ruang kerja (*Workspaces Profiles*) agar ekstensi Python tidak berjalan saat Anda hanya sedang menyunting file HTML sederhana.</li>
</ul>

<h2>2. Menjaga Umur Panjang dan Performa Puncak SSD NVMe</h2>
<p>Berbeda dari hard disk piringan magnetis, SSD menggunakan sel memori flash NAND yang memiliki batas siklus penulisan (TBW - Terabytes Written). Beban kerja programmer yang sering menghapus dan membuat ribuan file sementara (cache build, temporary log, dan node_modules) dapat mempercepat degradasi SSD jika tidak dikelola:</p>
<ul>
    <li><strong>Pastikan Fitur TRIM Selalu Aktif:</strong> TRIM memberi tahu pengontrol SSD sel mana yang tidak lagi digunakan sehingga proses pengumpulan sampah (*garbage collection*) berjalan di latar belakang tanpa menghambat kecepatan tulis. Pada Windows, periksa via PowerShell:
<pre class="ql-syntax">fsutil behavior query DisableDeleteNotify</pre>
    Jika hasilnya <code>0</code>, berarti TRIM aktif normal.</li>
    <li><strong>Sisakan Ruang Bebas (Over-Provisioning):</strong> Jangan pernah mengisi kapasitas SSD hingga di atas 85%. Menyisakan 15–20% ruang kosong memungkinkan pengontrol SSD melakukan perataan keausan (*wear leveling*) secara optimal dan menjaga kecepatan tulis tetap pada kecepatan puncaknya.</li>
</ul>

<h2>3. Panduan Aman Dual-Boot Windows 11 dan Linux Ubuntu</h2>
<p>Banyak developer lebih memilih lingkungan kernel Unix native untuk menjalankan ekosistem DevOps dan server production. Melakukan konfigurasi dual-boot adalah opsi terbaik untuk mendapatkan performa 100% perangkat keras tanpa overhead virtualisasi:</p>
<ol>
    <li><strong>Cadangkan Seluruh Data Penting:</strong> Gunakan media penyimpanan eksternal atau cloud sebelum menyentuh partisi hard disk.</li>
    <li><strong>Matikan Fast Startup & BitLocker:</strong> Di Windows, nonaktifkan Fast Startup pada menu Power Options agar partisi NTFS tidak terkunci saat sistem beralih ke Linux. Jika drive Anda terenkripsi BitLocker, pastikan Anda menyimpan kunci pemulihan (*Recovery Key*).</li>
    <li><strong>Kecilkan Partisi di Disk Management:</strong> Sisakan ruang kosong (*Unallocated Space*) minimal 60 GB hingga 100 GB dari drive utama Anda.</li>
    <li><strong>Instalasi Ubuntu:</strong> Booting melalui flashdisk USB Ubuntu, pilih opsi <em>"Install Ubuntu alongside Windows Boot Manager"</em>, lalu biarkan penginstal mengatur bootloader GRUB secara otomatis.</li>
</ol>

<h2>4. Manajemen Panas (Thermal Throttling)</h2>
<p>Saat laptop mencapai suhu 95°C ke atas, prosesor secara otomatis memangkas clock speed untuk melindungi komponen dari kerusakan fisik. Lakukan pembersihan debu pada kipas ventilasi setiap 6 bulan sekali dan ganti pasta termal jika perangkat Anda telah berusia lebih dari 2 tahun. Gunakan dudukan laptop (*laptop stand*) berventilasi agar udara dingin dapat terserap leluasa dari bagian bawah casing.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Izak Robinson Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL KOMPUTER 4: Dasar Jaringan Komputer untuk Web Developer
            [
                'title' => 'Dasar-Dasar Jaringan Komputer & Troubleshooting Esensial: Memahami Model OSI, DNS, TCP/IP, dan Subnetting untuk Web Developer',
                'slug' => 'dasar-jaringan-komputer-troubleshooting-osi-dns-tcp-subnetting',
                'category' => 'komputer',
                'summary' => 'Panduan fundamental jaringan komputer yang wajib dikuasai setiap programmer: cara kerja paket data internet dari browser ke server, resolusi DNS, handshake TCP, SSL/TLS, hingga teknik debugging koneksi jaringan.',
                'content' => '<p>Pernahkah Anda menemui kendala di mana aplikasi web yang Anda bangun berjalan mulus di komputer lokal (<code>localhost:3000</code>), namun gagal total saat diunggah ke server hosting atau diakses oleh pengguna luar? Seringkali akar masalahnya bukan terletak pada kesalahan sintaks kode pemrograman, melainkan pada ketidakpahaman terhadap protokol dasar jaringan komputer.</p>
<p>Memahami bagaimana bit-bit data mengalir melalui kabel serat optik, melewati router, diterjemahkan oleh server nama domain (DNS), dan diamankan oleh enkripsi kriptografi adalah pembeda utama antara pemrogram pemula dengan insinyur perangkat lunak profesional.</p>

<img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1200&q=80" alt="Kabel jaringan server data center dan infrastruktur internet global" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Anatomi Perjalanan Sebuah URL Web</h2>
<p>Saat pengguna mengetikkan <code>https://vxai.online</code> di peramban browser dan menekan tombol Enter, berikut rantai peristiwa mikroskopis yang terjadi dalam hitungan milidetik:</p>

<h3>A. Resolusi DNS (Domain Name System)</h3>
<p>Komputer tidak memahami nama teks seperti <code>vxai.online</code>. Komputer hanya memahami alamat angka biner (IP Address). Browser akan mencari alamat IP server tujuan melalui hierarki bertingkat:</p>
<ol>
    <li>Pemeriksaan Cache Browser lokal.</li>
    <li>Pemeriksaan Cache Host OS (file <code>hosts</code>).</li>
    <li>Pengiriman query ke DNS Resolver ISP (Internet Service Provider) atau DNS Publik (1.1.1.1 Cloudflare / 8.8.8.8 Google).</li>
    <li>Jika tidak ada di cache resolver, query diteruskan ke Root DNS Server, TLD Server (<code>.online</code>), hingga ke Authoritative DNS Server tempat domain terdaftar.</li>
</ol>

<h3>B. TCP 3-Way Handshake</h3>
<p>Setelah IP server diketahui (contoh: <code>103.123.45.67</code>), komputer pengirim membuka sambungan andal melalui protokol TCP:</p>
<ul>
    <li><strong>SYN (Synchronize):</strong> Klien mengirim paket "Halo server, saya ingin membuka koneksi pada port 443."</li>
    <li><strong>SYN-ACK (Synchronize-Acknowledge):</strong> Server membalas "Halo klien, permintaan diterima, saya siap."</li>
    <li><strong>ACK (Acknowledge):</strong> Klien mengonfirmasi "Baik server, koneksi resmi terbuka."</li>
</ul>

<h3>C. TLS/SSL Handshake (Enkripsi HTTPS)</h3>
<p>Untuk koneksi aman dengan gembok hijau, klien dan server menyepakati algoritma sandi kriptografi (Cipher Suite) dan saling bertukar sertifikat digital guna menghasilkan kunci simetris sesi yang tidak dapat diintip oleh pihak ketiga di jaringan publik.</p>

<h2>2. Alat Diagnostik Jaringan Wajib untuk Developer</h2>
<p>Ketika website Anda tidak bisa diakses atau API Anda mengalami timeout, jangan panik. Gunakan perangkat baris perintah (CLI) berikut untuk melacak titik kegagalan:</p>

<h3>1. Ping: Menguji Ketersediaan & Latensi Host</h3>
<pre class="ql-syntax">ping vxai.online</pre>
<p>Mengirimkan paket ICMP Echo Request. Jika hasilnya <em>Request Timed Out</em>, ada kemungkinan server mati atau firewall memblokir paket ICMP.</p>

<h3>2. Traceroute / Tracert: Melacak Rute Lompatan Paket</h3>
<pre class="ql-syntax">tracert vxai.online</pre>
<p>Menampilkan setiap router (hop) yang dilalui paket dari laptop Anda hingga mencapai server tujuan. Sangat berguna untuk mengetahui di simpul jaringan mana koneksi mengalami hambatan (*bottleneck*).</p>

<h3>3. cURL dengan Metrik Waktu Terperinci</h3>
<p>Perintah luar biasa untuk mengukur performa jaringan setiap lapisan HTTP:</p>
<pre class="ql-syntax">curl -w "DNS: %{time_namelookup}s | Connect: %{time_connect}s | TLS: %{time_appconnect}s | Total: %{time_total}s\n" -o /dev/null -s https://vxai.online</pre>
<p>Perintah ini langsung membongkar apakah kelambatan web disebabkan oleh proses resolusi DNS yang lambat, waktu handshake server yang lama, atau waktu pemrosesan aplikasi backend yang berat.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Izak Robinson Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
}
