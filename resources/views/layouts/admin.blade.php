<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Global -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-gray-800">
                <h1 class="text-xl font-bold tracking-wider">{{ $settings['app_name'] ?? 'CMS' }}</h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <!-- Logika request()->is() akan otomatis memberi warna biru pada menu yang sedang aktif -->
                <a href="/admin" class="{{ request()->is('admin') ? 'bg-blue-600' : 'hover:bg-gray-800' }} block px-4 py-2 rounded-lg">📊 Dashboard</a>
                <a href="{{ route('admin.submissions') }}" class="{{ request()->is('admin/submissions') ? 'bg-blue-600' : 'hover:bg-gray-800' }} block px-4 py-2 rounded-lg transition">📁 Hasil Koding Siswa</a>
                <a href="/admin/users" class="{{ request()->is('admin/users') ? 'bg-blue-600' : 'hover:bg-gray-800' }} block px-4 py-2 rounded-lg">👥 Manajemen User</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-800 rounded-lg">📚 Kurikulum & Modul</a>
                <a href="/admin/settings" class="{{ request()->is('admin/settings') ? 'bg-blue-600' : 'hover:bg-gray-800' }} block px-4 py-2 rounded-lg">⚙️ Global Settings</a>
            </nav>
            <div class="p-4 border-t border-gray-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-y-auto">
            <header class="h-16 bg-white shadow flex items-center justify-between px-6">
                <h2 class="text-2xl font-semibold text-gray-800">@yield('header_title', 'Dashboard')</h2>
                <!-- Slot untuk tombol khusus (seperti tombol Tambah User) -->
                <div>@yield('header_action')</div>
            </header>
            
            <div class="p-6">
                <!-- Konten spesifik setiap halaman akan masuk ke sini -->
                @yield('content')
            </div>
        </main>

    </div>
</body>
</html>