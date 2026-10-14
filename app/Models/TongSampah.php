<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TongSampah extends Model
{
    protected $table = 'tong_sampah';

    protected $fillable = ['nama_tong', 'lokasi', 'status', 'persentase_terisi'];

    public static function statistik(): array
    {
        $semua = static::all();

        return [
            'kosong' => $semua->where('status', 'kosong')->count(),
            'sedang' => $semua->where('status', 'sedang')->count(),
            'penuh'  => $semua->where('status', 'penuh')->count(),
            'total'  => $semua->count(),
        ];
    }
}
