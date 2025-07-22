@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Detail Pembayaran & Verifikasi</h1>

    <div class="card mb-4">
        <div class="card-header">
            Informasi Pembayaran
        </div>
        <div class="card-body">
            <p><strong>ID Pembayaran:</strong> {{ $pembayaran->id_pembayaran }}</p>
            <p><strong>Pelanggan:</strong> {{ $pembayaran->tagihan->pelanggan->nama_pelanggan ?? 'N/A' }} ({{ $pembayaran->tagihan->pelanggan->nomor_kwh ?? 'N/A' }})</p>
            <p><strong>Tagihan untuk:</strong> Bulan {{ $pembayaran->bulan_bayar }} Tahun {{ $pembayaran->tahun_bayar }}</p>
            <p><strong>Tanggal Pembayaran:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d F Y H:i') }}</p>
            <p><strong>Total Dibayar:</strong> Rp {{ number_format($pembayaran->total_bayar, 2, ',', '.') }}</p>
            <p><strong>Biaya Admin:</strong> Rp {{ number_format($pembayaran->biaya_admin, 2, ',', '.') }}</p>
            <p><strong>Status Pembayaran:</strong>
                @if ($pembayaran->status == 'Menunggu Konfirmasi')
                    <span class="badge bg-warning text-dark">{{ $pembayaran->status }}</span>
                @elseif ($pembayaran->status == 'Lunas')
                    <span class="badge bg-success">{{ $pembayaran->status }}</span>
                @elseif ($pembayaran->status == 'Ditolak')
                    <span class="badge bg-danger">{{ $pembayaran->status }}</span>
                @else
                    <span class="badge bg-secondary">{{ $pembayaran->status }}</span>
                @endif
            </p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Bukti Pembayaran
        </div>
        <div class="card-body text-center">
            @if ($pembayaran->bukti_pembayaran)
                <img src="{{ Storage::url($pembayaran->bukti_pembayaran) }}" class="img-fluid rounded" alt="Bukti Pembayaran" style="max-height: 400px;">
            @else
                <p>Tidak ada bukti pembayaran yang diunggah.</p>
            @endif
        </div>
    </div>

    @if ($pembayaran->status == 'Menunggu Konfirmasi')
        <div class="card">
            <div class="card-header">
                Aksi Verifikasi
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pembayaran.update', $pembayaran->id_pembayaran) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Ubah Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Verifikasi / Tolak</button>
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    @else
        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Kembali ke Daftar Pembayaran</a>
    @endif
</div>
@endsection
    