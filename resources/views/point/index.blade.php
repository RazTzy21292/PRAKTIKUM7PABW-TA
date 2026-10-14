@extends('layouts.app')

@section('content')
@php
/**
 * View: point/index
 * Halaman Poin Kamu & Papan Peringkat
 */
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Poin Kamu</h1>
        <p>Kumpulkan poin dari aktivitas edukasimu</p>
    </div>
    <div class="topbar-right">
        <a class="notif-btn" href="#"><i class="ti ti-bell" aria-hidden="true"></i><div class="notif-dot"></div></a>
    </div>
</div>

<div class="point-page-card">
    <div class="point-hero">
        <div class="point-big-icon"><i class="ti ti-star-filled" aria-hidden="true"></i></div>
        <div>
            <div class="point-big-num">{!! number_format($user['total_poin'], 0, ',', '.') !!}</div>
            <div class="point-big-label">Total Poin — Level {!! $levelInfo['level'] !!}</div>
        </div>
    </div>
    <div class="progress-bar" style="margin-bottom:6px">
        <div class="progress-fill" style="width:{!! $levelInfo['persen_progress'] !!}%"></div>
    </div>
    <div style="font-size:12px;color:#6a8a72">{!! $levelInfo['poin_kurang'] !!} poin lagi untuk mencapai Level {!! $levelInfo['level'] + 1 !!}</div>
</div>

<div class="point-page-card">
    <div class="sec-header" style="margin-bottom:8px"><h3>Papan Peringkat</h3></div>
    @foreach ($leaderboard as $index => $row)
@php
        $isMe = (int) $row['id'] === (int) $user['id'];
        $initial = getInitial($row['nama']);
    @endphp
        <div class="rank-item {!! $isMe ? 'me' : '' !!}">
            <div class="rank-num" style="{!! $isMe ? 'color:#2e7d4f' : '' !!}">{!! $index + 1 !!}</div>
            <div class="rank-avatar" style="{!! $isMe ? 'background:#2e7d4f;color:#fff' : '' !!}">{!! $initial !!}</div>
            <div class="rank-name" style="{!! $isMe ? 'font-weight:500;color:#1a5c2e' : '' !!}">
                {{ $row['nama'] }}{!! $isMe ? ' (kamu)' : '' !!}
            </div>
            <div class="rank-pts">{!! number_format($row['total_poin'], 0, ',', '.') !!} poin</div>
        </div>
    @endforeach
</div>
@endsection
