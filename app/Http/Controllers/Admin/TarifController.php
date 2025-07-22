<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif; // <-- Import model Tarif
use Illuminate\Http\Request;

class TarifController extends Controller
{
    /**
     * Menampilkan daftar semua tarif.
     */
    public function index()
    {
        $tarifs = Tarif::latest()->paginate(10);
        return view('admin.tarif.index', compact('tarifs'));
    }

    /**
     * Menampilkan form untuk membuat tarif baru.
     */
    public function create()
    {
        return view('admin.tarif.create');
    }

    /**
     * Menyimpan tarif baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'daya' => 'required|string|max:255|unique:tarifs',
            'tarifperkwh' => 'required|numeric|min:0',
        ]);

        // Buat data tarif baru
        Tarif::create($request->all());

        return redirect()->route('admin.tarif.index')
                         ->with('success', 'Tarif berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit tarif.
     */
    public function edit(Tarif $tarif)
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    /**
     * Memperbarui data tarif di database.
     */
    public function update(Request $request, Tarif $tarif)
    {
        // Validasi input
        $request->validate([
            'daya' => 'required|string|max:255|unique:tarifs,daya,' . $tarif->id_tarif . ',id_tarif',
            'tarifperkwh' => 'required|numeric|min:0',
        ]);

        // Update data tarif
        $tarif->update($request->all());

        return redirect()->route('admin.tarif.index')
                         ->with('success', 'Data tarif berhasil diperbarui.');
    }

    /**
     * Menghapus tarif dari database.
     */
    public function destroy(Tarif $tarif)
    {
        // Cek jika tarif masih digunakan oleh pelanggan
        if ($tarif->pelanggans()->exists()) {
            return redirect()->route('admin.tarif.index')
                             ->with('error', 'Tarif tidak dapat dihapus karena masih digunakan oleh pelanggan.');
        }

        $tarif->delete();

        return redirect()->route('admin.tarif.index')
                         ->with('success', 'Tarif berhasil dihapus.');
    }
}