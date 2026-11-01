<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $demo = [
            ['Andi Saputra', 'andi.saputra@smacan.sch.id', '2024001234', '11 IPA 2', 1250],
            ['Budi Rahayu', 'budi.rahayu@smacan.sch.id', '2024001235', '11 IPA 1', 2100],
            ['Siti Fatimah', 'siti.fatimah@smacan.sch.id', '2024001236', '11 IPA 2', 1850],
        ];

        foreach ($demo as [$nama, $email, $nis, $kelas, $poin]) {
            User::updateOrCreate(['email' => $email], [
                'nama' => $nama,
                'password' => 'password123',
                'nis' => $nis,
                'kelas' => $kelas,
                'role' => 'siswa',
                'total_poin' => $poin,
            ]);
        }

        $faker = Faker::create('id_ID');
        $daftarKelas = ['X IPA 1', 'X IPA 2', 'X IPS 1', 'XI IPA 1', 'XI IPA 2', 'XI IPS 1', 'XII IPA 1', 'XII IPS 1'];

        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(['email' => sprintf('dummy.%02d@smacan.sch.id', $i)], [
                'nama' => $faker->name(),
                'password' => 'password123',
                'nis' => '2024'.str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                'kelas' => $faker->randomElement($daftarKelas),
                'role' => 'siswa',
                'total_poin' => $faker->numberBetween(0, 2500),
            ]);
        }
    }
}
