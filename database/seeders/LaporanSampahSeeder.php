<?php

namespace Database\Seeders;

use App\Models\LaporanSampah;
use App\Models\TongSampah;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LaporanSampahSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $userIds = User::pluck('id')->all();
        $tongIds = TongSampah::pluck('id')->all();

        LaporanSampah::unguarded(function () use ($faker, $userIds, $tongIds) {
            for ($i = 0; $i < 25; $i++) {
                $tanggal = $faker->dateTimeBetween('-1 month', 'now');

                LaporanSampah::create([
                    'user_id' => $faker->randomElement($userIds),
                    'tong_id' => $faker->randomElement($tongIds),
                    'status' => $faker->randomElement(['kosong', 'sedang', 'penuh']),
                    'keterangan' => $faker->optional(0.7)->sentence(8),
                    'foto' => null,
                    'poin_didapat' => 5,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ]);
            }
        });
    }
}
