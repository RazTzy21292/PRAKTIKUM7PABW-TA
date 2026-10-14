<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    protected $table = 'edukasi';

    protected $fillable = ['judul', 'ringkasan', 'konten', 'waktu_baca', 'poin', 'icon_type'];

    /** Semua artikel + penanda sudah_klaim (1/0) untuk user tertentu. */
    public static function denganStatusKlaim(int $userId)
    {
        $sudah = EdukasiKlaim::where('user_id', $userId)->pluck('edukasi_id')->all();

        return static::orderByDesc('created_at')->get()->each(function ($artikel) use ($sudah) {
            $artikel->sudah_klaim = in_array($artikel->id, $sudah) ? 1 : 0;
        });
    }
}
