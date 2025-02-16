<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class DashboardController extends Controller
{
    // Menghitung total hadir hari ini
    public function index()
    {
        $totalHadir = Absensi::whereDate('Waktu', today())->count();
        $totalTerlambat = Absensi::where('Status', 'Terlambat')
            ->whereDate('Waktu', today())
            ->count();
        $totalSedih = Absensi::where('Mood', 'Sedih')
            ->whereDate('Waktu', today())
            ->count();

        return view('dashboard.index', compact('totalHadir', 'totalTerlambat', 'totalSedih'));
    }
}
