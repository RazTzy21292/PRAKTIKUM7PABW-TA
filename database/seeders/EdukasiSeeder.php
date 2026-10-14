<?php

namespace Database\Seeders;

use App\Models\Edukasi;
use Illuminate\Database\Seeder;

class EdukasiSeeder extends Seeder
{
    public function run(): void
    {
        $artikel = [
            [
                'judul' => 'Tips Membedakan Sampah Sesuai Jenisnya',
                'ringkasan' => 'Pelajari cara memilah sampah organik, anorganik, dan B3 dengan benar agar lingkungan sekolah tetap bersih.',
                'konten' => 'Sampah terbagi menjadi tiga jenis utama: organik (sisa makanan, daun), anorganik (plastik, kertas, kaleng), dan B3 (baterai, cat, obat kadaluarsa). Dengan memilah sampah sejak awal, proses daur ulang menjadi lebih mudah dan lingkungan sekolah tetap bersih. Biasakan selalu membuang sampah sesuai tong yang tersedia!',
                'waktu_baca' => 5,
                'poin' => 6,
                'icon_type' => 'organik',
            ],
            [
                'judul' => 'Manfaat Daur Ulang untuk Lingkungan',
                'ringkasan' => 'Temukan fakta menarik tentang bagaimana daur ulang membantu mengurangi polusi dan menghemat sumber daya alam.',
                'konten' => 'Daur ulang adalah proses mengubah sampah menjadi bahan baru yang bisa dipakai kembali. Dengan mendaur ulang kertas, plastik, dan logam, kita bisa mengurangi penumpukan sampah di TPA, menghemat energi produksi, dan menjaga keanekaragaman hayati. Mulai dari hal kecil: gunakan botol minum isi ulang dan kurangi plastik sekali pakai!',
                'waktu_baca' => 7,
                'poin' => 8,
                'icon_type' => 'anorganik',
            ],
            [
                'judul' => 'Bahaya Sampah B3 dan Cara Penanganannya',
                'ringkasan' => 'Kenali jenis sampah berbahaya dan beracun (B3) serta langkah aman dalam penanganannya di lingkungan sekolah.',
                'konten' => 'Sampah B3 (Bahan Berbahaya dan Beracun) seperti baterai, lampu neon, dan obat kadaluarsa tidak boleh dibuang sembarangan. Kandungan merkuri dan timbal di dalamnya bisa mencemari tanah dan air. Di sekolah, kumpulkan sampah B3 di tong khusus berwarna merah dan serahkan ke petugas untuk penanganan aman.',
                'waktu_baca' => 6,
                'poin' => 7,
                'icon_type' => 'b3',
            ],
            [
                'judul' => 'Dampak sampah',
                'ringkasan' => 'Dampak sampah sangat berbahaya bagi lingkungan bumi sampah yang menumpuk akan mengakibatkan banjir',
                'konten' => 'Salah satu ancaman terbesar bagi lingkungan saat ini adalah sampah yang terus menumpuk tanpa pengelolaan yang baik, sehingga dapat mencemari lingkungan dan membahayakan kesehatan masyarakat.',
                'waktu_baca' => 6,
                'poin' => 7,
                'icon_type' => 'b3',
            ],
        ];

        foreach ($artikel as $data) {
            Edukasi::create($data);
        }
    }
}
