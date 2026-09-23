@extends('layouts.admin')

@section('title', 'Tambah Pengguna - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Tambah Pengguna Baru')

@section('header_action')
<a href="{{ route('admin.users') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-4 py-2.5 rounded-xl transition">
    ← Kembali ke Daftar
</a>
@endsection

@section('content')
<div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm max-w-2xl overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-extrabold text-slate-900 text-base">Formulir Pendaftaran Akun</h3>
        <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun administrator, guru pengajar, atau siswa baru.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
        @csrf

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-xs font-semibold">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Misal: Budi Santoso" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email / NIP / NISN</label>
            <input type="text" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Misal: budi@sekolah.sch.id atau 12345678" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Peran Pengguna (Role)</label>
            <select name="role_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white" required>
                <option value="" disabled selected>-- Pilih Hak Akses --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }} ({{ $role->display_name ?? 'Akses' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi (Password Awal)</label>
            <input type="password" name="password" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Minimal 6 karakter" required>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.users') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md shadow-blue-500/20 text-xs transition duration-150">
                Simpan Pengguna Baru
            </button>
        </div>
    </form>
</div>
@endsection