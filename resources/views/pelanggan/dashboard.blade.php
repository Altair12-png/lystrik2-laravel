@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Selamat Datang, {{ Auth::guard('pelanggan')->user()->nama_pelanggan }}!</h1>
        <p class="fs-4">Ini adalah halaman informasi dan riwayat tagihan listrik Anda.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Informasi Pelanggan
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ Auth::guard('pelanggan')->user()->nama_pelanggan }}</p>
                <p><strong>Nomor KWH:</strong> {{ Auth::guard('pelanggan')->user()->nomor_kwh }}</p>
                <p><strong>Alamat:</strong> {{ Auth::guard('pelanggan')->user()->alamat }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Riwayat Tagihan</h5>
                <p class="card-text">Lihat semua riwayat tagihan dan pembayaran listrik Anda.</p>
                <a href="{{ route('pelanggan.tagihan.index') }}" class="btn btn-primary">Lihat Tagihan</a>
            </div>
        </div>
    </div>
</div>
@endsection