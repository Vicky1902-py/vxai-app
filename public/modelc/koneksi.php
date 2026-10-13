<?php
// koneksi.php
$host = "localhost";
$db   = "chaf2674_4dvx";      // Ganti dengan nama database Anda, misal: usercpanel_toto
$user = "chaf2674_4dvx";      // Ganti dengan user database Anda, misal: usercpanel_admin_toto
$pass = "0kB8iYw2.vSoRU[N";  // Ganti dengan password yang Anda buat tadi

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}
?>