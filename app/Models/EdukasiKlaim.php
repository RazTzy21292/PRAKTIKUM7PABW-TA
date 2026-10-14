<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdukasiKlaim extends Model
{
    protected $table = 'edukasi_klaim';

    protected $fillable = ['user_id', 'edukasi_id', 'poin_didapat'];
}
