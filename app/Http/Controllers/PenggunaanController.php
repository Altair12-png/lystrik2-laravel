<?php

namespace App\Http\Controllers;

use App\Models\Penggunaan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PenggunaanController extends Controller
{
    /**
     * Menampilkan daftar semua data penggunaan.
     */
    public function index()
    {
        // Mengambil semua data penggunaan beserta data pelanggan terkait
        $penggunaans = Penggunaan::with('pelanggan')->latest()->paginate(10);
        return view('penggunaan.index', compact('penggunaans'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all(); // Data untuk dropdown pilih pelanggan
        return view('penggunaan.create', compact('pelanggans'));
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|numeric|digits:4',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gt:meter_awal', // Pastikan meter akhir > meter awal
        ]);

        Penggunaan::create($request->all());

        return redirect()->route('penggunaan.index')
                         ->with('success', 'Data penggunaan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu data penggunaan.
     */
    public function show(Penggunaan $penggunaan)
    {
        return view('penggunaan.show', compact('penggunaan'));
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(Penggunaan $penggunaan)
    {
        $pelanggans = Pelanggan::all();
        return view('penggunaan.edit', compact('penggunaan', 'pelanggans'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, Penggunaan $penggunaan)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|numeric|digits:4',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gt:meter_awal',
        ]);

        $penggunaan->update($request->all());

        return redirect()->route('penggunaan.index')
                         ->with('success', 'Data penggunaan berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(Penggunaan $penggunaan)
    {
        $penggunaan->delete();

        return redirect()->route('penggunaan.index')
                         ->with('success', 'Data penggunaan berhasil dihapus.');
    }
}