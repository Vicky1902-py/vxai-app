<?php

namespace App\Services\Articles;

class WebArticles
{
    public static function getArticles(): array
    {
        $now = now();

        return [
            // ARTIKEL WEB / CODING 1: Flexbox vs CSS Grid
            [
                'title' => 'Mastering CSS Modern: Perbandingan Mendalam Flexbox vs CSS Grid dengan Studi Kasus Tata Letak Nyata',
                'slug' => 'mastering-css-modern-perbandingan-flexbox-css-grid-studi-kasus',
                'category' => 'coding',
                'summary' => 'Kupas tuntas dua teknologi tata letak paling krusial di dunia frontend modern: kapan menggunakan Flexbox 1 dimensi, kapan beralih ke CSS Grid 2 dimensi, dan bagaimana menggabungkan keduanya untuk layout responsif sempurna.',
                'content' => '<p>Bagi siapa pun yang pernah merasakan era merancang tata letak website menggunakan tabel HTML (<code>&lt;table&gt;</code>) atau teknik manipulasi float (<code>float: left</code> dan <code>clearfix</code>), kehadiran CSS Flexbox dan CSS Grid terasa seperti mukjizat rekayasa web. Namun, bagi para pemula, pertanyaan klasik yang paling sering membingungkan adalah: <em>kapan saya harus menggunakan Flexbox, dan kapan saya harus menggunakan CSS Grid?</em></p>
<p>Kunci utama penguasaan desain antarmuka modern bukan memilih salah satu dan membuang yang lain, melainkan memahami kekuatan dimensi masing-masing dan mengombinasikannya secara harmonis.</p>

<img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80" alt="Desain tata letak antarmuka web modern pada monitor komputer" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Flexbox: Sang Juara Tata Letak Satu Dimensi (1D)</h2>
<p>Flexbox (Flexible Box Layout Module) dirancang khusus untuk mendistribusikan ruang dan meratakan elemen sepanjang <strong>satu dimensi tunggal</strong>: baik berupa baris horizontal (row) ATAU kolom vertikal (column).</p>
<ul>
    <li><strong>Kekuatan Utama:</strong> Menyelaraskan konten berdasarkan ukuran dinamis konten di dalamnya (*content-driven*).</li>
    <li><strong>Kasus Penggunaan Ideal:</strong> Bilah navigasi atas (Navbar) di mana logo berada di kiri dan menu tautan berada di kanan (<code>justify-content: space-between</code>), tombol aksi dengan ikon dan teks di tengah persis (<code>align-items: center</code>), serta daftar tag pill filter.</li>
</ul>

<h3>Snippet Navbar dengan Flexbox:</h3>
<pre class="ql-syntax">.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
}</pre>

<h2>2. CSS Grid: Arsitektur Presisi Dua Dimensi (2D)</h2>
<p>CSS Grid dirancang untuk menangani <strong>dua dimensi secara serentak</strong>: mengatur baris dan kolom secara bersamaan dengan pembagian ruang yang matematis.</p>
<ul>
    <li><strong>Kekuatan Utama:</strong> Menata letak secara presisi berdasarkan cetak biru kerangka yang ditentukan terlebih dahulu (*layout-driven*).</li>
    <li><strong>Fitur Ajaib `auto-fit` & `minmax()`:</strong> Anda dapat membuat galeri kartu produk responsif tanpa memerlukan satupun media query:
<pre class="ql-syntax">.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}</pre>
    Elemen kartu otomatis berjejer 4 kolom di monitor lebar, 2 kolom di tablet, dan 1 kolom di layar ponsel secara otomatis!</li>
    <li><strong>Kasus Penggunaan Ideal:</strong> Galeri artikel berita, tata letak dashboard admin (sidebar kiri, header atas, kartu metrik tengah), dan majalah digital berstruktur asimetris.</li>
</ul>

<h2>3. Strategi Kombinasi: Harmoni Sempurna</h2>
<p>Pola terbaik yang diterapkan oleh pengembang senior adalah:</p>
<ol>
    <li>Gunakan <strong>CSS Grid</strong> untuk menyusun kerangka makro halaman (Header, Sidebar, Grid Artikel, Footer).</li>
    <li>Gunakan <strong>Flexbox</strong> untuk menyusun mikro-komponen di dalam masing-masing kartu (meratakan tanggal dengan avatar penulis, mengatur badge kategori, dan menyelaraskan ikon tombol).</li>
</ol>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL WEB / CODING 2: JavaScript Asynchronous
            [
                'title' => 'JavaScript Asynchronous dari Dasar: Menguasai Callbacks, Promises, dan Praktik Terbaik Async/Await',
                'slug' => 'javascript-asynchronous-dasar-callbacks-promises-async-await',
                'category' => 'coding',
                'summary' => 'Panduan komprehensif menaklukkan konsep tersulit JavaScript bagi pemula: memahami cara kerja Event Loop single-thread, menghindari Callback Hell, merangkai Promises, dan menulis kode asynchronous yang bersih dengan Async/Await.',
                'content' => '<p>JavaScript adalah bahasa pemrograman yang berjalan pada lingkungan berutas tunggal (<em>single-threaded</em>). Artinya, mesin JavaScript hanya dapat melakukan satu pekerjaan dalam satu waktu pada utas utamanya. Bayangkan jika sebuah aplikasi harus mengunduh data gambar sebesar 5 megabyte dari server, dan browser membeku total menolak tombol klik pengguna hingga unduhan selesai!</p>
<p>Agar hal mengerikan tersebut tidak terjadi, JavaScript mengadopsi model non-pemblokir (<em>non-blocking asynchronous model</em>). Mari kita kupas tuntas bagaimana evolusi penanganan proses asinkron di JavaScript dari masa kelam hingga standar elegan masa kini.</p>

<img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80" alt="Layar editor pemrograman dengan baris kode JavaScript asinkron" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Tragedi Masa Lalu: Callback Hell (Pyramid of Doom)</h2>
<p>Pada awalnya, proses asinkron ditangani menggunakan fungsi callback—sebuah fungsi yang dioperasikan sebagai argumen ke fungsi lain untuk dijalankan setelah tugas selesai. Masalah muncul saat tugas harus dieksekusi secara berurutan:</p>
<pre class="ql-syntax">getUser(userId, function(user) {
    getOrders(user.id, function(orders) {
        getOrderDetails(orders[0].id, function(details) {
            // Kode menjorok ke kanan tak terhingga dan sulit dibaca!
        });
    });
});</pre>

<h2>2. Fajar Baru: Objek Promise</h2>
<p>Diperkenalkan pada standar ECMAScript 2015 (ES6), Promise merepresentasikan sebuah nilai yang mungkin tersedia sekarang, di masa depan, atau tidak pernah sama sekali. Promise memiliki 3 status:</p>
<ul>
    <li><strong>Pending:</strong> Tugas sedang berjalan di latar belakang.</li>
    <li><strong>Fulfilled (Resolved):</strong> Tugas berhasil diselesaikan.</li>
    <li><strong>Rejected:</strong> Tugas gagal akibat error jaringan atau validasi.</li>
</ul>

<h2>3. Standar Modern Paling Bersih: Async / Await</h2>
<p>Sintaks <code>async/await</code> (hadir di ES2017) adalah pemanis sintaks (*syntactic sugar*) di atas Promises yang memungkinkan kita menulis kode asinkron dengan gaya sekuensial yang mudah dipahami manusia layaknya kode sinkron:</p>
<pre class="ql-syntax">async function fetchStudentDashboard(studentId) {
    try {
        console.log("Memulai pengambilan data profil...");
        const response = await fetch(`/api/students/${studentId}`);
        
        if (!response.ok) {
            throw new Error(`Gagal menghubungi server HTTP status: ${response.status}`);
        }

        const data = await response.json();
        console.log("Data berhasil diterima:", data);
        return data;
    } catch (error) {
        console.error("Terjadi kendala jaringan:", error.message);
        // Tampilkan pesan error ramah pengguna di antarmuka
    } finally {
        console.log("Proses selesai, sembunyikan spinner loading.");
    }
}</pre>

<p>Kombinasi kata kunci <code>async</code>, <code>await</code>, dan blok penanganan <code>try...catch</code> membuat kode Anda aman dari unhandled rejection dan mudah diuji dengan unit testing.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
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
