<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</title>
    
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
        .bg-argentina {
            background: repeating-linear-gradient(
                90deg,
                #FFFFFF,
                #FFFFFF 80px,
                #74ACDF 80px,
                #74ACDF 160px
            );
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.18);
        }
    </style>
</head>
<body class="bg-argentina min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="glass-card w-full max-w-md p-8 md:p-10 rounded-3xl border border-white/80 relative">
        
        <!-- Tombol Kembali ke Beranda -->
        <div class="mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-blue-600 transition bg-slate-100/80 hover:bg-blue-50 px-3.5 py-1.5 rounded-full">
                <span>←</span> <span>Kembali ke Beranda</span>
            </a>
        </div>

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-tr from-blue-600 to-indigo-600 text-white rounded-2xl flex items-center justify-center font-extrabold text-2xl mx-auto mb-4 shadow-lg shadow-blue-500/30">
                Vx
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
            <p class="text-slate-500 text-xs mt-1">Masuk ke Portal VxAI (Admin, Guru, Siswa)</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
                    <span>⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif
            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2" for="email">
                    Email / NISN / Username
                </label>
                <div class="relative">
                    <input type="text" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm bg-white/70 text-slate-900" placeholder="nama@email.com atau NISN" required autofocus>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2" for="password">
                    Kata Sandi (Password)
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm bg-white/70 text-slate-900" placeholder="••••••••" required>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                    <span class="ml-2 text-xs font-semibold text-slate-600">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition duration-150 shadow-lg shadow-blue-500/25 active:scale-[0.99] text-sm">
                Masuk ke Sistem
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}.<br>Akses Terpadu Siswa, Guru & Administrator.
        </div>
    </div>

</body>
</html>