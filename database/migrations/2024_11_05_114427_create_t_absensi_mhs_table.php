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
        Schema::create('t_absensi_mhs', function (Blueprint $table) {
            $table->id('absensi_id');
            $table->unsignedBigInteger('mahasiswa_id')->index();
            $table->unsignedBigInteger('sakit');
            $table->unsignedBigInteger('izin');
            $table->unsignedBigInteger('alpha');
            $table->unsignedBigInteger('poin');
            $table->string('status',20);
            $table->string('periode',10);
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_absensi_mhs');
    }
};
