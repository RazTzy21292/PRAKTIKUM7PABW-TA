<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

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
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->berhasil($request, 'Login berhasil! Mengalihkan ke dashboard...');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'nis' => ['nullable', 'string', 'max:30'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'string', Password::min(8)],
            'password_confirm' => ['required', 'string', 'same:password'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar, silakan login.',
            'password.min' => 'Password minimal 8 karakter.',
            'password_confirm.required' => 'Konfirmasi password wajib diisi.',
            'password_confirm.same' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nama' => $data['nama'],
            'email' => strtolower($data['email']),
            'password' => $data['password'],
            'nis' => $data['nis'] ?? null,
            'kelas' => $data['kelas'] ?? null,
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

    private function berhasil(Request $request, string $pesan)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $pesan, 'redirect' => url('/dashboard')]);
        }

        return redirect('/dashboard')->with('flash', ['type' => 'success', 'message' => $pesan]);
    }
}
