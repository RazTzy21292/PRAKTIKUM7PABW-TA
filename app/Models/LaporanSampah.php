<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanSampah extends Model
{
    protected $table = 'laporan_sampah';

    protected $fillable = ['user_id', 'tong_id', 'status', 'keterangan', 'foto', 'poin_didapat'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tong(): BelongsTo
    {
        return $this->belongsTo(TongSampah::class, 'tong_id');
    }

    /** Laporan + nama_tong & lokasi dari tabel tong_sampah (join). */
    public function scopeDenganTong(Builder $query): Builder
    {
        return $query
            ->join('tong_sampah', 'laporan_sampah.tong_id', '=', 'tong_sampah.id')
            ->select('laporan_sampah.*', 'tong_sampah.nama_tong', 'tong_sampah.lokasi')
            ->orderByDesc('laporan_sampah.created_at');
    }
}
