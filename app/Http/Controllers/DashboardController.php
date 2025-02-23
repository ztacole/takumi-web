<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class DashboardController extends Controller
{
    // Menghitung total hadir hari ini
    public function index()
    {
        return view('dashboard.index');
    }

    public function loadData(Request $request) {
        $type = $request->query('type');

        return view("dashboard.partials.$type");
    }

    public function getAllDataCount() {
        $totalHadir = Absensi::whereDate('Waktu', today())->count();
        $totalTerlambat = Absensi::where('Status', 'Terlambat')
            ->whereDate('Waktu', today())
            ->count();
        $totalSedih = Absensi::where('Mood', 'Sedih')
            ->whereDate('Waktu', today())
            ->count();

        return response()->json([
            'totalHadir' => $totalHadir,
            'totalTerlambat' => $totalTerlambat,
            'totalSedih' => $totalSedih
        ]);
    }

    public function getDataTerlambat() {
        $data = Absensi::where('Status', 'Terlambat')
            ->whereDate('Waktu', today())
            ->get();

        return response()->json([
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    public function getDataSedih() {
        $data = Absensi::where('Mood', 'Sedih')
            ->whereDate('Waktu', today())
            ->get();

        return response()->json([
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    public function getDataBelumHadir() {
        return response()->json([
            'data' => [],
            'total' => 0
        ]);
    }
}
