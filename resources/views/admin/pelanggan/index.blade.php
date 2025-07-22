@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Pelanggan</h1>
    <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary mb-3">Tambah Pelanggan</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Username</th>
                        <th>Nomor KWH</th>
                        <th>Daya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pelanggan->nama_pelanggan }}</td>
                            <td>{{ $pelanggan->username }}</td>
                            <td>{{ $pelanggan->nomor_kwh }}</td>
                            <td>{{ $pelanggan->tarif->daya }}</td>
                            <td>
                                <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id_pelanggan) }}" method="POST">
                                    <a href="{{ route('admin.pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pelanggans->links() }}
        </div>
    </div>
</div>
@endsection