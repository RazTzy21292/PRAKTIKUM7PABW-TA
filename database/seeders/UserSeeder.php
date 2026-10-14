<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun demo tetap (password: password123)
        $demo = [
            ['Andi Saputra', 'andi.saputra@smacan.sch.id', '2024001234', '11 IPA 2', 1250],
            ['Budi Rahayu', 'budi.rahayu@smacan.sch.id', '2024001235', '11 IPA 1', 2100],
            ['Siti Fatimah', 'siti.fatimah@smacan.sch.id', '2024001236', '11 IPA 2', 1850],
        ];

        foreach ($demo as [$nama, $email, $nis, $kelas, $poin]) {
            User::create([
                'nama' => $nama,
                'email' => $email,
                'password' => 'password123',
                'nis' => $nis,
                'kelas' => $kelas,
                'role' => 'siswa',
                'total_poin' => $poin,
            ]);
        }

        // Data dummy otomatis dengan Faker (locale Indonesia)
        $faker = Faker::create('id_ID');
        $daftarKelas = ['X IPA 1', 'X IPA 2', 'X IPS 1', 'XI IPA 1', 'XI IPA 2', 'XI IPS 1', 'XII IPA 1', 'XII IPS 1'];

        for ($i = 0; $i < 12; $i++) {
            User::create([
                'nama' => $faker->name(),
                'email' => $faker->unique()->numerify('siswa####') . '@smacan.sch.id',
                'password' => 'password123',
                'nis' => $faker->unique()->numerify('2024######'),
                'kelas' => $faker->randomElement($daftarKelas),
                'role' => 'siswa',
                'total_poin' => $faker->numberBetween(0, 2500),
            ]);
        }
    }
}
