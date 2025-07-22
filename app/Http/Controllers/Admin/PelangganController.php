<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar semua pelanggan.
     */
    public function index()
    {
        $pelanggans = Pelanggan::with('tarif')->latest()->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    /**
     * Menampilkan form untuk membuat pelanggan baru.
     */
    public function create()
    {
        $tarifs = Tarif::all();
        return view('admin.pelanggan.create', compact('tarifs'));
    }

    /**
     * Menyimpan pelanggan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:pelanggans',
            'password' => 'required|string|min:6',
            'nomor_kwh' => 'required|string|max:255|unique:pelanggans',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_tarif' => 'required|exists:tarifs,id_tarif',
        ]);

        Pelanggan::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nomor_kwh' => $request->nomor_kwh,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'id_tarif' => $request->id_tarif,
        ]);

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pelanggan.
     */
    public function edit(Pelanggan $pelanggan)
    {
        $tarifs = Tarif::all();
        return view('admin.pelanggan.edit', compact('pelanggan', 'tarifs'));
    }

    /**
     * Memperbarui data pelanggan di database.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:pelanggans,username,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            'nomor_kwh' => 'required|string|max:255|unique:pelanggans,nomor_kwh,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_tarif' => 'required|exists:tarifs,id_tarif',
        ]);

        $pelanggan->update([
            'username' => $request->username,
            'nomor_kwh' => $request->nomor_kwh,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'id_tarif' => $request->id_tarif,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $pelanggan->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus pelanggan dari database.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil dihapus.');
    }
}