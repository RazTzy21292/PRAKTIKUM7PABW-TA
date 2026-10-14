@extends('layouts.app')

@section('content')
@php
/**
 * View: laporan/index
 * Daftar laporan sampah milik user yang login (CRUD - Read)
 */
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Laporan Saya</h1>
        <p>Riwayat laporan kondisi tong sampah yang kamu upload</p>
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

@if (!empty($daftarLaporan))
@foreach ($daftarLaporan as $lap)
@php
    $badgeClass = $lap['status'] === 'penuh' ? 'badge-red' : ($lap['status'] === 'sedang' ? 'badge-amber' : 'badge-green');
@endphp
    <div class="laporan-card-list" id="laporan-{!! $lap['id'] !!}">
        <div class="laporan-thumb">
            @if (!empty($lap['foto']))
                <img src="{{ asset('uploads/laporan/' . $lap['foto']) }}" alt="Foto laporan">
            @else
                <i class="ti ti-trash" aria-hidden="true"></i>
            @endif
        </div>
        <div class="laporan-card-body">
            <div class="laporan-card-title">{{ $lap['nama_tong'] }} <span class="lokasi-status {!! $badgeClass !!}" style="margin-left:6px">{!! ucfirst($lap['status']) !!}</span></div>
            <div class="laporan-card-meta">{{ $lap['lokasi'] }} &middot; {!! timeAgo($lap['created_at']) !!} &middot; +{!! $lap['poin_didapat'] !!} poin</div>
            @if (!empty($lap['keterangan']))
                <div class="laporan-card-desc">{{ $lap['keterangan'] }}</div>
            @endif
            <div class="laporan-card-actions">
                <a href="{{ url('/laporan/edit/' . $lap['id']) }}" class="btn-secondary"><i class="ti ti-edit" style="font-size:13px;vertical-align:-2px" aria-hidden="true"></i> Edit</a>
                <form action="{{ url('/laporan/delete/' . $lap['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" style="display:inline">
@csrf
                    <button type="submit" class="btn-danger"><i class="ti ti-trash" style="font-size:13px;vertical-align:-2px" aria-hidden="true"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endforeach
@else
    <div class="empty-state">
        <i class="ti ti-clipboard-off" aria-hidden="true"></i>
        Kamu belum membuat laporan apapun. Yuk mulai lapor kondisi tong sampah!
    </div>
@endif

<a href="{{ url('/laporan/create') }}" class="fab-add">
    <i class="ti ti-plus" aria-hidden="true"></i> Lapor Sampah
</a>
@endsection
