<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $needsNama = ! Schema::hasColumn('users', 'nama');

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nama')) {
                $table->string('nama', 100)->nullable();
            }
            if (! Schema::hasColumn('users', 'nis')) {
                $table->string('nis', 30)->nullable();
            }
            if (! Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas', 50)->nullable();
            }
            if (! Schema::hasColumn('users', 'sekolah')) {
                $table->string('sekolah', 150)->nullable()->default('SMA Cendikia Nusantara');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa');
            }
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }
            if (! Schema::hasColumn('users', 'total_poin')) {
                $table->unsignedInteger('total_poin')->default(0);
            }
        });

        if ($needsNama && Schema::hasColumn('users', 'name')) {
            DB::table('users')->whereNull('nama')->update(['nama' => DB::raw('name')]);
        }
    }

    public function down(): void {}
};
