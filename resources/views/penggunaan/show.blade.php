@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Data Penggunaan</h2>

    <div class="form-group">
        <strong>Nama Pelanggan:</strong>
        {{ $penggunaan->pelanggan->nama_pelanggan ?? 'Tidak ada' }}
    </div>
    <div class="form-group">
        <strong>Bulan:</strong>
        {{ $penggunaan->bulan }}
    </div>
    <div class="form-group">
        <strong>Tahun:</strong>
        {{ $penggunaan->tahun }}
    </div>
    <div class="form-group">
        <strong>Meter Awal:</strong>
        {{ $penggunaan->meter_awal }} Kwh
    </div>
    <div class="form-group">
        <strong>Meter Akhir:</strong>
        {{ $penggunaan->meter_akhir }} Kwh
    </div>
    <a class="btn btn-primary mt-3" href="{{ route('penggunaan.index') }}">Kembali</a>
</div>
@endsection