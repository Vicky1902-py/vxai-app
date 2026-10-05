<?php

namespace App\Services\Articles;

class AndroidArticles
{
    public static function getArticles(): array
    {
        $now = now();

        return [
            // ARTIKEL ANDROID 1: Kotlin & Jetpack Compose MVVM
            [
                'title' => 'Panduan Memulai Pengembangan Aplikasi Android Modern: Kotlin, Jetpack Compose, dan Pola Arsitektur MVVM',
                'slug' => 'panduan-pengembangan-aplikasi-android-modern-kotlin-jetpack-compose-mvvm',
                'category' => 'android',
                'summary' => 'Langkah awal praktis menjadi Android Developer profesional: beralih dari XML ke deklaratif Jetpack Compose, penguasaan bahasa Kotlin, coroutines untuk proses asinkron, dan implementasi arsitektur Model-View-ViewModel (MVVM).',
                'content' => '<p>Dunia pengembangan aplikasi Android telah mengalami transformasi paling radikal dalam lima tahun terakhir. Era menyusun tata letak antarmuka menggunakan ratusan baris kode XML yang kaku, penggunaan <code>findViewById</code> yang rawan crash NullPointerException, serta callback bertingkat kini telah resmi digantikan oleh standar modern: <strong>Bahasa Pemrograman Kotlin</strong> dan toolkit antarmuka deklaratif <strong>Jetpack Compose</strong>.</p>
<p>Bagi Anda pengembang web yang telah terbiasa dengan paradigma komponen reaktif seperti React atau Vue, mempelajari Jetpack Compose akan terasa sangat alami karena mengadopsi filosofi deklaratif yang serupa: <em>UI adalah representasi murni dari State saat ini</em>.</p>

<img src="https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=1200&q=80" alt="Smartphone Android dengan layar kode pemrograman modern" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Mengapa Jetpack Compose Menang Telak dari XML?</h2>
<p>Jetpack Compose bukan sekadar penyegar tampilan, melainkan peningkatan produktivitas menyeluruh bagi tim pengembang:</p>
<ul>
    <li><strong>Lebih Sedikit Kode (Less Code):</strong> Menulis antarmuka dalam bahasa Kotlin murni memangkas hingga 60% jumlah baris kode dibanding memisahkan antara logika Java/Kotlin dan file layout XML.</li>
    <li><strong>Intuitif & Deklaratif:</strong> Anda cukup mendeskripsikan bagaimana tampilan harus terlihat berdasarkan state data. Saat data berubah, Compose secara otomatis merekonstruksi (*recompose*) bagian layar yang terpengaruh saja.</li>
    <li><strong>Interoperabilitas Sempurna:</strong> Anda dapat menyematkan komponen Compose di dalam proyek XML lama, atau menyematkan View Android tradisional di dalam halaman Compose baru.</li>
</ul>

<h2>2. Pola Arsitektur Bersih: MVVM (Model-View-ViewModel)</h2>
<p>Aplikasi profesional tidak boleh menumpuk seluruh logika di dalam satu file Activity. Standar emas arsitektur Android merekomendasikan pemisahan tanggung jawab menjadi tiga lapisan:</p>
<ol>
    <li><strong>Model (Data Layer):</strong> Bertanggung jawab mengambil data mentah dari database lokal (Room Database) atau API server web (Retrofit / Ktor Client).</li>
    <li><strong>ViewModel (Logic Layer):</strong> Menampung logika bisnis, bertahan melewati perubahan konfigurasi (seperti rotasi layar HP), dan memaparkan data dalam bentuk <code>StateFlow</code> yang aman.</li>
    <li><strong>View (UI Layer / Composable):</strong> Murni menerima data dari ViewModel dan merendernya ke layar pengguna tanpa menyentuh logika manipulasi data.</li>
</ol>

<h2>3. Contoh Kode Praktis: Kartu Profil Sederhana dengan Compose</h2>
<pre class="ql-syntax">@Composable
fun StudentProfileCard(studentName: String, xpScore: Int) {
    Card(
        modifier = Modifier
            .fillMaxWidth()
            .padding(16.dp),
        shape = RoundedCornerShape(16.dp),
        colors = CardDefaults.cardColors(containerColor = MaterialTheme.colorScheme.surfaceVariant)
    ) {
        Column(modifier = Modifier.padding(20.dp)) {
            Text(
                text = studentName,
                style = MaterialTheme.typography.titleLarge,
                fontWeight = FontWeight.Bold
            )
            Spacer(modifier = Modifier.height(8.dp))
            Text(
                text = "Total Poin Belajar: $xpScore XP",
                style = MaterialTheme.typography.bodyMedium,
                color = MaterialTheme.colorScheme.primary
            )
        }
    }
}</pre>

<h2>4. Roadmap Langkah Belajar Menjadi Android Engineer</h2>
<ol>
    <li>Kuasai sintaks modern Kotlin: Null Safety, Data Classes, Extension Functions, dan Lambda.</li>
    <li>Pahami asynchronous programming dengan <strong>Kotlin Coroutines & Flow</strong> untuk menghindari layar macet saat mengunduh data dari internet.</li>
    <li>Pelajari integrasi Dependency Injection menggunakan <strong>Hilt</strong> untuk mempermudah unit testing.</li>
    <li>Pelajari prinsip Material Design 3 (Material You) untuk menghasilkan aplikasi yang indah dan adaptif mengikuti tema warna pengguna.</li>
</ol>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL ANDROID 2: Optimasi Kinerja & Efisiensi Baterai
            [
                'title' => 'Optimalisasi Kinerja dan Efisiensi Baterai pada Smartphone Android: Trik Developer Mengurangi Background Process',
                'slug' => 'optimalisasi-kinerja-efisiensi-baterai-smartphone-android-background-process',
                'category' => 'android',
                'summary' => 'Analisis mendalam bagaimana sistem operasi Android mengelola daya: implementasi WorkManager, Doze Mode, reduksi wakelock, dan panduan pengguna memanfaatkan Developer Options untuk memaksimalkan masa pakai baterai.',
                'content' => '<p>Salah satu keluhan paling umum dari pengguna smartphone di seluruh dunia adalah baterai yang cepat habis dan perangkat yang terasa hangat bahkan saat sedang tidak digunakan secara aktif. Bagi pengembang aplikasi Android, mengabaikan efisiensi daya tidak hanya berakibat pada ulasan buruk bintang satu di Google Play Store, namun juga risiko aplikasi ditutup paksa oleh mekanisme internal Android Low Memory Killer.</p>
<p>Google telah memperkenalkan kebijakan ketat pada rilis Android terbaru (Android 14 dan 15) yang membatasi eksekusi proses di latar belakang (*background execution limits*). Bagaimana sistem operasi mengelola daya, dan apa yang harus dilakukan developer?</p>

<img src="https://images.unsplash.com/photo-1511707171634-5f897ff02560?auto=format&fit=crop&w=1200&q=80" alt="Smartphone Android modern dengan pengisian daya dan visual baterai" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Memahami Doze Mode & App Standby Buckets</h2>
<p>Sistem operasi Android mengadopsi mekanisme hemat daya bertingkat saat layar ponsel mati dan perangkat diam di atas meja tanpa digerakkan:</p>
<ul>
    <li><strong>Doze Mode:</strong> Sistem memutus akses jaringan internet untuk aplikasi non-kritis, menunda sinkronisasi tugas latar belakang, dan menonaktifkan alarm parsial. Sistem hanya membuka jendela pemeliharaan singkat (*maintenance window*) sesekali untuk menyelesaikan pekerjaan tertunda secara kolektif.</li>
    <li><strong>App Standby Buckets:</strong> Aplikasi dikelompokkan berdasarkan seberapa sering dibuka oleh pengguna (Active, Working Set, Frequent, Rare, Restricted). Semakin jarang dibuka, semakin sedikit kuota tugas latar belakang yang diizinkan oleh sistem.</li>
</ul>

<h2>2. Tinggalkan Background Service Kasar, Beralih ke WorkManager</h2>
<p>Di masa lalu, developer sering membuat <code>Service</code> tak berujung untuk menyinkronkan data setiap beberapa menit. Pendekatan ini terbukti menjadi pembunuh baterai nomor satu karena menahan prosesor agar tidak pernah masuk ke mode tidur nyenyak (*deep sleep state*).</p>
<p>Solusi resmi standar industri saat ini adalah <strong>WorkManager API</strong>. WorkManager secara cerdas menunda eksekusi tugas berat hingga kondisi perangkat ideal:</p>
<pre class="ql-syntax">val syncConstraints = Constraints.Builder()
    .setRequiredNetworkType(NetworkType.UNMETERED) // Hanya saat Wi-Fi
    .setRequiresCharging(true)                    // Hanya saat sedang di-charge
    .setRequiresBatteryNotLow(true)               // Baterai tidak sekarat
    .build()

val syncWorkRequest = PeriodicWorkRequestBuilder<DatabaseSyncWorker>(
    12, TimeUnit.HOURS
).setConstraints(syncConstraints).build()

WorkManager.getInstance(context).enqueue(syncWorkRequest)</pre>
<p>Dengan menerapkan batasan (*constraints*) di atas, aplikasi Anda tidak akan pernah menguras baterai pengguna saat mereka sedang beraktivitas di luar ruangan.</p>

<h2>3. Trik Developer Options untuk Menguji Kinerja HP</h2>
<p>Bagi programmer dan pengguna mahir, menu tersembunyi <em>Developer Options (Opsi Pengembang)</em> menyediakan instrumen diagnostik luar biasa:</p>
<ol>
    <li><strong>Show Refresh Rate:</strong> Memastikan layar 120Hz adaptif benar-benar turun ke 60Hz saat menampilkan konten statis untuk menghemat baterai.</li>
    <li><strong>Profile HWUI Rendering:</strong> Menampilkan grafik batang di layar yang menunjukkan apakah rendering frame antarmuka melewati batas 16 milidetik (penyebab tampilan patah-patah / jank).</li>
    <li><strong>Background Check:</strong> Mengaudit aplikasi pihak ketiga mana saja yang mendaftarkan broadcast receiver berjalan tanpa henti di latar belakang sistem.</li>
</ol>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02560?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL ANDROID 3: Aplikasi Hybrid WebView & PWA
            [
                'title' => 'Membangun Aplikasi Hybrid Android dengan WebView & Progressive Web Apps (PWA): Ringan, Cepat, dan Hemat Resource',
                'slug' => 'membangun-aplikasi-hybrid-android-webview-pwa-ringan-cepat',
                'category' => 'android',
                'summary' => 'Strategi efisien mengubah website responsif menjadi aplikasi Android berbasis Web App Manifest, Service Workers, dan wrapper WebView kustom yang aman serta memenuhi kriteria publikasi Google Play Store.',
                'content' => '<p>Tidak semua organisasi, sekolah, atau pengembang independen memiliki sumber daya untuk membangun dua basis kode terpisah (Kotlin untuk Android dan Swift untuk iOS). Pendekatan <strong>Aplikasi Hybrid</strong> yang memadukan teknologi web modern (HTML5, Tailwind CSS, JavaScript) dengan pembungkus (*wrapper*) native Android adalah solusi ideal untuk menghadirkan aplikasi cepat tanpa mengorbankan pengalaman pengguna.</p>
<p>Bahkan raksasa teknologi seperti Twitter (X Lite), Instagram, dan Uber mengandalkan perpaduan Progressive Web Apps (PWA) dan WebView untuk mereduksi ukuran unduhan APK dari puluhan megabyte menjadi hanya hitungan kilobyte.</p>

<img src="https://images.unsplash.com/photo-1526470608268-f674ce90ebd4?auto=format&fit=crop&w=1200&q=80" alt="Desain antarmuka aplikasi mobile responsif di layar smartphone" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Komponen Inti: Web App Manifest & Service Worker</h2>
<p>Langkah pertama membangun aplikasi hybrid adalah memastikan website Anda memenuhi standar PWA:</p>
<ul>
    <li><strong>Web App Manifest:</strong> File JSON yang mendeklarasikan nama aplikasi, warna tema bilah status (theme_color), ikon aplikasi resolusi tinggi (maskable icons), dan mode tampilan <code>"display": "standalone"</code> agar browser menyembunyikan bilah URL seperti aplikasi native asli.</li>
    <li><strong>Service Worker:</strong> Skrip JavaScript yang bertindak sebagai proxy jaringan perantara antara browser dan server. Service Worker dapat mencadangkan aset visual ke cache lokal sehingga aplikasi dapat terbuka instan meski koneksi internet padam.</li>
</ul>

<h2>2. Konfigurasi Komponen WebView Android yang Tangguh</h2>
<p>Di sisi aplikasi Android (Activity), konfigurasi WebView harus dilakukan dengan cermat agar tidak rentan terhadap serangan celah keamanan atau navigasi rusak:</p>
<pre class="ql-syntax">val webView = findViewById&lt;WebView&gt;(R.id.customWebView)

webView.settings.apply {
    javaScriptEnabled = true
    domStorageEnabled = true
    databaseEnabled = true
    allowFileAccess = false       // Keamanan: larang akses sistem file lokal
    allowContentAccess = false
    setSupportZoom(false)
}

// Mencegah link eksternal membuka browser luar
webView.webViewClient = object : WebViewClient() {
    override fun shouldOverrideUrlLoading(view: WebView?, request: WebResourceRequest?): Boolean {
        val url = request?.url.toString()
        if (url.startsWith("https://vxai.online")) {
            return false // Buka di dalam WebView aplikasi kita
        }
        // Tautan luar (misal WhatsApp / YouTube) buka di aplikasi sistem
        val intent = Intent(Intent.ACTION_VIEW, Uri.parse(url))
        startActivity(intent)
        return true
    }
}</pre>

<h2>3. Menangani Tombol Back Hardware Navigasi</h2>
<p>Kesalahan fatal pemula saat membuat WebView Android adalah: ketika pengguna menekan tombol Back fisik atau gesture geser di HP, aplikasi langsung tertutup keluar ke Home screen alih-alih kembali ke halaman web sebelumnya. Tangani event ini dengan benar:</p>
<pre class="ql-syntax">onBackPressedDispatcher.addCallback(this, object : OnBackPressedCallback(true) {
    override fun handleOnBackPressed() {
        if (webView.canGoBack()) {
            webView.goBack() // Mundur ke riwayat halaman web sebelumnya
        } else {
            isEnabled = false
            onBackPressedDispatcher.onBackPressed() // Tutup aplikasi jika di beranda
        }
    }
})</pre>

<p>Dengan menerapkan prinsip-prinsip di atas, aplikasi hybrid Anda akan terasa seringan dan secepat aplikasi native murni dengan efisiensi pemeliharaan kode satu atap.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1526470608268-f674ce90ebd4?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL ANDROID 4: Keamanan Aplikasi Android & Enkripsi
            [
                'title' => 'Keamanan Aplikasi Android: Manajemen Izin Runtime, Enkripsi SharedPreferences, dan Proteksi APK dari Reverse Engineering',
                'slug' => 'keamanan-aplikasi-android-izin-runtime-enkripsi-proteksi-apk',
                'category' => 'android',
                'summary' => 'Praktik terbaik mengamankan aplikasi Android dari ancaman kebocoran data dan pembajakan: implementasi Android Keystore, Jetpack Security EncryptedSharedPreferences, SSL Pinning, dan obfuscation dengan ProGuard/R8.',
                'content' => '<p>Ekosistem aplikasi mobile menyimpan informasi paling sensitif dalam kehidupan digital modern: token autentikasi sesi, data pribadi, riwayat pembayaran, hingga data identitas perangkat. Namun, sifat file paket aplikasi Android (APK) yang berupa arsip terkompresi membuatnya sangat rentan dibongkar kembali (*reverse engineered*) menggunakan perangkat seperti APKTool atau JADX jika tidak diproteksi dengan benar.</p>
<p>Bagi developer profesional, keamanan bukan sekadar fitur tambahan di akhir proyek, melainkan pondasi arsitektur sejak hari pertama baris kode ditulis.</p>

<img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80" alt="Ilustrasi keamanan siber gembok digital dan enkripsi data mobile" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Jangan Simpan Token Rahasia dalam Plaintext!</h2>
<p>Banyak pengembang menyimpan token autentikasi (JWT Token) atau kredensial API menggunakan SharedPreferences biasa dalam bentuk teks mentah. Pada perangkat yang telah di-root, file XML SharedPreferences dapat dibaca secara leluasa oleh aplikasi lain.</p>
<p>Gunakan pustaka resmi <strong>Jetpack Security (EncryptedSharedPreferences)</strong> yang mengintegrasikan enkripsi berbasis perangkat keras <strong>Android Keystore System</strong>:</p>
<pre class="ql-syntax">val masterKey = MasterKey.Builder(context)
    .setKeyScheme(MasterKey.KeyScheme.AES256_GCM)
    .build()

val securePreferences = EncryptedSharedPreferences.create(
    context,
    "secure_user_prefs",
    masterKey,
    EncryptedSharedPreferences.PrefKeyEncryptionScheme.AES256_SIV,
    EncryptedSharedPreferences.PrefValueEncryptionScheme.AES256_GCM
)</pre>
<p>Kunci enkripsi dikelola di lingkungan terisolasi perangkat keras (Hardware Security Module / StrongBox) yang bahkan tidak bisa diekstrak oleh sistem operasi sekalipun.</p>

<h2>2. Mencegah Serangan Sadap Jaringan: SSL/TLS Pinning</h2>
<p>Meskipun aplikasi Anda menggunakan HTTPS, peretas dapat memasang sertifikat root palsu (*custom CA certificate*) di ponsel pengguna untuk mencegat data sensitif menggunakan teknik Man-in-the-Middle (MITM) via software seperti Charles Proxy atau Burp Suite.</p>
<p>Aktifkan Network Security Config di file manifest untuk mengunci (*pin*) fingerprint sertifikat resmi domain server Anda:</p>
<pre class="ql-syntax">&lt;network-security-config&gt;
    &lt;domain-config&gt;
        &lt;domain includeSubdomains="true"&gt;vxai.online&lt;/domain&gt;
        &lt;pin-set&gt;
            &lt;pin digest="SHA-256"&gt;k2v657xUM4MmNGHgM56VNW6TVgnPGJrE7Ti04aYBoZo=&lt;/pin&gt;
        &lt;/pin-set&gt;
    &lt;/domain-config&gt;
&lt;/network-security-config&gt;</pre>

<h2>3. Menyamarkan Kode dengan R8 / ProGuard Obfuscation</h2>
<p>Secara default, saat mengompilasi APK, seluruh nama kelas, method, dan variabel tetap terbaca jelas saat didekompilasi. Aktifkan fitur minifikasi dan penyamaran kode pada file <code>build.gradle.kts</code> modul aplikasi:</p>
<pre class="ql-syntax">buildTypes {
    release {
        isMinifyEnabled = true
        isShrinkResources = true
        proguardFiles(
            getDefaultProguardFile("proguard-android-optimize.txt"),
            "proguard-rules.pro"
        )
    }
}</pre>
<p>R8 akan mengubah nama method seperti <code>validateUserPassword()</code> menjadi huruf acak seperti <code>a()</code>, sehingga menyulitkan peretas dalam menganalisis celah logika aplikasi.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80',
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
