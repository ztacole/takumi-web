<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('NISN', 10);
            $table->string('Nama', 250);
            $table->string('Jurusan', 50);
            $table->string('Kelas', 8);
            $table->enum('Lokasi', ['SMKN 24 Jakarta', 'Diluar SMKN 24 Jakarta'])->default('Diluar SMKN 24 Jakarta');
            $table->enum('Mood', ['Senang', 'Biasa saja', 'Sedih'])->default('Biasa saja');
            $table->text('Catatan')->nullable();
            $table->enum('Status', ['Tepat Waktu', 'Terlambat'])->default('Terlambat');
            $table->dateTime('Waktu')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
