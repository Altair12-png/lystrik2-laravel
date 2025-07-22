@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Data Pelanggan</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $pelanggan->username }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru (Opsional)</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                </div>
                <div class="mb-3">
                    <label for="nomor_kwh" class="form-label">Nomor KWH</label>
                    <input type="text" class="form-control" id="nomor_kwh" name="nomor_kwh" value="{{ $pelanggan->nomor_kwh }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $pelanggan->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="id_tarif" class="form-label">Daya Listrik</label>
                    <select class="form-select" id="id_tarif" name="id_tarif" required>
                        @foreach ($tarifs as $tarif)
                            <option value="{{ $tarif->id_tarif }}" {{ $pelanggan->id_tarif == $tarif->id_tarif ? 'selected' : '' }}>
                                {{ $tarif->daya }} (Rp {{ number_format($tarif->tarifperkwh, 2) }}/kWh)
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
