@extends('layouts.admin')

@section('title', 'Edit Pengguna - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Edit Data Pengguna')

@section('header_action')
<a href="{{ route('admin.users') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl transition">
    ← Kembali
</a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm max-w-2xl overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-900 text-base">Perbarui Data Akun: {{ $user->name }}</h3>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 space-y-5">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <!-- Email / NISN -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Email / NISN</label>
            <input type="text" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <!-- Role -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Peran (Role)</label>
            <select name="role_id" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }} ({{ $role->display_name ?? 'Akses' }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Reset Password (Opsional) -->
        <div class="pt-4 border-t border-gray-100">
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ganti Password (Opsional)</label>
            <p class="text-xs text-gray-400 mb-2">Biarkan kosong jika tidak ingin mengubah password lama pengguna.</p>
            <input type="password" name="password" placeholder="Masukkan password baru (minimal 6 karakter)" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.users') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
