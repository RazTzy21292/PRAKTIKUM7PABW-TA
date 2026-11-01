<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - SmaCan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo"><i class="ti ti-leaf" aria-hidden="true"></i> SmaCan</div>
        <p class="auth-subtitle">Buat akun baru dan mulai jaga kebersihan sekolahmu</p>

        @if (!empty($flash))
            <div class="alert alert-{!! $flash['type'] === 'error' ? 'error' : 'success' !!}">
                <i class="ti ti-{!! $flash['type'] === 'error' ? 'alert-circle' : 'check' !!}" aria-hidden="true"></i>
                {{ $flash['message'] }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
@csrf
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama lengkapmu" required autofocus
                       value="{{ old('nama') }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nama@smacan.sch.id" required
                       value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="nis">NIS (opsional)</label>
                <input type="text" id="nis" name="nis" class="form-control" placeholder="Nomor Induk Siswa"
                       value="{{ old('nis') }}">
            </div>
            <div class="form-group">
                <label for="kelas">Kelas (opsional)</label>
                <input type="text" id="kelas" name="kelas" class="form-control" placeholder="Contoh: 11 IPA 2"
                       value="{{ old('kelas') }}">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Konfirmasi Password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Ulangi password" required>
            </div>
            <div class="form-actions" style="margin-top:8px">
                <button type="submit" class="btn-primary" style="width:100%; justify-content:center">
                    <i class="ti ti-user-plus" aria-hidden="true"></i> Daftar
                </button>
            </div>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a>
        </div>
    </div>
</div>
</body>
</html>
