@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Verifikasi Pembayaran Pelanggan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Tagihan</th>
                        <th>Pelanggan</th>
                        <th>Bulan/Tahun Tagihan</th>
                        <th>Tanggal Bayar</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pembayaran->id_tagihan }}</td>
                            <td>{{ $pembayaran->tagihan->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                            <td>{{ $pembayaran->bulan_bayar }} {{ $pembayaran->tahun_bayar }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($pembayaran->total_bayar, 2, ',', '.') }}</td>
                            <td>
                                @if ($pembayaran->status == 'Menunggu Konfirmasi')
                                    <span class="badge bg-warning text-dark">{{ $pembayaran->status }}</span>
                                @elseif ($pembayaran->status == 'Lunas')
                                    <span class="badge bg-success">{{ $pembayaran->status }}</span>
                                @elseif ($pembayaran->status == 'Ditolak')
                                    <span class="badge bg-danger">{{ $pembayaran->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $pembayaran->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pembayaran.show', $pembayaran->id_pembayaran) }}" class="btn btn-sm btn-info">Lihat Detail</a>
                                @if ($pembayaran->status == 'Menunggu Konfirmasi')
                                    {{-- Tombol untuk verifikasi akan ada di halaman detail --}}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada pembayaran yang perlu diverifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pembayarans->links() }}
        </div>
    </div>
</div>
@endsection
