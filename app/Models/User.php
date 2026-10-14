<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'nama', 'email', 'password', 'nis', 'kelas',
        'sekolah', 'role', 'avatar', 'total_poin',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function laporan(): HasMany
    {
        return $this->hasMany(LaporanSampah::class, 'user_id');
    }

    public function klaim(): HasMany
    {
        return $this->hasMany(EdukasiKlaim::class, 'user_id');
    }

    /** Setiap 500 poin naik 1 level. */
    public function levelInfo(): array
    {
        $total = (int) $this->total_poin;
        $saatIni = $total % 500;

        return [
            'level' => intdiv($total, 500) + 1,
            'poin_saat_ini' => $saatIni,
            'poin_dibutuhkan' => 500,
            'poin_kurang' => 500 - $saatIni,
            'persen_progress' => (int) round($saatIni / 500 * 100),
        ];
    }

    public function initial(): string
    {
        return getInitial($this->nama);
    }

    public static function leaderboard(int $limit = 10)
    {
        return static::where('role', 'siswa')->orderByDesc('total_poin')->limit($limit)->get();
    }
}
