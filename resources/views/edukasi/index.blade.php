@extends('layouts.app')

@section('content')
@php
/**
 * View: edukasi/index
 * Halaman daftar artikel edukasi, baca via modal, klaim poin via AJAX
 */
$iconColors = [
    'organik' => ['bg' => '#c8e0cc', 'stroke' => '#2e7d4f'],
    'anorganik' => ['bg' => '#fdecd0', 'stroke' => '#c07800'],
    'b3' => ['bg' => '#fdecea', 'stroke' => '#c0392b'],
    'umum' => ['bg' => '#e8f5ec', 'stroke' => '#2e7d4f'],
];
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Edukasi</h1>
        <p>Belajar &amp; kumpulkan poin dari setiap artikel</p>
    </div>
    <div class="topbar-right">
        <a class="notif-btn" href="#"><i class="ti ti-bell" aria-hidden="true"></i><div class="notif-dot"></div></a>
    </div>
</div>

@foreach ($daftarEdukasi as $edu)
@php
    $color = $iconColors[$edu['icon_type']] ?? $iconColors['umum'];
    $sudahKlaim = (bool) $edu['sudah_klaim'];
@endphp
    <div class="edu-list-card">
        <div class="edu-list-img">
            <svg width="40" height="40" viewBox="0 0 60 60" fill="none">
                <rect x="15" y="12" width="30" height="40" rx="4" fill="{!! $color['bg'] !!}" stroke="{!! $color['stroke'] !!}" stroke-width="1.3"/>
                <rect x="11" y="7" width="38" height="7" rx="3" fill="#fff" opacity="0.6" stroke="{!! $color['stroke'] !!}" stroke-width="1.1"/>
                <rect x="22" y="2" width="16" height="7" rx="2.5" fill="#fff" opacity="0.6" stroke="{!! $color['stroke'] !!}" stroke-width="1"/>
            </svg>
        </div>
        <div class="edu-list-body">
            <div class="edu-list-title">{{ $edu['judul'] }}</div>
            <div class="edu-list-desc">{{ $edu['ringkasan'] }}</div>
            <div class="edu-list-footer">
                <span style="font-size:11px;color:#8a9a8a"><i class="ti ti-clock" style="font-size:13px;vertical-align:-2px" aria-hidden="true"></i> {!! $edu['waktu_baca'] !!} menit</span>
                <span class="edu-poin" style="font-size:12px">+{!! $edu['poin'] !!} poin</span>
                <button class="btn-baca" onclick="openModal('modal{!! $edu['id'] !!}')">Baca Sekarang</button>
                <button class="btn-poin show" id="claim{!! $edu['id'] !!}"
                        onclick="claimPoinAjax({!! $edu['id'] !!}, this)"
                        {!! $sudahKlaim ? 'disabled style="opacity:0.5"' : '' !!}>
                    <i class="ti ti-star" style="font-size:14px" aria-hidden="true"></i>
                    {!! $sudahKlaim ? '✓ Terklaim' : 'Klaim Poin' !!}
                </button>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modal{!! $edu['id'] !!}">
        <div class="modal-box">
            <div class="modal-title">{{ $edu['judul'] }}</div>
            <div class="modal-body">{{ $edu['konten'] }}</div>
            <div class="modal-footer">
                <button class="btn-close" onclick="closeModal('modal{!! $edu['id'] !!}')">Tutup</button>
                @if (!$sudahKlaim)
                    <button class="btn-claim" onclick="closeModal('modal{!! $edu['id'] !!}'); claimPoinAjax({!! $edu['id'] !!}, document.getElementById('claim{!! $edu['id'] !!}'))">
                        <i class="ti ti-star" style="font-size:14px;vertical-align:-2px;margin-right:4px" aria-hidden="true"></i>
                        Selesai &amp; Klaim +{!! $edu['poin'] !!} Poin
                    </button>
                @endif
            </div>
        </div>
    </div>
@endforeach

@if (empty($daftarEdukasi))
    <div class="empty-state">
        <i class="ti ti-book-off" aria-hidden="true"></i>
        Belum ada artikel edukasi.
    </div>
@endif
@endsection
