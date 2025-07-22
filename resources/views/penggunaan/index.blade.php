@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="container">
    <h2>Manajemen Penggunaan Listrik</h2>
    <a href="{{ route('penggunaan.create') }}" class="btn btn-primary mb-3">Tambah Data Penggunaan</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Bulan & Tahun</th>
                <th>Meter Awal</th>
                <th>Meter Akhir</th>
                <th width="280px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penggunaans as $penggunaan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $penggunaan->pelanggan->nama_pelanggan ?? 'Pelanggan tidak ditemukan' }}</td>
                <td>{{ $penggunaan->bulan }} {{ $penggunaan->tahun }}</td>
                <td>{{ $penggunaan->meter_awal }}</td>
                <td>{{ $penggunaan->meter_akhir }}</td>
                <td>
                    <form action="{{ route('penggunaan.destroy', $penggunaan->id_penggunaan) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('penggunaan.show', $penggunaan->id_penggunaan) }}">Detail</a>
                        <a class="btn btn-primary" href="{{ route('penggunaan.edit', $penggunaan->id_penggunaan) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $penggunaans->links() !!}
</div>
@endsection