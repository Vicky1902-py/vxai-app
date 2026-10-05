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

            // ARTIKEL WEB 3: Server-Driven UI & Edge Rendering
            [
                'title' => 'Server-Driven UI & Edge Rendering di Web Modern: Menyeimbangkan Performa SEO dan Interaktivitas Pengguna',
                'slug' => 'server-driven-ui-edge-rendering-web-modern-seo',
                'category' => 'web',
                'summary' => 'Analisis mendalam revolusi arsitektur rendering web: perbandingan komprehensif antara Server-Side Rendering (SSR), Static Site Generation (SSG), Incremental Static Regeneration (ISR), dan Edge Hydration untuk meraih skor 100 Google Core Web Vitals (LCP, INP, CLS).',
                'content' => '<p>Perdebatan seputar cara merender website telah menempuh perjalanan panjang. Di era awal web, seluruh halaman di-render oleh server (PHP klasik). Kemudian lahirlah gelombang Single Page Application (SPA) berbasis JavaScript sisi klien (React, Vue, Angular) yang menawarkan transisi halaman mulus layaknya aplikasi desktop, namun harus dibayar mahal dengan ukuran bundle JavaScript berukuran megabyte yang memperlambat waktu muat awal (*First Contentful Paint*) dan merusak pengindeksan mesin pencari (SEO).</p>
<p>Kini di tahun 2026, industri web mencapai titik keseimbangan emas melalui paradigma <strong>Server-Driven UI</strong> dan <strong>Edge Rendering</strong>.</p>

<img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80" alt="Grafik analitik kecepatan rendering halaman web dan performa SEO Core Web Vitals" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Spektrum Arsitektur Rendering Web Modern</h2>
<p>Seorang software engineer web profesional wajib memahami kapan harus menggunakan metode rendering yang tepat:</p>
<ul>
    <li><strong>Static Site Generation (SSG):</strong> Halaman HTML dikompilasi satu kali saat proses build. Waktu respon super cepat (dihantarkan langsung oleh CDN global), sangat cocok untuk halaman dokumentasi, syarat layanan, dan artikel statis.</li>
    <li><strong>Server-Side Rendering (SSR):</strong> Server menghasilkan HTML lengkap secara dinamis pada setiap permintaan pengguna. Wajib digunakan untuk halaman dengan data yang sering berubah secara real-time dan menuntut SEO optimal (misal: halaman detail berita dan profil publik).</li>
    <li><strong>Incremental Static Regeneration (ISR):</strong> Menggabungkan keunggulan SSG dan SSR. Halaman disajikan dari cache statis, namun secara otomatis diperbarui di latar belakang (*stale-while-revalidate*) ketika ada data baru yang masuk.</li>
    <li><strong>Edge SSR & Streaming:</strong> HTML dirender di jaringan server tepi (Edge Nodes) yang paling dekat dengan lokasi fisik pengguna (misal: node Jakarta atau Singapura) dan dikirimkan secara bertahap (*streaming chunks*) ke browser tanpa menunggu seluruh data selesai diproses.</li>
</ul>

<h2>2. Menaklukkan Metrik Google Core Web Vitals 2026</h2>
<p>Google AdSense dan algoritma perangkingan Google Search menjadikan tiga metrik Core Web Vitals sebagai indikator kesehatan utama website:</p>
<ol>
    <li><strong>LCP (Largest Contentful Paint &lt; 2.5 detik):</strong> Waktu yang dibutuhkan browser untuk menampilkan elemen visual terbesar di layar (biasanya gambar hero artikel atau judul utama). Terapkan atribut <code>fetchpriority="high"</code> pada tag gambar sampul teratas.</li>
    <li><strong>INP (Interaction to Next Paint &lt; 200 milidetik):</strong> Menggantikan metrik lama FID. Mengukur seberapa responsif halaman saat pengguna mengklik tombol atau membuka menu dropdown. Hindari eksekusi JavaScript yang memblokir utas utama (Main Thread) selama lebih dari 50ms.</li>
    <li><strong>CLS (Cumulative Layout Shift &lt; 0.1):</strong> Mengukur pergeseran tata letak visual yang mengejutkan pengguna. Selalu tentukan atribut <code>width</code> dan <code>height</code> eksplisit pada gambar dan wadah iklan AdSense agar tata letak tidak melompat tiba-tiba saat iklan dimuat.</li>
</ol>

<img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80" alt="Pengembang web mendesain arsitektur antarmuka digital modern" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>3. Kesimpulan: Membangun Web yang Cepat dan Menguntungkan</h2>
<p>Website yang cepat bukan hanya disukai oleh pengunjung manusia, tetapi juga sangat dicintai oleh bot crawler Google AdSense. Dengan menerapkan arsitektur server-driven yang hemat JavaScript dan dioptimalkan di jaringan CDN edge, biaya hosting server dapat ditekan hingga 60% sementara pendapatan iklan meningkat signifikan berkat pengalaman membaca yang mulus tanpa jeda.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL WEB 4: Panduan Arsitektur Database SQL vs NoSQL 2026
            [
                'title' => 'Panduan Arsitektur Database SQL vs NoSQL 2026: Kapan Memilih Relasional, Dokumen, Key-Value, atau Vektor',
                'slug' => 'panduan-arsitektur-database-sql-vs-nosql-vektor-2026',
                'category' => 'web',
                'summary' => 'Panduan strategis rekayasa basis data bagi software engineer: perbandingan fundamental ACID vs BASE teorema CAP, optimasi indeks B-Tree vs Hash, strategi partitioning/sharding tabel bernilai miliaran baris, dan peran database vektor modern.',
                'content' => '<p>Salah satu keputusan arsitektur paling krusial dalam siklus hidup pengembangan perangkat lunak adalah memilih mesin basis data (*database engine*) yang tepat. Keputusan yang keliru di awal proyek dapat menyebabkan kerugian biaya migrasi yang masif, kebocoran integritas data keuangan, atau kelumpuhan sistem (*downtime*) saat jumlah pengguna aktif harian melonjak dari ribuan menjadi jutaan.</p>
<p>Di era modern 2026, perdebatan bukan lagi tentang "SQL lebih baik daripada NoSQL" secara dogmatis, melainkan tentang <strong>Polyglot Persistence</strong>: menggunakan database yang tepat untuk setiap pola akses data yang spesifik.</p>

<img src="https://images.unsplash.com/photo-1544383835-bda2bc66a55d?auto=format&fit=crop&w=1200&q=80" alt="Visualisasi rak server pusat basis data penyimpanan data terstruktur" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Empat Kategori Utama Database Modern</h2>

<h3>A. Relational Database (RDBMS / SQL): PostgreSQL & MySQL</h3>
<ul>
    <li><strong>Karakteristik:</strong> Menjamin kepatuhan prinsip ACID (Atomicity, Consistency, Isolation, Durability) secara mutlak. Skema tabel terstruktur ketat dengan relasi foreign key.</li>
    <li><strong>Kasus Penggunaan Terbaik:</strong> Sistem buku besar keuangan (ledger), manajemen pengguna & autentikasi, transaksi e-commerce, dan sistem administrasi sekolah/SMK.</li>
</ul>

<h3>B. Document Database: MongoDB & Couchbase</h3>
<ul>
    <li><strong>Karakteristik:</strong> Menyimpan data semi-terstruktur dalam format dokumen JSON/BSON polimorfik. Skema fleksibel tanpa perlu migrasi DDL yang rumit.</li>
    <li><strong>Kasus Penggunaan Terbaik:</strong> Katalog produk dengan atribut yang dinamis, manajemen konten (CMS), dan logging event aplikasi.</li>
</ul>

<h3>C. Key-Value & In-Memory Cache: Redis & Valkey</h3>
<ul>
    <li><strong>Karakteristik:</strong> Seluruh data disimpan langsung di memori RAM fisik. Waktu baca dan tulis sub-milidetik (&lt; 1ms).</li>
    <li><strong>Kasus Penggunaan Terbaik:</strong> Manajemen token sesi login, pembatas laju trafik (Rate Limiter), leaderboard skor real-time, dan caching query database yang lambat.</li>
</ul>

<h3>D. Vector Database: pgvector, Pinecone, Qdrant & Milvus</h3>
<ul>
    <li><strong>Karakteristik:</strong> Mengindeks representasi matematis vektor berdimensi tinggi (misal: 1536 dimensi embedding dari model OpenAI/Gemini) menggunakan algoritma pencarian tetangga terdekat (Approximate Nearest Neighbor / ANN).</li>
    <li><strong>Kasus Penggunaan Terbaik:</strong> Sistem rekomendasi e-commerce, pencarian semantik teks alami, dan memori jangka panjang untuk agen AI RAG.</li>
</ul>

<img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1200&q=80" alt="Kabel serat optik dan jaringan server komputasi awan data center" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>2. Tips Optimasi Query Database untuk Menekan Biaya Server</h2>
<p>Banyak sistem mengalami kelambatan bukan karena spesifikasi server yang rendah, melainkan karena query SQL yang tidak efisien:</p>
<ol>
    <li><strong>Hindari Pola N+1 Query:</strong> Selalu gunakan teknik <em>Eager Loading</em> (misal: <code>Article::with(\'author\')->get()</code> di Laravel) alih-alih melakukan query berulang di dalam perulangan loop.</li>
    <li><strong>Gunakan Indeks B-Tree pada Kolom Filter:</strong> Pasang indeks pada kolom yang sering digunakan di klausul <code>WHERE</code>, <code>ORDER BY</code>, dan relasi <code>JOIN</code> (seperti <code>slug</code>, <code>category</code>, dan <code>published_at</code>).</li>
    <li><strong>Gunakan Perintah EXPLAIN ANALYZE:</strong> Periksa apakah database melakukan <em>Index Scan</em> yang cepat atau <em>Sequential Scan</em> (Full Table Scan) yang memindai jutaan baris tanpa perlindungan indeks.</li>
</ol>
<p>Dengan menguasai karakteristik berbagai mesin basis data ini, Anda dapat merancang arsitektur sistem yang tidak hanya tangguh dan terukur, tetapi juga hemat biaya operasional infrastruktur.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?auto=format&fit=crop&w=1200&q=80',
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
