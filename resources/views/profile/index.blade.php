@extends('layouts.app')

@section('content')
@php
/**
 * View: profile/index
 * Halaman Profil Saya — bisa edit data & ganti foto profil
 */
$initial = getInitial($user['nama']);
$tanggalGabung = date('F Y', strtotime($user['created_at']));

// Terjemahkan nama bulan ke Bahasa Indonesia
$bulanEn = ['January','February','March','April','May','June','July','August','September','October','November','December'];
$bulanId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tanggalGabung = str_replace($bulanEn, $bulanId, $tanggalGabung);
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Profil Saya</h1>
        <p>Kelola informasi akunmu</p>
    </div>
    <div class="topbar-right">
        <a class="notif-btn" href="#"><i class="ti ti-bell" aria-hidden="true"></i><div class="notif-dot"></div></a>
    </div>
</div>

@if (!empty($flash))
    <div class="alert alert-{!! $flash['type'] === 'error' ? 'error' : 'success' !!}">
        <i class="ti ti-{!! $flash['type'] === 'error' ? 'alert-circle' : 'check' !!}" aria-hidden="true"></i>
        {{ $flash['message'] }}
    </div>
@endif

<div class="profile-card">
    <div class="profile-head">
        <div class="profile-avatar">
            @if (!empty($user['avatar']))
                <img src="{{ asset('uploads/avatar/' . $user['avatar']) }}" alt="Avatar">
            @else
                {{ $initial }}
            @endif
        </div>
        <div>
            <div class="profile-name">{{ $user['nama'] }}</div>
            <div class="profile-role">Siswa — {{ $user['kelas'] ?? 'Belum diatur' }}</div>
        </div>
        <button class="btn-edit" style="margin-left:auto" onclick="openModal('modalEditProfile')">
            <i class="ti ti-edit" style="font-size:14px;vertical-align:-2px;margin-right:4px" aria-hidden="true"></i>Edit Profil
        </button>
    </div>
    <div class="profile-row">
        <i class="ti ti-mail" aria-hidden="true"></i>
        <div class="profile-row-val"><label>Email</label><span>{{ $user['email'] }}</span></div>
    </div>
    <div class="profile-row">
        <i class="ti ti-id-badge" aria-hidden="true"></i>
        <div class="profile-row-val"><label>NIS</label><span>{{ $user['nis'] ?? '-' }}</span></div>
    </div>
    <div class="profile-row">
        <i class="ti ti-building-school" aria-hidden="true"></i>
        <div class="profile-row-val"><label>Sekolah</label><span>{{ $user['sekolah'] }}</span></div>
    </div>
    <div class="profile-row">
        <i class="ti ti-calendar" aria-hidden="true"></i>
        <div class="profile-row-val"><label>Bergabung</label><span>{!! $tanggalGabung !!}</span></div>
    </div>
</div>

<div class="profile-card">
    <div class="sec-header" style="margin-bottom:12px"><h3>Statistik Aktivitas</h3></div>
    <div class="profile-stats">
        <div class="ps-item">
            <div class="ps-val">{!! number_format($user['total_poin'], 0, ',', '.') !!}</div>
            <div class="ps-label">Total Poin</div>
        </div>
        <div class="ps-item">
            <div class="ps-val">{!! $artikelDibaca !!}</div>
            <div class="ps-label">Artikel Dibaca</div>
        </div>
        <div class="ps-item">
            <div class="ps-val">Lvl.{!! $levelInfo['level'] !!}</div>
            <div class="ps-label">Level Kamu</div>
        </div>
    </div>
</div>

<!-- MODAL: EDIT PROFIL -->
<div class="modal-overlay" id="modalEditProfile">
    <div class="modal-box" style="max-width:480px">
        <div class="modal-title">Edit Profil</div>

        <!-- Form ganti foto avatar -->
        <form action="{{ url('/profile/avatar') }}" method="POST" enctype="multipart/form-data" style="margin-bottom:18px; padding-bottom:18px; border-bottom:0.5px solid #eaf2ec">
@csrf
            <div class="form-group" style="margin-bottom:8px">
                <label>Foto Profil</label>
                <input type="file" name="avatar" class="form-control" accept="image/jpeg,image/png,image/webp" required>
            </div>
            <button type="submit" class="btn-secondary" style="font-size:12px;padding:7px 14px">
                <i class="ti ti-upload" style="font-size:13px" aria-hidden="true"></i> Upload Foto Baru
            </button>
        </form>

        <!-- Form edit data profil -->
        <form action="{{ url('/profile/update') }}" method="POST">
@csrf
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ $user['nama'] }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user['email'] }}" required>
            </div>
            <div class="form-group">
                <label for="nis">NIS</label>
                <input type="text" id="nis" name="nis" class="form-control" value="{{ $user['nis'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" name="kelas" class="form-control" value="{{ $user['kelas'] ?? '' }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-close" onclick="closeModal('modalEditProfile')">Batal</button>
                <button type="submit" class="btn-claim">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@if (!empty($flash) && $flash['type'] === 'error')
<script>openModal('modalEditProfile');</script>
@endif
@endsection
