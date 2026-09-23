@extends('layouts.admin')

@section('title', 'Tambah Pengguna - ' . ($settings['app_name'] ?? 'CMS'))
@section('header_title', 'Tambah Pengguna Baru')

@section('header_action')
<a href="{{ route('admin.users') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold shadow">
    ← Kembali
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow max-w-3xl mx-auto overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-bold text-gray-800">Formulir Registrasi Akun</h3>
        <p class="text-sm text-gray-500 mt-1">Gunakan form ini untuk mendaftarkan akun pengajar atau siswa baru.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        <!-- Menampilkan pesan error validasi jika ada -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4">
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Misal: Budi Santoso" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Email / NIP / NISN</label>
            <input type="text" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Misal: 12345678 (sebagai username)" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Peran Pengguna (Role)</label>
            <select name="role_id" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white" required>
                <option value="" disabled selected>-- Pilih Peran --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Sementara</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Minimal 6 karakter" required>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                Simpan Data Pengguna
            </button>
        </div>
    </form>
</div>
@endsection