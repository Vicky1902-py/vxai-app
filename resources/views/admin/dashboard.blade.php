@extends('layouts.admin')

@section('title', 'Dashboard - ' . ($settings['app_name'] ?? 'CMS'))
@section('header_title', 'Dashboard Super Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow border-t-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Siswa</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $totalSiswa }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-t-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Guru</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $totalGuru }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow border-t-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Status Sistem</h3>
        <p class="text-xl font-bold text-green-600">Aktif & Berjalan</p>
    </div>
</div>
@endsection