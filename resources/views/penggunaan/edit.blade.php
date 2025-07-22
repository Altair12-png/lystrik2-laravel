@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Data Penggunaan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penggunaan.update', $penggunaan->id_penggunaan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="id_pelanggan">Nama Pelanggan:</label>
            <select name="id_pelanggan" class="form-control">
                @foreach ($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id_pelanggan }}" {{ $penggunaan->id_pelanggan == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                        {{ $pelanggan->nama_pelanggan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="bulan">Bulan:</label>
            <input type="text" name="bulan" class="form-control" value="{{ $penggunaan->bulan }}">
        </div>

        <div class="form-group">
            <label for="tahun">Tahun:</label>
            <input type="number" name="tahun" class="form-control" value="{{ $penggunaan->tahun }}">
        </div>

        <div class="form-group">
            <label for="meter_awal">Meter Awal (Kwh):</label>
            <input type="number" name="meter_awal" class="form-control" value="{{ $penggunaan->meter_awal }}">
        </div>

        <div class="form-group">
            <label for="meter_akhir">Meter Akhir (Kwh):</label>
            <input type="number" name="meter_akhir" class="form-control" value="{{ $penggunaan->meter_akhir }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        <a class="btn btn-secondary mt-3" href="{{ route('penggunaan.index') }}">Kembali</a>
    </form>
</div>
@endsection