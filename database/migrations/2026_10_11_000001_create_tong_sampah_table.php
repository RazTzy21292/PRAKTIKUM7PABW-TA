<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tong_sampah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tong', 100);
            $table->string('lokasi', 150);
            $table->enum('status', ['kosong', 'sedang', 'penuh'])->default('kosong');
            $table->unsignedInteger('persentase_terisi')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tong_sampah');
    }
};
