@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold">Selamat Datang di Dashboard</h1>
    <div class="card-container">
        <div class="card terlambat" onclick="openModal('modal1')" >
            <div class="text">
                <h4 class="info">Terlambat</h4>
                <h1>{{ $totalTerlambat }}</h1>
            </div>
            <i class="bi bi-exclamation-lg icon-bg"></i>
        </div>
        <div id="modal1" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                <h2 class="text-xl font-bold">Terlambat</h2>
                <p class="text-gray-600 mt-2">Yang terlambat hari ini</p>
                <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition" onclick="closeModal('modal1')">Tutup</button>
            </div>
        </div>
        <div class="card mood-sad" onclick="openModal('modal2')">
            <div class="text">
                <h4 class="info">Mood Sedih</h4>
                <h1>{{ $totalSedih }}</h1>
            </div>
            <i class="bi bi-emoji-frown icon-bg"></i>
        </div>
        <div id="modal2" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                <h2 class="text-xl font-bold">Judul Kartu 2</h2>
                <p class="text-gray-600 mt-2">Detail dari kartu kedua.</p>
                <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition" onclick="closeModal('modal2')">Tutup</button>
            </div>
        </div>
        <div class="card tidak-hadir" onclick="openModal('modal3')">
            <div class="text">
                <h4 class="info">Belum Absen</h4>
                <h1>{{ 1214 - $totalHadir }} dari 1214 Murid</h1>
            </div>
            <i class="bi bi-x-lg icon-bg"></i>
        </div>
        <div id="modal3" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                <h2 class="text-xl font-bold">Judul Kartu 3</h2>
                <p class="text-gray-600 mt-2">Detail dari kartu ketiga.</p>
                <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition" onclick="closeModal('modal3')">Tutup</button>
            </div>
        </div>
    </div>
@endsection
