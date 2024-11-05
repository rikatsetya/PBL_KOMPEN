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
        Schema::create('m_tendik', function (Blueprint $table) {
            $table->id('tendik_id');
            $table->unsignedBigInteger('no_induk')->unique();
            $table->string('username', 20)->unique();
            $table->string('tendik_nama', 100);
            $table->string('password');
            $table->string('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tendik');
    }
};
