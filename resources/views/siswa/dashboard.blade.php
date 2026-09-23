<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ruang Belajar - {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</title>
    
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
        /* Sembunyikan scrollbar untuk kesan aplikasi native di HP */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased overflow-hidden">

    <!-- ========================================== -->
    <!-- 1. TAMPILAN DESKTOP (IDE / WORKSPACE MODE) -->
    <!-- Tampil hanya di layar menengah ke atas (md:flex) -->
    <!-- ========================================== -->
    <div class="hidden md:flex h-screen w-full bg-gray-900 text-white">
        
        <!-- Sidebar Desktop -->
        <aside class="w-64 border-r border-gray-800 flex flex-col">
            <div class="h-20 flex items-center px-6 border-b border-gray-800 justify-between">
                <a href="{{ route('home') }}" class="font-bold text-lg text-blue-400 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-sm">Vx</span>
                    <span>Workspace</span>
                </a>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2 text-xs font-semibold">
                <!-- Tautan Beranda Aktif -->
                <a href="{{ route('siswa.dashboard') }}" class="block px-4 py-2.5 bg-blue-600 rounded-xl text-white">🏠 Beranda Siswa</a>
                <!-- Tautan Coding Lab Aktif -->
                <a href="{{ route('public.playground') }}" class="block px-4 py-2.5 hover:bg-gray-800 text-gray-300 hover:text-white rounded-xl transition">🧪 Live Coding Lab</a>
                <a href="{{ route('public.tutorials') }}" class="block px-4 py-2.5 hover:bg-gray-800 text-gray-300 hover:text-white rounded-xl transition">📖 Panduan Koding</a>
                <a href="{{ route('home') }}" class="block px-4 py-2.5 hover:bg-gray-800 text-gray-300 hover:text-white rounded-xl transition">🌐 Halaman Utama</a>
            </nav>
            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center font-bold">{{ substr($user->name, 0, 1) }}</div>
                    <div>
                        <div class="text-sm font-semibold">{{ $user->name }}</div>
                        <div class="text-xs text-blue-400">Level {{ $user->level }} ({{ $user->xp }} XP)</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-400 text-sm hover:text-red-300">Keluar Sistem</button>
                </form>
            </div>
        </aside>

        <!-- Main Content Desktop -->
        <main class="flex-1 flex flex-col bg-[#1e1e1e]">
            <header class="h-16 border-b border-gray-800 flex items-center px-6 text-gray-300 bg-[#252526]">
                Overview Siswa
            </header>
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ $user->name }}! 👋</h1>
                <p class="text-gray-400 mb-8">Pilih menu di samping untuk mulai menulis kode hari ini.</p>
                
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-[#2d2d2d] p-6 rounded-xl border border-gray-700">
                        <h3 class="text-gray-400 text-sm">Progres Kelas HTML</h3>
                        <div class="mt-2 text-2xl font-bold text-green-400">75%</div>
                    </div>
                    <div class="bg-[#2d2d2d] p-6 rounded-xl border border-gray-700">
                        <h3 class="text-gray-400 text-sm">Challenge Diselesaikan</h3>
                        <div class="mt-2 text-2xl font-bold text-blue-400">12 Tantangan</div>
                    </div>
                </div>
            </div>
        </main>
    </div>


    <!-- ========================================== -->
    <!-- 2. TAMPILAN MOBILE (SUPER APP / GRAB STYLE) -->
    <!-- Tampil hanya di layar kecil (md:hidden) -->
    <!-- ========================================== -->
    <div class="flex flex-col h-screen w-full md:hidden bg-gray-50 relative">
        
        <!-- Header Profil & XP (Mirip Saldo OVO/Gopay) -->
        <div class="bg-blue-600 text-white p-5 rounded-b-[2rem] shadow-md z-10">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-sm text-blue-200">Selamat datang,</p>
                    <h2 class="text-lg font-bold">{{ $user->name }}</h2>
                </div>
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold text-xl shadow-inner">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-2xl shadow text-gray-800 flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-500 font-semibold mb-1">Status Keahlian</p>
                    <div class="text-xl font-extrabold text-blue-600">Level {{ $user->level }}</div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 font-semibold mb-1">Total Poin</p>
                    <div class="text-lg font-bold text-orange-500">⭐ {{ $user->xp }} XP</div>
                </div>
            </div>
        </div>

        <!-- Menu Utama (Mirip Menu Grab/Gojek) -->
        <div class="flex-1 overflow-y-auto no-scrollbar p-5 pb-24">
            
            <h3 class="font-bold text-gray-800 mb-4">Mulai Belajar 🚀</h3>
            <div class="grid grid-cols-4 gap-4 mb-8 text-center">
                <!-- Icon 1 -->
                <div>
                    <a href="#" class="w-14 h-14 mx-auto bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-2 shadow-sm active:scale-95 transition">📘</a>
                    <span class="text-xs font-semibold text-gray-600">Materi</span>
                </div>
                <!-- Icon 2: Tautan Koding Lab Aktif -->
                <div>
                    <a href="{{ route('siswa.playground') }}" class="w-14 h-14 mx-auto bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-2xl mb-2 shadow-sm active:scale-95 transition">💻</a>
                    <span class="text-xs font-semibold text-gray-600">Koding</span>
                </div>
                <!-- Icon 3 -->
                <div>
                    <a href="#" class="w-14 h-14 mx-auto bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-2 shadow-sm active:scale-95 transition">🤖</a>
                    <span class="text-xs font-semibold text-gray-600">AI Tutor</span>
                </div>
                <!-- Icon 4 -->
                <div>
                    <a href="#" class="w-14 h-14 mx-auto bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl mb-2 shadow-sm active:scale-95 transition">🏆</a>
                    <span class="text-xs font-semibold text-gray-600">Misi</span>
                </div>
            </div>

            <!-- Kartu Lanjutkan Belajar -->
            <h3 class="font-bold text-gray-800 mb-4">Lanjutkan Terakhir</h3>
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-4 flex items-center gap-4 active:bg-gray-50 transition">
                <div class="w-12 h-12 bg-red-100 text-red-500 rounded-xl flex items-center justify-center text-xl font-bold">5</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-gray-800">HTML Dasar - Heading</h4>
                    <div class="w-full bg-gray-200 h-1.5 rounded-full mt-2">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                <div class="text-gray-400">➔</div>
            </div>

        </div>

        <!-- Bottom Navigation Bar (Fixed at bottom) -->
        <div class="absolute bottom-0 w-full bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-20 pb-safe">
            <!-- Tautan Beranda Aktif -->
            <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center text-blue-600">
                <span class="text-xl mb-1">🏠</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-400 hover:text-blue-600">
                <span class="text-xl mb-1">📚</span>
                <span class="text-[10px] font-semibold">Kelasku</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-400 hover:text-blue-600">
                <span class="text-xl mb-1">💬</span>
                <span class="text-[10px] font-semibold">Diskusi</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="flex flex-col items-center">
                @csrf
                <button type="submit" class="flex flex-col items-center text-gray-400 hover:text-red-500">
                    <span class="text-xl mb-1">🚪</span>
                    <span class="text-[10px] font-semibold">Keluar</span>
                </button>
            </form>
        </div>

    </div>

</body>
</html>