<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Dalam Pemeliharaan - {{ $settings['app_name'] ?? 'VxAI' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="max-w-md w-full bg-gray-800 border border-gray-700 rounded-3xl p-8 text-center shadow-2xl">
        <div class="w-20 h-20 bg-yellow-500/10 text-yellow-400 rounded-full flex items-center justify-center mx-auto text-4xl mb-6 border border-yellow-500/20">
            🚧
        </div>
        <h1 class="text-2xl font-black mb-3">Situs Sedang Diperbarui</h1>
        <p class="text-gray-400 text-sm leading-relaxed mb-6">
            Kami sedang melakukan peningkatan performa dan pemeliharaan sistem berkala pada platform <strong>{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</strong>. Layanan akan segera aktif kembali beberapa saat lagi.
        </p>
        <div class="pt-4 border-t border-gray-700 flex justify-between items-center text-xs text-gray-500">
            <span>&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'VxAI' }}</span>
            <a href="{{ route('login') }}" class="text-gray-400 hover:text-white underline">Akses Administrator</a>
        </div>
    </div>
</body>
</html>
