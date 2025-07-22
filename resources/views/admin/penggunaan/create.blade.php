@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Penggunaan dan Tagihan Baru</h1>

    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('admin.penggunaan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">Pelanggan</label>
                    <select class="form-select @error('id_pelanggan') is-invalid @enderror" id="id_pelanggan" name="id_pelanggan" required>
                        <option value="" disabled selected>Pilih Pelanggan</option>
                        @foreach ($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id_pelanggan }}" {{ old('id_pelanggan') == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                                {{ $pelanggan->nama_pelanggan }} ({{ $pelanggan->nomor_kwh }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_pelanggan')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select class="form-select @error('bulan') is-invalid @enderror" id="bulan" name="bulan" required>
                        <option value="" disabled selected>Pilih Bulan</option>
                        @php
                            $months = [
                                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ];
                        @endphp
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ old('bulan') == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                    @error('bulan')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" required min="2000" max="{{ date('Y') + 1 }}">
                    @error('tahun')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="meter_awal" class="form-label">Meter Awal</label>
                    <input type="number" step="0.01" class="form-control @error('meter_awal') is-invalid @enderror" id="meter_awal" name="meter_awal" value="{{ old('meter_awal') }}" required>
                    @error('meter_awal')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="meter_akhir" class="form-label">Meter Akhir</label>
                    <input type="number" step="0.01" class="form-control @error('meter_akhir') is-invalid @enderror" id="meter_akhir" name="meter_akhir" value="{{ old('meter_akhir') }}" required>
                    @error('meter_akhir')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.penggunaan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
