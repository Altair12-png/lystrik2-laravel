@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Tagihan Listrik Anda</h1>

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
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Jumlah Meter</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tagihans as $tagihan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tagihan->bulan }}</td>
                            <td>{{ $tagihan->tahun }}</td>
                            <td>{{ number_format($tagihan->jumlah_meter, 2, ',', '.') }} KWH</td>
                            <td>Rp {{ number_format($tagihan->total_bayar, 2, ',', '.') }}</td>
                            <td>
                                {{-- DEBUGGING: Tampilkan nilai status sebenarnya --}}
                                <p class="text-muted small">Status Asli: "{{ $tagihan->status }}"</p>
                                @if ($tagihan->status == 'Belum Bayar')
                                    <span class="badge bg-warning text-dark">{{ $tagihan->status }}</span>
                                @elseif ($tagihan->status == 'Menunggu Konfirmasi')
                                    <span class="badge bg-info">{{ $tagihan->status }}</span>
                                @elseif ($tagihan->status == 'Lunas')
                                    <span class="badge bg-success">{{ $tagihan->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $tagihan->status }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- DEBUGGING: Tampilkan URL yang dihasilkan --}}
                                @if ($tagihan->status == 'Belum Bayar')
                                    <p class="text-muted small">URL: "{{ route('pelanggan.pembayaran.create', $tagihan->id_tagihan) }}"</p>
                                    <a href="{{ route('pelanggan.pembayaran.create', $tagihan->id_tagihan) }}" class="btn btn-sm btn-success">Bayar Sekarang</a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Sudah Diproses</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada tagihan untuk Anda saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $tagihans->links() }}
        </div>
    </div>
</div>
@endsection
