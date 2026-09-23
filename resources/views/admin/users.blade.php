@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - ' . ($settings['app_name'] ?? 'Admin'))
@section('header_title', 'Manajemen Pengguna & Siswa')

@section('header_action')
<a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 transition inline-flex items-center gap-2">
    <span>+</span> <span>Tambah Pengguna</span>
</a>
@endsection

@section('content')

<!-- Form Import CSV & Search Bar -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    
    <!-- Box Import CSV -->
    <div class="lg:col-span-2 bg-gradient-to-r from-blue-50/80 to-indigo-50/50 border border-blue-200/80 p-5 rounded-3xl shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-blue-900 text-sm flex items-center gap-2">
                <span>📥</span> <span>Import Siswa Masal (CSV)</span>
            </h3>
            <p class="text-xs text-blue-700 mt-1">Format: <b>Nama, Email/NISN, Password</b> (Pemisah <code>,</code> atau <code>;</code> otomatis dideteksi).</p>
        </div>
        <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 w-full md:w-auto">
            @csrf
            <input type="file" name="file_csv" accept=".csv, .txt" required class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer bg-white border border-blue-200 rounded-xl">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-bold shadow whitespace-nowrap transition">
                Import
            </button>
        </form>
    </div>

    <!-- Live Search Filter -->
    <div class="bg-white border border-slate-200/90 p-5 rounded-3xl shadow-sm flex flex-col justify-center">
        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Cari Cepat Pengguna</label>
        <div class="relative">
            <input type="text" id="user-search" placeholder="Ketik nama atau email..." onkeyup="filterUsers()" class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
        </div>
    </div>

</div>

<!-- Tabel Pengguna -->
<div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-extrabold text-slate-900">Daftar Akun Terdaftar</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola kredensial, peran akses, serta progres level & XP siswa</p>
        </div>
        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-xl" id="total-users-badge">
            Total: {{ count($users) }} Akun
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs divide-y divide-slate-100" id="users-table">
            <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4">Email / NISN</th>
                    <th class="px-6 py-4">Peran (Role)</th>
                    <th class="px-6 py-4">Level & XP</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @foreach ($users as $user)
                <tr class="hover:bg-slate-50/80 transition user-row">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-xs shadow-sm">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="font-bold text-slate-900 text-sm user-name">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-mono user-email">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($user->role_id == 1)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-rose-50 text-rose-700 border border-rose-200">Super Admin</span>
                        @elseif ($user->role_id == 2)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">Guru</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200">Siswa</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-600">
                        @if ($user->role_id == 3)
                            <span class="font-bold text-slate-800">Level {{ $user->level }}</span>
                            <span class="text-amber-600 font-bold ml-1.5">({{ $user->xp }} XP)</span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 px-3 py-1.5 rounded-xl font-bold transition duration-150">
                                ✏️ Edit
                            </a>
                            
                            <!-- Delete Button -->
                            @if(Auth::id() != $user->id)
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 px-3 py-1.5 rounded-xl font-bold transition duration-150">
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

<script>
function filterUsers() {
    const input = document.getElementById('user-search').value.toLowerCase();
    const rows = document.querySelectorAll('.user-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const name = row.querySelector('.user-name').innerText.toLowerCase();
        const email = row.querySelector('.user-email').innerText.toLowerCase();
        if (name.includes(input) || email.includes(input)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('total-users-badge').innerText = `Menampilkan: ${visibleCount} Akun`;
}
</script>
@endsection