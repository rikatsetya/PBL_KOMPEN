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
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->id('mahasiswa_id');
            $table->unsignedBigInteger('nim')->unique();
            $table->string('username', 20)->unique();
            $table->string('mahasiswa_nama', 100);
            $table->string('password');
            $table->string('foto');
            $table->unsignedBigInteger('no_telp');
            $table->string('jurusan', 50);
            $table->string('prodi', 50);
            $table->string('kelas', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa');
    }
};
