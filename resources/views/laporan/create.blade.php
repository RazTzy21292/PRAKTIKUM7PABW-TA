@extends('layouts.app')

@section('content')
@php
/**
 * View: laporan/create
 * Form upload laporan sampah baru (CRUD - Create)
 */
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Lapor Sampah</h1>
        <p>Laporkan kondisi tong sampah yang kamu temukan</p>
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
@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="form-card">
    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
@csrf
        <div class="form-group">
            <label for="tong_id">Lokasi Tong Sampah</label>
            <select id="tong_id" name="tong_id" class="form-control" required>
                <option value="">Pilih lokasi tong</option>
                @foreach ($daftarTong as $tong)
                    <option value="{!! $tong['id'] !!}" @selected(old('tong_id') == $tong['id'])>{{ $tong['nama_tong'] }} — {{ $tong['lokasi'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status Kondisi</label>
            <select id="status" name="status" class="form-control" required>
                <option value="">Pilih status</option>
                <option value="kosong" @selected(old('status') === 'kosong')>Kosong</option>
                <option value="sedang" @selected(old('status') === 'sedang')>Sedang (terisi sebagian)</option>
                <option value="penuh" @selected(old('status') === 'penuh')>Penuh</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan (opsional)</label>
            <textarea id="keterangan" name="keterangan" class="form-control" placeholder="Contoh: Tong sudah penuh sejak pagi, perlu segera dikosongkan">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-group">
            <label for="foto">Foto Tong Sampah (opsional, +5 poin bonus)</label>
            <input type="file" id="foto" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG, atau WEBP; maksimal 2 MB.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="ti ti-upload" aria-hidden="true"></i> Kirim Laporan</button>
            <a href="{{ url('/laporan') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
