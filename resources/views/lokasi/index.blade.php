@extends('layouts.app')

@section('content')
@php
/**
 * View: lokasi/index
 * Halaman daftar lokasi & status tong sampah real-time
 */
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Lokasi Tong Sampah</h1>
        <p>Status real-time di seluruh area sekolah</p>
    </div>
    <div class="topbar-right">
        <a class="notif-btn" href="#"><i class="ti ti-bell" aria-hidden="true"></i><div class="notif-dot"></div></a>
    </div>
</div>

<div class="lokasi-grid">
    @foreach ($daftarTong as $tong)
@php
        $badgeClass = $tong['status'] === 'penuh' ? 'badge-red' : ($tong['status'] === 'sedang' ? 'badge-amber' : 'badge-green');
        $statusLabel = ucfirst($tong['status']);
        $fillColor = $tong['status'] === 'penuh' ? '#c0392b' : ($tong['status'] === 'sedang' ? '#c07800' : '#2e7d4f');
        $bgColor = $tong['status'] === 'penuh' ? '#fdecea' : ($tong['status'] === 'sedang' ? '#fdecd0' : '#c8e0cc');
    @endphp
        <div class="lokasi-card">
            <svg width="60" height="68" viewBox="0 0 60 68" fill="none">
                <rect x="8" y="18" width="44" height="46" rx="6" fill="{!! $bgColor !!}" stroke="{!! $fillColor !!}" stroke-width="1.5"/>
                <rect x="4" y="12" width="52" height="8" rx="4" fill="#fff" opacity="0.5" stroke="{!! $fillColor !!}" stroke-width="1.3"/>
                <rect x="20" y="4" width="20" height="9" rx="4" fill="#fff" opacity="0.5" stroke="{!! $fillColor !!}" stroke-width="1.2"/>
                <line x1="22" y1="28" x2="22" y2="56" stroke="{!! $fillColor !!}" stroke-width="1.4" stroke-linecap="round" opacity="0.6"/>
                <line x1="30" y1="28" x2="30" y2="56" stroke="{!! $fillColor !!}" stroke-width="1.4" stroke-linecap="round" opacity="0.6"/>
                <line x1="38" y1="28" x2="38" y2="56" stroke="{!! $fillColor !!}" stroke-width="1.4" stroke-linecap="round" opacity="0.6"/>
            </svg>
            <div class="lokasi-name">{{ $tong['nama_tong'] }}</div>
            <div class="lokasi-place">{{ $tong['lokasi'] }}</div>
            <div class="lokasi-status {!! $badgeClass !!}">{!! $statusLabel !!} ({!! $tong['persentase_terisi'] !!}%)</div>
        </div>
    @endforeach

    @if (empty($daftarTong))
        <div class="empty-state" style="grid-column: 1/-1">
            <i class="ti ti-map-pin-off" aria-hidden="true"></i>
            Belum ada data tong sampah.
        </div>
    @endif
</div>
@endsection
