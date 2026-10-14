<?php

namespace App\Http\Controllers;

use App\Models\TongSampah;
use Illuminate\Support\Facades\Auth;

class LokasiController extends Controller
{
    public function index()
    {
        return view('lokasi.index', [
            'user' => Auth::user(),
            'daftarTong' => TongSampah::orderBy('nama_tong')->get()->all(),
            'activePage' => 'lokasi',
        ]);
    }
}
