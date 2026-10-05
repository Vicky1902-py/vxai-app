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

            // ARTIKEL ANDROID 5: Arsitektur Multi-Modul & Type-Safe Navigation
            [
                'title' => 'Navigasi Declarative & Arsitektur Multi-Modul Android 2026: Mengelola Skalabilitas Aplikasi Skala Besar',
                'slug' => 'navigasi-declarative-arsitektur-multi-modul-android-2026',
                'category' => 'android',
                'summary' => 'Best practice arsitektur aplikasi Android modern skala enterprise: pemecahan monolit menjadi feature modules, implementasi Type-Safe Navigation Compose, dependency injection dengan Koin/Hilt, dan optimasi build time Gradle secara signifikan.',
                'content' => '<p>Membangun aplikasi Android dengan basis kode monolitik tunggal (di mana seluruh modul fitur, jaringan, dan database bercampur di dalam modul <code>:app</code>) mungkin terasa cepat di awal pembuatan prototipe. Namun seiring bertambahnya fitur dan tim pengembang, arsitektur monolit menjadi mimpi buruk: waktu kompilasi (*build time*) membengkak hingga puluhan menit, konflik penggabungan kode (*merge conflicts*) terjadi setiap hari, dan kesalahan kecil pada satu fitur dapat meruntuhkan seluruh aplikasi.</p>
<p>Memasuki tahun 2026, standar baku pengembangan aplikasi Android enterprise berpusat pada <strong>Arsitektur Multi-Modul</strong> yang dipadukan dengan <strong>Type-Safe Navigation di Jetpack Compose</strong>.</p>

<img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?auto=format&fit=crop&w=1200&q=80" alt="Antarmuka pengembangan aplikasi mobile modern di laptop" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Strategi Pembagian Modul: Core vs Feature Modules</h2>
<p>Alih-alih membagi modul berdasarkan layer teknis semata (misal: modul-ui, modul-data), strategi modularisasi modern membaginya berdasarkan kapabilitas domain bisnis:</p>
<ul>
    <li><strong>:core:designsystem:</strong> Komponen UI terstandardisasi (tema warna, tipografi, tombol kustom, dan ikon) yang digunakan di seluruh aplikasi.</li>
    <li><strong>:core:network & :core:database:</strong> Klien HTTP (Ktor / Retrofit) dan instance basis data lokal (Room / SQLDelight) yang terisolasi.</li>
    <li><strong>:feature:auth, :feature:dashboard, :feature:learning:</strong> Setiap fitur bisnis diisolasi sebagai modul mandiri yang tidak saling bergantung secara langsung (<em>zero direct dependency between features</em>).</li>
</ul>

<h3>Manfaat Masif Compilation Avoidance di Gradle</h3>
<p>Ketika seorang pengembang hanya mengubah file antarmuka di <code>:feature:learning</code>, mesin Gradle tidak perlu mengompilasi ulang modul <code>:feature:auth</code> atau <code>:core:network</code>. Hasilnya, siklus build incremental berkurang drastis dari 8 menit menjadi di bawah 25 detik!</p>

<h2>2. Type-Safe Navigation di Jetpack Compose</h2>
<p>Generasi awal Navigation Compose mengandalkan String URL route (mirip tautan web seperti <code>"profile/{userId}"</code>) yang sangat rawan memicu crash (*runtime exception*) akibat salah ketik parameter nama.</p>
<p>Kini dengan integrasi pustaka resmi <strong>Kotlinx Serialization</strong>, rute navigasi didefinisikan murni sebagai class data bertipe kuat:</p>
<pre class="ql-syntax">import kotlinx.serialization.Serializable

// Definisikan rute dan argumen bertipe kuat (Type-Safe)
@Serializable
object HomeRoute

@Serializable
data class CourseDetailRoute(val courseId: String, val level: Int)

// Di dalam NavHost Compose:
NavHost(navController = navController, startDestination = HomeRoute) {
    composable&lt;HomeRoute&gt; {
        HomeScreen(onCourseClick = { id -&gt;
            navController.navigate(CourseDetailRoute(courseId = id, level = 1))
        })
    }
    composable&lt;CourseDetailRoute&gt; { backStackEntry -&gt;
        val detail: CourseDetailRoute = backStackEntry.toRoute()
        CourseDetailScreen(courseId = detail.courseId, level = detail.level)
    }
}</pre>
<p>Compiler Kotlin akan langsung menolak proses kompilasi jika ada argumen wajib yang lupa disertakan. Tidak ada lagi crash layar putih di tangan pengguna akhir!</p>

<img src="https://images.unsplash.com/photo-1607252650355-f7fd0460ccdb?auto=format&fit=crop&w=1200&q=80" alt="Robot sistem operasi Android dan grafis interaktif teknologi mobile" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>3. Kesimpulan & Panduan Migrasi</h2>
<p>Bagi Anda yang sedang merintis aplikasi skala menengah ke atas, mulailah dengan mengekstrak modul <code>:core:model</code> dan <code>:core:network</code> terlebih dahulu. Dengan arsitektur yang modular dan navigasi yang aman, aplikasi Anda siap diskalakan ke jutaan pengguna tanpa mengorbankan kecepatan rilis fitur baru.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?auto=format&fit=crop&w=1200&q=80',
                'author_id' => 1,
                'author_name' => 'Vicky Koroh',
                'views_count' => 0,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ARTIKEL ANDROID 6: Optimasi Baseline Profiles & R8
            [
                'title' => 'Kompilasi Ahead-Of-Time (AOT), Baseline Profiles, dan R8: Cara Menghasilkan Aplikasi Android Instan Tanpa Lag',
                'slug' => 'optimasi-baseline-profiles-r8-kompilasi-aot-android',
                'category' => 'android',
                'summary' => 'Rahasia performa aplikasi startup instan (cold start) di bawah 500ms pada Android: cara kerja Android Runtime (ART), pembuatan Baseline Profiles dengan Macrobenchmark, dan teknik canggih optimasi ukuran APK dengan R8 Proguard tree shaking.',
                'content' => '<p>Kesan pertama pengguna terhadap sebuah aplikasi ditentukan dalam 3 detik pertama. Jika aplikasi membutuhkan waktu lebih dari 5 detik hanya untuk memuat layar pembuka (*cold start*), atau mengalami frame drop (patah-patah) saat pengguna menggulir daftar berita pertama kali, kemungkinan besar pengguna akan memberikan rating bintang satu di Google Play Store atau bahkan langsung menghapus aplikasi tersebut.</p>
<p>Di balik layar, Android Runtime (ART) bekerja keras menyeimbangkan antara waktu instalasi APK dan kecepatan eksekusi kode. Memahami sinergi antara <strong>Baseline Profiles</strong> dan <strong>Kompiler R8</strong> adalah rahasia para raksasa teknologi dalam menyajikan aplikasi yang terasa instan dan sehalus sutra.</p>

<img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=1200&q=80" alt="Smartphone modern di tangan pengguna dengan layar grafis responsif cepat" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>1. Dilema JIT vs AOT di Android Runtime (ART)</h2>
<p>Dalam sejarah Android, kompilasi kode telah melalui beberapa revolusi besar:</p>
<ol>
    <li><strong>Dalvik JIT (Just-In-Time):</strong> Kode dikompilasi ke instruksi mesin saat aplikasi sedang berjalan. Efeknya: proses startup lambat dan ponsel terasa panas karena CPU bekerja ganda menerjemahkan bytecode.</li>
    <li><strong>ART AOT Murni (Android 5-6):</strong> Seluruh kode dikompilasi saat instalasi. Efeknya: waktu unduh dan instalasi aplikasi sangat lama hingga menghabiskan ruang penyimpanan.</li>
    <li><strong>Cloud Profiles & Baseline Profiles (Android Modern):</strong> Sistem hibrida cerdas. Hanya alur kritis (startup dan render halaman beranda) yang dikompilasi AOT terlebih dahulu, sedangkan fitur yang jarang dibuka tetap menggunakan JIT.</li>
</ol>

<h2>2. Apa Itu Baseline Profiles dan Bagaimana Cara Kerjanya?</h2>
<p><strong>Baseline Profiles</strong> adalah daftar kelas dan method kritis yang dibundel langsung ke dalam file APK/AAB saat proses rilis di Google Play Store. Ketika pengguna mengunduh aplikasi, ART di perangkat pengguna langsung mengompilasi rute kritis tersebut menjadi kode mesin asli (native machine code) bahkan sebelum aplikasi dibuka pertama kali.</p>

<h3>Hasil Pengujian di Lapangan:</h3>
<ul>
    <li><strong>Kecepatan Startup (Cold Start):</strong> Meningkat 30% hingga 45% lebih cepat (membuka aplikasi di bawah 500 milidetik).</li>
    <li><strong>Pencegahan Frame Jank (ANR):</strong> Menghilangkan lag saat scrolling list berita atau feed pertama kali hingga 40%.</li>
</ul>

<h3>Cara Mengenerate Baseline Profile dengan Macrobenchmark:</h3>
<pre class="ql-syntax">@OptIn(ExperimentalBaselineProfilesApi::class)
class GenerateBaselineProfile {
    @get:Rule
    val baselineProfileRule = BaselineProfileRule()

    @Test
    fun generate() = baselineProfileRule.collect(
        packageName = "online.vxai.app"
    ) {
        pressHome()
        startActivityAndWait()
        // Simulasikan alur pengguna yang paling krusial
        device.findObject(By.text("Berita Terkini")).click()
        device.waitForIdle()
    }
}</pre>

<img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80" alt="Grafik analitik data performa sistem digital dan efisiensi memori" style="width:100%;border-radius:16px;margin:24px 0;box-shadow:0 10px 25px rgba(0,0,0,0.1);">

<h2>3. Optimasi Ukuran File dengan R8 Tree-Shaking</h2>
<p>Selain kecepatan eksekusi, ukuran unduhan APK menentukan tingkat retensi pengguna di wilayah dengan koneksi seluler terbatas. Kompiler <strong>R8</strong> melakukan serangkaian transformasi mikro tingkat lanjut:</p>
<ul>
    <li><strong>Tree Shaking (Eliminasi Dead Code):</strong> Menghapus kelas dan fungsi pustaka eksternal yang tidak pernah dipanggil oleh kode Anda.</li>
    <li><strong>Inlining Method:</strong> Menggabungkan method-method kecil ke dalam pemanggilnya untuk menghemat overhead pemanggilan stack memori.</li>
    <li><strong>Resource Shrinking:</strong> Otomatis menghapus file gambar XML, string, dan layout yang tidak terpakai dari file binary APK final.</li>
</ul>
<p>Dengan memadukan Baseline Profiles dan konfigurasi R8 yang terkalibrasi, aplikasi Android Anda tidak hanya memiliki ukuran file yang ramping, tetapi juga menghadirkan pengalaman pengguna kelas dunia yang responsif dan tanpa jeda.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=1200&q=80',
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
