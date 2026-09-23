@extends('layouts.admin')

@section('title', 'Pengaturan & AdSense - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Pengaturan Aplikasi & Google AdSense')

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm max-w-4xl overflow-hidden">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">
        @csrf

        <div class="p-6 space-y-6">
            
            <!-- SEKSI 1: GOOGLE ADSENSE (PRIORITAS BARU) -->
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-2xl border border-yellow-200 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">💰</span>
                    <h3 class="font-bold text-gray-900 text-base">Konfigurasi Google AdSense</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Setelah akun AdSense Anda disetujui, aktifkan status di bawah ini dan masukkan ID Penayang (Publisher ID) Anda. Kode script iklan akan otomatis disisipkan ke seluruh halaman publik.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <!-- Status AdSense -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Status Penayangan Iklan</label>
                        <select name="adsense_status" class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:ring-2 focus:ring-blue-500">
                            <option value="false" {{ ($settings['adsense_status'] ?? 'false') == 'false' ? 'selected' : '' }}>Nonaktif (Iklan Ditutup)</option>
                            <option value="true" {{ ($settings['adsense_status'] ?? 'false') == 'true' ? 'selected' : '' }}>Aktif (Tayangkan Iklan di Publik)</option>
                        </select>
                    </div>

                    <!-- Client ID AdSense -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Publisher Client ID (ca-pub-xxx)</label>
                        <input type="text" name="adsense_client_id" value="{{ $settings['adsense_client_id'] ?? '' }}" placeholder="Contoh: ca-pub-1234567890123456" class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:ring-2 focus:ring-blue-500 font-mono">
                    </div>
                </div>

                <!-- Pengaturan File ads.txt -->
                <div class="pt-3">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                        Isi File <code>ads.txt</code> (Dapat diakses di <a href="/ads.txt" target="_blank" class="text-blue-600 underline">vxai.online/ads.txt</a>)
                    </label>
                    <p class="text-[11px] text-gray-500 mb-2">Tempelkan baris otorisasi dari dashboard AdSense Anda di sini:</p>
                    <textarea name="ads_txt_content" rows="3" class="w-full px-4 py-2.5 border rounded-xl text-xs font-mono bg-white focus:ring-2 focus:ring-blue-500">{{ $settings['ads_txt_content'] ?? "google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0" }}</textarea>
                </div>
            </div>

            <!-- SEKSI 2: INFORMASI APLIKASI -->
            <div class="space-y-4">
                <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <span>⚙️</span> <span>Identitas & Informasi Situs</span>
                </h3>

                <!-- Nama Aplikasi -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Aplikasi / Website</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Email Kontak Pengelola -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Email Kontak Pengelola (Muncul di Kebijakan Privasi)</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Mode Pemeliharaan (Maintenance Mode) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Mode Pemeliharaan (Maintenance Mode)</label>
                    <select name="maintenance_mode" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="false" {{ ($settings['maintenance_mode'] ?? 'false') == 'false' ? 'selected' : '' }}>Nonaktif (Situs Normal Terbuka Publik)</option>
                        <option value="true" {{ ($settings['maintenance_mode'] ?? 'false') == 'true' ? 'selected' : '' }}>Aktif (Tutup Sementara dengan Pesan Pemeliharaan)</option>
                    </select>
                </div>
            </div>

            <!-- SEKSI 3: LOGO & FAVICON -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                <!-- Logo -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Logo Utama</label>
                    @if(!empty($settings['app_logo']))
                        <div class="mb-3 p-3 border rounded-xl bg-gray-50 inline-block">
                            <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="h-10 object-contain">
                        </div>
                    @endif
                    <input type="file" name="app_logo" accept="image/png, image/jpeg, image/svg+xml" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Favicon -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Favicon Browser</label>
                    @if(!empty($settings['app_favicon']))
                        <div class="mb-3 p-3 border rounded-xl bg-gray-50 inline-block">
                            <img src="{{ asset($settings['app_favicon']) }}" alt="Favicon" class="h-8 w-8 object-contain">
                        </div>
                    @endif
                    <input type="file" name="app_favicon" accept="image/png, image/x-icon, image/ico" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

        </div>

        <div class="p-6 bg-gray-50 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm shadow transition">
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection