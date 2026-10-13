<?php
// Otomatis sinkronkan dan catat pengunjung ke database Laravel (visitor_traffic)
try {
    $envPath = dirname(dirname(__DIR__)) . '/.env';
    $dbConfig = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'chaf2674_vxai_codinglab',
        'username' => 'chaf2674_vxai_codinglab',
        'password' => 'Yp4CK}&UFAQ]#5DN',
    ];

    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) continue;
            if (str_contains($line, '=')) {
                list($key, $val) = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val, " \t\n\r\0\x0B\"'");
                if ($key === 'DB_HOST') $dbConfig['host'] = $val;
                if ($key === 'DB_PORT') $dbConfig['port'] = $val;
                if ($key === 'DB_DATABASE') $dbConfig['database'] = $val;
                if ($key === 'DB_USERNAME') $dbConfig['username'] = $val;
                if ($key === 'DB_PASSWORD') $dbConfig['password'] = $val;
            }
        }
    }

    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 2,
    ]);

    // Dapatkan IP Pengunjung
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    if (strpos($ip, ',') !== false) {
        $ip = trim(explode(',', $ip)[0]);
    }
    $path = 'public/modelc';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $referer = substr($_SERVER['HTTP_REFERER'] ?? '', 0, 250);

    // Deteksi Perangkat
    $device = 'Desktop';
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
        $device = 'Tablet';
    } elseif (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent)) {
        $device = 'Mobile';
    }

    // Deteksi Browser
    $browser = 'Lainnya';
    if (preg_match('/edg/i', $userAgent)) $browser = 'Edge';
    elseif (preg_match('/chrome/i', $userAgent)) $browser = 'Chrome';
    elseif (preg_match('/safari/i', $userAgent) && !preg_match('/chrome/i', $userAgent)) $browser = 'Safari';
    elseif (preg_match('/firefox/i', $userAgent)) $browser = 'Firefox';
    elseif (preg_match('/opera|opr/i', $userAgent)) $browser = 'Opera';

    // Deduplikasi kunjungan per IP dalam rentang 5 menit
    $stmt = $pdo->prepare("SELECT id FROM visitor_traffic WHERE ip_address = ? AND page_url = ? AND visited_at >= DATE_SUB(NOW(), INTERVAL 5 MINUTE) LIMIT 1");
    $stmt->execute([$ip, $path]);
    if (!$stmt->fetch()) {
        $ins = $pdo->prepare("INSERT INTO visitor_traffic (ip_address, page_url, referer, device, browser, user_agent, visited_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $ins->execute([$ip, $path, $referer, $device, $browser, substr($userAgent, 0, 255)]);
    }
} catch (\Throwable $e) {
    // Abaikan jika database belum siap agar halaman tetap cepat dan tampil sempurna
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengusulan Model C - Guru ASN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Efek Motion: Animasi Gradien Bergerak */
        .bg-animate {
            background: linear-gradient(-45deg, #dbeafe, #93c5fd, #bfdbfe, #e0f2fe);
            background-size: 400% 400%;
            animation: gradient 12s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
    
    <!-- Google AdSense Script -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3916810451792947"
         crossorigin="anonymous"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8T8L9ENK2Z"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-8T8L9ENK2Z');
    </script>
</head>
<body class="bg-animate flex items-center justify-center min-h-screen p-4">
    
    <div class="w-full max-w-6xl flex items-center justify-center gap-6 my-auto">
        
        <!-- Iklan Samping Kiri (Desktop Skyscraper) -->
        <aside class="hidden lg:flex flex-col items-center justify-center w-[160px] xl:w-[180px] shrink-0">
            <div class="w-full bg-white/70 backdrop-blur-sm rounded-xl p-2 border border-blue-200/50 shadow-md text-center min-h-[500px] xl:min-h-[600px] flex flex-col justify-center items-center overflow-hidden">
                <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider mb-2">Iklan</span>
                <ins class="adsbygoogle"
                     style="display:block;width:100%;height:100%;min-height:480px"
                     data-ad-client="ca-pub-3916810451792947"
                     data-ad-slot="1234567890"
                     data-ad-format="vertical"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </aside>

        <!-- Card Utama (Tampilan Asli & Rapi) -->
        <main class="max-w-lg w-full bg-white/95 backdrop-blur-md rounded-xl shadow-2xl p-8 text-center border-t-4 border-blue-600 shrink-0">
            <div class="mb-6">
                <!-- Logo Pemprov -->
                <img src="Logo.png" alt="Logo Pemprov NTT" class="w-20 h-auto mx-auto mb-4 object-contain">
                
                <h1 class="text-2xl font-bold text-gray-800">Pengusulan Model C</h1>
                <p class="text-gray-500 mt-2 text-sm">Portal Resmi Pengusulan Guru ASN</p>
            </div>
            
            <div class="bg-blue-50/80 p-5 rounded-lg text-left mb-6">
                <h2 class="font-semibold text-blue-800 text-sm mb-3">Persiapkan Dokumen Berikut (Format PDF/Scan):</h2>
                <ul class="list-disc list-inside text-sm text-blue-700 space-y-2">
                    <li>Kartu Tanda Penduduk (KTP)</li>
                    <li>Kartu Keluarga (KK)</li>
                    <li>Dokumen Kepegawaian</li>
                    <li>Akta Nikah Suami dan Istri</li>
                    <li>Dokumen Anak (jika mengajukan tunjangan anak)</li>
                    <li>Daftar Gaji / Slip Gaji (Jika Suami atau Istri ASN)</li>
                    <li class="align-top">
                        <span class="inline-block align-top">Formulir Model C</span>
                        <div class="ml-5 mt-2 mb-1">
                            <a href="https://docs.google.com/document/d/1Kv1KPEXgpdrIhqI2QUF8JdtDZQwYCA8e/edit?usp=sharing&ouid=112867452598279288756&rtpof=true&sd=true" target="_blank" class="inline-flex items-center text-xs bg-white text-blue-600 border border-blue-400 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded transition duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Contoh Formulir
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Tombol Aksi Pengusulan -->
            <a href="https://forms.gle/Efa19HEzHovZX9M97" 
               target="_blank"
               class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                <span>Mulai Isi Pengusulan</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
            
            <p class="text-xs text-gray-400 mt-6">
                &copy; 2026 <a href="https://vxai.online" class="hover:text-blue-600 underline">vxai.online</a>. Sistem Layanan Guru ASN.
            </p>
        </main>

        <!-- Iklan Samping Kanan (Desktop Skyscraper) -->
        <aside class="hidden lg:flex flex-col items-center justify-center w-[160px] xl:w-[180px] shrink-0">
            <div class="w-full bg-white/70 backdrop-blur-sm rounded-xl p-2 border border-blue-200/50 shadow-md text-center min-h-[500px] xl:min-h-[600px] flex flex-col justify-center items-center overflow-hidden">
                <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider mb-2">Iklan</span>
                <ins class="adsbygoogle"
                     style="display:block;width:100%;height:100%;min-height:480px"
                     data-ad-client="ca-pub-3916810451792947"
                     data-ad-slot="1234567890"
                     data-ad-format="vertical"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </aside>

    </div>

</body>
</html>