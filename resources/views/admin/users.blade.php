@extends('layouts.admin')

@section('title', 'Manajemen User - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Manajemen Pengguna & Siswa')

@section('header_action')
<a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow transition inline-flex items-center gap-1.5">
    <span>+</span> <span>Tambah Pengguna</span>
</a>
@endsection

@section('content')

<!-- Form Import CSV -->
<div class="bg-blue-50 border border-blue-200 p-5 rounded-2xl mb-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
    <div>
        <h3 class="font-bold text-blue-900 text-sm">Import Data Siswa Masal (CSV)</h3>
        <p class="text-xs text-blue-700 mt-1">Format kolom: <b>Nama, Email/NISN, Password</b> (Pemisah koma <code>,</code> atau titik koma <code>;</code> otomatis dideteksi).</p>
    </div>
    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 w-full md:w-auto">
        @csrf
        <input type="file" name="file_csv" accept=".csv, .txt" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-white border border-blue-200 rounded-xl">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-bold shadow whitespace-nowrap transition">
            Import CSV
        </button>
    </form>
</div>

<!-- Tabel Pengguna -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
        <span class="text-xs font-bold text-gray-500 uppercase">Daftar Akun Terdaftar ({{ count($users) }})</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-500 font-semibold uppercase">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Email / NISN</th>
                    <th class="px-6 py-3">Peran (Role)</th>
                    <th class="px-6 py-3">Level & XP</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-gray-900 text-sm">{{ $user->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-mono">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($user->role_id == 1)
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-red-100 text-red-800">Super Admin</span>
                        @elseif ($user->role_id == 2)
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-green-100 text-green-800">Guru</span>
                        @else
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-blue-100 text-blue-800">Siswa</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-600">
                        @if ($user->role_id == 3)
                            Level {{ $user->level }} <span class="text-orange-500 font-bold">({{ $user->xp }} XP)</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                                ✏️ Edit
                            </a>
                            
                            <!-- Delete Button -->
                            @if(Auth::id() != $user->id)
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection