<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TongSampahSeeder::class,
            EdukasiSeeder::class,
            UserSeeder::class,
            LaporanSampahSeeder::class,
        ]);
    }
}
