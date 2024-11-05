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
        Schema::create('t_surat_kompen', function (Blueprint $table) {
            $table->id('surat_id');
            $table->unsignedBigInteger('mahasiswa_id')->index();
            $table->unsignedBigInteger('admin_id')->index();
            $table->unsignedBigInteger('absensi_id')->index();
            $table->date('tanggal_pengajuan');
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->foreign('admin_id')->references('admin_id')->on('m_admin');
            $table->foreign('absensi_id')->references('absensi_id')->on('t_absensi_mhs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_surat_kompen');
    }
};
