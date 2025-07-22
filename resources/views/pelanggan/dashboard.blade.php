@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard Pelanggan') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Selamat Datang, {{ Auth::user()->nama_pelanggan }}!</h4>
                    <p>Berikut adalah riwayat tagihan listrik Anda.</p>

                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bulan & Tahun</th>
                                <th>Jumlah Meter Digunakan (Kwh)</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tagihans as $tagihan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tagihan->bulan }} {{ $tagihan->tahun }}</td>
                                <td>{{ number_format($tagihan->jumlah_meter, 2, ',', '.') }}</td>
                                <td>Rp {{ number_format($tagihan->total_bayar, 2, ',', '.') }}</td>
                                <td>
                                    @if ($tagihan->status == 'Belum Bayar')
                                        <span class="badge bg-warning text-dark">{{ $tagihan->status }}</span>
                                    @elseif ($tagihan->status == 'Menunggu Konfirmasi')
                                        <span class="badge bg-info">{{ $tagihan->status }}</span>
                                    @elseif ($tagihan->status == 'Lunas')
                                        <span class="badge bg-success">{{ $tagihan->status }}</span>
                                    @elseif ($tagihan->status == 'Ditolak')
                                        <span class="badge bg-danger">{{ $tagihan->status }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $tagihan->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($tagihan->status == 'Belum Bayar')
                                        <a href="{{ route('pelanggan.pembayaran.create', $tagihan->id_tagihan) }}" class="btn btn-primary btn-sm">Bayar Sekarang</a>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Sudah Diproses</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data tagihan untuk Anda.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Link untuk paginasi --}}
                    {!! $tagihans->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
