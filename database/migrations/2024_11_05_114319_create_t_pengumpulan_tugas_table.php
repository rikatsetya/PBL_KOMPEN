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
        Schema::create('t_pengumpulan_tugas', function (Blueprint $table) {
            $table->id('pengumpulan_id');
            $table->unsignedBigInteger('tugas_id')->index();
            $table->unsignedBigInteger('mahasiswa_id')->index();
            $table->string('lampiran');
            $table->string('foto_sebelum');
            $table->string('foto_sesudah');
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('tugas_id')->references('tugas_id')->on('t_tugas');
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pengumpulan_tugas');
    }
};
