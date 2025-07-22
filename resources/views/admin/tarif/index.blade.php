@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Tarif</h1>
    <a href="{{ route('admin.tarif.create') }}" class="btn btn-primary mb-3">Tambah Tarif</a>

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
                        <th>Daya</th>
                        <th>Tarif per KWH</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tarifs as $tarif)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tarif->daya }}</td>
                            <td>Rp {{ number_format($tarif->tarifperkwh, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('admin.tarif.destroy', $tarif->id_tarif) }}" method="POST">
                                    <a href="{{ route('admin.tarif.edit', $tarif->id_tarif) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data tarif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $tarifs->links() }}
        </div>
    </div>
</div>
@endsection