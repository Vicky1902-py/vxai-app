@extends('layouts.admin')

@section('title', 'Pengaturan & AdSense Hub - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Pengaturan Platform & Google AdSense')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm max-w-4xl overflow-hidden">
    
    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <div>
            <h3 class="text-base font-extrabold text-slate-900">Pusat Konfigurasi & Integrasi</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola penayangan Google AdSense, identitas website, dan mode pemeliharaan</p>
        </div>
        <span class="text-xs font-mono font-bold bg-blue-50 text-blue-700 px-3 py-1 rounded-xl">v2.1 Stable</span>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-slate-100">
        @csrf

        <div class="p-8 space-y-8">
            
            <!-- SEKSI 1: GOOGLE ADSENSE HUB (FITUR UTAMA) -->
            <div class="bg-gradient-to-br from-amber-50/80 via-orange-50/40 to-white p-6 md:p-8 rounded-3xl border border-amber-200/80 shadow-sm space-y-5">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl font-black shadow-md shadow-amber-500/20">
                            💰
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base">Google AdSense Hub</h3>
                            <p class="text-xs text-slate-600 mt-0.5">Monetisasi platform koding publik Anda dengan jaringan iklan resmi Google</p>
                        </div>
                    </div>
                    @if(($settings['adsense_status'] ?? 'false') === 'true')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            ● Iklan Sedang Tayang
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-300">
                            Status: Nonaktif
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <!-- Status Switch -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Status Penayangan Iklan
                        </label>
                        <select name="adsense_status" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-semibold bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            <option value="false" {{ ($settings['adsense_status'] ?? 'false') == 'false' ? 'selected' : '' }}>
                                🔴 Nonaktif (Jangan Tampilkan Iklan)
                            </option>
                            <option value="true" {{ ($settings['adsense_status'] ?? 'false') == 'true' ? 'selected' : '' }}>
                                🟢 Aktif (Tayangkan Script & Banner AdSense)
                            </option>
                        </select>
                        <p class="text-[11px] text-slate-500 mt-1.5">Aktifkan setelah akun AdSense Anda disetujui oleh Google.</p>
                    </div>

                    <!-- Client ID AdSense -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Publisher Client ID (ca-pub-xxx)
                        </label>
                        <input type="text" name="adsense_client_id" value="{{ $settings['adsense_client_id'] ?? '' }}" placeholder="Contoh: ca-pub-1234567890123456" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-mono font-semibold bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <p class="text-[11px] text-slate-500 mt-1.5">Dapatkan dari dashboard Google AdSense Anda (Akun ➔ Pengaturan ➔ Informasi Akun).</p>
                    </div>
                </div>

                <!-- Konfigurasi File ads.txt -->
                <div class="pt-2">
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Isi File <code>ads.txt</code> (Verifikasi Kepemilikan)
                        </label>
                        <a href="{{ route('ads.txt') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                            <span>Uji Link ads.txt</span> <span>↗</span>
                        </a>
                    </div>
                    <p class="text-[11px] text-slate-500 mb-2">Google AdSense mewajibkan baris otorisasi penayang ini agar pendapatan iklan tidak terganggu:</p>
                    <textarea id="ads_txt_area" name="ads_txt_content" rows="3" class="w-full p-4 border border-slate-200 rounded-2xl text-xs font-mono bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none leading-relaxed">{{ $settings['ads_txt_content'] ?? "google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0" }}</textarea>
                </div>

                <!-- Tips Lolos AdSense -->
                <div class="bg-white/90 p-4 rounded-2xl border border-amber-200/60 text-xs text-slate-600 space-y-1">
                    <div class="font-bold text-slate-800 flex items-center gap-1.5">
                        <span>💡</span> <span>Status Kesiapan Review Google AdSense di vxai.online:</span>
                    </div>
                    <p>✓ <strong>Akses Publik</strong>: Live Playground dan Panduan Koding terbuka untuk umum.</p>
                    <p>✓ <strong>Halaman Legal Wajib</strong>: Kebijakan Privasi, Syarat Layanan, Tentang Kami, dan Kontak telah siap.</p>
                    <p>✓ <strong>File ads.txt</strong>: Otomatis disajikan melalui endpoint <code>https://vxai.online/ads.txt</code>.</p>
                </div>
            </div>

            <!-- SEKSI 2: GOOGLE SEARCH CONSOLE & SEO HUB (FITUR BARU) -->
            <div class="bg-gradient-to-br from-blue-50/80 via-indigo-50/40 to-white p-6 md:p-8 rounded-3xl border border-blue-200/80 shadow-sm space-y-5">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl font-black shadow-md shadow-blue-600/20">
                            🔍
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base">Google Search Console & SEO Hub</h3>
                            <p class="text-xs text-slate-600 mt-0.5">Verifikasi kepemilikan website, sitemap XML otomatis, robots.txt, dan pengindeksan Google</p>
                        </div>
                    </div>
                    @if(!empty($settings['google_site_verification']))
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>● Terkonfigurasi</span>
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                            Belum Terverifikasi
                        </span>
                    @endif
                </div>

                <!-- Info Status Harmoni AdSense & SEO -->
                <div class="bg-white/90 p-4 rounded-2xl border border-blue-200/60 text-xs text-slate-700 space-y-1.5">
                    <div class="font-bold text-slate-900 flex items-center gap-2">
                        <span class="text-emerald-500">🛡️</span> <span>Terintegrasi Aman & Harmonis dengan Google AdSense</span>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Fitur SEO ini dirancang khusus agar <strong>tidak mengganggu script Google AdSense</strong> maupun file <code>ads.txt</code>. Crawler AdSense (<code>Mediapartners-Google</code>) otomatis diberi izin penuh pada file <code>robots.txt</code> sehingga proses persetujuan dan pendapatan iklan tetap maksimal.
                    </p>
                </div>

                <!-- Input Meta Tag Verifikasi Google Search Console -->
                <div class="space-y-1.5 pt-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Google Site Verification (Meta Tag / Kode HTML Tag)
                        </label>
                        <span class="text-[11px] font-mono text-blue-600 font-bold">Metode Utama GSC</span>
                    </div>
                    <input type="text" name="google_site_verification" value="{{ $settings['google_site_verification'] ?? '' }}" 
                           placeholder="Contoh: aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890 atau seluruh tag <meta name='google-site-verification' content='...'>" 
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl text-xs font-mono font-semibold bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <p class="text-[11px] text-slate-500">
                        Dapatkan dari <strong>Google Search Console</strong> ➔ Tambah Properti ➔ Pilih <em>Awalan URL (URL Prefix)</em> ➔ Metode <strong>Tag HTML</strong>. Masukkan kode atau seluruh tag di sini.
                    </p>
                </div>

                <!-- Quick Links: Sitemap & Robots.txt -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <!-- Sitemap XML Card -->
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span>🗺️</span> <span>Sitemap XML Publik</span>
                            </span>
                            <a href="{{ route('sitemap') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                                <span>Buka sitemap.xml</span> <span>↗</span>
                            </a>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Peta situs dinamis yang memuat otomatis seluruh halaman beranda, playground, panduan, dan seluruh artikel berita tutorial koding/AI terbaru.
                        </p>
                        <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-[11px] font-mono text-slate-700 select-all">
                            {{ url('/sitemap.xml') }}
                        </div>
                        <p class="text-[10px] text-slate-400">
                            Salin URL di atas lalu masukkan ke menu <strong>Peta Situs (Sitemaps)</strong> di Google Search Console.
                        </p>
                    </div>

                    <!-- Robots.txt Link Card -->
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span>🤖</span> <span>File robots.txt Publik</span>
                            </span>
                            <a href="{{ route('robots.txt') }}" target="_blank" class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                                <span>Buka robots.txt</span> <span>↗</span>
                            </a>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Menginstruksikan bot pencari Googlebot dan Mediapartners-Google (AdSense) untuk merayapi seluruh konten publik dan mengabaikan halaman admin internal.
                        </p>
                        <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-[11px] font-mono text-slate-700 select-all">
                            {{ url('/robots.txt') }}
                        </div>
                        <p class="text-[10px] text-slate-400">
                            Terbuka otomatis untuk seluruh mesin pencari Google, Bing, Yahoo, dan AdSense.
                        </p>
                    </div>
                </div>

                <!-- Konfigurasi Isi robots.txt -->
                <div class="pt-2">
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Kustomisasi Isi File <code>robots.txt</code>
                        </label>
                        <span class="text-[11px] text-slate-400">Dapat diedit bebas oleh Admin</span>
                    </div>
                    <textarea name="robots_txt_content" rows="6" class="w-full p-4 border border-slate-200 rounded-2xl text-xs font-mono bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none leading-relaxed">{{ $settings['robots_txt_content'] ?? "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nDisallow: /guru\nDisallow: /siswa\nDisallow: /migrate-db\n\nUser-agent: Mediapartners-Google\nAllow: /\n\nSitemap: " . url('/sitemap.xml') }}</textarea>
                </div>

                <!-- Meta Tag Tambahan / Kode TXT / Header Scripts (Opsional) -->
                <div class="pt-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Meta Tag Tambahan / Verifikasi Webmaster Lain (Opsional)
                    </label>
                    <textarea name="custom_meta_tags" rows="3" placeholder="Contoh: <meta name='msvalidate.01' content='...' /> atau tag verifikasi lainnya" class="w-full p-3 border border-slate-200 rounded-2xl text-xs font-mono bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none leading-relaxed">{{ $settings['custom_meta_tags'] ?? '' }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Disisipkan secara aman ke dalam tag <code>&lt;head&gt;</code> di seluruh halaman publik tanpa mengganggu AdSense.</p>
                </div>

                <!-- Panduan Langkah demi Langkah GSC -->
                <div class="bg-blue-900/5 p-4 rounded-2xl border border-blue-200/80 text-xs text-slate-700 space-y-2">
                    <div class="font-bold text-blue-900 flex items-center gap-2">
                        <span>📋</span> <span>Langkah Mendaftarkan vxai.online ke Google Search Console:</span>
                    </div>
                    <ol class="list-decimal list-inside space-y-1 text-[11px] text-slate-600 leading-relaxed">
                        <li>Buka <a href="https://search.google.com/search-console" target="_blank" class="text-blue-600 underline font-bold">Google Search Console</a> lalu login dengan akun Google Anda.</li>
                        <li>Pilih opsi <strong>Awalan URL (URL Prefix)</strong> dan masukkan <code>https://vxai.online</code>.</li>
                        <li>Pilih metode verifikasi <strong>Tag HTML</strong>, salin kode yang muncul, dan tempelkan pada kolom <em>Google Site Verification</em> di atas.</li>
                        <li>Klik tombol <strong>Simpan Semua Pengaturan</strong> di bawah.</li>
                        <li>Kembali ke Google Search Console dan klik tombol <strong>Verifikasi</strong>.</li>
                        <li>Setelah terverifikasi, buka menu <strong>Peta Situs (Sitemaps)</strong> di Google Search Console, ketik <code>sitemap.xml</code> lalu klik <strong>Kirim</strong>.</li>
                    </ol>
                </div>
            </div>

            <!-- SEKSI 3: IDENTITAS APLIKASI & KONTAK -->
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg font-bold">
                        ⚙️
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Identitas Platform</h3>
                        <p class="text-xs text-slate-500">Nama sistem, email resmi kontak, dan aksesibilitas publik</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Website / Brand</label>
                        <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Kontak Pengelola</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <p class="text-[11px] text-slate-400 mt-1">Muncul di halaman Kebijakan Privasi dan Formulir Kontak.</p>
                    </div>
                </div>

                <!-- Mode Pemeliharaan -->
                <div class="pt-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Mode Pemeliharaan (Maintenance Mode)</label>
                    <select name="maintenance_mode" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="false" {{ ($settings['maintenance_mode'] ?? 'false') == 'false' ? 'selected' : '' }}>
                            🟢 Nonaktif (Website Terbuka Normal untuk Publik & Siswa)
                        </option>
                        <option value="true" {{ ($settings['maintenance_mode'] ?? 'false') == 'true' ? 'selected' : '' }}>
                            🔴 Aktif (Tutup Sementara dengan Pesan Pemeliharaan Ramah)
                        </option>
                    </select>
                </div>
            </div>

            <!-- SEKSI 3: LOGO & FAVICON -->
            <div class="space-y-5 pt-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg font-bold">
                        🖼️
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Media & Branding</h3>
                        <p class="text-xs text-slate-500">Unggah logo dan ikon peramban (favicon)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Logo Utama -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Logo Utama</label>
                        @if(!empty($settings['app_logo']))
                            <div class="mb-3 p-3 bg-white border border-slate-200 rounded-xl inline-block shadow-sm">
                                <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="h-10 object-contain">
                            </div>
                        @endif
                        <input type="file" name="app_logo" accept="image/png, image/jpeg, image/svg+xml" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        <p class="text-[11px] text-slate-400 mt-2">Format: PNG, JPG, SVG.</p>
                    </div>

                    <!-- Favicon -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Favicon Browser</label>
                        @if(!empty($settings['app_favicon']))
                            <div class="mb-3 p-3 bg-white border border-slate-200 rounded-xl inline-block shadow-sm">
                                <img src="{{ asset($settings['app_favicon']) }}" alt="Favicon" class="h-8 w-8 object-contain">
                            </div>
                        @endif
                        <input type="file" name="app_favicon" accept="image/png, image/x-icon, image/ico" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        <p class="text-[11px] text-slate-400 mt-2">Rekomendasi resolusi 32x32 atau 64x64 pixel.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="p-6 bg-slate-50/80 border-t border-slate-200/80 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3 px-8 rounded-2xl text-sm shadow-lg shadow-blue-500/20 hover:-translate-y-0.5 transition duration-150">
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection