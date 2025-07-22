<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        $tarifs = Tarif::all();
        return view('auth.register', compact('tarifs'));
    }

    /**
     * Menangani permintaan registrasi.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:pelanggans'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'nomor_kwh' => ['required', 'string', 'max:20', 'unique:pelanggans'],
            'alamat' => ['required', 'string'],
            'id_tarif' => ['required', 'exists:tarifs,id_tarif'],
        ]);

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nomor_kwh' => $request->nomor_kwh,
            'alamat' => $request->alamat,
            'id_tarif' => $request->id_tarif,
        ]);

        Auth::guard('pelanggan')->login($pelanggan);

        return redirect()->route('pelanggan.dashboard');
    }
}