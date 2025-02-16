<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{

    public function index() {
        return view('absensi.index');
    }

    // Menampilkan semua data absensi dengan pagination & filter
    public function getAbsensi(Request $request)
    {
        $query = Absensi::query();

        if ($request->filled('nama')) {
            $query->where('Nama', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('jurusan')) {
            $query->where('Jurusan', $request->jurusan);
        }
        if ($request->filled('kelas')) {
            $query->where('Kelas', $request->kelas);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('Waktu', $request->tanggal);
        }
        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }
        if ($request->filled('mood')) {
            $query->where('Mood', $request->mood);
        }

        $data = $query->orderBy('ID', 'DESC')->paginate($request->limit ?? 25);

        return response()->json([
            'data' => $data->items(),
            'total' => $query->count(),
            'limit' => $request->limit,
            'page' => $request->page
        ]);
    }
}

