<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ' . ($settings['app_name'] ?? 'VxAI'))</title>
    
    <!-- Favicon -->
    @if(!empty($settings['app_favicon']))
        <link rel="icon" href="{{ asset($settings['app_favicon']) }}">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre, .font-mono { font-family: 'JetBrains Mono', monospace; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex">
    
    <!-- Sidebar Admin -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 border-r border-slate-800 select-none z-20">
        
        <!-- Logo & Header -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800/80 justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center font-extrabold text-white text-lg shadow-lg shadow-blue-500/30">
                    Vx
                </div>
                <div>
                    <span class="font-extrabold text-sm tracking-tight text-white block leading-tight">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                    <span class="text-[10px] text-blue-400 font-bold uppercase tracking-wider">Control Panel</span>
                </div>
            </a>
        </div>
        
        <!-- Navigasi Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar text-xs font-semibold">
            
            <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menu Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150">
                <span class="text-base">📊</span> <span>Dashboard & Trafik</span>
            </a>

            <!-- Submisi Koding -->
            <a href="{{ route('admin.submissions') }}" class="{{ request()->is('admin/submissions*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150">
                <span class="text-base">💻</span> <span>Hasil Koding Siswa</span>
            </a>

            <!-- Kelola Berita & Artikel -->
            <a href="{{ route('admin.articles') }}" class="{{ request()->is('admin/articles*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150">
                <span class="text-base">📰</span> <span>Berita & Artikel</span>
            </a>

            <!-- Manajemen User -->
            <a href="{{ route('admin.users') }}" class="{{ request()->is('admin/users*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150">
                <span class="text-base">👥</span> <span>Manajemen Pengguna</span>
            </a>

            <!-- Pengaturan & AdSense -->
            <a href="{{ route('admin.settings') }}" class="{{ request()->is('admin/settings*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150">
                <span class="text-base">⚙️</span> <span>Pengaturan & AdSense</span>
            </a>

            <div class="pt-6 px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Akses Langsung</div>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-blue-400 transition">
                <span class="flex items-center gap-2.5">
                    <span>🌐</span> <span>Website Publik</span>
                </span>
                <span class="text-xs">↗</span>
            </a>

            <a href="{{ route('public.playground') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-yellow-400 transition">
                <span class="flex items-center gap-2.5">
                    <span>⚡</span> <span>Live Playground</span>
                </span>
                <span class="text-xs">↗</span>
            </a>

        </nav>

        <!-- Profile Bar Bawah -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
            <div class="flex items-center gap-3 mb-3 px-1">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center font-black text-xs text-white shadow">
                    A
                </div>
                <div class="truncate flex-1">
                    <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-emerald-400 font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Super Admin</span>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-slate-800 hover:bg-rose-600/90 text-slate-300 hover:text-white text-xs font-semibold py-2.5 rounded-xl transition duration-150 flex items-center justify-center gap-2">
                    <span>🚪</span> <span>Keluar Sistem</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-8 shrink-0 z-10">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">@yield('header_title', 'Dashboard')</h2>
                <p class="text-xs text-slate-500 mt-0.5">Sistem Manajemen & Pemantau Platform VxAI</p>
            </div>
            <div class="flex items-center gap-4">
                @yield('header_action')
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 overflow-y-auto custom-scrollbar p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-semibold flex items-start gap-3 shadow-sm">
                        <span class="text-base text-emerald-500">✓</span>
                        <div class="flex-1 leading-relaxed">{{ session('success') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl text-xs font-semibold flex items-start gap-3 shadow-sm">
                        <span class="text-base text-rose-500">⚠️</span>
                        <div class="flex-1 leading-relaxed">{{ $errors->first() }}</div>
                    </div>
                @endif

                @yield('content')

            </div>
        </main>

    </div>

    @stack('scripts')
</body>
</html>