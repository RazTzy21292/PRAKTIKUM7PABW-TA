<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\EdukasiKlaim;
use App\Models\LaporanSampah;
use App\Models\TongSampah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * REST API internal (dipakai AJAX di frontend). Semua route dilindungi middleware 'auth'.
 */
class ApiController extends Controller
{
    use HandlesUploads;

    public function stats()
    {
        $user = Auth::user();

        return $this->ok([
            'total_poin' => (int) $user->total_poin,
            'level' => $user->levelInfo(),
            'tong' => TongSampah::statistik(),
        ]);
    }

    public function tong()
    {
        return $this->ok(TongSampah::orderBy('nama_tong')->get());
    }

    public function laporanIndex()
    {
        $daftar = LaporanSampah::denganTong()->where('laporan_sampah.user_id', Auth::id())->get();

        $daftar->each(function ($item) {
            $item->foto_url = $item->foto ? asset('uploads/laporan/' . $item->foto) : null;
        });

        return $this->ok($daftar);
    }

    public function laporanStore(Request $request)
    {
        $user = Auth::user();
        $tongId = $request->input('tong_id');
        $status = $request->input('status');

        if (empty($tongId) || ! in_array($status, ['kosong', 'sedang', 'penuh'], true) || ! TongSampah::whereKey($tongId)->exists()) {
            return $this->error('Lokasi tong dan status wajib diisi dengan benar.', 422);
        }

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $this->simpanGambar($request->file('foto'), 'laporan', 'laporan_');
            if ($foto === false) {
                return $this->error('Foto harus JPG/PNG/WEBP dan maksimal 2MB.', 422);
            }
        }

        $poin = $foto ? 10 : 5;

        $laporan = LaporanSampah::create([
            'user_id' => $user->id,
            'tong_id' => $tongId,
            'status' => $status,
            'keterangan' => trim((string) $request->input('keterangan', '')) ?: null,
            'foto' => $foto,
            'poin_didapat' => $poin,
        ]);

        TongSampah::whereKey($tongId)->update(['status' => $status]);
        $user->increment('total_poin', $poin);

        $baru = LaporanSampah::denganTong()->where('laporan_sampah.id', $laporan->id)->first();
        $baru->foto_url = $foto ? asset('uploads/laporan/' . $foto) : null;

        return $this->ok($baru, 'Laporan berhasil ditambahkan. +' . $poin . ' poin.', 201);
    }

    public function laporanDelete($id)
    {
        $laporan = LaporanSampah::where('id', $id)->where('user_id', Auth::id())->first();

        if (! $laporan) {
            return $this->error('Laporan tidak ditemukan atau bukan milikmu.', 404);
        }

        $this->hapusGambar($laporan->foto, 'laporan');
        $laporan->delete();

        return $this->ok(null, 'Laporan berhasil dihapus.');
    }

    public function leaderboard()
    {
        $meId = Auth::id();

        $data = User::leaderboard(10)->map(fn ($u) => [
            'id' => $u->id,
            'nama' => $u->nama,
            'total_poin' => $u->total_poin,
            'initial' => $u->initial(),
            'is_me' => (int) $u->id === (int) $meId,
        ]);

        return $this->ok($data);
    }

    public function edukasiKlaim($id)
    {
        $user = Auth::user();
        $artikel = Edukasi::find($id);

        if (! $artikel) {
            return $this->error('Artikel tidak ditemukan.', 404);
        }

        if (EdukasiKlaim::where('user_id', $user->id)->where('edukasi_id', $artikel->id)->exists()) {
            return $this->error('Kamu sudah klaim poin untuk artikel ini.', 409);
        }

        EdukasiKlaim::create([
            'user_id' => $user->id,
            'edukasi_id' => $artikel->id,
            'poin_didapat' => $artikel->poin,
        ]);
        $user->increment('total_poin', $artikel->poin);
        $user->refresh();

        return $this->ok([
            'poin_didapat' => (int) $artikel->poin,
            'total_poin' => (int) $user->total_poin,
        ], '+' . $artikel->poin . ' poin berhasil diklaim!');
    }

    public function profileShow()
    {
        $user = Auth::user();
        $data = $user->toArray();
        $data['level_info'] = $user->levelInfo();
        $data['avatar_url'] = $user->avatar ? asset('uploads/avatar/' . $user->avatar) : null;
        $data['initial'] = $user->initial();

        return $this->ok($data);
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $nama = trim((string) $request->input('nama', ''));
        $email = trim((string) $request->input('email', ''));

        if ($nama === '' || $email === '') {
            return $this->error('Nama dan email wajib diisi.', 422);
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->error('Format email tidak valid.', 422);
        }
        if (User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
            return $this->error('Email sudah digunakan akun lain.', 409);
        }

        $user->update([
            'nama' => $nama,
            'email' => $email,
            'nis' => trim((string) $request->input('nis', '')) ?: null,
            'kelas' => trim((string) $request->input('kelas', '')) ?: null,
        ]);

        return $this->ok($user->fresh(), 'Profil berhasil diperbarui.');
    }

    private function ok($data = [], string $message = 'OK', int $status = 200)
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $status);
    }

    private function error(string $message, int $status = 400)
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => []], $status);
    }
}
