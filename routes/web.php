<?php

use Illuminate\Support\Facades\Route;

//View
Route::get('/', [App\Http\Controllers\AuthController::class, 'index'])->name('index');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/load', [App\Http\Controllers\DashboardController::class, 'loadData']);

Route::get('/absensi', [App\Http\Controllers\AbsensiController::class, 'index']);


//API
Route::get('/api/absensi', [App\Http\Controllers\AbsensiController::class, 'getAbsensi']);

Route::get('/api/dashboard', [App\Http\Controllers\DashboardController::class, 'getAllDataCount']);
Route::get('/api/dashboard/terlambat', [App\Http\Controllers\DashboardController::class, 'getDataTerlambat']);
Route::get('/api/dashboard/sedih', [App\Http\Controllers\DashboardController::class, 'getDataSedih']);
Route::get('/api/dashboard/belum-hadir', [App\Http\Controllers\DashboardController::class, 'getDataBelumHadir']);
