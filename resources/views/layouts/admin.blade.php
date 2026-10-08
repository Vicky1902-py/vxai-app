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

    <script>
        (function() {
            try {
                if (localStorage.getItem('vxai_admin_sidebar_collapsed') === 'true') {
                    document.documentElement.classList.add('sidebar-collapsed');
                }
            } catch (e) {}
        })();
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre, .font-mono { font-family: 'JetBrains Mono', monospace; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Sidebar Auxiliary Pane Transition & Styles */
        #sidebar-admin {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-toggle-arrow {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Collapsed State (Mini Icon-only) */
        html.sidebar-collapsed #sidebar-admin {
            width: 5rem !important; /* 80px */
        }
        html.sidebar-collapsed .sidebar-text,
        html.sidebar-collapsed .sidebar-header-section {
            display: none !important;
        }
        html.sidebar-collapsed .sidebar-divider-collapsed {
            display: block !important;
        }
        html.sidebar-collapsed .sidebar-header-box {
            justify-content: center !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        html.sidebar-collapsed .sidebar-logo-link {
            justify-content: center !important;
            margin: 0 auto !important;
        }
        html.sidebar-collapsed .sidebar-nav {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        html.sidebar-collapsed .sidebar-link {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 3.25rem !important;
            height: 3.25rem !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        html.sidebar-collapsed .sidebar-link span.text-base {
            font-size: 1.25rem !important;
        }
        html.sidebar-collapsed .sidebar-profile-footer {
            padding: 0.75rem 0.5rem !important;
        }
        html.sidebar-collapsed .sidebar-profile-container {
            justify-content: center !important;
            margin-bottom: 0.75rem !important;
            padding: 0 !important;
        }
        html.sidebar-collapsed .sidebar-logout-btn {
            width: 3.25rem !important;
            height: 3.25rem !important;
            padding: 0 !important;
            margin: 0 auto !important;
            border-radius: 0.75rem !important;
        }
        html.sidebar-collapsed .sidebar-toggle-arrow {
            transform: rotate(180deg) !important;
        }
        #sidebar-floating-tooltip {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex">
    
    <!-- Sidebar Admin -->
    <aside id="sidebar-admin" class="relative w-64 bg-slate-900 text-white flex flex-col shrink-0 border-r border-slate-800 select-none z-20">
        
        <!-- Toggle Edge Button (Auxiliary Pane Toggle) -->
        <button type="button" id="btn-toggle-sidebar-edge" class="absolute -right-3.5 top-6 w-7 h-7 bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white rounded-full border-2 border-slate-900 shadow-md flex items-center justify-center z-30 transition-all duration-200 group" title="Kecilkan / Besarkan Menu Sidebar (Ctrl+B)">
            <svg class="w-3.5 h-3.5 sidebar-toggle-arrow text-slate-300 group-hover:text-white group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Logo & Header -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800/80 justify-between sidebar-header-box">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 sidebar-logo-link overflow-hidden" title="{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}">
                <div class="w-10 h-10 shrink-0 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center font-extrabold text-white text-lg shadow-lg shadow-blue-500/30">
                    Vx
                </div>
                <div class="sidebar-text">
                    <span class="font-extrabold text-sm tracking-tight text-white block leading-tight whitespace-nowrap">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                    <span class="text-[10px] text-blue-400 font-bold uppercase tracking-wider block">Control Panel</span>
                </div>
            </a>
        </div>
        
        <!-- Navigasi Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar text-xs font-semibold sidebar-nav">
            
            <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider sidebar-header-section">Menu Utama</div>
            <div class="hidden sidebar-divider-collapsed border-t border-slate-800/80 my-2"></div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" aria-label="Dashboard & Trafik" data-tooltip="Dashboard & Trafik" class="{{ request()->is('admin') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150 sidebar-link">
                <span class="text-base shrink-0">📊</span> <span class="sidebar-text truncate">Dashboard & Trafik</span>
            </a>

            <!-- Submisi Koding -->
            <a href="{{ route('admin.submissions') }}" aria-label="Hasil Koding Siswa" data-tooltip="Hasil Koding Siswa" class="{{ request()->is('admin/submissions*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150 sidebar-link">
                <span class="text-base shrink-0">💻</span> <span class="sidebar-text truncate">Hasil Koding Siswa</span>
            </a>

            <!-- Kelola Berita & Artikel -->
            <a href="{{ route('admin.articles') }}" aria-label="Berita & Artikel" data-tooltip="Berita & Artikel" class="{{ request()->is('admin/articles*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150 sidebar-link">
                <span class="text-base shrink-0">📰</span> <span class="sidebar-text truncate">Berita & Artikel</span>
            </a>

            <!-- Kelola Modul Playground -->
            <a href="{{ route('admin.playground') }}" aria-label="Modul Playground" data-tooltip="Modul Playground" class="{{ request()->is('admin/playground*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150 sidebar-link">
                <span class="text-base shrink-0">🎮</span> <span class="sidebar-text truncate">Modul Playground</span>
            </a>

            <!-- Manajemen User -->
            <a href="{{ route('admin.users') }}" aria-label="Manajemen Pengguna" data-tooltip="Manajemen Pengguna" class="{{ request()->is('admin/users*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150 sidebar-link">
                <span class="text-base shrink-0">👥</span> <span class="sidebar-text truncate">Manajemen Pengguna</span>
            </a>

            <!-- Pengaturan & AdSense -->
            <a href="{{ route('admin.settings') }}" aria-label="Pengaturan & AdSense" data-tooltip="Pengaturan & AdSense" class="{{ request()->is('admin/settings*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }} flex items-center gap-3 px-3.5 py-3 rounded-xl transition duration-150 sidebar-link">
                <span class="text-base shrink-0">⚙️</span> <span class="sidebar-text truncate">Pengaturan & AdSense</span>
            </a>

            <div class="pt-6 px-3 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider sidebar-header-section">Akses Langsung</div>
            <div class="hidden sidebar-divider-collapsed border-t border-slate-800/80 my-3"></div>

            <a href="{{ route('home') }}" target="_blank" aria-label="Website Publik" data-tooltip="Website Publik (Tab Baru)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-blue-400 transition sidebar-link">
                <span class="flex items-center gap-2.5">
                    <span class="text-base shrink-0">🌐</span> <span class="sidebar-text truncate">Website Publik</span>
                </span>
                <span class="text-xs sidebar-text">↗</span>
            </a>

            <a href="{{ route('public.playground') }}" target="_blank" aria-label="Live Playground" data-tooltip="Live Playground (Tab Baru)" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-yellow-400 transition sidebar-link">
                <span class="flex items-center gap-2.5">
                    <span class="text-base shrink-0">⚡</span> <span class="sidebar-text truncate">Live Playground</span>
                </span>
                <span class="text-xs sidebar-text">↗</span>
            </a>

        </nav>

        <!-- Profile Bar Bawah -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/40 sidebar-profile-footer">
            <div class="flex items-center gap-3 mb-3 px-1 sidebar-profile-container">
                <div class="w-9 h-9 shrink-0 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center font-black text-xs text-white shadow" title="{{ Auth::user()->name ?? 'Administrator' }}">
                    A
                </div>
                <div class="truncate flex-1 sidebar-text">
                    <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-[10px] text-emerald-400 font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Super Admin</span>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" aria-label="Keluar Sistem" data-tooltip="Keluar Sistem" class="w-full bg-slate-800 hover:bg-rose-600/90 text-slate-300 hover:text-white text-xs font-semibold py-2.5 rounded-xl transition duration-150 flex items-center justify-center gap-2 sidebar-logout-btn">
                    <span class="text-base shrink-0">🚪</span> <span class="sidebar-text">Keluar Sistem</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200/80 flex items-center justify-between px-6 sm:px-8 shrink-0 z-10">
            <div class="flex items-center gap-4">
                <!-- Toggle Sidebar Auxiliary Button in Topbar -->
                <button type="button" id="btn-toggle-sidebar-topbar" class="p-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition shadow-sm flex items-center justify-center group" title="Kecilkan / Besarkan Menu Sidebar (Ctrl+B)">
                    <svg class="w-5 h-5 text-slate-600 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">@yield('header_title', 'Dashboard')</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Sistem Manajemen & Pemantau Platform VxAI</p>
                </div>
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

                @if(isset($errors) && $errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl text-xs font-semibold flex items-start gap-3 shadow-sm">
                        <span class="text-base text-rose-500">⚠️</span>
                        <div class="flex-1 leading-relaxed">{{ $errors->first() }}</div>
                    </div>
                @endif

                @yield('content')

            </div>
        </main>

    </div>

    <!-- Sidebar Auxiliary Pane Toggle & Floating Tooltip Script -->
    <script>
        (function() {
            const toggleSidebar = () => {
                const isCurrentlyCollapsed = document.documentElement.classList.contains('sidebar-collapsed');
                if (isCurrentlyCollapsed) {
                    document.documentElement.classList.remove('sidebar-collapsed');
                    localStorage.setItem('vxai_admin_sidebar_collapsed', 'false');
                } else {
                    document.documentElement.classList.add('sidebar-collapsed');
                    localStorage.setItem('vxai_admin_sidebar_collapsed', 'true');
                }
            };

            // Bind Toggle Buttons
            const edgeBtn = document.getElementById('btn-toggle-sidebar-edge');
            const topbarBtn = document.getElementById('btn-toggle-sidebar-topbar');

            if (edgeBtn) edgeBtn.addEventListener('click', toggleSidebar);
            if (topbarBtn) topbarBtn.addEventListener('click', toggleSidebar);

            // Shortcut Ctrl+B / Cmd+B to toggle sidebar
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && (e.key === 'b' || e.key === 'B')) {
                    const activeTag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
                    if (activeTag !== 'input' && activeTag !== 'textarea') {
                        e.preventDefault();
                        toggleSidebar();
                    }
                }
            });

            // Floating Tooltip for Icon-only Mode
            const tooltipEl = document.createElement('div');
            tooltipEl.id = 'sidebar-floating-tooltip';
            tooltipEl.className = 'fixed pointer-events-none px-3 py-1.5 bg-slate-900 text-white text-xs font-bold rounded-lg shadow-2xl border border-slate-700/80 z-50 transition-opacity duration-150 opacity-0 whitespace-nowrap hidden';
            document.body.appendChild(tooltipEl);

            const items = document.querySelectorAll('.sidebar-link, .sidebar-logout-btn');
            items.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    if (!document.documentElement.classList.contains('sidebar-collapsed')) return;
                    const text = item.getAttribute('data-tooltip');
                    if (!text) return;

                    tooltipEl.textContent = text;
                    tooltipEl.classList.remove('hidden');

                    const rect = item.getBoundingClientRect();
                    tooltipEl.style.top = `${rect.top + (rect.height / 2) - (tooltipEl.offsetHeight / 2)}px`;
                    tooltipEl.style.left = `${rect.right + 12}px`;
                    
                    requestAnimationFrame(() => {
                        tooltipEl.classList.remove('opacity-0');
                    });
                });

                item.addEventListener('mouseleave', () => {
                    tooltipEl.classList.add('opacity-0');
                    setTimeout(() => {
                        if (tooltipEl.classList.contains('opacity-0')) {
                            tooltipEl.classList.add('hidden');
                        }
                    }, 150);
                });
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>