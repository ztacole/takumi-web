<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    // Menghitung total hadir hari ini
    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('index')->withErrors(['message' => 'Silakan login dulu']);
        }

        return view('dashboard.index');
    }

    public function loadData(Request $request) {
        if (!Session::has('user')) {
            return redirect()->route('index')->withErrors(['message' => 'Silakan login dulu']);
        }

        $type = $request->query('type');

        return view("dashboard.partials.$type");
    }

    public function getAllDataCount() {
        if (!Session::has('user')) {
            return redirect()->route('index')->withErrors(['message' => 'Silakan login dulu']);
        }
        
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
        if (!Session::has('user')) {
            return redirect()->route('index')->withErrors(['message' => 'Silakan login dulu']);
        }
        
        $data = Absensi::where('Status', 'Terlambat')
            ->whereDate('Waktu', today())
            ->get();

        return response()->json([
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    public function getDataSedih() {
        if (!Session::has('user')) {
            return redirect()->route('index')->withErrors(['message' => 'Silakan login dulu']);
        }
        
        $data = Absensi::where('Mood', 'Sedih')
            ->whereDate('Waktu', today())
            ->get();

        return response()->json([
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    public function getDataBelumHadir() {
        if (!Session::has('user')) {
            return redirect()->route('index')->withErrors(['message' => 'Silakan login dulu']);
        }
        
        return response()->json([
            'data' => [],
            'total' => 0
        ]);
    }
}
