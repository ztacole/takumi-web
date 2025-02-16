<?php

use Illuminate\Support\Facades\Route;

//View
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);
Route::get('/absensi', [App\Http\Controllers\AbsensiController::class, 'index']);

//API
Route::get('/api/absensi', [App\Http\Controllers\AbsensiController::class, 'getAbsensi']);