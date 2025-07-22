@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Pelanggan Baru</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pelanggan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="nomor_kwh" class="form-label">Nomor KWH</label>
                    <input type="text" class="form-control" id="nomor_kwh" name="nomor_kwh" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="id_tarif" class="form-label">Daya Listrik</label>
                    <select class="form-select" id="id_tarif" name="id_tarif" required>
                        @foreach ($tarifs as $tarif)
                            <option value="{{ $tarif->id_tarif }}">{{ $tarif->daya }} (Rp {{ number_format($tarif->tarifperkwh, 2) }}/kWh)</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection