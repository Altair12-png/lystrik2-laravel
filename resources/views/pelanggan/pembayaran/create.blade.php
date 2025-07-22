@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Form Pembayaran Tagihan</h1>

    <div class="card">
        <div class="card-header">
            Detail Tagihan
        </div>
        <div class="card-body">
            <p><strong>Bulan/Tahun:</strong> {{ $tagihan->bulan }} {{ $tagihan->tahun }}</p>
            <p><strong>Jumlah Meter:</strong> {{ number_format($tagihan->jumlah_meter, 2, ',', '.') }} KWH</p>
            <p><strong>Total Tagihan:</strong> Rp {{ number_format($tagihan->total_bayar, 2, ',', '.') }}</p>
            <p><strong>Biaya Admin:</strong> Rp {{ number_format(2500, 2, ',', '.') }}</p> {{-- Biaya admin hardcoded --}}
            <p><strong>Total Yang Harus Dibayar:</strong> Rp {{ number_format($tagihan->total_bayar + 2500, 2, ',', '.') }}</p>
            <hr>
            <p class="alert alert-info">Silakan transfer jumlah total yang harus dibayar ke rekening berikut:</p>
            <p><strong>Bank:</strong> Bank ABC</p>
            <p><strong>Nomor Rekening:</strong> 1234567890</p>
            <p><strong>Atas Nama:</strong> PT. Lystrik Jaya</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Unggah Bukti Pembayaran
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('pelanggan.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_tagihan" value="{{ $tagihan->id_tagihan }}">

                <div class="mb-3">
                    <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran (Gambar)</label>
                    <input class="form-control @error('bukti_pembayaran') is-invalid @enderror" type="file" id="bukti_pembayaran" name="bukti_pembayaran" required>
                    @error('bukti_pembayaran')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
                <a href="{{ route('pelanggan.tagihan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
