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
        Schema::create('daftar_poli', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_dokter');
            $table->unsignedInteger('id_jadwal');
            $table->text('keluhan');
            $table->integer('no_antrian');
            $table->foreign('id_dokter')->references('id')->on('users');
            $table->foreign('id_jadwal')->references('id')->on('jadwal_periksa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_poli');
    }
};
