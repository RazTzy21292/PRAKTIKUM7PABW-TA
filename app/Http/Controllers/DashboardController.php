<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use App\Models\LaporanSampah;
use App\Models\TongSampah;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('dashboard.index', [
            'user' => $user,
            'statTong' => TongSampah::statistik(),
            'levelInfo' => $user->levelInfo(),
            'laporanTerbaru' => LaporanSampah::denganTong()->limit(3)->get()->all(),
            'edukasiTerbaru' => array_slice(Edukasi::denganStatusKlaim($user->id)->all(), 0, 1),
            'activePage' => 'home',
        ]);
    }
}
