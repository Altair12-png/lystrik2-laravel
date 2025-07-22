@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-primary text-white text-center">
                {{-- INI BARIS YANG DIPERBAIKI --}}
                <img src="{{ asset('images/logo-pln.png') }}" alt="Logo PLN" style="height: 50px; margin-bottom: 1rem;">
                <h3 class="fw-light my-2">Selamat Datang di Lystrik</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" name="username" type="text" placeholder="Username" required value="{{ old('username') }}">
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Login sebagai:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="user_type_admin" value="admin" checked>
                            <label class="form-check-label" for="user_type_admin">
                                Admin / Petugas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="user_type_pelanggan" value="pelanggan">
                            <label class="form-check-label" for="user_type_pelanggan">
                                Pelanggan
                            </label>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">

                <div class="small mb-2"><a href="{{ route('register') }}">Belum punya akun? Daftar sekarang!</a></div>
                <div class="text-muted">Aplikasi Pembayaran Listrik Pascabayar</div>
            </div>
                
        </div>
    </div>
</div>
@endsection