<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $user = Auth::user();

        return view('profile.index', [
            'user' => $user,
            'levelInfo' => $user->levelInfo(),
            'artikelDibaca' => $user->klaim()->count(),
            'activePage' => 'profile',
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $nama = trim((string) $request->input('nama', ''));
        $email = trim((string) $request->input('email', ''));
        $nis = trim((string) $request->input('nis', ''));
        $kelas = trim((string) $request->input('kelas', ''));

        if ($nama === '' || $email === '') {
            return $this->kembali('error', 'Nama dan email wajib diisi.');
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->kembali('error', 'Format email tidak valid.');
        }
        if (User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
            return $this->kembali('error', 'Email sudah digunakan akun lain.');
        }

        $user->update([
            'nama' => $nama,
            'email' => $email,
            'nis' => $nis ?: null,
            'kelas' => $kelas ?: null,
        ]);

        return $this->kembali('success', 'Profil berhasil diperbarui.');
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        if (! $request->hasFile('avatar')) {
            return $this->kembali('error', 'Gagal mengupload foto. Silakan coba lagi.');
        }

        $nama = $this->simpanGambar($request->file('avatar'), 'avatar', 'avatar_' . $user->id . '_');
        if ($nama === false) {
            return $this->kembali('error', 'Foto harus JPG, PNG, atau WEBP dan maksimal 2MB.');
        }

        $this->hapusGambar($user->avatar, 'avatar');
        $user->update(['avatar' => $nama]);

        return $this->kembali('success', 'Foto profil berhasil diperbarui.');
    }

    private function kembali(string $type, string $message)
    {
        return redirect('/profile')->with('flash', ['type' => $type, 'message' => $message]);
    }
}
