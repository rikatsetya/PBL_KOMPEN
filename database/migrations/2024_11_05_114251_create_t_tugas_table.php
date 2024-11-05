<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_tugas', function (Blueprint $table) {
            $table->id('tugas_id');
            $table->unsignedBigInteger('dosen_id')->index()->nullable();
            $table->unsignedBigInteger('tendik_id')->index()->nullable();
            $table->unsignedBigInteger('admin_id')->index()->nullable();
            $table->string('tugas_nama', 100);
            $table->text('deskripsi');
            $table->unsignedBigInteger('tugas_bobot');
            $table->date('tugas_tenggat');
            $table->string('periode',10);
            $table->timestamps();

            $table->foreign('dosen_id')->references('dosen_id')->on('m_dosen');
            $table->foreign('tendik_id')->references('tendik_id')->on('m_tendik');
            $table->foreign('admin_id')->references('admin_id')->on('m_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_tugas');
    }
};
