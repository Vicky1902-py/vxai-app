@extends('layouts.public')

@section('title', 'Hubungi Kami (Contact) - ' . ($settings['app_name'] ?? 'VxAI'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-200 shadow-sm space-y-6 text-gray-700 leading-relaxed text-sm">
        
        <h1 class="text-3xl font-black text-gray-900 border-b pb-4">Hubungi Kami</h1>

        <p>
            Apakah Anda memiliki pertanyaan seputar materi koding, kerjasama sekolah, saran perbaikan sistem, atau pertanyaan terkait kemitraan iklan? Tim kami siap mendengar masukan Anda.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
            
            <!-- Info Kontak -->
            <div class="space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <h3 class="text-base font-bold text-gray-900">Saluran Komunikasi Resmi</h3>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold">Email Pengelola:</span>
                    <a href="mailto:{{ $settings['contact_email'] ?? 'admin@vxai.online' }}" class="text-blue-600 font-bold hover:underline text-sm">
                        {{ $settings['contact_email'] ?? 'admin@vxai.online' }}
                    </a>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold">Website:</span>
                    <span class="text-gray-800 font-medium">https://vxai.online</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold">Waktu Respon:</span>
                    <span class="text-gray-600">Senin - Jumat, 08.00 - 17.00 WITA</span>
                </div>
            </div>

            <!-- Form Pesan Sederhana (Mailto) -->
            <div class="space-y-4">
                <h3 class="text-base font-bold text-gray-900">Kirim Pesan Cepat</h3>
                <form onsubmit="kirimEmail(event)" class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" id="contact-name" class="w-full px-3 py-2 border rounded-xl text-sm" placeholder="Nama Anda" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Pesan / Masukan</label>
                        <textarea id="contact-msg" rows="3" class="w-full px-3 py-2 border rounded-xl text-sm" placeholder="Tuliskan pesan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-xl text-sm transition shadow">
                        Kirim Pesan via Email
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
    function kirimEmail(e) {
        e.preventDefault();
        const nama = document.getElementById('contact-name').value;
        const msg = document.getElementById('contact-msg').value;
        const adminEmail = "{{ $settings['contact_email'] ?? 'admin@vxai.online' }}";
        window.location.href = `mailto:${adminEmail}?subject=Pesan Kontak dari ${encodeURIComponent(nama)}&body=${encodeURIComponent(msg)}`;
    }
</script>
@endpush
@endsection
