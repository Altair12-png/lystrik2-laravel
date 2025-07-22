@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Penggunaan dan Tagihan</h1>
    <a href="{{ route('admin.penggunaan.create') }}" class="btn btn-primary mb-3">Tambah Penggunaan & Tagihan</a>

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
                        <th>Pelanggan</th>
                        <th>Nomor KWH</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Meter Awal</th>
                        <th>Meter Akhir</th>
                        <th>Jumlah Meter</th>
                        <th>Total Bayar</th>
                        <th>Status Tagihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penggunaans as $penggunaan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $penggunaan->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $penggunaan->pelanggan->nomor_kwh }}</td>
                            <td>{{ $penggunaan->bulan }}</td>
                            <td>{{ $penggunaan->tahun }}</td>
                            <td>{{ number_format($penggunaan->meter_awal, 2, ',', '.') }}</td>
                            <td>{{ number_format($penggunaan->meter_akhir, 2, ',', '.') }}</td>
                            <td>{{ number_format($penggunaan->jumlah_meter, 2, ',', '.') }}</td>
                            <td>Rp {{ number_format($penggunaan->tagihan->total_bayar ?? 0, 2, ',', '.') }}</td>
                            <td>
                                @if ($penggunaan->tagihan->status == 'Belum Bayar')
                                    <span class="badge bg-warning text-dark">{{ $penggunaan->tagihan->status }}</span>
                                @elseif ($penggunaan->tagihan->status == 'Menunggu Konfirmasi')
                                    <span class="badge bg-info">{{ $penggunaan->tagihan->status }}</span>
                                @elseif ($penggunaan->tagihan->status == 'Lunas')
                                    <span class="badge bg-success">{{ $penggunaan->tagihan->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $penggunaan->tagihan->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.penggunaan.edit', $penggunaan->id_penggunaan) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.penggunaan.destroy', $penggunaan->id_penggunaan) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? Ini juga akan menghapus tagihan terkait.')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada data penggunaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $penggunaans->links() }}
        </div>
    </div>
</div>
@endsection
