@extends('layouts.app')

@section('content')
@php
/**
 * View: dashboard/index
 * Halaman Home — sesuai desain HTML asli (hero, stats, point card, edukasi & laporan terbaru)
 */
$initial = getInitial($user['nama']);
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Dashboard</h1>
        <p>Selamat datang, {{ $user['nama'] }}!</p>
    </div>
    <div class="topbar-right">
        <a class="notif-btn" href="#"><i class="ti ti-bell" aria-hidden="true"></i><div class="notif-dot"></div></a>
        <a class="user-chip" href="{{ url('/profile') }}">
            <div class="avatar">
                @if (!empty($user['avatar']))
                    <img src="{{ asset('uploads/avatar/' . $user['avatar']) }}" alt="Avatar">
                @else
                    {{ $initial }}
                @endif
            </div>
            <span>{{ $user['nama'] }}</span>
        </a>
    </div>
</div>

<div class="hero">
    <div class="hero-text">
        <h2>Bersihkan Sekolah Dari Kuman</h2>
        <p>Pantau kondisi tempat sampah di sekolahmu dan ikut jaga kebersihan lingkungan.</p>
    </div>
    <div class="hero-icons">
        <svg class="trash-svg" width="54" height="64" viewBox="0 0 54 64" fill="none"><rect x="8" y="18" width="38" height="42" rx="5" fill="rgba(255,255,255,0.22)" stroke="rgba(255,255,255,0.6)" stroke-width="1.5"/><rect x="4" y="13" width="46" height="7" rx="3.5" fill="rgba(255,255,255,0.35)" stroke="rgba(255,255,255,0.7)" stroke-width="1.2"/><rect x="20" y="7" width="14" height="7" rx="3" fill="rgba(255,255,255,0.25)" stroke="rgba(255,255,255,0.55)" stroke-width="1.2"/><line x1="19" y1="27" x2="19" y2="52" stroke="rgba(255,255,255,0.45)" stroke-width="1.5" stroke-linecap="round"/><line x1="27" y1="27" x2="27" y2="52" stroke="rgba(255,255,255,0.45)" stroke-width="1.5" stroke-linecap="round"/><line x1="35" y1="27" x2="35" y2="52" stroke="rgba(255,255,255,0.45)" stroke-width="1.5" stroke-linecap="round"/></svg>
        <svg class="trash-svg" width="44" height="54" viewBox="0 0 44 54" fill="none"><rect x="5" y="14" width="34" height="36" rx="5" fill="rgba(255,255,255,0.16)" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/><rect x="2" y="10" width="40" height="6" rx="3" fill="rgba(255,255,255,0.28)" stroke="rgba(255,255,255,0.55)" stroke-width="1.2"/><rect x="15" y="5" width="14" height="6" rx="3" fill="rgba(255,255,255,0.22)" stroke="rgba(255,255,255,0.45)" stroke-width="1.2"/><path d="M16 22 Q22 18 28 22 Q22 28 16 22Z" fill="rgba(255,255,255,0.3)"/><line x1="22" y1="22" x2="22" y2="42" stroke="rgba(255,255,255,0.4)" stroke-width="1.5" stroke-linecap="round"/></svg>
    </div>
</div>

<div class="point-card">
    <div class="point-icon"><i class="ti ti-star-filled" aria-hidden="true"></i></div>
    <div class="point-info">
        <label>Total Poin</label>
        <div class="poin-num">{!! number_format($user['total_poin'], 0, ',', '.') !!}</div>
    </div>
    <div class="point-progress">
        <label><span>Progress ke Level {!! $levelInfo['level'] + 1 !!}</span><span>Lvl.{!! $levelInfo['level'] !!}</span></label>
        <div class="progress-bar"><div class="progress-fill" style="width:{!! $levelInfo['persen_progress'] !!}%"></div></div>
    </div>
    <div class="level-badge">Lvl.{!! $levelInfo['level'] !!}</div>
</div>

<div>
    <div class="sec-header">
        <h3>Status Tempat Sampah</h3>
        <a href="{{ url('/lokasi') }}">Lihat detail →</a>
    </div>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Kosong</div>
            <div class="stat-val green">{!! $statTong['kosong'] !!}</div>
            <div class="stat-badge badge-green"><i class="ti ti-check" style="font-size:13px" aria-hidden="true"></i> Aman</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sedang</div>
            <div class="stat-val amber">{!! $statTong['sedang'] !!}</div>
            <div class="stat-badge badge-amber"><i class="ti ti-alert-triangle" style="font-size:13px" aria-hidden="true"></i> Pantau</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Penuh</div>
            <div class="stat-val red">{!! $statTong['penuh'] !!}</div>
            <div class="stat-badge badge-red"><i class="ti ti-alert-circle" style="font-size:13px" aria-hidden="true"></i> Segera</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Tong</div>
            <div style="display:flex;align-items:center;gap:8px">
                <svg width="26" height="30" viewBox="0 0 26 30" fill="none"><rect x="3" y="8" width="20" height="19" rx="3" fill="#c8e0cc" stroke="#2e7d4f" stroke-width="1.2"/><rect x="1" y="5" width="24" height="4" rx="2" fill="#e8f5ec" stroke="#2e7d4f" stroke-width="1.2"/><rect x="9" y="1" width="8" height="4" rx="2" fill="#e8f5ec" stroke="#2e7d4f" stroke-width="1"/><line x1="9" y1="13" x2="9" y2="23" stroke="#2e7d4f" stroke-width="1.1" stroke-linecap="round"/><line x1="13" y1="13" x2="13" y2="23" stroke="#2e7d4f" stroke-width="1.1" stroke-linecap="round"/><line x1="17" y1="13" x2="17" y2="23" stroke="#2e7d4f" stroke-width="1.1" stroke-linecap="round"/></svg>
                <div class="stat-val dark">{!! $statTong['total'] !!}</div>
            </div>
            <div class="stat-badge badge-gray">Semua</div>
        </div>
    </div>
</div>

<div class="two-col">
    <div>
        <div class="sec-header">
            <h3>Edukasi Terbaru</h3>
            <a href="{{ url('/edukasi') }}">Baca Sekarang</a>
        </div>
        @if (!empty($edukasiTerbaru))
@foreach ($edukasiTerbaru as $edu)
            <a class="edu-card" href="{{ url('/edukasi') }}">
                <div class="edu-img"><i class="ti ti-recycle" style="font-size:80px; color:#2e7d4f"></i></div>
                <div class="edu-body">
                    <div class="edu-title">{{ $edu['judul'] }}</div>
                    <div class="edu-meta">
                        <i class="ti ti-clock" style="font-size:13px" aria-hidden="true"></i> {!! $edu['waktu_baca'] !!} menit baca
                        <span class="edu-poin">+{!! $edu['poin'] !!} poin</span>
                    </div>
                </div>
            </a>
        @endforeach
@else
            <p style="font-size:13px;color:#8a9a8a">Belum ada artikel edukasi.</p>
        @endif
    </div>
    <div>
        <div class="sec-header">
            <h3>Laporan Terbaru</h3>
            <a href="{{ url('/laporan') }}">Lihat detail →</a>
        </div>
        @if (!empty($laporanTerbaru))
@foreach ($laporanTerbaru as $lap)
@php
            $dotColor = $lap['status'] === 'penuh' ? '#e74c3c' : ($lap['status'] === 'sedang' ? '#f39c12' : '#2e7d4f');
            $statusLabel = $lap['status'] === 'penuh' ? 'Penuh – Perlu dikosongkan' : ($lap['status'] === 'sedang' ? 'Sedang – terisi sebagian' : 'Kosong – Baru dikosongkan');
            $waktu = timeAgo($lap['created_at']);
        @endphp
            <div class="laporan-item">
                <div class="laporan-dot" style="background:{!! $dotColor !!}"></div>
                <div class="laporan-info">
                    <div class="laporan-name">{{ $lap['nama_tong'] }}</div>
                    <div class="laporan-sub">{!! $statusLabel !!}</div>
                </div>
                <div class="laporan-time">{!! $waktu !!}</div>
            </div>
        @endforeach
@else
            <p style="font-size:13px;color:#8a9a8a">Belum ada laporan masuk.</p>
        @endif
    </div>
</div>
@endsection
