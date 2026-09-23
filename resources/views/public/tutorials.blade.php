@extends('layouts.public')

@section('title', 'Panduan Koding & Kurikulum Lengkap (HTML5, CSS3, JavaScript) - ' . ($settings['app_name'] ?? 'VxAI'))
@section('meta_description', 'Kurikulum dan panduan terlengkap belajar pemrograman web dari dasar hingga mahir: HTML5 semantik, CSS3 Flexbox & Grid modern, serta JavaScript DOM interaktif.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Hero Header -->
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-extrabold uppercase tracking-wider border border-blue-200">
            Kurikulum Terbuka & Berjenjang
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 mt-4 mb-4 tracking-tight leading-tight">
            Panduan Lengkap <span class="text-blue-600">Pemrograman Web</span> Modern
        </h1>
        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
            Materi terstruktur dari tingkat dasar hingga mahir yang disusun khusus untuk siswa SMKN 1 Kupang Barat dan siapa saja yang ingin menguasai teknologi web. Setiap topik dilengkapi studi kasus yang bisa langsung Anda uji di <strong>Live Playground</strong>.
        </p>

        <!-- Quick Jump Bar -->
        <div class="flex flex-wrap justify-center gap-2 mt-8">
            <a href="#modul-html" class="px-4 py-2 rounded-xl text-xs font-bold bg-white text-orange-600 border border-orange-200 hover:bg-orange-50 shadow-sm transition">
                🟧 Tingkat 1: HTML5 Fondasi
            </a>
            <a href="#modul-css" class="px-4 py-2 rounded-xl text-xs font-bold bg-white text-blue-600 border border-blue-200 hover:bg-blue-50 shadow-sm transition">
                🟦 Tingkat 2: CSS3 Tata Letak
            </a>
            <a href="#modul-js" class="px-4 py-2 rounded-xl text-xs font-bold bg-white text-amber-600 border border-amber-200 hover:bg-amber-50 shadow-sm transition">
                🟨 Tingkat 3: JavaScript Interaktif
            </a>
            <a href="#modul-proyek" class="px-4 py-2 rounded-xl text-xs font-bold bg-white text-purple-600 border border-purple-200 hover:bg-purple-50 shadow-sm transition">
                🟪 Tingkat 4: Proyek Mandiri
            </a>
            <a href="{{ route('public.playground') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                ⚡ Buka Playground
            </a>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODUL 1: FONDASI HTML5                                   -->
    <!-- ======================================================== -->
    <section id="modul-html" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm mb-12 scroll-mt-24">
        
        <div class="flex items-center justify-between flex-wrap gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <span class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-sm">
                    1
                </span>
                <div>
                    <span class="text-[11px] font-bold text-orange-600 uppercase tracking-wider">Tingkat 1 • Fondasi Utama</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">HTML5: Kerangka & Struktur Web</h2>
                    <p class="text-xs text-slate-500 mt-0.5">HyperText Markup Language menyusun seluruh teks, gambar, formulir, dan struktur dokumen.</p>
                </div>
            </div>
            <a href="{{ route('public.playground') }}?challenge=html_struktur" class="bg-orange-50 hover:bg-orange-600 text-orange-700 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-orange-200">
                <span>⚡</span> <span>Uji Latihan HTML di Playground</span>
            </a>
        </div>

        <div class="space-y-8 text-sm text-slate-700 leading-relaxed">
            
            <!-- 1.1 Struktur Dokumen -->
            <div>
                <h3 class="text-base font-extrabold text-slate-900 mb-2">1.1 Struktur Dokumen Standar HTML5</h3>
                <p class="text-xs text-slate-600 mb-3">Setiap file website diawali dengan deklarasi tipe dokumen dan struktur pembungkus utama:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">&lt;!DOCTYPE html&gt;
&lt;html lang="id"&gt;
  &lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;Judul Halaman Web Saya&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
    &lt;h1&gt;Selamat Datang di Dunia Pemrograman!&lt;/h1&gt;
    &lt;p&gt;Ini adalah paragraf konten utama website.&lt;/p&gt;
  &lt;/body&gt;
&lt;/html&gt;</pre>
            </div>

            <!-- 1.2 Hirarki Teks & Tautan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div>
                    <h4 class="font-extrabold text-slate-900 mb-2 text-xs uppercase tracking-wider text-orange-600">Hirarki Judul & Teks</h4>
                    <p class="text-xs text-slate-600 mb-3">Gunakan heading untuk struktur dokumen yang ramah mesin pencari (SEO):</p>
                    <ul class="space-y-1.5 text-xs text-slate-600">
                        <li><code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono font-bold text-slate-800">&lt;h1&gt;</code>: Judul utama halaman (wajib hanya 1 per halaman).</li>
                        <li><code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono font-bold text-slate-800">&lt;h2&gt; - &lt;h6&gt;</code>: Subjudul berjenjang.</li>
                        <li><code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono font-bold text-slate-800">&lt;p&gt;</code>: Paragraf teks biasa.</li>
                        <li><code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono font-bold text-slate-800">&lt;strong&gt;</code>: Menebalkan teks penting.</li>
                        <li><code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono font-bold text-slate-800">&lt;em&gt;</code>: Memiringkan teks penekanan.</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-extrabold text-slate-900 mb-2 text-xs uppercase tracking-wider text-orange-600">Tautan & Gambar</h4>
                    <p class="text-xs text-slate-600 mb-3">Menghubungkan halaman dan menampilkan media visual:</p>
                    <pre class="bg-slate-900 text-slate-200 p-4 rounded-xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">&lt;!-- Tautan Eksternal --&gt;
&lt;a href="https://vxai.online" target="_blank"&gt;Buka VxAI&lt;/a&gt;

&lt;!-- Menyisipkan Gambar --&gt;
&lt;img src="logo.png" alt="Deskripsi Gambar" width="200"&gt;</pre>
                </div>
            </div>

            <!-- 1.3 Formulir Interaktif -->
            <div class="pt-4 border-t border-slate-100">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-base font-extrabold text-slate-900">1.2 Formulir Input & Pengumpulan Data</h3>
                    <a href="{{ route('public.playground') }}?challenge=html_formulir" class="text-xs font-bold text-blue-600 hover:underline">
                        Coba Form Ini di Playground ➔
                    </a>
                </div>
                <p class="text-xs text-slate-600 mb-3">Formulir memungkinkan pengguna mengirimkan input teks, kata sandi, pilihan dropdown, dan tombol submit:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">&lt;form action="/simpan" method="POST"&gt;
  &lt;label for="nama"&gt;Nama Lengkap:&lt;/label&gt;
  &lt;input type="text" id="nama" name="nama" placeholder="Ketik nama Anda" required&gt;

  &lt;label for="email"&gt;Email Pengguna:&lt;/label&gt;
  &lt;input type="email" id="email" name="email" required&gt;

  &lt;label for="jurusan"&gt;Jurusan:&lt;/label&gt;
  &lt;select id="jurusan" name="jurusan"&gt;
    &lt;option value="RPL"&gt;Rekayasa Perangkat Lunak&lt;/option&gt;
    &lt;option value="TKJ"&gt;Teknik Komputer & Jaringan&lt;/option&gt;
  &lt;/select&gt;

  &lt;button type="submit"&gt;Kirim Formulir&lt;/button&gt;
&lt;/form&gt;</pre>
            </div>

            <!-- 1.4 Elemen Semantik Modern -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900 mb-2">1.3 Elemen Semantik HTML5 (Standar Industri)</h3>
                <p class="text-xs text-slate-600 mb-4">Gunakan tag semantik dibanding tag `&lt;div&gt;` polos untuk meningkatkan aksesibilitas dan kemudahan dibaca mesin:</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <strong class="text-orange-600 block mb-1">&lt;header&gt;</strong>
                        Kepala dokumen, logo, dan navigasi situs.
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <strong class="text-orange-600 block mb-1">&lt;nav&gt;</strong>
                        Kumpulan tautan menu navigasi website.
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <strong class="text-orange-600 block mb-1">&lt;main&gt;</strong>
                        Konten pokok dan unik dari satu halaman.
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <strong class="text-orange-600 block mb-1">&lt;footer&gt;</strong>
                        Kaki halaman berisi hak cipta & kontak.
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ======================================================== -->
    <!-- MODUL 2: SENI & TATA LETAK CSS3                          -->
    <!-- ======================================================== -->
    <section id="modul-css" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm mb-12 scroll-mt-24">
        
        <div class="flex items-center justify-between flex-wrap gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <span class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-sm">
                    2
                </span>
                <div>
                    <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Tingkat 2 • Desain & Estetika</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">CSS3: Tata Letak, Flexbox & Grid Modern</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Cascading Style Sheets mengatur warna, tipografi, jarak (spacing), dan animasi layar.</p>
                </div>
            </div>
            <a href="{{ route('public.playground') }}?challenge=css_flexbox" class="bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-blue-200">
                <span>⚡</span> <span>Uji Flexbox di Playground</span>
            </a>
        </div>

        <div class="space-y-8 text-sm text-slate-700 leading-relaxed">
            
            <!-- 2.1 CSS Box Model -->
            <div>
                <h3 class="text-base font-extrabold text-slate-900 mb-2">2.1 Memahami CSS Box Model</h3>
                <p class="text-xs text-slate-600 mb-4">Setiap elemen di web adalah kotak empat persegi panjang yang terdiri dari 4 lapisan:</p>
                
                <div class="bg-slate-900 text-slate-100 p-6 rounded-2xl font-mono text-xs border border-slate-800 text-center max-w-lg mx-auto mb-4">
                    <div class="border-2 border-dashed border-amber-500 p-3 rounded-xl bg-amber-500/10">
                        <span class="text-amber-400 font-bold block mb-1">MARGIN (Ruang Luar)</span>
                        <div class="border-2 border-blue-500 p-3 rounded-lg bg-blue-500/10">
                            <span class="text-blue-400 font-bold block mb-1">BORDER (Garis Tepi)</span>
                            <div class="border-2 border-emerald-500 p-3 rounded bg-emerald-500/10">
                                <span class="text-emerald-400 font-bold block mb-1">PADDING (Ruang Dalam)</span>
                                <div class="bg-slate-800 p-2 rounded text-white font-bold">
                                    CONTENT (Teks / Gambar)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <pre class="bg-slate-900 text-slate-200 p-4 rounded-xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">.kotak {
  box-sizing: border-box; /* Sangat disarankan agar padding tidak merusak lebar */
  width: 300px;
  padding: 1.5rem;       /* Jarak ke dalam */
  border: 1px solid #38bdf8;
  margin: 1rem auto;     /* Jarak ke luar (tengah) */
  border-radius: 1rem;   /* Sudut bulat */
}</pre>
            </div>

            <!-- 2.2 Flexbox Lengkap -->
            <div class="pt-4 border-t border-slate-100">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-base font-extrabold text-slate-900">2.2 Master Tata Letak Flexbox</h3>
                    <a href="{{ route('public.playground') }}?challenge=css_flexbox" class="text-xs font-bold text-blue-600 hover:underline">
                        Muat Latihan Flexbox ➔
                    </a>
                </div>
                <p class="text-xs text-slate-600 mb-3">Flexbox adalah standar industri untuk menyusun elemen 1 dimensi (baris atau kolom) secara rapi:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">/* Kontainer Induk (Parent) */
.baris-sejajar {
  display: flex;
  flex-direction: row;            /* default: 'row' (mendatar) atau 'column' (menurun) */
  justify-content: space-between; /* Perataan horizontal: flex-start, center, space-between */
  align-items: center;            /* Perataan vertikal: center, flex-start, stretch */
  gap: 1.5rem;                    /* Jarak otomatis antar elemen anak */
  flex-wrap: wrap;                /* Turun ke bawah jika layar sempit di HP */
}

/* Elemen Anak (Child) */
.item-anak {
  flex: 1;                        /* Membagi lebar secara merata */
  min-width: 250px;
}</pre>
            </div>

            <!-- 2.3 CSS Grid -->
            <div class="pt-4 border-t border-slate-100">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-base font-extrabold text-slate-900">2.3 CSS Grid untuk Galeri & Portofolio</h3>
                    <a href="{{ route('public.playground') }}?challenge=css_grid" class="text-xs font-bold text-blue-600 hover:underline">
                        Muat Latihan CSS Grid ➔
                    </a>
                </div>
                <p class="text-xs text-slate-600 mb-3">CSS Grid sempurna untuk tata letak 2 dimensi (baris dan kolom sekaligus). Sangat cocok untuk galeri kartu:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">.galeri-grid {
  display: grid;
  /* Otomatis menambah atau mengurangi kolom sesuai ukuran layar */
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 1.5rem;
}</pre>
            </div>

            <!-- 2.4 Media Queries Responsif Layar -->
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-base font-extrabold text-slate-900 mb-2">2.4 Desain Responsif dengan Media Queries</h3>
                <p class="text-xs text-slate-600 mb-3">Memastikan website tampil sempurna di smartphone (HP), tablet, maupun monitor desktop:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">/* Gaya default untuk Desktop / Layar Lebar */
.navigasi { display: flex; gap: 2rem; }

/* Jika dibuka di layar HP (lebar maksimal 768px) */
@media (max-width: 768px) {
  .navigasi {
    flex-direction: column; /* Ubah menu mendatar menjadi menurun */
    gap: 0.75rem;
  }
}</pre>
            </div>

        </div>
    </section>

    <!-- ======================================================== -->
    <!-- MODUL 3: JAVASCRIPT LOGIKA & INTERAKTIVITAS              -->
    <!-- ======================================================== -->
    <section id="modul-js" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm mb-12 scroll-mt-24">
        
        <div class="flex items-center justify-between flex-wrap gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <span class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-sm">
                    3
                </span>
                <div>
                    <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Tingkat 3 • Logika & Interaktivitas</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">JavaScript: DOM & Aksi Pengguna</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Bahasa skrip yang menghidupkan website: merespon klik tombol, validasi, dan alur aplikasi.</p>
                </div>
            </div>
            <a href="{{ route('public.playground') }}?challenge=js_counter_theme" class="bg-amber-50 hover:bg-amber-600 text-amber-700 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-amber-200">
                <span>⚡</span> <span>Uji JavaScript di Playground</span>
            </a>
        </div>

        <div class="space-y-8 text-sm text-slate-700 leading-relaxed">
            
            <!-- 3.1 Variabel & Fungsi -->
            <div>
                <h3 class="text-base font-extrabold text-slate-900 mb-2">3.1 Variabel Modern (`const` & `let`) dan Fungsi</h3>
                <p class="text-xs text-slate-600 mb-3">Gunakan `const` untuk nilai yang tidak berubah dan `let` untuk nilai yang akan bertambah atau berganti:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">// Deklarasi Variabel
const namaSekolah = "SMKN 1 Kupang Barat";
let jumlahSiswa = 350;

// Arrow Function Modern
const beriSalam = (nama) => {
  return `Halo ${nama}, selamat datang di ${namaSekolah}!`;
};

console.log(beriSalam("Budi"));</pre>
            </div>

            <!-- 3.2 Manipulasi DOM & Event Listener -->
            <div class="pt-4 border-t border-slate-100">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-base font-extrabold text-slate-900">3.2 Menangkap Elemen & Mendengarkan Event Klik</h3>
                    <a href="{{ route('public.playground') }}?challenge=js_counter_theme" class="text-xs font-bold text-blue-600 hover:underline">
                        Coba Counter di Playground ➔
                    </a>
                </div>
                <p class="text-xs text-slate-600 mb-3">DOM (Document Object Model) adalah jembatan antara JavaScript dan elemen HTML:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">// 1. Tangkap elemen HTML berdasarkan ID
const tombol = document.getElementById("tombol-klik");
const labelAngka = document.getElementById("nilai-angka");

let counter = 0;

// 2. Pasang pendengar aksi klik (Event Listener)
tombol.addEventListener("click", function() {
  counter++;
  labelAngka.innerText = counter; // Perbarui teks di layar secara langsung!
  
  if (counter >= 10) {
    labelAngka.classList.add("text-sukses"); // Tambah class CSS
  }
});</pre>
            </div>

            <!-- 3.3 Membuat Aplikasi To-Do List -->
            <div class="pt-4 border-t border-slate-100">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-base font-extrabold text-slate-900">3.3 Menambah Elemen HTML Baru Secara Dinamis</h3>
                    <a href="{{ route('public.playground') }}?challenge=js_todolist" class="text-xs font-bold text-blue-600 hover:underline">
                        Buka Latihan To-Do List ➔
                    </a>
                </div>
                <p class="text-xs text-slate-600 mb-3">Membuat elemen baru `createElement` dan menyisipkannya ke dalam daftar `appendChild`:</p>
                <pre class="bg-slate-900 text-slate-200 p-5 rounded-2xl text-xs font-mono overflow-x-auto leading-relaxed border border-slate-800">function tambahTugasBaru(isiTugas) {
  const list = document.getElementById("daftar-tugas");
  
  // Buat tag &lt;li&gt; baru
  const itemBaru = document.createElement("li");
  itemBaru.innerText = isiTugas;
  
  // Klik untuk menandai selesai
  itemBaru.addEventListener("click", () => {
    itemBaru.classList.toggle("selesai");
  });

  // Masukkan ke dalam daftar
  list.appendChild(itemBaru);
}</pre>
            </div>

        </div>
    </section>

    <!-- ======================================================== -->
    <!-- MODUL 4: PROYEK PRAKTIK MANDIRI                          -->
    <!-- ======================================================== -->
    <section id="modul-proyek" class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm mb-12 scroll-mt-24">
        
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <span class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-sm">
                4
            </span>
            <div>
                <span class="text-[11px] font-bold text-purple-600 uppercase tracking-wider">Tingkat 4 • Portofolio & Proyek Nyata</span>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Katalog Latihan & Tantangan Terpadu</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih proyek di bawah ini untuk langsung dikerjakan di Live Playground satu-klik:</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            
            <!-- Proyek 1 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex flex-col justify-between hover:border-blue-400 transition">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                        🟢 Tingkat 1: Pemula
                    </span>
                    <h3 class="font-extrabold text-base text-slate-900 mt-2 mb-1">Struktur Web & Formulir Pendaftaran</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Latihan menyusun profil diri, heading, paragraf, serta form registrasi siswa dengan validasi HTML5.
                    </p>
                </div>
                <a href="{{ route('public.playground') }}?challenge=html_formulir" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition text-center">
                    ⚡ Kerjakan Proyek Ini ➔
                </a>
            </div>

            <!-- Proyek 2 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex flex-col justify-between hover:border-blue-400 transition">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-300">
                        🔵 Tingkat 2: Menengah
                    </span>
                    <h3 class="font-extrabold text-base text-slate-900 mt-2 mb-1">Tata Letak Flexbox & Grid Portofolio</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Membuat navbar responsif, hero section, dan kartu galeri karya otomatis yang rapi di layar HP dan laptop.
                    </p>
                </div>
                <a href="{{ route('public.playground') }}?challenge=css_flexbox" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition text-center">
                    ⚡ Kerjakan Proyek Ini ➔
                </a>
            </div>

            <!-- Proyek 3 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex flex-col justify-between hover:border-blue-400 transition">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-300">
                        🟣 Tingkat 3: Mahir
                    </span>
                    <h3 class="font-extrabold text-base text-slate-900 mt-2 mb-1">Aplikasi To-Do List Interaktif</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Aplikasi manajemen tugas: menambah catatan baru, menandai selesai dengan coret teks, dan menghapus tugas.
                    </p>
                </div>
                <a href="{{ route('public.playground') }}?challenge=js_todolist" class="bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition text-center">
                    ⚡ Kerjakan Proyek Ini ➔
                </a>
            </div>

            <!-- Proyek 4 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex flex-col justify-between hover:border-blue-400 transition">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-300">
                        🟣 Tingkat 3: Mahir
                    </span>
                    <h3 class="font-extrabold text-base text-slate-900 mt-2 mb-1">Simulator Obrolan AI Tutor Interaktif</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Membangun antarmuka obrolan cerdas yang membalas pertanyaan koding pengguna secara otomatis.
                    </p>
                </div>
                <a href="{{ route('public.playground') }}?challenge=js_ai_bot" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition text-center">
                    ⚡ Kerjakan Proyek Ini ➔
                </a>
            </div>

        </div>
    </section>

    <!-- Banner Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 rounded-3xl p-8 sm:p-12 text-white text-center shadow-xl">
        <h2 class="text-2xl sm:text-3xl font-black mb-3">Siap Menguji Kemampuan Koding Anda?</h2>
        <p class="text-blue-100 max-w-xl mx-auto text-xs sm:text-sm mb-6 leading-relaxed">
            Pilih latihan di Live Playground, ketik kode Anda, lihat hasilnya secara real-time, dan simpan agar dapat dievaluasi langsung oleh guru pengajar!
        </p>
        <a href="{{ route('public.playground') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white text-blue-600 font-extrabold text-sm shadow-xl hover:bg-blue-50 transition transform hover:-translate-y-0.5">
            <span>⚡ Mulai Latihan di Playground Sekarang</span>
        </a>
    </div>

</div>
@endsection

