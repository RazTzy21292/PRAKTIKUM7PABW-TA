<?php

namespace Database\Seeders;

use App\Models\TongSampah;
use Illuminate\Database\Seeder;

class TongSampahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Tong Kelas 10A', 'Gedung A - Lantai 1', 'sedang', 5],
            ['Tong Kantin', 'Area Kantin', 'sedang', 70],
            ['Tong Kelas 11B', 'Gedung B - Lantai 2', 'penuh', 95],
            ['Tong Lapangan', 'Area Lapangan', 'kosong', 0],
            ['Tong Perpustakaan', 'Gedung C - Lantai 1', 'penuh', 55],
            ['Tong UKS', 'Gedung A - UKS', 'kosong', 10],
        ];

        foreach ($data as [$nama, $lokasi, $status, $persen]) {
            TongSampah::create([
                'nama_tong' => $nama,
                'lokasi' => $lokasi,
                'status' => $status,
                'persentase_terisi' => $persen,
            ]);
        }
    }
}
