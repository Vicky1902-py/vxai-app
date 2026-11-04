<?php
// koneksi.php - Konfigurasi koneksi aman membaca dari .env
$envPath = dirname(dirname(__DIR__)) . '/.env';
$env = [];
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            list($key, $val) = explode('=', $line, 2);
            $env[trim($key)] = trim($val, " \t\n\r\0\x0B\"'");
        }
    }
}

$host = $env['DB_4D_HOST'] ?? $env['DB_HOST'] ?? '127.0.0.1';
$db   = $env['DB_4D_DATABASE'] ?? 'chaf2674_4dvx';
$user = $env['DB_4D_USERNAME'] ?? 'chaf2674_4dvx';
$pass = $env['DB_4D_PASSWORD'] ?? ($env['DB_PASSWORD'] ?? '');

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}
?>
