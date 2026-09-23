<?php
// index.php
require 'koneksi.php';

// Menarik 100 data untuk tabel riwayat
$query = "SELECT * FROM keluaran_toto ORDER BY tanggal DESC LIMIT 100";
$result = $conn->query($query);

// Menarik 7 data keluaran terakhir khusus untuk Analisis Algoritma Opsi 2 
$query_7hari = "SELECT * FROM keluaran_toto ORDER BY tanggal DESC LIMIT 7";
$result_7hari = $conn->query($query_7hari);

$history = [];
if ($result_7hari->num_rows > 0) {
    while($row = $result_7hari->fetch_assoc()) {
        $history[] = $row; // Index 0 = H-1, Index 1 = H-2, Index 2 = H-3, ..., Index 6 = H-7
    }
}

// Inisialisasi default
$prediksi_as = '-'; $prediksi_kop = '-'; $prediksi_kepala = '-'; $prediksi_ekor = '-';

// Eksekusi perhitungan jika data minimal 7 hari (1 siklus) sudah terinput
if (count($history) >= 7) {
    $h1 = $history[0]; // 1 Hari Lalu
    $h2 = $history[1]; // 2 Hari Lalu
    $h3 = $history[2]; // 3 Hari Lalu
    $h7 = $history[6]; // Hari yang sama minggu lalu

    // Formulasi Matematis (Cross-Relational Anchoring)
    // Target AS: Relasi H-1 disilang dengan H-7
    $prediksi_as = abs(($h1['posisi_as'] + $h7['posisi_as']) % 10);
    
    // Target KOP: Relasi H-2 disilang dengan H-7
    $prediksi_kop = abs(($h2['posisi_kop'] + $h7['posisi_kop']) % 10);
    
    // Target KEPALA: Relasi H-3 disilang dengan H-7
    $prediksi_kepala = abs(($h3['posisi_kepala'] + $h7['posisi_kepala']) % 10);
    
    // Target EKOR: Biji Algoritmik dari 3 Hari Terakhir
    $prediksi_ekor = abs(($h1['posisi_ekor'] + $h2['posisi_ekor'] + $h3['posisi_ekor']) % 10);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Analisis 4D</title>
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans p-4 md:p-8">
    
    <div class="max-w-5xl mx-auto space-y-6">
        
        <!-- Header & Navigasi -->
        <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Analitik Probabilitas 4D</h1>
                <p class="text-sm text-gray-500 mt-1">Sistem mencari pola probabilitas berdasarkan histori.</p>
            </div>
            <a href="input.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                + Input Data Baru
            </a>
        </div>

        <!-- Section Prediksi Angka Ikut -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Prediksi Opsi 2 (3 Hari Terakhir + Minggu Lalu)</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                
                <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                    <h3 class="font-semibold text-indigo-900 text-sm mb-2 tracking-widest">AS</h3>
                    <p class="text-4xl font-black text-indigo-600"><?php echo $prediksi_as; ?></p>
                </div>

                <div class="bg-teal-50 p-6 rounded-lg border border-teal-100">
                    <h3 class="font-semibold text-teal-900 text-sm mb-2 tracking-widest">KOP</h3>
                    <p class="text-4xl font-black text-teal-600"><?php echo $prediksi_kop; ?></p>
                </div>

                <div class="bg-orange-50 p-6 rounded-lg border border-orange-100">
                    <h3 class="font-semibold text-orange-900 text-sm mb-2 tracking-widest">KEPALA</h3>
                    <p class="text-4xl font-black text-orange-600"><?php echo $prediksi_kepala; ?></p>
                </div>

                <div class="bg-rose-50 p-6 rounded-lg border border-rose-100">
                    <h3 class="font-semibold text-rose-900 text-sm mb-2 tracking-widest">EKOR</h3>
                    <p class="text-4xl font-black text-rose-600"><?php echo $prediksi_ekor; ?></p>
                </div>

            </div>
            <?php if (count($history) < 7): ?>
                <p class="text-red-500 text-sm mt-4 text-center">Diperlukan minimal 7 data keluaran berurutan untuk memproses algoritma ini.</p>
            <?php endif; ?>
        </div>

        <!-- Tabel Riwayat Data -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Keluaran Terakhir</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 rounded-tl-lg">Tanggal</th>
                            <th class="px-6 py-3">AS</th>
                            <th class="px-6 py-3">KOP</th>
                            <th class="px-6 py-3">KEPALA</th>
                            <th class="px-6 py-3 rounded-tr-lg">EKOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $result->data_seek(0);
                            while($row = $result->fetch_assoc()) {
                                echo "<tr class='bg-white border-b hover:bg-gray-50'>";
                                echo "<td class='px-6 py-4 font-medium text-gray-900'>{$row['tanggal']}</td>";
                                echo "<td class='px-6 py-4'>{$row['posisi_as']}</td>";
                                echo "<td class='px-6 py-4'>{$row['posisi_kop']}</td>";
                                echo "<td class='px-6 py-4'>{$row['posisi_kepala']}</td>";
                                echo "<td class='px-6 py-4'>{$row['posisi_ekor']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='px-6 py-4 text-center'>Belum ada data historis yang diinput.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>