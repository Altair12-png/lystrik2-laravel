@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="fw-light my-2">Daftar Akun Baru</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input id="nama_pelanggan" type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required>
                        <label for="nama_pelanggan">Nama Lengkap</label>
                        @error('nama_pelanggan')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required>
                        <label for="username">Username</label>
                         @error('username')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-floating mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                <label for="password">Password</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-floating mb-3">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                <label for="password-confirm">Konfirmasi Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input id="nomor_kwh" type="text" class="form-control @error('nomor_kwh') is-invalid @enderror" name="nomor_kwh" value="{{ old('nomor_kwh') }}" required>
                        <label for="nomor_kwh">Nomor KWH</label>
                        @error('nomor_kwh')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                     <div class="form-floating mb-3">
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required style="height: 100px">{{ old('alamat') }}</textarea>
                        <label for="alamat">Alamat</label>
                        @error('alamat')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                     <div class="form-floating mb-3">
                        <select class="form-select @error('id_tarif') is-invalid @enderror" id="id_tarif" name="id_tarif" required>
                             <option value="" disabled selected>Pilih Daya Listrik Anda</option>
                            @foreach ($tarifs as $tarif)
                                <option value="{{ $tarif->id_tarif }}" {{ old('id_tarif') == $tarif->id_tarif ? 'selected' : '' }}>
                                    {{ $tarif->daya }} (Rp {{ number_format($tarif->tarifperkwh) }}/kWh)
                                </option>
                            @endforeach
                        </select>
                        <label for="id_tarif">Daya Listrik</label>
                         @error('id_tarif')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                           Daftar
                        </button>
                    </div>
                </form>
            </div>
             <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('login') }}">Sudah punya akun? Login di sini</a></div>
            </div>
        </div>
    </div>
</div>
@endsection