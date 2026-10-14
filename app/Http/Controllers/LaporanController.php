<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Models\LaporanSampah;
use App\Models\TongSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    use HandlesUploads;

    private const STATUS = ['kosong', 'sedang', 'penuh'];

    /** READ - daftar laporan milik user yang login */
    public function index()
    {
        $user = Auth::user();

        return view('laporan.index', [
            'user' => $user,
            'daftarLaporan' => LaporanSampah::denganTong()->where('laporan_sampah.user_id', $user->id)->get()->all(),
            'activePage' => 'laporan',
        ]);
    }

    /** CREATE - form */
    public function create()
    {
        return view('laporan.create', [
            'user' => Auth::user(),
            'daftarTong' => TongSampah::orderBy('nama_tong')->get()->all(),
            'activePage' => 'laporan',
        ]);
    }

    /** CREATE - simpan ke database */
    public function store(Request $request)
    {
        $user = Auth::user();
        $tongId = $request->input('tong_id');
        $status = $request->input('status');

        if (empty($tongId) || empty($status)) {
            return $this->kembali('/laporan/create', 'error', 'Lokasi tong dan status wajib dipilih.');
        }
        if (! in_array($status, self::STATUS, true) || ! TongSampah::whereKey($tongId)->exists()) {
            return $this->kembali('/laporan/create', 'error', 'Status tidak valid.');
        }

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $this->simpanGambar($request->file('foto'), 'laporan', 'laporan_');
            if ($foto === false) {
                return $this->kembali('/laporan/create', 'error', 'Foto harus berformat JPG/PNG/WEBP dan maksimal 2MB.');
            }
        }

        $poin = $foto ? 10 : 5;

        LaporanSampah::create([
            'user_id' => $user->id,
            'tong_id' => $tongId,
            'status' => $status,
            'keterangan' => trim((string) $request->input('keterangan', '')) ?: null,
            'foto' => $foto,
            'poin_didapat' => $poin,
        ]);

        TongSampah::whereKey($tongId)->update(['status' => $status]);
        $user->increment('total_poin', $poin);

        return $this->kembali('/laporan', 'success', 'Laporan berhasil dikirim! +' . $poin . ' poin didapat.');
    }

    /** UPDATE - form edit (hanya milik sendiri) */
    public function edit($id)
    {
        $laporan = $this->milikSendiri($id);
        if (! $laporan) {
            return $this->kembali('/laporan', 'error', 'Laporan tidak ditemukan atau bukan milikmu.');
        }

        return view('laporan.edit', [
            'user' => Auth::user(),
            'laporan' => $laporan,
            'daftarTong' => TongSampah::orderBy('nama_tong')->get()->all(),
            'activePage' => 'laporan',
        ]);
    }

    /** UPDATE - simpan perubahan */
    public function update(Request $request, $id)
    {
        $laporan = $this->milikSendiri($id);
        if (! $laporan) {
            return $this->kembali('/laporan', 'error', 'Laporan tidak ditemukan atau bukan milikmu.');
        }

        $tongId = $request->input('tong_id');
        $status = $request->input('status');

        if (empty($tongId) || ! in_array($status, self::STATUS, true) || ! TongSampah::whereKey($tongId)->exists()) {
            return $this->kembali('/laporan/edit/' . $id, 'error', 'Data tidak valid.');
        }

        $data = [
            'tong_id' => $tongId,
            'status' => $status,
            'keterangan' => trim((string) $request->input('keterangan', '')) ?: null,
        ];

        if ($request->hasFile('foto')) {
            $fotoBaru = $this->simpanGambar($request->file('foto'), 'laporan', 'laporan_');
            if ($fotoBaru === false) {
                return $this->kembali('/laporan/edit/' . $id, 'error', 'Foto harus berformat JPG/PNG/WEBP dan maksimal 2MB.');
            }
            $this->hapusGambar($laporan->foto, 'laporan');
            $data['foto'] = $fotoBaru;
        }

        $laporan->update($data);
        TongSampah::whereKey($tongId)->update(['status' => $status]);

        return $this->kembali('/laporan', 'success', 'Laporan berhasil diperbarui.');
    }

    /** DELETE - hapus laporan milik sendiri */
    public function delete($id)
    {
        $laporan = $this->milikSendiri($id);
        if (! $laporan) {
            return $this->kembali('/laporan', 'error', 'Laporan tidak ditemukan atau bukan milikmu.');
        }

        $this->hapusGambar($laporan->foto, 'laporan');
        $laporan->delete();

        return $this->kembali('/laporan', 'success', 'Laporan berhasil dihapus.');
    }

    private function milikSendiri($id): ?LaporanSampah
    {
        return LaporanSampah::where('id', $id)->where('user_id', Auth::id())->first();
    }

    private function kembali(string $url, string $type, string $message)
    {
        return redirect($url)->with('flash', ['type' => $type, 'message' => $message]);
    }
}
