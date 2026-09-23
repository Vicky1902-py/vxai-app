@extends('layouts.public')

@section('title', 'Panduan Koding Lengkap (HTML, CSS, JS) - ' . ($settings['app_name'] ?? 'VxAI'))
@section('meta_description', 'Pelajari dasar-dasar pemrograman web dari awal: struktur HTML5, styling CSS3 modern, dan interaktivitas JavaScript untuk pemula.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Header Panduan -->
    <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="px-3.5 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold uppercase tracking-wider">
            Kurikulum Terbuka
        </span>
        <h1 class="text-3xl md:text-5xl font-black text-gray-900 mt-4 mb-4 tracking-tight">
            Panduan Dasar Pemrograman Web
        </h1>
        <p class="text-gray-600 text-base leading-relaxed">
            Kumpulan referensi cepat, sintaksis penting, dan studi kasus untuk membangun fondasi koding yang kuat sebelum langsung berlatih di Live Playground.
        </p>
    </div>

    <!-- Modul 1: HTML5 -->
    <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-200 shadow-sm mb-10">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center font-black text-xl">1</span>
            <div>
                <h2 class="text-2xl font-black text-gray-900">HTML5: Kerangka Struktur Web</h2>
                <p class="text-xs text-gray-500">HyperText Markup Language digunakan untuk menyusun elemen konten halaman web.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <h3 class="font-bold text-gray-800 text-sm mb-2 text-orange-600">Struktur Dokumen Standar</h3>
                <pre class="bg-gray-900 text-gray-200 p-4 rounded-xl text-xs font-mono overflow-x-auto leading-relaxed">&lt;!DOCTYPE html&gt;
&lt;html lang="id"&gt;
  &lt;head&gt;
    &lt;title&gt;Judul Web&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
    &lt;h1&gt;Halo Dunia&lt;/h1&gt;
    &lt;p&gt;Paragraf pertama saya.&lt;/p&gt;
  &lt;/body&gt;
&lt;/html&gt;</pre>
            </div>

            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <h3 class="font-bold text-gray-800 text-sm mb-2 text-orange-600">Elemen Semantik Utama</h3>
                <ul class="space-y-2 text-xs text-gray-700">
                    <li><code class="bg-orange-100 text-orange-800 px-1 rounded font-bold">&lt;header&gt;</code>: Bagian kepala situs (logo dan menu).</li>
                    <li><code class="bg-orange-100 text-orange-800 px-1 rounded font-bold">&lt;main&gt;</code>: Konten utama halaman dokumen.</li>
                    <li><code class="bg-orange-100 text-orange-800 px-1 rounded font-bold">&lt;section&gt;</code>: Pengelompokan bagian konten mandiri.</li>
                    <li><code class="bg-orange-100 text-orange-800 px-1 rounded font-bold">&lt;footer&gt;</code>: Kaki halaman (hak cipta dan legalitas).</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modul 2: CSS3 -->
    <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-200 shadow-sm mb-10">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-black text-xl">2</span>
            <div>
                <h2 class="text-2xl font-black text-gray-900">CSS3: Menghias & Tata Letak</h2>
                <p class="text-xs text-gray-500">Cascading Style Sheets menentukan warna, tipografi, tata letak, dan responsivitas layar.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <h3 class="font-bold text-gray-800 text-sm mb-2 text-blue-600">CSS Box Model & Styling</h3>
                <pre class="bg-gray-900 text-gray-200 p-4 rounded-xl text-xs font-mono overflow-x-auto leading-relaxed">.kartu {
  background-color: #ffffff;
  padding: 24px;
  margin: 16px auto;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  max-width: 480px;
}</pre>
            </div>

            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <h3 class="font-bold text-gray-800 text-sm mb-2 text-blue-600">Flexbox Modern</h3>
                <pre class="bg-gray-900 text-gray-200 p-4 rounded-xl text-xs font-mono overflow-x-auto leading-relaxed">.container-tengah {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}</pre>
            </div>
        </div>
    </div>

    <!-- Modul 3: JavaScript -->
    <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-200 shadow-sm mb-10">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center font-black text-xl">3</span>
            <div>
                <h2 class="text-2xl font-black text-gray-900">JavaScript: Interaktivitas & Logika</h2>
                <p class="text-xs text-gray-500">Bahasa skrip yang menghidupkan website melalui manipulasi elemen (DOM) dan aksi pengguna.</p>
            </div>
        </div>

        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
            <h3 class="font-bold text-gray-800 text-sm mb-2 text-yellow-600">Menangani Tombol & Aksi (Event Listener)</h3>
            <pre class="bg-gray-900 text-gray-200 p-4 rounded-xl text-xs font-mono overflow-x-auto leading-relaxed">const tombol = document.getElementById("tombol-salam");

tombol.addEventListener("click", function() {
  const nama = prompt("Siapa nama Anda?");
  if (nama) {
    alert("Selamat datang di dunia koding, " + nama + "! 🚀");
  }
});</pre>
        </div>
    </div>

    <!-- Banner Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 md:p-12 text-white text-center shadow-xl">
        <h2 class="text-2xl md:text-3xl font-black mb-3">Siap Mencoba Sendiri?</h2>
        <p class="text-blue-100 max-w-xl mx-auto text-sm mb-6">
            Uji semua sintaks di atas secara langsung di peramban tanpa instalasi apa pun.
        </p>
        <a href="{{ route('public.playground') }}" class="inline-flex items-center px-8 py-3.5 rounded-2xl bg-white text-blue-600 font-bold text-sm shadow hover:bg-blue-50 transition">
            Buka Live Playground Sekarang ➔
        </a>
    </div>

</div>
@endsection
