<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VxAI Coding Lab - Platform Belajar Koding</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Motif Garis Jersey Argentina (#74ACDF dan #FFFFFF) */
        .bg-argentina {
            background: repeating-linear-gradient(
                90deg,
                #FFFFFF,
                #FFFFFF 80px,
                #74ACDF 80px,
                #74ACDF 160px
            );
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-argentina min-h-screen flex flex-col font-sans antialiased">
    
    <!-- Navbar -->
    <nav class="glass-effect fixed w-full z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-500 rounded text-white flex items-center justify-center font-bold">Vx</div>
                    <span class="font-bold text-xl text-gray-800">VxAI Coding Lab</span>
                </div>
                <div>
                    <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-semibold transition-all shadow-md">Masuk / Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center pt-20 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="glass-effect rounded-3xl shadow-2xl p-8 md:p-16 max-w-4xl w-full text-center transform transition-all hover:scale-[1.01]">
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                Kuasai <span class="text-blue-600">Koding dan Kecerdasan Artifisial</span> Langsung dari Browser
            </h1>
            <p class="text-lg md:text-xl text-gray-700 mb-10 max-w-2xl mx-auto">
                Platform pembelajaran interaktif yang dirancang khusus untuk mencetak talenta digital hebat di SMKN 1 Kupang Barat. Ketik kode, lihat hasil *real-time*, dan pecahkan tantangan bersama AI Tutor.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg transition-transform hover:-translate-y-1">Mulai Belajar Sekarang</a>
                <a href="#fitur" class="bg-white hover:bg-gray-50 text-blue-600 border-2 border-blue-600 px-8 py-4 rounded-xl font-bold text-lg shadow transition-transform hover:-translate-y-1">Lihat Kurikulum</a>
            </div>

            <!-- Fitur Cards -->
            <div id="fitur" class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-3xl mb-4">⚡</div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Live Code Editor</h3>
                    <p class="text-gray-600 text-sm">HTML, CSS, dan JavaScript dieksekusi langsung. Tanpa perlu instalasi aplikasi tambahan.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-3xl mb-4">🤖</div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">AI Code Tutor</h3>
                    <p class="text-gray-600 text-sm">Terjebak error? VxAI Tutor siap membantu menganalisis kode dan memberikan petunjuk secara instan.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-3xl mb-4">🏆</div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Sistem Gamifikasi</h3>
                    <p class="text-gray-600 text-sm">Kumpulkan XP, raih lencana (Badge), dan naikkan levelmu di setiap tantangan yang berhasil diselesaikan.</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>