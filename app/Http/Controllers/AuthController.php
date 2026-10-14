<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function landing()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('landing');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        if ($email === '' || $password === '') {
            return $this->gagal($request, 'Email dan password wajib diisi.', 'login');
        }

        if (! Auth::attempt(['email' => $email, 'password' => $password])) {
            return $this->gagal($request, 'Email atau password salah.', 'login');
        }

        $request->session()->regenerate();

        return $this->berhasil($request, 'Login berhasil! Mengalihkan ke dashboard...');
    }

    public function register(Request $request)
    {
        $nama = trim((string) $request->input('nama', ''));
        $email = trim((string) $request->input('email', ''));
        $nis = trim((string) $request->input('nis', ''));
        $kelas = trim((string) $request->input('kelas', ''));
        $password = (string) $request->input('password', '');

        // Menerima beberapa kemungkinan nama kolom konfirmasi password
        $konfirmasi = (string) ($request->input('password_confirm')
            ?? $request->input('password_confirmation')
            ?? $request->input('konfirmasi_password')
            ?? $request->input('konfirmasi')
            ?? '');

        if ($nama === '' || $email === '' || $password === '') {
            return $this->gagal($request, 'Nama, email, dan password wajib diisi.', 'register');
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->gagal($request, 'Format email tidak valid.', 'register');
        }
        if (strlen($password) < 6) {
            return $this->gagal($request, 'Password minimal 6 karakter.', 'register');
        }
        if ($password !== $konfirmasi) {
            return $this->gagal($request, 'Konfirmasi password tidak cocok.', 'register');
        }
        if (User::where('email', $email)->exists()) {
            return $this->gagal($request, 'Email sudah terdaftar, silakan login.', 'register');
        }

        $user = User::create([
            'nama' => $nama,
            'email' => $email,
            'password' => $password, // di-hash otomatis oleh cast 'hashed' pada model
            'nis' => $nis ?: null,
            'kelas' => $kelas ?: null,
            'role' => 'siswa',
            'total_poin' => 0,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->berhasil($request, 'Registrasi berhasil! Selamat datang di SmaCan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/landing');
    }

    private function adaJson(Request $request): bool
    {
        return $request->ajax() || $request->wantsJson();
    }

    private function gagal(Request $request, string $pesan, string $halaman)
    {
        if ($this->adaJson($request)) {
            return response()->json(['success' => false, 'message' => $pesan]);
        }

        return redirect('/' . $halaman)
            ->withInput($request->except(
                'password',
                'password_confirm',
                'password_confirmation',
                'konfirmasi_password',
                'konfirmasi'
            ))
            ->with('flash', ['type' => 'error', 'message' => $pesan]);
    }

    private function berhasil(Request $request, string $pesan)
    {
        if ($this->adaJson($request)) {
            return response()->json(['success' => true, 'message' => $pesan, 'redirect' => url('/dashboard')]);
        }

        return redirect('/dashboard')->with('flash', ['type' => 'success', 'message' => $pesan]);
    }
}