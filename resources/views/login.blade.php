<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VxAI Coding Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-argentina min-h-screen flex items-center justify-center p-4 font-sans">

    <div class="glass-card w-full max-w-md p-8 rounded-3xl border border-white">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-bold text-2xl mx-auto mb-4 shadow-lg">Vx</div>
            <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang Kembali</h2>
            <p class="text-gray-500 text-sm mt-1">Silakan masuk ke akun VxAI Coding Lab Anda</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">Email Admin / Guru / Siswa</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50" placeholder="Masukkan Email Anda" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/50" placeholder="••••••••" required>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-transform hover:-translate-y-0.5 shadow-md">
                Mulai Sesi
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500">
            &copy; 2026 VxAI Online. Sistem Informasi Manajemen Pembelajaran.
        </div>
    </div>

</body>
</html>