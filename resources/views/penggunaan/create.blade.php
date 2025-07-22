@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Data Penggunaan Baru</h2>

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

    <form action="{{ route('penggunaan.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_pelanggan">Nama Pelanggan:</label>
            <select name="id_pelanggan" class="form-control">
                <option value="">-- Pilih Pelanggan --</option>
                @foreach ($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama_pelanggan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="bulan">Bulan:</label>
            <input type="text" name="bulan" class="form-control" placeholder="Contoh: Januari" value="{{ old('bulan') }}">
        </div>

        <div class="form-group">
            <label for="tahun">Tahun:</label>
            <input type="number" name="tahun" class="form-control" placeholder="Contoh: 2024" value="{{ old('tahun') }}">
        </div>

        <div class="form-group">
            <label for="meter_awal">Meter Awal (Kwh):</label>
            <input type="number" name="meter_awal" class="form-control" placeholder="Meter Awal" value="{{ old('meter_awal') }}">
        </div>

        <div class="form-group">
            <label for="meter_akhir">Meter Akhir (Kwh):</label>
            <input type="number" name="meter_akhir" class="form-control" placeholder="Meter Akhir" value="{{ old('meter_akhir') }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a class="btn btn-secondary mt-3" href="{{ route('penggunaan.index') }}">Kembali</a>
    </form>
</div>
@endsection