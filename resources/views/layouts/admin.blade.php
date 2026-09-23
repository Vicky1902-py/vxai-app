<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ' . ($settings['app_name'] ?? 'VxAI'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Admin -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col shrink-0">
            <div class="h-16 flex items-center px-6 border-b border-gray-800 justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center font-black text-sm">Vx</span>
                    <span class="font-extrabold text-base tracking-wide">{{ $settings['app_name'] ?? 'Admin Panel' }}</span>
                </div>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto text-sm">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition">
                    <span>📊</span> <span>Dashboard & Trafik</span>
                </a>
                <a href="{{ route('admin.submissions') }}" class="{{ request()->is('admin/submissions*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition">
                    <span>📁</span> <span>Hasil Koding Masuk</span>
                </a>
                <a href="{{ route('admin.users') }}" class="{{ request()->is('admin/users*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition">
                    <span>👥</span> <span>Manajemen User</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="{{ request()->is('admin/settings*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} flex items-center gap-3 px-4 py-2.5 rounded-xl font-medium transition">
                    <span>⚙️</span> <span>Pengaturan & AdSense</span>
                </a>

                <div class="pt-6 pb-2 px-3 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Tautan Cepat</div>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs text-blue-400 hover:bg-gray-800 transition">
                    <span>🌐</span> <span>Lihat Website Publik ➔</span>
                </a>
                <a href="{{ route('public.playground') }}" target="_blank" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs text-yellow-400 hover:bg-gray-800 transition">
                    <span>⚡</span> <span>Buka Live Playground ➔</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 mb-3 px-2">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center font-bold text-xs text-white">A</div>
                    <div class="truncate">
                        <div class="text-xs font-bold text-gray-200 truncate">{{ Auth::user()->name ?? 'Super Admin' }}</div>
                        <div class="text-[10px] text-gray-400">Super Administrator</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gray-800 hover:bg-red-600 text-gray-300 hover:text-white text-xs font-bold py-2 rounded-xl transition">
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-y-auto">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0">
                <h2 class="text-xl font-black text-gray-900">@yield('header_title', 'Dashboard')</h2>
                <div>@yield('header_action')</div>
            </header>
            
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-xl text-sm font-semibold shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl text-sm font-semibold shadow-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

    </div>
    @stack('scripts')
</body>
</html>