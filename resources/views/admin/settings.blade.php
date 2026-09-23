@extends('layouts.admin')

@section('title', 'Global Settings - ' . ($settings['app_name'] ?? 'CMS'))
@section('header_title', 'Pengaturan Aplikasi (Global Settings)')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow max-w-4xl overflow-hidden">
    <!-- Pastikan enctype="multipart/form-data" ada karena kita akan upload file gambar -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">
        @csrf

        <div class="p-6 space-y-6">
            <!-- Nama Aplikasi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Aplikasi / Website</label>
                <input type="text" name="app_name" value="{{ $settings['app_name'] ?? '' }}" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                <p class="text-xs text-gray-500 mt-1">Nama ini akan muncul di title bar browser dan sidebar panel admin.</p>
            </div>

            <!-- Warna Utama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Utama (Primary Color)</label>
                <div class="flex items-center gap-4">
                    <input type="color" name="primary_color" value="{{ $settings['primary_color'] ?? '#1D4ED8' }}" class="h-10 w-20 cursor-pointer border rounded">
                    <input type="text" value="{{ $settings['primary_color'] ?? '#1D4ED8' }}" class="px-4 py-2 border rounded-lg bg-gray-50 text-gray-500" disabled>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Upload Logo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Utama</label>
                    @if(isset($settings['app_logo']) && $settings['app_logo'] != 'default_logo.png')
                        <div class="mb-3 p-2 border rounded bg-gray-50 inline-block">
                            <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="h-12 object-contain">
                        </div>
                    @endif
                    <input type="file" name="app_logo" accept="image/png, image/jpeg, image/svg+xml" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, SVG.</p>
                </div>

                <!-- Upload Favicon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Favicon (Ikon Browser)</label>
                    @if(isset($settings['app_favicon']) && $settings['app_favicon'] != 'default_favicon.ico')
                        <div class="mb-3 p-2 border rounded bg-gray-50 inline-block">
                            <img src="{{ asset($settings['app_favicon']) }}" alt="Favicon" class="h-8 w-8 object-contain">
                        </div>
                    @endif
                    <input type="file" name="app_favicon" accept="image/png, image/x-icon, image/ico" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Gunakan resolusi kotak (16x16 atau 32x32 pixel).</p>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Mode Pemeliharaan (Maintenance Mode)</label>
                <select name="maintenance_mode" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="false" {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == 'false') ? 'selected' : '' }}>Nonaktif (Bisa diakses publik)</option>
                    <option value="true" {{ (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == 'true') ? 'selected' : '' }}>Aktif (Situs ditutup sementara)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Jika diaktifkan, siswa tidak bisa login dan belajar sementara waktu.</p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection