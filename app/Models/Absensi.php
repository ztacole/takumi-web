<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'NISN',
        'Nama',
        'Jurusan',
        'Kelas',
        'Lokasi',
        'Mood',
        'Catatan',
        'Status',
        'Waktu',
    ];
}
