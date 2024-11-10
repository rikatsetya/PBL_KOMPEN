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
        Schema::create('t_tugas', function (Blueprint $table) {
            $table->id('tugas_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('tugas_nama', 100);
            $table->text('deskripsi');
            $table->unsignedBigInteger('tugas_bobot');
            $table->date('tugas_tenggat');
            $table->string('periode',10);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_user');
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
