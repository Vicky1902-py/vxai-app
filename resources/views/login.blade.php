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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-pattern {
            background-color: #0b132b;
            background-image: radial-gradient(#1e3a8a 1.2px, transparent 1.2px);
            background-size: 28px 28px;
        }
    </style>
</head>
<body class="hero-pattern min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Container Card (Split Layout Modern di Layar Desktop) -->
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200/90 flex flex-col md:flex-row relative">
        
        <!-- ============================================== -->
        <!-- SISI KIRI: Visual Lanskap NTT & Brand Showcase -->
        <!-- ============================================== -->
        <div class="relative md:w-5/12 bg-slate-900 hidden md:flex flex-col justify-between p-8 text-white overflow-hidden">
            <!-- Background Foto NTT Labuan Bajo/Padar -->
            <img src="https://images.unsplash.com/photo-1548784741-0e7f108d7755?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=85&w=800" 
                 alt="NTT Padar Island" 
                 class="absolute inset-0 w-full h-full object-cover brightness-75">
            
            <!-- Deep Blue Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-900/60 to-slate-950/80"></div>

            <!-- Header Kiri -->
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-sky-200 hover:text-white transition bg-white/10 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/10">
                    <span>← Kembali ke Beranda</span>
                </a>
                <div class="mt-8">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-blue-500/40 mb-3">
                        Vx
                    </div>
                    <h3 class="text-2xl font-black text-white tracking-tight leading-snug">
                        {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}
                    </h3>
                    <p class="text-xs text-sky-200 font-bold uppercase tracking-wider mt-1">
                        Gerbang Literasi Koding NTT
                    </p>
                </div>
            </div>

            <!-- Footer Kiri (Konteks NTT) -->
            <div class="relative z-10 pt-8 border-t border-white/10">
                <p class="text-xs text-slate-200 leading-relaxed font-normal">
                    "Mencetak generasi unggul rekayasa perangkat lunak dan AI dari SMKN 1 Kupang Barat untuk Indonesia dan dunia."
                </p>
                <div class="mt-3 flex items-center gap-2 text-[11px] text-sky-300 font-semibold">
                    <span>🏝️</span>
                    <span>Labuan Bajo • Kupang • Flobamorata</span>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- SISI KANAN: Formulir Login Jelas & High Contrast -->
        <!-- ============================================== -->
        <div class="flex-1 p-8 sm:p-10 md:p-12 flex flex-col justify-between">
            
            <!-- Tombol Kembali untuk Tampilan Mobile -->
            <div class="md:hidden mb-6 flex justify-between items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-blue-600 transition bg-slate-100 px-3 py-1.5 rounded-full">
                    <span>←</span> <span>Beranda</span>
                </a>
                <span class="text-xs font-bold text-blue-600">SMKN 1 Kupang Barat</span>
            </div>

            <div>
                <!-- Brand Header Kanan -->
                <div class="mb-8">
                    <div class="flex items-center gap-2.5 mb-2 md:hidden">
                        <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-base shadow">Vx</div>
                        <span class="font-black text-lg text-slate-900">{{ $settings['app_name'] ?? 'VxAI' }}</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1">Masuk ke Portal Akses Terpadu (Admin, Guru, dan Siswa)</p>
                </div>

                <!-- Alert Pesan Error jika Ada -->
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2.5 mb-6">
                        <span class="text-base">⚠️</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2" for="email">
                            Email / NISN / Username
                        </label>
                        <div class="relative">
                            <input type="text" name="email" id="email" value="{{ old('email') }}" 
                                   class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition text-sm bg-white text-slate-900 font-medium placeholder-slate-400 shadow-sm" 
                                   placeholder="nama@email.com atau NISN" required autofocus>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2" for="password">
                            Kata Sandi (Password)
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" 
                                   class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition text-sm bg-white text-slate-900 font-medium placeholder-slate-400 shadow-sm" 
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                            <span class="ml-2 font-semibold text-slate-600">Ingat Saya di Perangkat Ini</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition duration-150 shadow-lg shadow-blue-500/25 active:scale-[0.99] text-sm flex items-center justify-center gap-2">
                        <span>Masuk ke Sistem</span>
                        <span>➔</span>
                    </button>
                </form>
            </div>

            <!-- Footer Hak Cipta & NTT Context -->
            <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI Coding Lab' }}.<br>
                SMKN 1 Kupang Barat • Nusa Tenggara Timur.
            </div>

        </div>

    </div>

</body>
</html>