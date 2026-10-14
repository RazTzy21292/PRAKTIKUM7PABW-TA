<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use App\Models\EdukasiKlaim;
use Illuminate\Support\Facades\Auth;

class EdukasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('edukasi.index', [
            'user' => $user,
            'daftarEdukasi' => Edukasi::denganStatusKlaim($user->id)->all(),
            'activePage' => 'edukasi',
        ]);
    }

    /** Klaim poin (versi form biasa, tanpa AJAX). */
    public function klaim($id)
    {
        $user = Auth::user();
        $artikel = Edukasi::find($id);

        if (! $artikel) {
            return redirect('/edukasi')->with('flash', ['type' => 'error', 'message' => 'Artikel tidak ditemukan.']);
        }

        if (EdukasiKlaim::where('user_id', $user->id)->where('edukasi_id', $artikel->id)->exists()) {
            return redirect('/edukasi')->with('flash', ['type' => 'error', 'message' => 'Kamu sudah klaim poin untuk artikel ini.']);
        }

        EdukasiKlaim::create([
            'user_id' => $user->id,
            'edukasi_id' => $artikel->id,
            'poin_didapat' => $artikel->poin,
        ]);
        $user->increment('total_poin', $artikel->poin);

        return redirect('/edukasi')->with('flash', ['type' => 'success', 'message' => '+' . $artikel->poin . ' poin berhasil diklaim!']);
    }
}
