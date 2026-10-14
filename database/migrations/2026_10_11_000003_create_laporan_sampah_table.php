<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_sampah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tong_id')->constrained('tong_sampah')->cascadeOnDelete();
            $table->enum('status', ['kosong', 'sedang', 'penuh']);
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedInteger('poin_didapat')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_sampah');
    }
};
