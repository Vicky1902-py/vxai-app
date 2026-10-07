@extends('layouts.public')

@section('title', 'Sertifikat Kelulusan Koding - ' . $studentName . ' - ' . ($settings['app_name'] ?? 'VxAI Coding Lab'))
@section('meta_description', 'Sertifikat resmi kelulusan 10 level tantangan pemrograman web dan penguasaan fondasi digital VxAI Coding Lab.')

@push('styles')
<style>
    @media print {
        body { background: white !important; color: black !important; padding: 0 !important; }
        nav, footer, .no-print { display: none !important; }
        .certificate-container { border: 8px double #1e3a8a !important; box-shadow: none !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

    <!-- Action Bar Atas (Cetak & Bagikan) -->
    <div class="no-print bg-white p-4 sm:p-6 rounded-3xl border border-slate-200/90 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold mb-1">
                <span>✓ Status: Terverifikasi Resmi</span>
            </div>
            <h1 class="text-xl font-black text-slate-900">Sertifikat Kelulusan 10 Level Koding</h1>
            <p class="text-xs text-slate-500">ID Sertifikat: <code class="font-mono font-bold text-blue-600">{{ $certId }}</code></p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                <span>🖨️</span> <span>Cetak / Simpan PDF</span>
            </button>

            <a href="https://api.whatsapp.com/send?text={{ urlencode('Saya telah menyelesaikan 10 Level Tantangan Koding di VxAI Coding Lab! Cek sertifikat saya di: ' . url()->current()) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-bold text-xs transition flex items-center gap-1.5 shadow-md shadow-emerald-500/20">
                <span>📱</span> <span>Bagikan ke WhatsApp</span>
            </a>

            <a href="{{ route('public.playground') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-bold text-xs transition">
                ⚡ Ke Playground
            </a>
        </div>
    </div>

    <!-- Sertifikat Fisik (Desain Mewah & Elegan) -->
    <div class="certificate-container bg-white rounded-3xl p-8 sm:p-14 border-8 border-double border-blue-900 shadow-2xl relative overflow-hidden text-center text-slate-900">
        
        <!-- Watermark Background Logo -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none font-black text-[220px]">
            VxAI
        </div>

        <!-- Frame Sudut Emas / Aksen -->
        <div class="absolute top-4 left-4 w-12 h-12 border-t-4 border-l-4 border-amber-500 pointer-events-none"></div>
        <div class="absolute top-4 right-4 w-12 h-12 border-t-4 border-r-4 border-amber-500 pointer-events-none"></div>
        <div class="absolute bottom-4 left-4 w-12 h-4 border-b-4 border-l-4 border-amber-500 pointer-events-none"></div>
        <div class="absolute bottom-4 right-4 w-12 h-4 border-b-4 border-r-4 border-amber-500 pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            
            <!-- Logo & Lembaga -->
            <div class="flex items-center justify-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-tr from-blue-700 to-indigo-700 text-white rounded-2xl flex items-center justify-center font-black text-xl shadow-md">
                    Vx
                </div>
                <div class="text-left">
                    <span class="font-black text-xl tracking-tight text-slate-900 block leading-tight">{{ $settings['app_name'] ?? 'VxAI Coding Lab' }}</span>
                    <span class="text-[11px] text-blue-600 font-extrabold uppercase tracking-widest block">Modern Coding & AI Innovation</span>
                </div>
            </div>

            <div class="space-y-1">
                <span class="text-xs font-black tracking-widest uppercase text-amber-600">CERTIFICATE OF ACHIEVEMENT</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-blue-950 uppercase tracking-wide">
                    SERTIFIKAT KELULUSAN
                </h2>
                <p class="text-xs text-slate-500">Diberikan secara resmi kepada:</p>
            </div>

            <!-- Nama Penerima -->
            <div class="py-2 border-b-2 border-slate-300 max-w-lg mx-auto">
                <h3 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight font-serif italic">
                    {{ $studentName }}
                </h3>
            </div>

            <!-- Deskripsi Kelulusan -->
            <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Telah berhasil menyelesaikan secara tuntas <strong>10 Level Tantangan Pemrograman Web</strong> (Fondasi Dokumen HTML5 Semantik, Desain Tata Letak Modern CSS3 Flexbox/Grid, Manipulasi Logika DOM JavaScript Interaktif, dan Proyek Pembuatan Aplikasi Mini Game) dengan predikat <strong>Sangat Memuaskan</strong>.
            </p>

            <!-- Tanda Tangan & Kredensial -->
            <div class="pt-8 grid grid-cols-2 max-w-md mx-auto items-end gap-8 text-center">
                <div>
                    <span class="text-[11px] text-slate-400 block mb-1">Diterbitkan pada:</span>
                    <span class="text-xs font-bold text-slate-800">{{ $issueDate }}</span>
                    <div class="mt-8 border-t border-slate-300 pt-1 text-[11px] text-slate-500">
                        Kupang Barat, NTT
                    </div>
                </div>

                <div>
                    <!-- Cap Digital Stempel -->
                    <div class="inline-block px-3 py-1 rounded-lg border border-blue-300 text-blue-700 font-mono text-[10px] font-bold mb-2 bg-blue-50">
                        VERIFIED • {{ $certId }}
                    </div>
                    <div class="border-t border-slate-300 pt-1">
                        <span class="font-bold text-xs text-slate-900 block font-serif">Vicky Koroh</span>
                        <span class="text-[10px] text-slate-500 block">Lead Educator & Developer</span>
                    </div>
                </div>
            </div>

            <!-- Catatan Kaki Verifikasi -->
            <div class="pt-6 text-[10px] text-slate-400">
                Sertifikat ini diotentikasi secara digital oleh ekosistem VxAI Coding Lab • Verifikasi mandiri: <span class="font-mono text-slate-500">{{ url()->current() }}</span>
            </div>

        </div>

    </div>

</div>
@endsection
