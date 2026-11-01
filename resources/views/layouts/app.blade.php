@php
/**
 * Layout utama aplikasi (untuk halaman setelah login)
 * Variabel $content berisi HTML dari view spesifik halaman
 * Variabel $activePage menentukan menu sidebar mana yang aktif
 */
$activePage = $activePage ?? '';
$user = $user ?? null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmaCan - Dashboard Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body>

<h2 class="sr-only">SmaCan Dashboard Siswa</h2>

<div class="app">
    <nav class="sidebar">
        <div class="logo"><i class="ti ti-leaf logo-icon" aria-hidden="true"></i> SmaCan</div>

        <a class="nav-item {!! $activePage === 'home' ? 'active' : '' !!}" href="{{ url('/dashboard') }}">
            <i class="ti ti-home" aria-hidden="true"></i> Home
        </a>
        <a class="nav-item {!! $activePage === 'lokasi' ? 'active' : '' !!}" href="{{ url('/lokasi') }}">
            <i class="ti ti-map-pin" aria-hidden="true"></i> Lokasi
        </a>
        <a class="nav-item {!! $activePage === 'edukasi' ? 'active' : '' !!}" href="{{ url('/edukasi') }}">
            <i class="ti ti-book" aria-hidden="true"></i> Edukasi
        </a>
        <a class="nav-item {!! $activePage === 'laporan' ? 'active' : '' !!}" href="{{ url('/laporan') }}">
            <i class="ti ti-upload" aria-hidden="true"></i> Laporan Saya
        </a>
        <a class="nav-item {!! $activePage === 'point' ? 'active' : '' !!}" href="{{ url('/point') }}">
            <i class="ti ti-star" aria-hidden="true"></i> Point
        </a>
        <a class="nav-item {!! $activePage === 'profile' ? 'active' : '' !!}" href="{{ url('/profile') }}">
            <i class="ti ti-user-circle" aria-hidden="true"></i> Profile
        </a>

        <div class="nav-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="nav-item logout" type="submit" style="width:100%;border:0;background:transparent;text-align:left;font:inherit;cursor:pointer">
                    <i class="ti ti-logout" aria-hidden="true"></i> Keluar
                </button>
            </form>
        </div>
    </nav>

    <main class="main active-page">
        @yield('content')
    </main>
</div>

<div class="toast" id="toast"></div>

<script>window.APP_BASE_URL = '{{ url("/") }}';</script>
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
