<?php

namespace App\Services;

use App\Models\PlaygroundChallenge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PlaygroundChallengeService
{
    public const VERSION = '2026_09_24_playground_v1';

    /**
     * Dapatkan 10 modul tantangan default persis seperti yang telah teruji.
     */
    public static function getDefaultChallenges(): array
    {
        return [
            // TINGKAT 1: PEMULA (HTML5)
            [
                'slug' => 'html_struktur',
                'level' => 'pemula',
                'level_badge' => '🟢 Pemula (HTML5)',
                'category' => 'html',
                'title' => 'Latihan 1: Struktur Web & Format Teks',
                'desc' => 'Pelajari susunan dasar tag HTML5, judul, paragraf, penekanan teks, dan tautan halaman.',
                'instructions' => [
                    'Ubah judul `<h1>` menjadi nama lengkap Anda.',
                    'Tuliskan satu paragraf `<p>` yang menceritakan alasan Anda ingin belajar koding.',
                    'Tambahkan tag `<strong>` pada kata kunci penting dan `<em>` untuk teks miring.',
                    'Ubah atribut `href` pada link `<a>` agar mengarah ke website SMKN 1 Kupang Barat atau situs favorit Anda.'
                ],
                'html_code' => '<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Programmer Pemula</title>
</head>
<body>
  <header>
    <h1>Halo, Dunia Pemrograman! 🌍</h1>
    <p>Saya sedang memulai perjalanan koding web interaktif bersama <strong>VxAI Platform</strong>.</p>
  </header>
  
  <main>
    <p>Koding itu <em>sangat seru dan melatih logika berpikir</em>.</p>
    <a href="https://vxai.online" target="_blank">Kunjungi Portal Utama VxAI &rarr;</a>
  </main>
</body>
</html>',
                'css_code' => 'body {
  font-family: \'Plus Jakarta Sans\', system-ui, sans-serif;
  background-color: #0f172a;
  color: #f1f5f9;
  padding: 3rem 1.5rem;
  max-width: 640px;
  margin: 0 auto;
  line-height: 1.6;
}
h1 {
  color: #38bdf8;
  font-size: 2rem;
  margin-bottom: 0.5rem;
}
a {
  display: inline-block;
  margin-top: 1.25rem;
  color: #60a5fa;
  text-decoration: none;
  font-weight: bold;
}
a:hover {
  text-decoration: underline;
}',
                'js_code' => 'console.log("Latihan 1 siap dijalankan!");',
                'order_num' => 1,
                'is_active' => true,
            ],

            [
                'slug' => 'html_formulir',
                'level' => 'pemula',
                'level_badge' => '🟢 Pemula (HTML5)',
                'category' => 'html',
                'title' => 'Latihan 2: Formulir Pendaftaran Siswa',
                'desc' => 'Membangun form kontak interaktif dengan validasi input teks, email, dan respon submit.',
                'instructions' => [
                    'Lengkapi form dengan kolom input nama dan email.',
                    'Tambahkan atribut `required` agar form tidak bisa dikirim jika kolom kosong.',
                    'Tekan tombol "Kirim Pendaftaran" dan amati respon ucapan selamat di bawahnya.'
                ],
                'html_code' => '<div class="form-card">
  <h2>Pendaftaran Siswa Baru 🎓</h2>
  <p>Lengkapi formulir singkat di bawah ini:</p>
  
  <form id="form-daftar">
    <div class="form-group">
      <label for="nama">Nama Lengkap Siswa</label>
      <input type="text" id="nama" placeholder="Misal: Vicky Sanjaya" required>
    </div>

    <div class="form-group">
      <label for="email">Alamat Email / NISN</label>
      <input type="email" id="email" placeholder="siswa@sekolah.sch.id" required>
    </div>

    <button type="submit" id="btn-submit-form">Kirim Pendaftaran &rarr;</button>
  </form>

  <div id="notifikasi-sukses" class="alert-box"></div>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #090d16;
  color: #f8fafc;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.form-card {
  background: #1e293b;
  padding: 2rem 2.5rem;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5);
  border: 1px solid #334155;
}
h2 { color: #38bdf8; margin: 0 0 0.5rem 0; font-size: 1.5rem; }
p { color: #94a3b8; font-size: 0.85rem; margin-bottom: 1.5rem; }
.form-group { margin-bottom: 1.25rem; text-align: left; }
label { display: block; font-size: 0.8rem; font-weight: bold; margin-bottom: 0.5rem; color: #cbd5e1; }
input {
  width: 100%;
  box-sizing: border-box;
  padding: 0.75rem 1rem;
  background: #0f172a;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  color: white;
  outline: none;
  font-size: 0.9rem;
}
input:focus { border-color: #38bdf8; ring: 2px #38bdf8; }
button {
  width: 100%;
  padding: 0.85rem;
  background: #2563eb;
  color: white;
  border: none;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
  transition: 0.2s;
  font-size: 0.95rem;
}
button:hover { background: #1d4ed8; }
.alert-box {
  display: none;
  margin-top: 1.25rem;
  padding: 0.85rem;
  background: #064e3b;
  color: #6ee7b7;
  border-radius: 0.75rem;
  font-size: 0.85rem;
  text-align: center;
  border: 1px solid #059669;
}',
                'js_code' => 'document.getElementById(\'form-daftar\').addEventListener(\'submit\', function(e) {
  e.preventDefault();
  const nama = document.getElementById(\'nama\').value;
  const alertBox = document.getElementById(\'notifikasi-sukses\');
  
  alertBox.style.display = \'block\';
  alertBox.innerHTML = \'🎉 Selamat <b>\' + nama + \'</b>, berkas pendaftaran Anda telah diterima sistem!\';
});',
                'order_num' => 2,
                'is_active' => true,
            ],

            [
                'slug' => 'html_tabel',
                'level' => 'pemula',
                'level_badge' => '🟢 Pemula (HTML5)',
                'category' => 'html',
                'title' => 'Latihan 3: Tabel Data Nilai Siswa',
                'desc' => 'Menyusun tabel data terstruktur dengan thead, tbody, baris, kolom, dan badge status.',
                'instructions' => [
                    'Pelajari struktur tag `<table>`, `<thead>`, `<tbody>`, `<tr>`, `<th>`, dan `<td>`.',
                    'Tambahkan satu baris siswa baru di dalam `<tbody>`.',
                    'Ubah status kelulusan dengan menambahkan class `badge-lulus` atau `badge-remedial`.'
                ],
                'html_code' => '<div class="table-container">
  <h2>Rekap Nilai Koding Web 📊</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Materi</th>
        <th>Skor</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Budi Pratama</td>
        <td>HTML5 Dasar</td>
        <td>95</td>
        <td><span class="badge badge-lulus">Lulus</span></td>
      </tr>
      <tr>
        <td>2</td>
        <td>Siti Rahma</td>
        <td>CSS3 Flexbox</td>
        <td>88</td>
        <td><span class="badge badge-lulus">Lulus</span></td>
      </tr>
      <tr>
        <td>3</td>
        <td>Ahmad Dani</td>
        <td>JavaScript DOM</td>
        <td>65</td>
        <td><span class="badge badge-remedial">Remedial</span></td>
      </tr>
    </tbody>
  </table>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #0f172a;
  color: #f8fafc;
  padding: 2.5rem 1.5rem;
}
.table-container {
  max-width: 700px;
  margin: 0 auto;
  background: #1e293b;
  padding: 2rem;
  border-radius: 1.5rem;
  border: 1px solid #334155;
}
h2 { color: #38bdf8; margin-top: 0; }
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
  font-size: 0.9rem;
}
th, td {
  padding: 0.85rem 1rem;
  text-align: left;
  border-bottom: 1px solid #334155;
}
th {
  background: #0f172a;
  color: #94a3b8;
  text-transform: uppercase;
  font-size: 0.75rem;
  letter-spacing: 0.05em;
}
tr:hover { background: #334155/30; }
.badge {
  padding: 0.25rem 0.6rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: bold;
}
.badge-lulus { background: #064e3b; color: #6ee7b7; }
.badge-remedial { background: #7f1d1d; color: #fca5a5; }',
                'js_code' => 'console.log("Tabel data berhasil dimuat!");',
                'order_num' => 3,
                'is_active' => true,
            ],

            // TINGKAT 2: MENENGAH (CSS3)
            [
                'slug' => 'css_flexbox',
                'level' => 'menengah',
                'level_badge' => '🔵 Menengah (CSS3)',
                'category' => 'css',
                'title' => 'Latihan 4: Tata Letak Flexbox Modern',
                'desc' => 'Menguasai perataan layout modern: navbar responsif, hero card, dan tombol sejajar rapi.',
                'instructions' => [
                    'Gunakan `display: flex` pada elemen kontainer navbar.',
                    'Atur perataan horizontal dengan `justify-content: space-between` dan vertikal dengan `align-items: center`.',
                    'Eksplorasi penataan 3 kartu keunggulan sejajar dengan properti `gap: 1.5rem`.'
                ],
                'html_code' => '<nav class="navbar">
  <div class="logo">⚡ VxAI Lab</div>
  <div class="nav-links">
    <a href="#">Beranda</a>
    <a href="#">Materi</a>
    <a href="#">Tantangan</a>
  </div>
  <button class="btn-login">Masuk</button>
</nav>

<div class="hero">
  <h1>Kuasai Flexbox Sekarang 🚀</h1>
  <p>Flexbox membuat penataan elemen sejajar menjadi sangat mudah dan presisi.</p>
  
  <div class="cards-container">
    <div class="card">
      <h3>⚡ Cepat</h3>
      <p>Tanpa float atau kalkulasi manual rumit.</p>
    </div>
    <div class="card">
      <h3>📱 Responsif</h3>
      <p>Menyesuaikan otomatis di layar HP dan laptop.</p>
    </div>
    <div class="card">
      <h3>🎯 Presisi</h3>
      <p>Elemen selalu terpusat sempurna di tengah.</p>
    </div>
  </div>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #0b1120;
  color: #f8fafc;
  margin: 0;
  padding: 0;
}
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background: #1e293b;
  border-bottom: 1px solid #334155;
}
.logo { font-weight: 900; font-size: 1.25rem; color: #38bdf8; }
.nav-links { display: flex; gap: 1.5rem; }
.nav-links a { color: #cbd5e1; text-decoration: none; font-size: 0.9rem; font-weight: 600; }
.nav-links a:hover { color: #38bdf8; }
.btn-login {
  background: #2563eb;
  color: white;
  border: none;
  padding: 0.5rem 1.2rem;
  border-radius: 9999px;
  font-weight: bold;
  cursor: pointer;
}
.hero {
  padding: 3rem 2rem;
  text-align: center;
  max-width: 900px;
  margin: 0 auto;
}
.cards-container {
  display: flex;
  gap: 1.5rem;
  margin-top: 2.5rem;
  flex-wrap: wrap;
}
.card {
  flex: 1;
  min-width: 220px;
  background: #1e293b;
  padding: 1.5rem;
  border-radius: 1.25rem;
  border: 1px solid #334155;
  text-align: left;
}
.card h3 { color: #38bdf8; margin-top: 0; }',
                'js_code' => 'console.log("Flexbox layout loaded successfully!");',
                'order_num' => 4,
                'is_active' => true,
            ],

            [
                'slug' => 'css_grid',
                'level' => 'menengah',
                'level_badge' => '🔵 Menengah (CSS3)',
                'category' => 'css',
                'title' => 'Latihan 5: CSS Grid Portofolio Responsif',
                'desc' => 'Membuat grid galeri kartu proyek otomatis dengan repeat auto-fit dan minmax.',
                'instructions' => [
                    'Gunakan `display: grid` pada kontainer galeri.',
                    'Terapkan `grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));` agar kolom otomatis fleksibel.',
                    'Beri jarak antar kartu dengan properti `gap: 1.5rem`.'
                ],
                'html_code' => '<div class="container">
  <div class="header">
    <h2>Portofolio Siswa SMKN 1 Kupang Barat 🌟</h2>
    <p>Koleksi karya koding website inovatif</p>
  </div>

  <div class="grid-gallery">
    <div class="project-card">
      <div class="badge">Web App</div>
      <h3>Sistem Perpustakaan</h3>
      <p>Aplikasi peminjaman buku digital dengan pencarian cepat.</p>
    </div>
    <div class="project-card">
      <div class="badge">AI Lab</div>
      <h3>Tutor Pintar AI</h3>
      <p>Asisten belajar mandiri untuk pemula pemrograman.</p>
    </div>
    <div class="project-card">
      <div class="badge">Frontend</div>
      <h3>Kalkulator Fisika</h3>
      <p>Simulasi rumus gerak dan gravitasi interaktif.</p>
    </div>
    <div class="project-card">
      <div class="badge">Game</div>
      <h3>Kuis Trivia Koding</h3>
      <p>Uji ketangkasan logika dengan leaderboard poin.</p>
    </div>
  </div>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #090e17;
  color: #f1f5f9;
  padding: 2.5rem 1.5rem;
  margin: 0;
}
.container { max-width: 1000px; margin: 0 auto; }
.header { text-align: center; margin-bottom: 2.5rem; }
.header h2 { color: #38bdf8; font-size: 1.8rem; margin: 0; }
.header p { color: #94a3b8; }
.grid-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
}
.project-card {
  background: #1e293b;
  padding: 1.75rem;
  border-radius: 1.25rem;
  border: 1px solid #334155;
  transition: transform 0.2s, border-color 0.2s;
}
.project-card:hover {
  transform: translateY(-5px);
  border-color: #38bdf8;
}
.badge {
  display: inline-block;
  background: #0284c7/30;
  color: #38bdf8;
  padding: 0.2rem 0.6rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: bold;
  margin-bottom: 1rem;
}
.project-card h3 { margin: 0 0 0.5rem 0; font-size: 1.15rem; }
.project-card p { color: #94a3b8; font-size: 0.85rem; line-height: 1.5; margin: 0; }',
                'js_code' => 'console.log("CSS Grid layout ready!");',
                'order_num' => 5,
                'is_active' => true,
            ],

            [
                'slug' => 'css_animation',
                'level' => 'menengah',
                'level_badge' => '🔵 Menengah (CSS3)',
                'category' => 'css',
                'title' => 'Latihan 6: Glassmorphism & Animasi Hover',
                'desc' => 'Menciptakan efek kaca transparan blur dan animasi hover interaktif modern.',
                'instructions' => [
                    'Gunakan `backdrop-filter: blur(16px)` untuk efek buram ala kaca transparan.',
                    'Gunakan transisi `transition: all 0.3s cubic-bezier(...)` untuk kehalusan gerakan.',
                    'Tambahkan animasi denyut `@keyframes glow` pada tombol aksi.'
                ],
                'html_code' => '<div class="background-scene">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="glass-box">
    <div class="icon">✨</div>
    <h2>Efek Glassmorphism</h2>
    <p>Desain kaca transparan modern yang elegan, lembut di mata, dan memberikan kedalaman visual.</p>
    <button class="btn-glow">Coba Efek Kaca</button>
  </div>
</div>',
                'css_code' => 'body {
  margin: 0;
  background: #0f172a;
  font-family: system-ui, sans-serif;
  color: white;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}
.background-scene { position: relative; padding: 2rem; }
.blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(60px);
  z-index: 0;
}
.blob-1 { width: 180px; height: 180px; background: #2563eb; top: -30px; left: -30px; }
.blob-2 { width: 180px; height: 180px; background: #ec4899; bottom: -30px; right: -30px; }
.glass-box {
  position: relative;
  z-index: 1;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1px solid rgba(255, 255, 255, 0.18);
  border-radius: 2rem;
  padding: 3rem 2.5rem;
  max-width: 380px;
  text-align: center;
  box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
  transition: transform 0.3s;
}
.glass-box:hover { transform: translateY(-8px); }
.icon { font-size: 2.5rem; margin-bottom: 1rem; }
h2 { margin: 0 0 0.75rem 0; font-size: 1.5rem; }
p { color: #cbd5e1; font-size: 0.9rem; line-height: 1.6; margin-bottom: 2rem; }
.btn-glow {
  background: linear-gradient(135deg, #38bdf8, #2563eb);
  color: white;
  border: none;
  padding: 0.8rem 1.8rem;
  border-radius: 9999px;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0 10px 20px -5px rgba(56, 189, 248, 0.5);
  transition: 0.2s;
}
.btn-glow:hover { transform: scale(1.05); }',
                'js_code' => 'console.log("Glassmorphism effect ready!");',
                'order_num' => 6,
                'is_active' => true,
            ],

            // TINGKAT 3: MAHIR (JAVASCRIPT & AI)
            [
                'slug' => 'js_counter_theme',
                'level' => 'mahir',
                'level_badge' => '🟣 Mahir (JavaScript)',
                'category' => 'javascript',
                'title' => 'Latihan 7: Counter & Pengalih Tema (Dark/Light)',
                'desc' => 'Manipulasi nilai angka di DOM, event listener klik, dan manipulasi class mode tampilan.',
                'instructions' => [
                    'Klik tombol `+` dan `-` untuk menambah dan mengurangi nilai counter.',
                    'Periksa logika JavaScript yang membatasi nilai minimum atau mengubah warna angka saat bernilai negatif.',
                    'Gunakan tombol "Alihkan Tema" untuk mengubah warna kartu antara tema terang dan gelap.'
                ],
                'html_code' => '<div class="card" id="main-card">
  <div class="top-bar">
    <span class="badge">Aplikasi Interaktif</span>
    <button id="btn-theme" class="theme-btn">☀️ Mode Terang</button>
  </div>

  <h2>Penghitung Angka (Counter) 🔢</h2>
  <div id="counter-value" class="counter-display">0</div>

  <div class="button-group">
    <button id="btn-dec" class="action-btn btn-danger">- Kurang</button>
    <button id="btn-reset" class="action-btn btn-neutral">↺ Reset</button>
    <button id="btn-inc" class="action-btn btn-success">+ Tambah</button>
  </div>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #090e17;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  transition: background 0.3s;
}
.card {
  background: #1e293b;
  color: #f8fafc;
  padding: 2.5rem;
  border-radius: 1.5rem;
  width: 360px;
  text-align: center;
  border: 1px solid #334155;
  box-shadow: 0 20px 25px rgba(0,0,0,0.4);
  transition: all 0.3s;
}
.card.light-mode {
  background: #ffffff;
  color: #0f172a;
  border-color: #cbd5e1;
}
.top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
.badge { font-size: 0.75rem; font-weight: bold; color: #38bdf8; }
.theme-btn {
  background: #334155;
  color: white;
  border: none;
  padding: 0.3rem 0.7rem;
  border-radius: 0.5rem;
  font-size: 0.75rem;
  cursor: pointer;
}
.card.light-mode .theme-btn { background: #e2e8f0; color: #0f172a; }
.counter-display {
  font-size: 4rem;
  font-weight: 900;
  color: #38bdf8;
  margin: 1.5rem 0;
  font-family: monospace;
}
.button-group { display: flex; gap: 0.75rem; justify-content: center; }
.action-btn {
  padding: 0.65rem 1.2rem;
  border-radius: 0.75rem;
  border: none;
  font-weight: bold;
  cursor: pointer;
  font-size: 0.9rem;
}
.btn-danger { background: #ef4444; color: white; }
.btn-neutral { background: #64748b; color: white; }
.btn-success { background: #10b981; color: white; }',
                'js_code' => 'let count = 0;
let isLight = false;

const counterDisplay = document.getElementById(\'counter-value\');
const card = document.getElementById(\'main-card\');
const themeBtn = document.getElementById(\'btn-theme\');

document.getElementById(\'btn-inc\').addEventListener(\'click\', () => {
  count++;
  counterDisplay.innerText = count;
});

document.getElementById(\'btn-dec\').addEventListener(\'click\', () => {
  count--;
  counterDisplay.innerText = count;
});

document.getElementById(\'btn-reset\').addEventListener(\'click\', () => {
  count = 0;
  counterDisplay.innerText = count;
});

themeBtn.addEventListener(\'click\', () => {
  isLight = !isLight;
  if (isLight) {
    card.classList.add(\'light-mode\');
    themeBtn.innerText = \'🌙 Mode Gelap\';
  } else {
    card.classList.remove(\'light-mode\');
    themeBtn.innerText = \'☀️ Mode Terang\';
  }
});',
                'order_num' => 7,
                'is_active' => true,
            ],

            [
                'slug' => 'js_todolist',
                'level' => 'mahir',
                'level_badge' => '🟣 Mahir (JavaScript)',
                'category' => 'javascript',
                'title' => 'Latihan 8: Aplikasi To-Do List Lengkap',
                'desc' => 'Membangun aplikasi manajemen kegiatan: tambah tugas baru, coret selesai, dan hapus tugas.',
                'instructions' => [
                    'Ketik tugas di kolom input dan klik tombol "Tambah".',
                    'Klik pada teks tugas untuk mencoret (menandai selesai).',
                    'Klik ikon hapus (✕) untuk membuang tugas dari daftar.'
                ],
                'html_code' => '<div class="todo-app">
  <h2>Daftar Tugas Koding 📝</h2>
  <div class="input-wrapper">
    <input type="text" id="input-todo" placeholder="Tulis tugas baru...">
    <button id="btn-add">Tambah</button>
  </div>

  <ul id="todo-list" class="list">
    <li class="completed"><span>Belajar Dasar HTML5</span><button class="btn-del">&times;</button></li>
    <li><span>Menyusun Tata Letak Flexbox</span><button class="btn-del">&times;</button></li>
  </ul>
  
  <div class="footer-info" id="todo-count">Total: 2 tugas</div>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #0f172a;
  color: #f8fafc;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.todo-app {
  background: #1e293b;
  padding: 2.5rem;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 440px;
  box-shadow: 0 20px 25px rgba(0,0,0,0.5);
  border: 1px solid #334155;
}
h2 { color: #38bdf8; margin: 0 0 1.5rem 0; font-size: 1.4rem; text-align: center; }
.input-wrapper { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
input {
  flex: 1;
  padding: 0.75rem 1rem;
  background: #0f172a;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  color: white;
  outline: none;
}
input:focus { border-color: #38bdf8; }
#btn-add {
  background: #2563eb;
  color: white;
  border: none;
  padding: 0.75rem 1.25rem;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
}
.list { list-style: none; padding: 0; margin: 0; }
.list li {
  background: #0f172a;
  padding: 0.75rem 1rem;
  border-radius: 0.75rem;
  margin-bottom: 0.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  border: 1px solid #334155;
  transition: 0.2s;
}
.list li.completed span { text-decoration: line-through; color: #64748b; }
.btn-del {
  background: #ef4444/20;
  color: #ef4444;
  border: none;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  cursor: pointer;
  font-weight: bold;
}
.footer-info {
  margin-top: 1.25rem;
  font-size: 0.75rem;
  color: #94a3b8;
  text-align: right;
}',
                'js_code' => 'const input = document.getElementById(\'input-todo\');
const btnAdd = document.getElementById(\'btn-add\');
const list = document.getElementById(\'todo-list\');
const countInfo = document.getElementById(\'todo-count\');

function updateCount() {
  const items = list.querySelectorAll(\'li\').length;
  countInfo.innerText = \'Total: \' + items + \' tugas\';
}

function addTodo() {
  const val = input.value.trim();
  if (!val) return;

  const li = document.createElement(\'li\');
  li.innerHTML = \'<span>\' + val + \'</span><button class="btn-del">&times;</button>\';
  
  li.querySelector(\'span\').addEventListener(\'click\', () => {
    li.classList.toggle(\'completed\');
  });

  li.querySelector(\'.btn-del\').addEventListener(\'click\', (e) => {
    e.stopPropagation();
    li.remove();
    updateCount();
  });

  list.appendChild(li);
  input.value = \'\';
  updateCount();
}

btnAdd.addEventListener(\'click\', addTodo);
input.addEventListener(\'keypress\', (e) => {
  if (e.key === \'Enter\') addTodo();
});

list.querySelectorAll(\'li\').forEach(li => {
  li.querySelector(\'span\').addEventListener(\'click\', () => li.classList.toggle(\'completed\'));
  li.querySelector(\'.btn-del\').addEventListener(\'click\', (e) => {
    e.stopPropagation();
    li.remove();
    updateCount();
  });
});',
                'order_num' => 8,
                'is_active' => true,
            ],

            [
                'slug' => 'js_kalkulator',
                'level' => 'mahir',
                'level_badge' => '🟣 Mahir (JavaScript)',
                'category' => 'javascript',
                'title' => 'Latihan 9: Kalkulator Cepat & Generator Motivasi',
                'desc' => 'Menerapkan logika perhitungan angka dan memilih data acak (random quote generator).',
                'instructions' => [
                    'Ketik dua angka dan pilih operasi matematika (Tambah, Kurang, Kali, Bagi).',
                    'Klik tombol "Hitung Hasil" untuk menampilkan kalkulasi di layar.',
                    'Klik tombol "Kutipan Motivasi" untuk merandom kata-kata inspirasi teknologi.'
                ],
                'html_code' => '<div class="calc-box">
  <h2>Kalkulator Mini VxAI 🧮</h2>

  <div class="inputs">
    <input type="number" id="num1" value="12" placeholder="Angka 1">
    <select id="operator">
      <option value="+">+</option>
      <option value="-">-</option>
      <option value="*">&times;</option>
      <option value="/">&divide;</option>
    </select>
    <input type="number" id="num2" value="8" placeholder="Angka 2">
  </div>

  <button id="btn-calc" class="btn-primary">Hitung Hasil</button>
  <div class="result" id="output-calc">= 20</div>

  <hr class="divider">

  <button id="btn-quote" class="btn-secondary">💡 Dapatkan Kutipan Koding</button>
  <p id="quote-text" class="quote">"Satu-satunya cara melakukan pekerjaan hebat adalah mencintai apa yang Anda kerjakan."</p>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #0b1120;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.calc-box {
  background: #1e293b;
  padding: 2.5rem;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 380px;
  border: 1px solid #334155;
  text-align: center;
}
h2 { color: #38bdf8; margin: 0 0 1.5rem 0; font-size: 1.35rem; }
.inputs { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
input, select {
  padding: 0.75rem;
  background: #0f172a;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  color: white;
  outline: none;
  font-weight: bold;
}
input { flex: 1; text-align: center; font-size: 1.1rem; }
select { font-size: 1.1rem; }
.btn-primary {
  width: 100%;
  padding: 0.8rem;
  background: #2563eb;
  color: white;
  border: none;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
}
.result {
  font-size: 2rem;
  font-weight: 900;
  color: #38bdf8;
  margin: 1rem 0;
}
.divider { border: none; border-top: 1px solid #334155; margin: 1.5rem 0; }
.btn-secondary {
  background: #334155;
  color: #f8fafc;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 0.75rem;
  font-size: 0.8rem;
  font-weight: bold;
  cursor: pointer;
}
.quote {
  font-style: italic;
  font-size: 0.85rem;
  color: #94a3b8;
  margin-top: 1rem;
  line-height: 1.5;
}',
                'js_code' => 'document.getElementById(\'btn-calc\').addEventListener(\'click\', function() {
  const n1 = parseFloat(document.getElementById(\'num1\').value) || 0;
  const n2 = parseFloat(document.getElementById(\'num2\').value) || 0;
  const op = document.getElementById(\'operator\').value;
  let res = 0;

  if (op === \'+\') res = n1 + n2;
  else if (op === \'-\') res = n1 - n2;
  else if (op === \'*\') res = n1 * n2;
  else if (op === \'/\') res = n2 !== 0 ? (n1 / n2).toFixed(2) : \'Tak Hingga\';

  document.getElementById(\'output-calc\').innerText = \'= \' + res;
});

const quotes = [
  \'"Satu-satunya cara melakukan pekerjaan hebat adalah mencintai apa yang Anda kerjakan." - Steve Jobs\',
  \'"Koding bukan tentang mengetik sintaks, melainkan tentang menyelesaikan masalah." - Anonim\',
  \'"Jangan takut berbuat salah saat menulis kode; bug adalah guru terbaik." - Programmer\',
  \'"Generasi muda SMKN 1 Kupang Barat siap memimpin era Kecerdasan Buatan!" - VxAI\'
];

document.getElementById(\'btn-quote\').addEventListener(\'click\', function() {
  const rand = quotes[Math.floor(Math.random() * quotes.length)];
  document.getElementById(\'quote-text\').innerText = rand;
});',
                'order_num' => 9,
                'is_active' => true,
            ],

            [
                'slug' => 'js_ai_bot',
                'level' => 'mahir',
                'level_badge' => '🟣 Mahir (JavaScript & AI)',
                'category' => 'ai',
                'title' => 'Latihan 10: Simulator Asisten AI Interaktif',
                'desc' => 'Membuat jendela obrolan chat simulasi AI dengan animasi gelembung percakapan responsif.',
                'instructions' => [
                    'Ketik pertanyaan di kotak teks (misal: "Apa itu HTML?", "Siapa kamu?", atau "Tips koding").',
                    'Tekan enter atau tombol kirim untuk memunculkan pesan di riwayat obrolan.',
                    'Amati balasan bot cerdas yang disimulasikan melalui logika percabangan JavaScript!'
                ],
                'html_code' => '<div class="chat-container">
  <div class="chat-header">
    <div class="avatar">🤖</div>
    <div>
      <div class="bot-name">VxAI Tutor Bot</div>
      <div class="bot-status">● Online & Siap Membantu</div>
    </div>
  </div>

  <div class="chat-messages" id="chat-box">
    <div class="message bot">
      Halo! Saya asisten virtual belajar koding VxAI. Tanyakan apa saja tentang HTML, CSS, atau JavaScript! 👋
    </div>
  </div>

  <form id="chat-form" class="chat-input-bar">
    <input type="text" id="user-input" placeholder="Ketik pertanyaan koding Anda..." required>
    <button type="submit">Kirim &rarr;</button>
  </form>
</div>',
                'css_code' => 'body {
  font-family: system-ui, sans-serif;
  background: #0b1120;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  padding: 1rem;
}
.chat-container {
  background: #1e293b;
  border-radius: 1.5rem;
  width: 100%;
  max-width: 440px;
  height: 520px;
  display: flex;
  flex-direction: column;
  border: 1px solid #334155;
  overflow: hidden;
  box-shadow: 0 25px 50px rgba(0,0,0,0.5);
}
.chat-header {
  background: #0f172a;
  padding: 1rem 1.25rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  border-bottom: 1px solid #334155;
}
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
}
.bot-name { font-weight: bold; font-size: 0.9rem; }
.bot-status { font-size: 0.7rem; color: #10b981; }
.chat-messages {
  flex: 1;
  padding: 1rem;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}
.message {
  max-width: 80%;
  padding: 0.75rem 1rem;
  border-radius: 1rem;
  font-size: 0.85rem;
  line-height: 1.5;
}
.message.bot {
  background: #0f172a;
  color: #f1f5f9;
  align-self: flex-start;
  border-bottom-left-radius: 0.25rem;
  border: 1px solid #334155;
}
.message.user {
  background: #2563eb;
  color: white;
  align-self: flex-end;
  border-bottom-right-radius: 0.25rem;
}
.chat-input-bar {
  display: flex;
  padding: 0.75rem;
  background: #0f172a;
  border-top: 1px solid #334155;
  gap: 0.5rem;
}
.chat-input-bar input {
  flex: 1;
  background: #1e293b;
  border: 1px solid #475569;
  border-radius: 0.75rem;
  padding: 0.65rem 1rem;
  color: white;
  outline: none;
  font-size: 0.85rem;
}
.chat-input-bar button {
  background: #2563eb;
  color: white;
  border: none;
  padding: 0.65rem 1.2rem;
  border-radius: 0.75rem;
  font-weight: bold;
  cursor: pointer;
}',
                'js_code' => 'const form = document.getElementById(\'chat-form\');
const input = document.getElementById(\'user-input\');
const chatBox = document.getElementById(\'chat-box\');

function appendMessage(sender, text) {
  const msg = document.createElement(\'div\');
  msg.className = \'message \' + sender;
  msg.innerText = text;
  chatBox.appendChild(msg);
  chatBox.scrollTop = chatBox.scrollHeight;
}

form.addEventListener(\'submit\', function(e) {
  e.preventDefault();
  const query = input.value.trim();
  if (!query) return;

  appendMessage(\'user\', query);
  input.value = \'\';

  setTimeout(() => {
    let reply = \'Pertanyaan menarik! Cobalah bereksperimen langsung dengan kode di editor kiri.\';
    const qLower = query.toLowerCase();

    if (qLower.includes(\'html\')) {
      reply = \'HTML (HyperText Markup Language) adalah kerangka utama halaman web. Setiap konten teks dan tombol dibungkus oleh tag HTML!\';
    } else if (qLower.includes(\'css\')) {
      reply = \'CSS (Cascading Style Sheets) berfungsi menghias website agar berwarna, rapi dengan Flexbox/Grid, dan nyaman dipandang.\';
    } else if (qLower.includes(\'javascript\') || qLower.includes(\'js\')) {
      reply = \'JavaScript adalah otak dari website! Tanpa JS, web Anda statis. Dengan JS, tombol bisa diklik dan animasi bisa bergerak.\';
    } else if (qLower.includes(\'halo\') || qLower.includes(\'hai\')) {
      reply = \'Halo juga sahabat koding! Ada materi yang ingin kamu latih hari ini?\';
    }

    appendMessage(\'bot\', reply);
  }, 400);
});',
                'order_num' => 10,
                'is_active' => true,
            ],
        ];
    }

    /**
     * Dapatkan template preset siap pakai untuk admin saat membuat latihan baru
     */
    public static function getStarterTemplates(): array
    {
        return [
            'blank_html' => [
                'name' => 'HTML5 Dokumen Dasar',
                'level' => 'pemula',
                'level_badge' => '🟢 Pemula (HTML5)',
                'category' => 'html',
                'desc' => 'Kerangka dasar dokumen web HTML5 dengan heading, paragraf, dan link.',
                'instructions' => "Buat struktur HTML5 lengkap\nTambahkan tag heading dan paragraf\nUji coba menambahkan gambar atau tautan",
                'html' => "<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Latihan Web Baru</title>\n</head>\n<body>\n  <h1>Selamat Datang di Halaman Baru</h1>\n  <p>Tuliskan kode HTML Anda di sini untuk memulai eksperimen web.</p>\n</body>\n</html>",
                'css' => "body {\n  font-family: system-ui, sans-serif;\n  background: #0f172a;\n  color: #f8fafc;\n  padding: 2rem;\n  line-height: 1.6;\n}\nh1 { color: #38bdf8; }",
                'js' => "console.log('Halaman web baru siap dikembangkan!');",
            ],
            'form_modern' => [
                'name' => 'Formulir Interaktif Modern',
                'level' => 'pemula',
                'level_badge' => '🟢 Pemula (HTML5)',
                'category' => 'html',
                'desc' => 'Formulir input dengan styling modern, validasi input, dan feedback pesan.',
                'instructions' => "Lengkapi kolom isian form\nTambahkan validasi data\nTangkap event submit pada form",
                'html' => "<div class=\"card\">\n  <h2>Formulir Kontak</h2>\n  <form id=\"contact-form\">\n    <input type=\"text\" placeholder=\"Nama Anda\" required>\n    <button type=\"submit\">Kirim Pesan</button>\n  </form>\n  <p id=\"msg\" style=\"display:none; color:#34d399; margin-top:1rem;\">Pesan berhasil dikirim!</p>\n</div>",
                'css' => "body { background: #0b1120; color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: sans-serif; }\n.card { background: #1e293b; padding: 2rem; border-radius: 1rem; border: 1px solid #334155; width: 320px; }\ninput { width: 100%; padding: 0.7rem; margin: 1rem 0; border-radius: 0.5rem; border: 1px solid #475569; background: #0f172a; color: white; box-sizing: border-box; }\nbutton { width: 100%; padding: 0.7rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; font-weight: bold; cursor: pointer; }",
                'js' => "document.getElementById('contact-form').addEventListener('submit', function(e) {\n  e.preventDefault();\n  document.getElementById('msg').style.display = 'block';\n});",
            ],
            'flexbox_layout' => [
                'name' => 'Tata Letak Flexbox Sejajar',
                'level' => 'menengah',
                'level_badge' => '🔵 Menengah (CSS3)',
                'category' => 'css',
                'desc' => 'Layout baris kartu produk atau fitur dengan flexbox responsif.',
                'instructions' => "Atur properti display: flex pada pembungkus kartu\nGunakan gap untuk memberi jarak\nAtur kelenturan ukuran dengan flex: 1",
                'html' => "<div class=\"wrapper\">\n  <div class=\"box\">🚀 Fitur Cepat</div>\n  <div class=\"box\">🔒 Sistem Aman</div>\n  <div class=\"box\">📱 Ramah Mobile</div>\n</div>",
                'css' => "body { background: #0f172a; color: white; font-family: sans-serif; padding: 3rem; }\n.wrapper { display: flex; gap: 1rem; flex-wrap: wrap; }\n.box { flex: 1; min-width: 180px; background: #1e293b; padding: 2rem; border-radius: 1rem; border: 1px solid #334155; text-align: center; font-weight: bold; }",
                'js' => "// Flexbox murni dengan CSS",
            ],
            'grid_gallery' => [
                'name' => 'CSS Grid Galeri Otomatis',
                'level' => 'menengah',
                'level_badge' => '🔵 Menengah (CSS3)',
                'category' => 'css',
                'desc' => 'Galeri kartu responsif otomatis tanpa media queries menggunakan CSS Grid.',
                'instructions' => "Terapkan display: grid\nGunakan repeat(auto-fit, minmax(...))\nUji di berbagai ukuran layar",
                'html' => "<div class=\"grid-box\">\n  <div class=\"item\">Proyek 1</div>\n  <div class=\"item\">Proyek 2</div>\n  <div class=\"item\">Proyek 3</div>\n  <div class=\"item\">Proyek 4</div>\n</div>",
                'css' => "body { background: #0b1120; color: white; font-family: sans-serif; padding: 2rem; }\n.grid-box { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; }\n.item { background: #1e293b; padding: 2rem; border-radius: 1rem; border: 1px solid #334155; text-align: center; }",
                'js' => "// Grid layout responsif otomatis",
            ],
            'js_interactive' => [
                'name' => 'JavaScript Interaktif & Event DOM',
                'level' => 'mahir',
                'level_badge' => '🟣 Mahir (JavaScript)',
                'category' => 'javascript',
                'desc' => 'Eksperimen interaktif dengan event listener klik, modifikasi teks, dan style.',
                'instructions' => "Tangkap elemen tombol menggunakan getElementById\nPasang addEventListener click\nUbah nilai teks di dalam elemen output",
                'html' => "<div class=\"container\">\n  <h2>Generator Angka Keberuntungan 🎲</h2>\n  <div id=\"angka\" class=\"num\">?</div>\n  <button id=\"btn-acak\">Acak Angka Sekarang</button>\n</div>",
                'css' => "body { background: #0f172a; color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: sans-serif; }\n.container { background: #1e293b; padding: 2.5rem; border-radius: 1.5rem; text-align: center; border: 1px solid #334155; }\n.num { font-size: 3.5rem; font-weight: 900; color: #38bdf8; margin: 1.5rem 0; font-family: monospace; }\nbutton { padding: 0.8rem 1.5rem; background: #2563eb; color: white; border: none; border-radius: 0.75rem; font-weight: bold; cursor: pointer; }",
                'js' => "document.getElementById('btn-acak').addEventListener('click', function() {\n  const acak = Math.floor(Math.random() * 100) + 1;\n  document.getElementById('angka').innerText = acak;\n});",
            ],
            'ai_bot_simulator' => [
                'name' => 'Simulator Chatbot AI Sederhana',
                'level' => 'mahir',
                'level_badge' => '🟣 Mahir (JavaScript & AI)',
                'category' => 'ai',
                'desc' => 'Jendela percakapan interaktif berbasis percabangan logika AI sederhana.',
                'instructions' => "Ketik pesan pada form\nKirim dan tampilkan pesan pengguna\nJalankan logika balasan bot otomatis",
                'html' => "<div class=\"chat-box\">\n  <div class=\"chat-head\">🤖 AI Assistant Lite</div>\n  <div id=\"chat-body\" class=\"chat-body\">\n    <div class=\"bubble bot\">Halo! Ada yang bisa saya bantu?</div>\n  </div>\n  <form id=\"c-form\" class=\"chat-foot\">\n    <input type=\"text\" id=\"c-input\" placeholder=\"Tulis pesan...\" required>\n    <button type=\"submit\">Kirim</button>\n  </form>\n</div>",
                'css' => "body { background: #090e17; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }\n.chat-box { width: 340px; height: 420px; background: #1e293b; border-radius: 1rem; border: 1px solid #334155; display: flex; flex-direction: column; overflow: hidden; }\n.chat-head { padding: 1rem; background: #0f172a; font-weight: bold; border-bottom: 1px solid #334155; }\n.chat-body { flex: 1; padding: 1rem; overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem; }\n.bubble { padding: 0.6rem 0.9rem; border-radius: 0.8rem; font-size: 0.85rem; max-width: 80%; }\n.bot { background: #0f172a; align-self: flex-start; }\n.user { background: #2563eb; align-self: flex-end; }\n.chat-foot { display: flex; padding: 0.5rem; background: #0f172a; border-top: 1px solid #334155; gap: 0.5rem; }\n.chat-foot input { flex: 1; padding: 0.5rem 0.8rem; border-radius: 0.5rem; border: 1px solid #334155; background: #1e293b; color: white; }\n.chat-foot button { padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; font-weight: bold; cursor: pointer; }",
                'js' => "document.getElementById('c-form').addEventListener('submit', function(e) {\n  e.preventDefault();\n  const inp = document.getElementById('c-input');\n  const val = inp.value.trim();\n  if(!val) return;\n  const body = document.getElementById('chat-body');\n  body.innerHTML += '<div class=\"bubble user\">' + val + '</div>';\n  inp.value = '';\n  setTimeout(() => {\n    body.innerHTML += '<div class=\"bubble bot\">Saya menerima pesan Anda: \"' + val + '\". Semangat koding!</div>';\n    body.scrollTop = body.scrollHeight;\n  }, 400);\n});",
            ],
        ];
    }

    /**
     * Dapatkan semua modul tantangan aktif yang siap di-render di Live Playground
     */
    public static function getActiveChallenges(): array
    {
        try {
            if (Schema::hasTable('playground_challenges')) {
                // Auto sync jika tabel masih kosong
                if (DB::table('playground_challenges')->count() === 0) {
                    self::syncDefaultChallenges();
                }

                $records = PlaygroundChallenge::active()->get();

                if ($records->isNotEmpty()) {
                    return $records->map(function ($ch) {
                        return [
                            'id' => $ch->slug,
                            'slug' => $ch->slug,
                            'level' => $ch->level,
                            'levelBadge' => $ch->level_badge,
                            'category' => $ch->category,
                            'title' => $ch->title,
                            'desc' => $ch->desc,
                            'instructions' => is_array($ch->instructions) ? $ch->instructions : (json_decode($ch->instructions, true) ?: []),
                            'html' => $ch->html_code ?? '',
                            'css' => $ch->css_code ?? '',
                            'js' => $ch->js_code ?? '',
                        ];
                    })->toArray();
                }
            }
        } catch (\Throwable $e) {
            // Fallback gracefully
        }

        // Fallback jika belum migrasi atau terjadi galat database
        return array_map(function ($item) {
            return [
                'id' => $item['slug'],
                'slug' => $item['slug'],
                'level' => $item['level'],
                'levelBadge' => $item['level_badge'],
                'category' => $item['category'],
                'title' => $item['title'],
                'desc' => $item['desc'],
                'instructions' => $item['instructions'],
                'html' => $item['html_code'],
                'css' => $item['css_code'],
                'js' => $item['js_code'],
            ];
        }, self::getDefaultChallenges());
    }

    /**
     * Sinkronisasi tantangan bawaan ke database.
     * $force = true akan menimpa seluruh modul dengan data bawaan.
     */
    public static function syncDefaultChallenges(bool $force = false): bool
    {
        try {
            if (!Schema::hasTable('playground_challenges')) {
                return false;
            }

            $defaults = self::getDefaultChallenges();
            $count = DB::table('playground_challenges')->count();

            // Jika tabel kosong atau dipaksa reset
            if ($count === 0 || $force) {
                if ($force) {
                    DB::table('playground_challenges')->truncate();
                }

                foreach ($defaults as $item) {
                    $insertData = $item;
                    $insertData['instructions'] = json_encode($item['instructions']);
                    $insertData['created_at'] = now();
                    $insertData['updated_at'] = now();
                    DB::table('playground_challenges')->insert($insertData);
                }
            } else {
                // Pastikan modul-modul bawaan yang belum ada disisipkan
                foreach ($defaults as $item) {
                    $exists = DB::table('playground_challenges')->where('slug', $item['slug'])->exists();
                    if (!$exists) {
                        $insertData = $item;
                        $insertData['instructions'] = json_encode($item['instructions']);
                        $insertData['created_at'] = now();
                        $insertData['updated_at'] = now();
                        DB::table('playground_challenges')->insert($insertData);
                    }
                }
            }

            // Catat versi di global settings jika tabel tersedia
            if (Schema::hasTable('global_settings')) {
                DB::table('global_settings')->updateOrInsert(
                    ['setting_key' => 'playground_challenges_version'],
                    [
                        'setting_value' => self::VERSION,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
