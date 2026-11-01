<?php

namespace App\Http\Controllers;

use App\Models\LaporanSampah;
use App\Models\TongSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('laporan.index', [
            'user' => $user,
            'daftarLaporan' => LaporanSampah::denganTong()->where('laporan_sampah.user_id', $user->id)->get()->all(),
            'activePage' => 'laporan',
        ]);
    }

    public function create()
    {
        return view('laporan.create', [
            'user' => Auth::user(),
            'daftarTong' => TongSampah::orderBy('nama_tong')->get()->all(),
            'activePage' => 'laporan',
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate($this->aturanValidasi(), $this->pesanValidasi());
        $foto = $request->file('foto')?->store('laporan', 'public');
        $poin = $foto ? 10 : 5;

        $user->laporan()->create([
            'user_id' => $user->id,
            'tong_id' => $data['tong_id'],
            'status' => $data['status'],
            'keterangan' => $data['keterangan'] ?? null,
            'foto' => $foto,
            'poin_didapat' => $poin,
        ]);

        TongSampah::whereKey($data['tong_id'])->update(['status' => $data['status']]);
        $user->increment('total_poin', $poin);

        return redirect()->route('laporan.index')->with('flash', [
            'type' => 'success',
            'message' => 'Laporan berhasil dikirim! +'.$poin.' poin didapat.',
        ]);
    }

    public function edit(int $id)
    {
        $laporan = $this->milikSendiri($id);

        return view('laporan.edit', [
            'user' => Auth::user(),
            'laporan' => $laporan,
            'daftarTong' => TongSampah::orderBy('nama_tong')->get()->all(),
            'activePage' => 'laporan',
        ]);
    }

    public function update(Request $request, int $id)
    {
        $laporan = $this->milikSendiri($id);
        $data = $request->validate($this->aturanValidasi(), $this->pesanValidasi());
        unset($data['foto']);
        $data['edited_at'] = now();
        $fotoLama = $laporan->foto;
        $fotoBaru = $request->file('foto')?->store('laporan', 'public');
        if ($fotoBaru) {
            $data['foto'] = $fotoBaru;
        }
        $laporan->update($data);
        TongSampah::whereKey($data['tong_id'])->update(['status' => $data['status']]);

        if ($fotoBaru) {
            $this->hapusFoto($fotoLama);
        }

        return redirect()->route('laporan.index')->with('flash', [
            'type' => 'success',
            'message' => 'Laporan berhasil diperbarui.',
        ]);
    }

    public function destroy(int $id)
    {
        $laporan = $this->milikSendiri($id);
        $foto = $laporan->foto;
        $laporan->delete();
        $this->hapusFoto($foto);

        return redirect()->route('laporan.index')->with('flash', [
            'type' => 'success',
            'message' => 'Laporan berhasil dihapus.',
        ]);
    }

    private function milikSendiri(int $id): LaporanSampah
    {
        return LaporanSampah::where('user_id', Auth::id())->findOrFail($id);
    }

    private function aturanValidasi(): array
    {
        return [
            'tong_id' => ['required', 'exists:tong_sampah,id'],
            'status' => ['required', 'in:kosong,sedang,penuh'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    private function pesanValidasi(): array
    {
        return [
            'tong_id.required' => 'Lokasi tong wajib dipilih.',
            'tong_id.exists' => 'Lokasi tong yang dipilih tidak tersedia.',
            'status.required' => 'Status kondisi wajib dipilih.',
            'status.in' => 'Pilih status kosong, sedang, atau penuh.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ];
    }

    private function hapusFoto(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (str_contains($path, '/')) {
            Storage::disk('public')->delete($path);

            return;
        }

        Storage::disk('public')->delete('laporan/'.$path);
        $legacyPath = public_path('uploads/laporan/'.basename($path));
        if (is_file($legacyPath)) {
            unlink($legacyPath);
        }
    }
}
