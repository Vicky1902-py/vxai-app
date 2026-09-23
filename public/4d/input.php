<?php
require 'koneksi.php';

$pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $as = (int)$_POST['posisi_as'];
    $kop = (int)$_POST['posisi_kop'];
    $kepala = (int)$_POST['posisi_kepala'];
    $ekor = (int)$_POST['posisi_ekor'];

    $sql = "INSERT INTO keluaran_toto (tanggal, posisi_as, posisi_kop, posisi_kepala, posisi_ekor) 
            VALUES ('$tanggal', $as, $kop, $kepala, $ekor)";

    if ($conn->query($sql) === TRUE) {
        $pesan = '<div class="bg-emerald-500/10 border border-emerald-500 text-emerald-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <strong>Data untuk '.$tanggal.' berhasil disimpan.</strong>
                  </div>';
    } else {
        $pesan = '<div class="bg-red-500/10 border border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <strong>Error: ' . $conn->error . '</strong>
                  </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Keluaran 4D</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans p-4 md:p-8 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-2xl">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-indigo-600">
                Pusat Input Data
            </h1>
            <a href="index.php" class="text-slate-500 hover:text-blue-600 font-medium text-sm transition-colors flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <?php echo $pesan; ?>

        <div class="bg-white p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
            <form action="input.php" method="POST" class="space-y-8">
                
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Putaran</label>
                    <input type="date" name="tanggal" required 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white outline-none transition-all text-slate-700 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Formasi Angka Keluar</label>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="relative group">
                            <label class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-indigo-500 tracking-widest">AS</label>
                            <input type="number" name="posisi_as" min="0" max="9" required 
                                   class="w-full text-center text-3xl font-black p-4 border-2 border-slate-100 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all text-slate-800">
                        </div>
                        <div class="relative group">
                            <label class="absolute -top-3 left-3 bg-white px-2 text-xs font-bold text-teal-500 tracking-widest">KOP</label>
                            <input type="number" name="posisi_kop" min="0" max="9" required 
                                   class="w-full text-center text-3xl font-black p-4 border-2 border-slate-100 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all text-slate-800">
                        </div>
                        <div class="relative group">
                            <label class="absolute -top-3 left-1 bg-white px-2 text-xs font-bold text-orange-500 tracking-widest">KEP</label>
                            <input type="number" name="posisi_kepala" min="0" max="9" required 
                                   class="w-full text-center text-3xl font-black p-4 border-2 border-slate-100 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 outline-none transition-all text-slate-800">
                        </div>
                        <div class="relative group">
                            <label class="absolute -top-3 left-2 bg-white px-2 text-xs font-bold text-rose-500 tracking-widest">EKR</label>
                            <input type="number" name="posisi_ekor" min="0" max="9" required 
                                   class="w-full text-center text-3xl font-black p-4 border-2 border-slate-100 rounded-xl focus:border-rose-500 focus:ring-4 focus:ring-rose-500/20 outline-none transition-all text-slate-800">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-4 rounded-xl transition-all shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5">
                        Simpan ke Database Analitik
                    </button>
                </div>
                
            </form>
        </div>
    </div>

</body>
</html>