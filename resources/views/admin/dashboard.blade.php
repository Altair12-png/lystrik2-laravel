@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Dashboard Admin</h1>
        <p class="col-md-8 fs-4">Selamat datang, {{ Auth::user()->nama_admin }}.</p>
        <p>Di sini Anda dapat mengelola data pelanggan, tarif, penggunaan, dan verifikasi pembayaran.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Kelola Pelanggan</h5>
                <p class="card-text">Tambah, lihat, dan ubah data pelanggan.</p>
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-primary">Masuk</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Kelola Tarif</h5>
                <p class="card-text">Tambah, lihat, dan ubah data tarif listrik.</p>
                <a href="{{ route('admin.tarif.index') }}" class="btn btn-primary">Masuk</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
         <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Verifikasi Pembayaran</h5>
                <p class="card-text">Lihat dan verifikasi pembayaran dari pelanggan.</p>
                <a href="#" class="btn btn-success">Masuk</a>
            </div>
        </div>
    </div>
</div>
@endsection