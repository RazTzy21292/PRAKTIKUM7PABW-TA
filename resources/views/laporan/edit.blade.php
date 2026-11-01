@extends('layouts.app')

@section('content')
@php
/**
 * View: laporan/edit
 * Form edit laporan sampah milik sendiri (CRUD - Update)
 */
@endphp
<div class="topbar">
    <div class="page-title">
        <h1>Edit Laporan</h1>
        <p>Perbarui data laporan kondisi tong sampah</p>
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
    @if (!empty($laporan['foto']))
        <div class="form-group">
            <label>Foto Saat Ini</label>
            <div class="laporan-thumb" style="width:100px;height:100px">
                <img src="{{ str_contains($laporan['foto'], '/') ? url('foto/' . $laporan['foto']) : asset('uploads/laporan/' . $laporan['foto']) }}" alt="Foto laporan">
            </div>
        </div>
    @endif

    <form action="{{ route('laporan.update', $laporan['id']) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
        <div class="form-group">
            <label for="tong_id">Lokasi Tong Sampah</label>
            <select id="tong_id" name="tong_id" class="form-control" required>
                @foreach ($daftarTong as $tong)
                    <option value="{!! $tong['id'] !!}" {!! (int) $tong['id'] === (int) old('tong_id', $laporan['tong_id']) ? 'selected' : '' !!}>
                        {{ $tong['nama_tong'] }} — {{ $tong['lokasi'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status Kondisi</label>
            <select id="status" name="status" class="form-control" required>
                <option value="kosong" {!! old('status', $laporan['status']) === 'kosong' ? 'selected' : '' !!}>Kosong</option>
                <option value="sedang" {!! old('status', $laporan['status']) === 'sedang' ? 'selected' : '' !!}>Sedang (terisi sebagian)</option>
                <option value="penuh" {!! old('status', $laporan['status']) === 'penuh' ? 'selected' : '' !!}>Penuh</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan (opsional)</label>
            <textarea id="keterangan" name="keterangan" class="form-control">{{ old('keterangan', $laporan['keterangan'] ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="foto">Ganti Foto (opsional)</label>
            <input type="file" id="foto" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG, atau WEBP; maksimal 2 MB.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="ti ti-device-floppy" aria-hidden="true"></i> Simpan Perubahan</button>
            <a href="{{ url('/laporan') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection