@extends('layouts.admin')

@section('title', 'Manajemen User - ' . ($settings['app_name'] ?? 'CMS'))
@section('header_title', 'Manajemen Pengguna')

@section('header_action')
<!-- Mengubah button menjadi tag <a> yang mengarah ke rute form create -->
<a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow inline-block transition">
    + Tambah Pengguna
</a>
@endsection

@section('content')

<!-- Menambahkan blok notifikasi sukses (hanya muncul jika ada pesan sukses dari controller) -->
@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
        {{ session('success') }}
    </div>
@endif

<!-- Error Notifikasi untuk Import -->
@if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
        {{ $errors->first() }}
    </div>
@endif

<!-- Form Import CSV -->
<div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
    <div>
        <h3 class="font-bold text-blue-800">Import Data Siswa Masal (CSV)</h3>
        <p class="text-sm text-blue-600 mt-1">Format kolom di Excel: <b>Nama, NISN/Email, Password</b>. Lalu <i>Save As -> CSV</i>. (Baris pertama akan diabaikan sebagai header).</p>
    </div>
    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 w-full md:w-auto">
        @csrf
        <input type="file" name="file_csv" accept=".csv" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer bg-white border border-blue-200 rounded-lg">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow whitespace-nowrap transition">Import Data</button>
    </form>
</div>

<!-- Tabel Pengguna -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email / NISN</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran (Role)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statistik Belajar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap"><div class="font-medium text-gray-900">{{ $user->name }}</div></td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if ($user->role_id == 1)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $user->role_name }}</span>
                    @elseif ($user->role_id == 2)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $user->role_name }}</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $user->role_name }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    @if ($user->role_id == 3) Level {{ $user->level }} ({{ $user->xp }} XP) @else - @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                    <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection