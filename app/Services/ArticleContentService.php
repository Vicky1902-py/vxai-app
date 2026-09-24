<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ArticleContentService
{
    // Naikkan versi ini setiap kali konten artikel bawaan diperbarui
    public const VERSION = '2026_09_24_koding_ai_html_v2';

    /**
     * Dapatkan daftar 6 artikel edukasi berkualitas tinggi tentang:
     * - Dasar-dasar Koding
     * - Dasar-dasar AI
     * - Belajar HTML
     */
    public static function getDefaultArticles(): array
    {
        $now = now();

        return [
            // ARTIKEL 1: BELAJAR HTML DARI NOL
            [
                'title' => 'Belajar HTML dari Nol: Panduan Langkah demi Langkah untuk Pemula',
                'slug' => 'belajar-html-dari-nol-panduan-pemula',
                'category' => 'coding',
                'summary' => 'Panduan paling ramah untuk kamu yang baru pertama kali ingin membuat website. Pelajari cara kerja HTML, struktur dasar dokumen, tag penting, dan buat halaman web pertamamu dalam waktu kurang dari 30 menit.',
                'content' => '<p>Pernahkah kamu penasaran bagaimana sebuah website dibuat? Ketika kamu membuka Google, YouTube, atau portal berita favoritmu, semua tulisan, gambar, tombol, dan kotak pencarian yang kamu lihat di layar berawal dari satu bahasa fondasi yang sama: <strong>HTML</strong>.</p>
<p>Kabar baiknya: kamu <strong>tidak perlu latar belakang IT</strong> atau bakat matematika khusus untuk belajar HTML. Bahkan jika hari ini adalah hari pertamamu mengenal dunia pemrograman, panduan ini disusun langkah demi langkah dengan bahasa manusia yang santai dan mudah dicerna.</p>
<img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=1100&q=80" alt="Layar komputer menampilkan kode HTML terstruktur" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Apa Sebenarnya HTML Itu?</h2>
<p>HTML adalah singkatan dari <strong>HyperText Markup Language</strong>. Jangan terintimidasi oleh namanya! Mari kita sederhanakan definisinya:</p>
<ul>
    <li><strong>HyperText:</strong> Teks yang punya kekuatan khusus untuk menghubungkan satu halaman ke halaman lain (melalui tautan atau link).</li>
    <li><strong>Markup Language:</strong> Bahasa penanda yang menggunakan tanda kurung siku (seperti <code>&lt;p&gt;</code> atau <code>&lt;h1&gt;</code>) untuk memberitahu browser apa makna dari setiap teks yang kamu tulis.</li>
</ul>
<blockquote>"Bayangkan HTML seperti kerangka tulang sebuah rumah. HTML menentukan di mana letak pintu, di mana jendela dipasang, dan seberapa tinggi atapnya. Tanpa kerangka, sebuah rumah tidak akan pernah berdiri."</blockquote>

<h2>Langkah 1: Siapkan Peralatan Kodingmu</h2>
<p>Untuk mulai menulis HTML, kamu hanya butuh dua alat yang sudah 100% gratis dan kemungkinan besar sudah ada di komputermu:</p>
<ol>
    <li><strong>Web Browser:</strong> Google Chrome, Mozilla Firefox, Microsoft Edge, atau Safari. Browser inilah yang bertugas menerjemahkan kode tulisanmu menjadi tampilan visual.</li>
    <li><strong>Editor Koding:</strong> Kamu bisa menggunakan <em>Notepad</em> bawaan Windows, aplikasi seperti <em>VS Code</em>, atau cara paling praktis: langsung gunakan <strong>Live Playground VxAI</strong> di website ini tanpa perlu instal software apa pun!</li>
</ol>

<h2>Langkah 2: Menulis Dokumen HTML Pertamamu</h2>
<p>Setiap dokumen HTML di dunia memiliki anatomi standar yang selalu sama. Coba perhatikan contoh kode berikut:</p>
<pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="id"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;title&gt;Halaman Web Pertamaku&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Halo Dunia, Saya Mulai Belajar Koding!&lt;/h1&gt;
    &lt;p&gt;Ini adalah halaman web resmi pertama yang saya tulis sendiri dari nol.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>

<p>Mari kita bedah artinya satu demi satu:</p>
<ul>
    <li><code>&lt;!DOCTYPE html&gt;</code>: Memberitahu browser bahwa dokumen ini menggunakan standar HTML5 modern.</li>
    <li><code>&lt;html&gt;</code>: Elemen induk yang membungkus seluruh isi halaman web.</li>
    <li><code>&lt;head&gt;</code>: Bagian "di balik layar". Di sinilah judul tab browser (<code>&lt;title&gt;</code>) dan setelan bahasa disimpan. Pengunjung tidak melihat isi head secara langsung di layar.</li>
    <li><code>&lt;body&gt;</code>: Tubuh utama website. <strong>Semua hal yang ingin kamu tampilkan ke pengunjung</strong> (teks, gambar, video, tombol) wajib ditaruh di dalam tag body ini.</li>
</ul>

<img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1100&q=80" alt="Seseorang sedang mengetik kode di laptop" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Langkah 3: Menguasai Tag-Tag Dasar yang Paling Sering Dipakai</h2>
<p>Dalam 90% pembuatan website, kamu akan selalu menjumpai tag-tag berikut:</p>
<h3>1. Judul dan Sub-judul (Heading)</h3>
<p>HTML menyediakan enam tingkatan heading, mulai dari yang paling besar <code>&lt;h1&gt;</code> hingga yang paling kecil <code>&lt;h6&gt;</code>. Biasanya, setiap halaman hanya memiliki satu <code>&lt;h1&gt;</code> sebagai judul utama artikel.</p>
<pre><code>&lt;h1&gt;Judul Terbesar (H1)&lt;/h1&gt;
&lt;h2&gt;Sub-judul Bab (H2)&lt;/h2&gt;
&lt;h3&gt;Topik Spesifik (H3)&lt;/h3&gt;</code></pre>

<h3>2. Paragraf Teks</h3>
<p>Untuk menulis kalimat atau paragraf cerita, gunakan tag <code>&lt;p&gt;</code>. Browser akan otomatis memberikan jarak spasi antar paragraf.</p>
<pre><code>&lt;p&gt;Belajar koding ternyata sangat menyenangkan saat kita memahami logikanya.&lt;/p&gt;</code></pre>

<h3>3. Membuat Tautan (Link)</h3>
<p>Gunakan tag <code>&lt;a&gt;</code> (singkatan dari anchor) bersama atribut <code>href</code> untuk menghubungkan pengunjung ke halaman lain:</p>
<pre><code>&lt;a href="https://vxai.online/playground"&gt;Buka Live Playground VxAI&lt;/a&gt;</code></pre>

<h3>4. Menampilkan Gambar</h3>
<p>Tag gambar <code>&lt;img&gt;</code> adalah tag mandiri tanpa penutup. Jangan lupa selalu sertakan atribut <code>alt</code> untuk deskripsi gambar jika internet lambat atau untuk pembaca tunanetra:</p>
<pre><code>&lt;img src="foto-saya.jpg" alt="Foto profil Andi di laboratorium komputer"&gt;</code></pre>

<h3>5. Daftar Berbutir (List)</h3>
<p>Ada dua jenis daftar: daftar dengan nomor (<code>&lt;ol&gt;</code> = ordered list) dan daftar dengan simbol butir (<code>&lt;ul&gt;</code> = unordered list). Isinya menggunakan <code>&lt;li&gt;</code> (list item).</p>
<pre><code>&lt;ul&gt;
    &lt;li&gt;Belajar HTML Dasar&lt;/li&gt;
    &lt;li&gt;Belajar CSS Desain&lt;/li&gt;
    &lt;li&gt;Belajar Logika Pemrograman&lt;/li&gt;
&lt;/ul&gt;</code></pre>

<h2>Langkah 4: Praktik Mandiri — Buat Biodata Sederhana</h2>
<p>Sekarang giliranmu! Salin kode latihan berikut ke <strong>Live Playground VxAI</strong> dan ubah isinya dengan namamu sendiri:</p>
<pre><code>&lt;h1&gt;Halo, Nama Saya Budi Santoso&lt;/h1&gt;
&lt;p&gt;Saya seorang pelajar yang bercita-cita menjadi &lt;strong&gt;Software Engineer&lt;/strong&gt;.&lt;/p&gt;

&lt;h2&gt;Keahlian yang Sedang Saya Pelajari:&lt;/h2&gt;
&lt;ol&gt;
    &lt;li&gt;HTML5 Semantik&lt;/li&gt;
    &lt;li&gt;Dasar-dasar Kecerdasan Buatan (AI)&lt;/li&gt;
    &lt;li&gt;Logika Koding Dasar&lt;/li&gt;
&lt;/ol&gt;

&lt;p&gt;Mau kenalan lebih lanjut? &lt;a href="mailto:budi@example.com"&gt;Kirim Email ke Saya&lt;/a&gt;.&lt;/p&gt;</code></pre>

<h2>Kesalahan Umum Pemula &amp; Solusinya</h2>
<ul>
    <li><strong>Lupa menutup tag:</strong> Membuka <code>&lt;p&gt;</code> tapi lupa menulis <code>&lt;/p&gt;</code>. Biasakan mengetik tag penutup langsung setelah membuat tag pembuka.</li>
    <li><strong>Salah ketik tanda kurung:</strong> Menggunakan tanda kurung biasa <code>(p)</code> alih-alih tanda kurung siku <code>&lt;p&gt;</code>.</li>
    <li><strong>Lupa menyimpan file dengan format .html:</strong> Jika menyimpan lewat Notepad, pastikan opsi simpan dipilih sebagai "All Files" dan nama filenya diakhiri dengan <code>.html</code> (misal: <code>index.html</code>).</li>
</ul>

<img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1100&q=80" alt="Workspace modern untuk web development" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Kesimpulan &amp; Langkah Berikutnya</h2>
<p>Selamat! Kamu sudah memahami konsep dasar HTML dan berhasil membuat halaman pertamamu. HTML adalah langkah pertama yang kokoh. Pada artikel berikutnya, kita akan mempelajari <strong>Dasar-Dasar Koding</strong> dan cara mempercantik tampilan halaman web ini menggunakan <strong>CSS</strong> agar warnanya memukau dan tampilannya rapi di ponsel.</p>
<p>Jangan berhenti di teori — buka Playground sekarang juga dan cobalah mengubah kode-kode di atas!</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 420,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(1),
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],

            // ARTIKEL 2: DASAR-DASAR KODING
            [
                'title' => 'Dasar-Dasar Koding untuk Pemula: Dari Nol Sampai Paham Logika Pemrograman',
                'slug' => 'dasar-dasar-koding-memahami-logika-pemrograman-pemula',
                'category' => 'coding',
                'summary' => 'Banyak orang mengira koding itu rumit dan harus jago matematika. Padahal koding adalah seni memecahkan masalah dengan langkah logis. Pelajari konsep variabel, percabangan IF-ELSE, looping, dan fungsi dengan bahasa yang paling mudah dimengerti.',
                'content' => '<p>Di era digital saat ini, kata "koding" terdengar di mana-mana — dari obrolan tongkrongan, iklan lowongan kerja bergaji tinggi, hingga berita inovasi aplikasi pintar. Namun bagi kebanyakan orang yang belum pernah mencoba, koding seringkali dibayangkan seperti adegan film: layar hitam pekat penuh angka hijau yang membingungkan dan hanya bisa dikerjakan oleh jenius matematika.</p>
<p>Kenyataannya sangat berbeda. <strong>Koding pada intinya hanyalah seni berkomunikasi dengan komputer</strong>. Karena komputer tidak mengerti bahasa manusia sehari-hari, kita memberikan instruksi langkah demi langkah menggunakan aturan logika yang jelas. Jika kamu bisa mengikuti instruksi resep membuat mie instan, kamu sudah punya modal yang cukup untuk belajar koding!</p>

<img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1100&q=80" alt="Meja kerja programmer rapi dengan laptop dan kopi" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>4 Konsep Inti Pemrograman yang Ada di Semua Bahasa</h2>
<p>Entah kamu nanti belajar JavaScript, Python, PHP, C++, atau Java, ada 4 konsep fundamental yang selalu ada di setiap bahasa pemrograman di dunia:</p>

<h3>1. Variabel: Kotak Penyimpanan Bernama</h3>
<p>Bayangkan kamu punya beberapa kotak kardus di kamarmu. Supaya tidak bingung, kamu menempelkan stiker nama di kotak itu: satu kotak diberi label "Sepatu", satu kotak "Buku".</p>
<p>Dalam koding, kotak itu disebut <strong>Variabel</strong>. Variabel digunakan untuk menyimpan data sementara agar bisa diolah nanti:</p>
<pre><code>// Contoh logika variabel dalam koding:
namaSiswa = "Rian";
umur = 16;
sudahLulus = false;</code></pre>
<p>Komputer akan mengingat bahwa kotak <code>namaSiswa</code> berisi teks "Rian" dan kotak <code>umur</code> berisi angka 16.</p>

<h3>2. Percabangan Logika (Condition / IF-ELSE)</h3>
<p>Komputer tidak punya akal budi, tapi komputer sangat jago memeriksa kondisi "Benar" (True) atau "Salah" (False). Inilah yang kita sebut logika <strong>IF - ELSE</strong>:</p>
<pre><code>JIKA (nilaiUjian &gt;= 75) MAKA:
    tampilkan "Selamat, kamu lulus!"
SELAIN ITU:
    tampilkan "Tetap semangat, silakan coba remidi."</code></pre>
<p>Pola pikir pengkondisian ini dipakai di hampir semua sistem yang kamu pakai setiap hari: jika kata sandi benar buka aplikasi, jika saldo cukup proses pembayaran, jika batere lemah nyalakan mode hemat daya.</p>

<img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1100&q=80" alt="Layar laptop menampilkan baris-baris kode program" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h3>3. Perulangan (Looping): Pekerja yang Tak Pernah Lelah</h3>
<p>Kelebihan utama komputer dibanding manusia adalah kemampuannya melakukan pekerjaan berulang ribuan kali dengan kecepatan tinggi tanpa pernah merasa bosan atau lelah. Daripada menulis perintah 100 kali, programmer cukup menulis 3 baris perulangan:</p>
<pre><code>ULANGI dari hitungan 1 sampai 100:
    cetak "Saya berjanji akan rajin berlatih koding!"</code></pre>

<h3>4. Fungsi (Function): Resep Praktis Siap Pakai</h3>
<p>Fungsi adalah sekumpulan baris kode yang diberi nama agar bisa dipanggil berkali-kali kapan pun dibutuhkan tanpa perlu menulis ulang dari awal. Seperti tombol blender: kamu tinggal tekan tombol "Blend", dan mesin akan menjalankan serangkaian proses mencacah es batu dan buah secara otomatis.</p>

<h2>Langkah Praktis Memulai Koding Hari Ini</h2>
<p>Jangan terjebak membaca teori berbulan-bulan tanpa pernah mengetik satu baris kode pun. Ikuti langkah sederhana ini:</p>
<ol>
    <li><strong>Mulai dari yang visual terlebih dahulu:</strong> Kombinasi HTML dan CSS adalah titik awal terbaik karena setiap baris kode yang kamu ketik langsung memunculkan hasil nyata di layar.</li>
    <li><strong>Pahami konsep, jangan hafalkan sintaks:</strong> Programmer profesional tidak menghafal seluruh kamus kode. Mereka memahami logikanya dan mencari dokumentasi resmi saat lupa nama fungsi.</li>
    <li><strong>Biasakan memecah masalah besar menjadi bagian kecil:</strong> Ingin membuat aplikasi toko online? Jangan pikirkan semuanya sekaligus. Pecah jadi: buat tombol beli dulu, lalu buat kotak keranjang, lalu hitung total belanja.</li>
    <li><strong>Gunakan fasilitas Live Playground:</strong> Berlatihlah di Playground VxAI di mana kamu bisa mengetik kode dan melihat hasilnya seketika tanpa perlu pusing setel server.</li>
</ol>

<img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1100&q=80" alt="Editor teks koding modern dengan tema gelap" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Pesan Motivasi untuk Calon Coder</h2>
<blockquote>"Setiap programmer ahli di Google, Microsoft, atau startup unicorn pernah menghasilkan pesan error merah di layar mereka ribuan kali. Yang membedakan pemenang dan yang menyerah hanyalah rasa penasaran untuk mencari tahu mengapa kodenya belum berjalan."</blockquote>
<p>Luangkan waktu 20 menit setiap hari untuk koding. Otakmu akan perlahan terbiasa dengan pola pikir komputasional. Selamat datang di dunia koding — dunianya para pencipta solusi!</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 580,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(2),
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],

            // ARTIKEL 3: DASAR-DASAR AI (KECERDASAN BUATAN)
            [
                'title' => 'Dasar-Dasar Kecerdasan Buatan (AI): Panduan Lengkap & Mudah Dipahami Siapa Saja',
                'slug' => 'dasar-dasar-ai-kecerdasan-buatan-panduan-pemula',
                'category' => 'ai',
                'summary' => 'Dari asisten pintar di ponsel hingga mobil otonom, AI sedang mengubah peradaban manusia. Pahami apa itu AI, bagaimana mesin bisa belajar melalui Machine Learning, jenis-jenis AI modern, dan bagaimana kamu bisa memanfaatkannya.',
                'content' => '<p>Beberapa tahun terakhir, dunia dikejutkan oleh kemunculan teknologi kecerdasan buatan (<em>Artificial Intelligence</em> atau AI) yang mampu menulis esai ilmiah dalam hitungan detik, menciptakan ilustrasi digital yang memukau, menganalisis penyakit medis, hingga membantu programmer menulis baris-baris kode secara otomatis.</p>
<p>Namun, di balik keajaiban itu, sering muncul kebingungan dan kekhawatiran: <em>Bagaimana sebenarnya AI bekerja? Apakah komputer benar-benar bisa berpikir seperti manusia? Dan apakah AI akan merebut pekerjaan kita?</em> Mari kita kupas tuntas dengan bahasa yang sederhana dan masuk akal.</p>

<img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=1100&q=80" alt="Visualisasi konsep kecerdasan buatan dan jaringan saraf tiruan" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Apa Sebenarnya Kecerdasan Buatan (AI) Itu?</h2>
<p>Secara sederhana, <strong>Kecerdasan Buatan (AI)</strong> adalah bidang ilmu komputer yang bertujuan membuat sistem atau perangkat lunak mampu melakukan tugas-tugas yang biasanya membutuhkan kecerdasan manusia — seperti mengenali pola, memecahkan masalah, memahami bahasa, dan mengambil keputusan.</p>
<p>Perbedaan terbesar antara program biasa dan AI terletak pada <strong>cara kerjanya</strong>:</p>
<ul>
    <li><strong>Program Konvensional:</strong> Programmer harus menulis setiap aturan dengan kaku. Misalnya: "Jika tombol ditekan, putar musik". Jika ada situasi baru di luar aturan yang ditulis, program akan bingung dan macet.</li>
    <li><strong>Sistem AI (Machine Learning):</strong> Komputer tidak diberi aturan kaku, melainkan diberi ribuan atau jutaan contoh data, lalu komputer <em>menemukan polanya sendiri</em>.</li>
</ul>

<h2>Bagaimana Mesin Belajar? Analogi Anak Kecil Mengenali Kucing</h2>
<p>Bayangkan kamu sedang mengajari seorang balita mengenali seekor kucing. Apakah kamu memberikan definisi biologis yang rumit? Tentu tidak. Kamu hanya menunjukkan foto kucing berulang kali sambil berkata: "Lihat, ini kucing!"</p>
<p>Lalu kamu menunjukkan foto anjing dan berkata: "Bukan, yang ini anjing."</p>
<p>Setelah melihat puluhan contoh, otak si balita secara alami menyimpulkan ciri-cirinya: kucing punya telinga runcing, kumis kecil, dan tubuh lentur. Ketika suatu hari ia melihat kucing jenis baru di taman yang belum pernah ia lihat sebelumnya, ia langsung bisa menebak dengan tepat: "Itu kucing!"</p>
<p><strong>Persis seperti itulah Machine Learning bekerja!</strong> Komputer diberi jutaan data gambar, teks, atau suara, lalu algoritma matematika di dalamnya memetakan pola-pola pembeda tersebut.</p>

<img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1100&q=80" alt="Koneksi digital abstrak dan aliran data cerdas" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>3 Istilah AI yang Wajib Kamu Pahami</h2>
<p>Agar tidak bingung saat membaca berita teknologi, kenali hubungan ketiga istilah ini:</p>
<ol>
    <li><strong>Artificial Intelligence (AI):</strong> Payung besar yang mencakup semua teknologi komputer pintar.</li>
    <li><strong>Machine Learning (ML):</strong> Cabang dari AI di mana mesin belajar sendiri dari data tanpa diprogram secara eksplisit untuk setiap situasi.</li>
    <li><strong>Deep Learning (Jaringan Saraf Tiruan):</strong> Bagian dari ML yang meniru struktur sel saraf otak manusia (disebut <em>Neural Networks</em>) untuk memproses data yang sangat kompleks seperti foto beresolusi tinggi, suara manusia, dan bahasa alami.</li>
</ol>

<h2>Mengenal AI Generatif &amp; Model Bahasa Besar (LLM)</h2>
<p>Sistem AI yang paling ramai dibicarakan saat ini — seperti ChatGPT, Claude, dan Google Gemini — masuk ke dalam kategori <strong>Generative AI</strong> berbasis <strong>Large Language Models (LLM)</strong>.</p>
<p>Model-model ini telah membaca miliaran dokumen teks, artikel buku, dan baris kode pemrograman dari internet. Berkat latihan masif tersebut, AI generatif sangat handal memprediksi kata demi kata berikutnya yang paling masuk akal dalam sebuah percakapan, sehingga jawabannya terdengar sangat alami seperti berbicara dengan manusia berwawasan luas.</p>

<img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1100&q=80" alt="Aliran data kode digital dan keamanan siber" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Apakah AI Akan Menggantikan Manusia?</h2>
<p>Banyak pakar teknologi dunia sepakat pada satu kesimpulan penting:</p>
<blockquote>"AI tidak akan menggantikan manusia. Tetapi manusia yang pandai menggunakan AI akan menggantikan manusia yang menolak belajar AI."</blockquote>
<p>AI adalah alat pengungkit (<em>lever</em>). Seperti halnya mesin kalkulator tidak memusnahkan profesi akuntan melainkan membuat mereka bekerja 10 kali lebih cepat, AI membantu kita menghemat waktu dari tugas-tugas administratif rutin sehingga kita bisa fokus pada kreativitas, strategi, dan empati kemanusiaan.</p>

<h2>Langkah Pertama Memanfaatkan AI untuk Diri Sendiri</h2>
<ul>
    <li><strong>Jadikan AI sebagai teman belajar (Study Buddy):</strong> Saat kamu bingung membaca materi pelajaran atau kode koding, mintalah AI: <em>"Tolong jelaskan konsep ini seolah-olah saya anak usia 15 tahun."</em></li>
    <li><strong>Latih kemampuan Prompting:</strong> Belajarlah memberikan instruksi yang jelas, lengkap dengan konteks dan contoh hasil yang diinginkan.</li>
    <li><strong>Tetap kritis dan lakukan verifikasi:</strong> AI terkadang bisa mengalami "halusinasi" (memberikan jawaban yang terdengar meyakinkan padahal salah faktanya). Selalu uji kebenaran kode atau data penting sebelum menggunakannya.</li>
</ul>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Riset AI VxAI',
                'views_count' => 610,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(3),
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],

            // ARTIKEL 4: BELAJAR HTML5 SEMANTIK & STANDAR INDUSTRI
            [
                'title' => 'Panduan Lengkap HTML5 Semantik: Cara Membangun Struktur Web Standar Industri & Ramah SEO',
                'slug' => 'belajar-html5-semantik-standar-industri-seo',
                'category' => 'coding',
                'summary' => 'Jangan hanya menggunakan tag <div> untuk semua bagian website! Pelajari tag semantik modern seperti <header>, <nav>, <main>, <article>, dan <footer> agar websitemu ramah mesin pencari Google dan mudah diakses semua pengguna.',
                'content' => '<p>Banyak pemula yang baru belajar HTML merasa puas ketika sebuah website sudah tampil di layar browser. Namun, ketika kode tersebut diperiksa oleh seorang Senior Web Developer, seringkali ditemukan satu kebiasaan buruk yang sangat dihindari di dunia kerja: <strong>"Div Soup"</strong> — yaitu membungkus seluruh elemen halaman hanya dengan tag <code>&lt;div&gt;</code> tanpa makna!</p>
<p>Padahal, standar web modern sejak diperkenalkannya HTML5 sangat menekankan penggunaan <strong>HTML Semantik</strong>. Mari kita pelajari mengapa hal ini sangat penting dan bagaimana cara menerapkannya dengan benar.</p>

<img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1100&q=80" alt="Perancangan layout halaman web yang terstruktur" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Apa Itu Elemen Semantik?</h2>
<p>Kata <em>semantik</em> berarti "berkaitan dengan makna atau arti kata". Dalam HTML:</p>
<ul>
    <li><strong>Elemen Non-Semantik:</strong> Tag yang tidak memberitahu apa pun tentang isi kontennya. Contohnya <code>&lt;div&gt;</code> dan <code>&lt;span&gt;</code>. Tag ini murni wadah kosong tanpa arti.</li>
    <li><strong>Elemen Semantik:</strong> Tag yang namanya dengan jelas mendeskripsikan tujuan dan makna konten di dalamnya — baik kepada manusia, browser, mesin perayap Google (SEO), maupun alat bantu disabilitas (Screen Reader). Contohnya <code>&lt;header&gt;</code>, <code>&lt;article&gt;</code>, dan <code>&lt;footer&gt;</code>.</li>
</ul>

<h2>Daftar Tag Semantik Utama yang Wajib Dikuasai</h2>
<p>Berikut adalah peta struktur tata letak halaman web standar industri:</p>

<h3>1. &lt;header&gt;</h3>
<p>Digunakan untuk bagian pengantar atau kepala dari sebuah halaman web atau bab artikel. Biasanya berisi logo situs, judul utama, atau slogan.</p>

<h3>2. &lt;nav&gt;</h3>
<p>Khusus membungkus daftar link menu navigasi utama situs. Mesin pencari seperti Google menggunakan tag ini untuk memetakan struktur penting websitemu.</p>
<pre><code>&lt;nav&gt;
    &lt;ul&gt;
        &lt;li&gt;&lt;a href="/"&gt;Beranda&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href="/berita"&gt;Berita &amp; Tips&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href="/playground"&gt;Playground Koding&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/nav&gt;</code></pre>

<h3>3. &lt;main&gt;</h3>
<p>Mewakili konten utama yang paling unik dari halaman tersebut. <strong>Aturan penting:</strong> Dalam satu halaman HTML hanya boleh ada tepat satu tag <code>&lt;main&gt;</code>!</p>

<h3>4. &lt;article&gt; dan &lt;section&gt;</h3>
<p>Sering membuat pemula bingung, begini cara membedakannya:</p>
<ul>
    <li><code>&lt;article&gt;</code>: Bagian konten mandiri yang tetap masuk akal jika dipublikasikan terpisah di tempat lain (misalnya artikel berita, ulasan produk, atau postingan blog).</li>
    <li><code>&lt;section&gt;</code>: Pengelompokan bab tematik dari suatu halaman (misalnya Section Hero, Section Testimoni, Section Kontak).</li>
</ul>

<h3>5. &lt;aside&gt;</h3>
<p>Digunakan untuk konten pendukung yang berhubungan secara tidak langsung dengan konten utama — misalnya daftar artikel terkait di bilah samping (sidebar), iklan sponsor, atau profil singkat penulis.</p>

<h3>6. &lt;footer&gt;</h3>
<p>Bagian catatan kaki penutup di bagian paling bawah halaman atau akhir artikel. Biasanya memuat informasi hak cipta, kebijakan privasi, kontak, dan tautan sosial media.</p>

<img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&w=1100&q=80" alt="Lingkungan pengembangan koding profesional" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Studi Kasus Nyata: Struktur Halaman Web Portal Modern</h2>
<p>Perhatikan perbandingan bagaimana struktur HTML5 semantik ditulis secara rapi dan profesional:</p>
<pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="id"&gt;
&lt;head&gt;
    &lt;title&gt;Portal Belajar Teknologi VxAI&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;!-- Kepala Halaman &amp; Navigasi --&gt;
    &lt;header&gt;
        &lt;h1&gt;VxAI Tech News&lt;/h1&gt;
        &lt;nav&gt;
            &lt;a href="#coding"&gt;Dasar Koding&lt;/a&gt; |
            &lt;a href="#ai"&gt;Dasar AI&lt;/a&gt; |
            &lt;a href="#html"&gt;Belajar HTML&lt;/a&gt;
        &lt;/nav&gt;
    &lt;/header&gt;

    &lt;!-- Konten Inti --&gt;
    &lt;main&gt;
        &lt;article&gt;
            &lt;h2&gt;Mengapa HTML Semantik Sangat Dicintai Google SEO?&lt;/h2&gt;
            &lt;p&gt;Ditulis oleh Admin Editorial • 24 September 2026&lt;/p&gt;
            &lt;p&gt;Mesin bot perayap Google membaca halaman kita tanpa melihat visual grafik...&lt;/p&gt;
        &lt;/article&gt;

        &lt;aside&gt;
            &lt;h3&gt;Artikel Pilihan Lainnya&lt;/h3&gt;
            &lt;p&gt;Panduan Prompt Engineering untuk Pemula.&lt;/p&gt;
        &lt;/aside&gt;
    &lt;/main&gt;

    &lt;!-- Catatan Kaki --&gt;
    &lt;footer&gt;
        &lt;p&gt;&amp;copy; 2026 VxAI Coding Lab. Seluruh Hak Cipta Dilindungi.&lt;/p&gt;
    &lt;/footer&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>

<h2>3 Keuntungan Nyata Menggunakan HTML Semantik</h2>
<ol>
    <li><strong>Peringkat SEO Lebih Tinggi:</strong> Mesin pencari seperti Google dan Bing dapat langsung mengenali mana judul utama, mana isi artikel, dan mana menu situs, sehingga situsmu berpeluang tampil di halaman pertama hasil pencarian.</li>
    <li><strong>Aksesibilitas Universal (Accessibility / A11y):</strong> Penyandang disabilitas yang menggunakan alat bantu pembaca layar tunanetra (Screen Reader) dapat melompat langsung ke menu navigasi atau ke artikel utama tanpa harus mendengarkan ribuan baris teks acak.</li>
    <li><strong>Kode Jauh Lebih Mudah Dirawat (Maintainable):</strong> Ketika kamu atau rekan satu tim membuka kembali file kodingan ini 6 bulan ke depan, kalian langsung tahu fungsi setiap blok kode dalam hitungan detik.</li>
</ol>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Riset Rekayasa Web',
                'views_count' => 380,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(4),
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
            ],

            // ARTIKEL 5: TRIK PRAKTIS PROMPT ENGINEERING UNTUK KODING
            [
                'title' => 'Trik Praktis Prompt Engineering: Memanfaatkan AI untuk Mempercepat Belajar Koding',
                'slug' => 'trik-praktis-prompt-engineering-belajar-koding-ai',
                'category' => 'ai',
                'summary' => 'Ingin punya mentor koding pribadi 24 jam gratis? Pelajari teknik merancang instruksi (prompt) yang tepat agar asisten AI bisa menjelaskan pesan error, mengajari logika rumit, dan mereview kodemu secara akurat.',
                'content' => '<p>Kehadiran model kecerdasan buatan seperti ChatGPT, Claude, dan Gemini adalah anugerah terbesar bagi siapa saja yang ingin belajar pemrograman secara otodidak. Dahulu, ketika seorang pemula mengalami pesan error di layarnya, ia bisa menghabiskan waktu berjam-jam bahkan berhari-hari mencari solusi di forum internet.</p>
<p>Sekarang, kamu bisa menanyakan kendala tersebut kepada AI dan mendapatkan solusi dalam 5 detik. Namun ada satu tantangan besar: <strong>Kualitas jawaban AI sangat bergantung pada bagaimana caramu menyusun pertanyaan (prompt)</strong>.</p>
<p>Keahlian menyusun instruksi yang efektif kepada AI inilah yang disebut <strong>Prompt Engineering</strong>. Berikut adalah teknik praktis yang terbukti melipatgandakan produktivitas belajar kodingmu!</p>

<img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1100&q=80" alt="Matriks kode digital dan interaksi AI" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Formula 4 Elemen: Prompt Emas Pemrograman</h2>
<p>Hindari membuat prompt yang terlalu singkat dan ambigu seperti: <em>"Buatkan saya kodingan tombol"</em>. Jawaban AI pasti akan sangat umum dan seringkali tidak sesuai dengan kebutuhanmu.</p>
<p>Gunakan formula 4 elemen ini untuk hasil yang sempurna:</p>
<ol>
    <li><strong>Peran (Role):</strong> Tentukan keahlian apa yang harus diperankan AI.</li>
    <li><strong>Konteks (Context):</strong> Jelaskan teknologi yang sedang kamu gunakan dan tujuan proyekmu.</li>
    <li><strong>Tugas Spesifik (Task):</strong> Perintahkan secara detail apa yang harus dihasilkan.</li>
    <li><strong>Batasan (Constraints):</strong> Tentukan apa yang boleh dan <strong>tidak boleh</strong> dilakukan oleh AI.</li>
</ol>

<h3>Contoh Perbandingan Prompt:</h3>
<blockquote>
    <strong>❌ Prompt Buruk:</strong><br>
    "Tolong perbaiki kode HTML saya yang error."<br><br>
    <strong>✅ Prompt Berkualitas Tinggi:</strong><br>
    "Bertindaklah sebagai Senior Web Developer dan Pengajar Koding yang ramah untuk siswa pemula. Saya sedang membuat halaman profil sederhana menggunakan HTML5 murni tanpa framework apa pun. Di bawah ini adalah kode saya. Gambar saya tidak mau muncul di browser. Tolong jelaskan di baris mana letak kesalahannya, berikan kode perbaikannya, dan jelaskan mengapa kode lama saya gagal dengan bahasa yang mudah dipahami."
</blockquote>

<h2>3 Skenario Praktis Menggunakan AI untuk Belajar</h2>

<h3>1. Meminta AI Menjelaskan Kode Baris demi Baris</h3>
<p>Ketika kamu melihat contoh kode yang membingungkan di tutorial, jangan hanya disalin! Tanyakan kepada AI:</p>
<pre><code>"Tolong bedah dan jelaskan potongan kode JavaScript berikut baris per baris. 
Untuk setiap baris, berikan analogi kehidupan sehari-hari agar saya yang baru belajar 
koding bisa paham fungsi logikanya secara mendalam."</code></pre>

<img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1100&q=80" alt="Keamanan komputasi awan dan kecerdasan artifisial" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h3>2. Menggunakan AI Sebagai Pembuat Soal Latihan Mandiri</h3>
<p>Cara terbaik menguji apakah kamu sudah benar-benar paham suatu materi adalah dengan mengerjakan soal kuis koding:</p>
<pre><code>"Saya baru saja selesai belajar tag HTML dasar (heading, paragraf, list, link, dan image). 
Buatkan saya 3 studi kasus latihan membuat struktur web mini dari tingkat mudah ke sedang. 
Sertakan instruksi tugas yang jelas, dan sembunyikan kunci jawabannya terlebih dahulu 
sampai saya mencoba menjawabnya."</code></pre>

<h3>3. Meminta Rekomendasi Optimasi Kode (Code Review)</h3>
<p>Setelah kamu berhasil membuat sesuatu di Live Playground, minta umpan balik dari AI:</p>
<pre><code>"Berikut kode HTML/CSS yang sudah berhasil saya buat dan berjalan normal. 
Sebagai mentor, tolong berikan 3 masukan agar kode ini lebih rapi, sesuai standar 
semantik industri, dan lebih cepat dimuat di browser."</code></pre>

<h2>Aturan Emas: Hindari "Jebakan Ketergantungan AI"</h2>
<ul>
    <li><strong>Jangan pernah sekadar Copy-Paste buta:</strong> Jika kamu menyalin kode dari AI tanpa memahami satu baris pun artinya, kemampuan kodingmu tidak akan pernah bertumbuh.</li>
    <li><strong>Ketik ulang kode dengan tanganmu sendiri:</strong> Mengetik manual melatih ingatan motorik (<em>muscle memory</em>) jarimu terhadap tanda kurung, titik koma, dan sintaks penting.</li>
    <li><strong>AI adalah kopilot, kamu adalah kaptennya:</strong> Jangan biarkan AI mengambil alih seluruh proses berpikir. Gunakan AI untuk memperjelas keraguanmu, memvalidasi ide, dan mempercepat pemahaman.</li>
</ul>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Riset AI VxAI',
                'views_count' => 495,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(5),
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],

            // ARTIKEL 6: PROYEK NYATA PEMULA (HTML + CSS + LOGIKA)
            [
                'title' => 'Proyek Nyata Pemula: Memadukan HTML, CSS, dan Logika Koding Menjadi Kartu Interaktif',
                'slug' => 'proyek-nyata-pemula-memadukan-html-css-logika-koding',
                'category' => 'coding',
                'summary' => 'Praktik langsung adalah cara tercepat menguasai koding. Di tutorial langkah demi langkah ini, kita akan menggabungkan struktur HTML, gaya desain CSS modern, dan sedikit logika JavaScript menjadi kartu profil interaktif yang memukau.',
                'content' => '<p>Pernahkah kamu merasa sudah membaca banyak artikel dan menonton banyak tutorial video, tapi saat membuka editor koding yang kosong, tanganmu tiba-tiba kaku dan tidak tahu harus mulai mengetik apa? Jangan khawatir, hampir semua programmer pernah mengalami sindrom ini!</p>
<p>Kunci untuk mengatasi rasa ragu adalah <strong>langsung membangun proyek mini yang nyata</strong>. Di artikel ini, kita tidak hanya belajar teori terpisah — kita akan menggabungkan <strong>HTML</strong> (struktur), <strong>CSS</strong> (keindahan visual), dan sedikit logika <strong>JavaScript</strong> (interaktivitas) menjadi sebuah Kartu Profil Pengembang Interaktif yang bisa langsung kamu pamerkan!</p>

<img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1100&q=80" alt="Workspace koding interaktif modern" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Tiga Pilar Pembangunan Web</h2>
<p>Mari kita ingat kembali peran ketiga teknologi ini:</p>
<ol>
    <li><strong>HTML:</strong> Menyediakan konten (foto profil, nama, deskripsi, dan tombol).</li>
    <li><strong>CSS:</strong> Membuat kartu berada di tengah layar, memberikan latar belakang putih melengkung yang elegan, dan menambahkan bayangan halus.</li>
    <li><strong>JavaScript:</strong> Membuat tombol bisa diklik dan merespons dengan pesan ramah serta menghitung jumlah apresiasi (like).</li>
</ol>

<h2>Langkah 1: Menyiapkan Struktur HTML</h2>
<p>Ketik atau salin kode struktur berikut ke dalam editor:</p>
<pre><code>&lt;div class="kartu-profil"&gt;
    &lt;div class="badge-status"&gt;Sedang Belajar Koding&lt;/div&gt;
    &lt;h2 id="nama-user"&gt;Nathania Putri&lt;/h2&gt;
    &lt;p class="profesi"&gt;Calon Web &amp; AI Engineer • Kupang, NTT&lt;/p&gt;
    &lt;p class="bio"&gt;
        "Saya sedang aktif mempelajari HTML5 semantik, estetika CSS modern, 
        dan pemanfaatan AI untuk memecahkan masalah sehari-hari."
    &lt;/p&gt;
    
    &lt;div class="aksi-container"&gt;
        &lt;button class="btn-sapa" onclick="kirimSalam()"&gt;👋 Kirim Salam&lt;/button&gt;
        &lt;button class="btn-like" onclick="tambahLike()"&gt;❤️ Suka (&lt;span id="jumlah-like"&gt;0&lt;/span&gt;)&lt;/button&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>

<h2>Langkah 2: Menghias dengan CSS Modern</h2>
<p>Tambahkan kode CSS berikut di dalam tag <code>&lt;style&gt;</code> untuk memberikan sentuhan desain berstandar industri:</p>
<pre><code>&lt;style&gt;
    /* Reset &amp; Font Dasar */
    body {
        font-family: \'Segoe UI\', Roboto, sans-serif;
        background: #f1f5f9;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        margin: 0;
        padding: 20px;
    }

    /* Wadah Kartu Utama */
    .kartu-profil {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        max-width: 420px;
        width: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .kartu-profil:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(37, 99, 235, 0.12);
    }

    .badge-status {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 999px;
        margin-bottom: 16px;
    }

    h2 {
        color: #0f172a;
        margin: 0 0 6px 0;
        font-size: 22px;
    }

    .profesi {
        color: #2563eb;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .bio {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .aksi-container {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    button {
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-sapa {
        background: #2563eb;
        color: white;
    }
    .btn-sapa:hover {
        background: #1d4ed8;
    }

    .btn-like {
        background: #f8fafc;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-like:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }
&lt;/style&gt;</code></pre>

<img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1100&q=80" alt="Menguji kode program di laptop" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>Langkah 3: Memberi "Nyawa" dengan Logika JavaScript</h2>
<p>Sekarang mari kita buat agar tombol tersebut benar-benar bereaksi ketika diklik pengunjung:</p>
<pre><code>&lt;script&gt;
    // Variabel untuk melacak jumlah like
    let totalLike = 0;

    function kirimSalam() {
        alert("Halo dari Nathania! Terima kasih sudah mampir ke profil koding saya 😊");
    }

    function tambahLike() {
        totalLike = totalLike + 1;
        document.getElementById("jumlah-like").innerText = totalLike;
    }
&lt;/script&gt;</code></pre>

<h2>Uji Coba Sekarang di Live Playground!</h2>
<p>Buka <strong>Live Playground VxAI</strong>, satukan ketiga blok kode di atas (HTML, style CSS, dan script JS), lalu klik tombol "Kirim Salam" dan "Suka". Angka like akan otomatis bertambah secara real-time di layar!</p>
<p>Sensasi melihat idemu berubah menjadi tampilan hidup di browser inilah yang membuat jutaan programmer di seluruh dunia jatuh cinta pada dunia koding. Selamat berkarya, dan teruslah mencoba tantangan-tantangan baru!</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Tim Pengajar VxAI',
                'views_count' => 510,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(6),
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(6),
            ]
        ];
    }

    /**
     * Sinkronisasi artikel bawaan ke database.
     * Otomatis berjalan saat pembaruan ditarik via Git di cPanel.
     */
    public static function syncDefaultArticles(bool $force = false): bool
    {
        try {
            if (!Schema::hasTable('articles')) {
                return false;
            }

            // Periksa versi konten artikel di database
            $currentVersion = null;
            if (Schema::hasTable('global_settings')) {
                $currentVersion = DB::table('global_settings')
                    ->where('setting_key', 'articles_content_version')
                    ->value('setting_value');
            }

            // Jika versi sama dan ada artikel, tidak perlu proses ulang (hemat performa 0ms)
            $articlesCount = DB::table('articles')->count();
            if (!$force && $currentVersion === self::VERSION && $articlesCount >= 6) {
                return false;
            }

            // Daftar slug lama/usang yang harus dibersihkan agar database bersih
            $legacySlugs = [
                'panduan-lengkap-belajar-web-development-modern-2026',
                '7-trik-prompt-engineering-coding-ai-assistant',
                'tren-kecerdasan-artifisial-2026-industri-digital-indonesia',
                'panduan-troubleshooting-komputer-pc-lemot-blue-screen',
                '10-trik-rahasia-optimasi-hp-android-performa-baterai',
                'arsitektur-pemrograman-modern-web-skalabel-terintegrasi-ai',
                'transformasi-digital-smk-ntt-pusat-talenta-ai-2026',
                // versi transisi sebelumnya
                'belajar-html-dari-nol-panduan-lengkap-halaman-web-pertama',
                'dasar-dasar-koding-apa-itu-pemrograman-dari-mana-memulai',
                'mengenal-kecerdasan-buatan-ai-panduan-dasar-mudah-dipahami',
                'belajar-css-pemula-cara-mempercantik-halaman-web',
                'belajar-javascript-dasar-halaman-web-interaktif-responsif',
                'cara-menggunakan-ai-belajar-koding-lebih-cepat-prompt-engineering',
            ];

            // Hapus artikel lama yang ada dalam daftar legacy
            DB::table('articles')->whereIn('slug', $legacySlugs)->delete();

            // Dapatkan artikel terstandar baru
            $defaultArticles = self::getDefaultArticles();

            foreach ($defaultArticles as $item) {
                $existing = DB::table('articles')->where('slug', $item['slug'])->first();

                if ($existing) {
                    // Update konten agar selalu sinkron dengan versi terbaru dari Git
                    DB::table('articles')->where('slug', $item['slug'])->update([
                        'title' => $item['title'],
                        'category' => $item['category'],
                        'summary' => $item['summary'],
                        'content' => $item['content'],
                        'thumbnail_url' => $item['thumbnail_url'],
                        'author_name' => $item['author_name'],
                        'status' => $item['status'],
                        'is_featured' => $item['is_featured'],
                        'updated_at' => now(),
                    ]);
                } else {
                    // Insert baru
                    DB::table('articles')->insert($item);
                }
            }

            // Simpan versi terkini ke global_settings
            if (Schema::hasTable('global_settings')) {
                DB::table('global_settings')->updateOrInsert(
                    ['setting_key' => 'articles_content_version'],
                    [
                        'setting_value' => self::VERSION,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            return true;
        } catch (\Throwable $e) {
            // Tangkap dan abaikan agar website publik tidak pernah fatal crash
            return false;
        }
    }
}
