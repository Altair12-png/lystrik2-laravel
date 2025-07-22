@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Tarif Baru</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.tarif.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="daya" class="form-label">Daya</label>
                    <input type="text" class="form-control" id="daya" name="daya" placeholder="Contoh: 900 VA" required>
                </div>
                <div class="mb-3">
                    <label for="tarifperkwh" class="form-label">Tarif per KWH</label>
                    <input type="number" step="0.01" class="form-control" id="tarifperkwh" name="tarifperkwh" placeholder="Contoh: 1352.00" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.tarif.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection