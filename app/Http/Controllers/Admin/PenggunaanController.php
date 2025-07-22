<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Gunakan untuk transaksi database

class PenggunaanController extends Controller
{
    /**
     * Menampilkan daftar semua penggunaan dan tagihan.
     */
    public function index()
    {
        // Mengambil data penggunaan dengan relasi pelanggan dan tagihan, kemudian diurutkan dan dipaginasi
        $penggunaans = Penggunaan::with('pelanggan', 'tagihan')->latest()->paginate(10);
        return view('admin.penggunaan.index', compact('penggunaans'));
    }

    /**
     * Menampilkan form untuk menambahkan data penggunaan baru.
     */
    public function create()
    {
        // Mengambil semua data pelanggan untuk dropdown pilihan di form
        $pelanggans = Pelanggan::all();
        return view('admin.penggunaan.create', compact('pelanggans'));
    }

    /**
     * Menyimpan data penggunaan baru dan secara otomatis membuat tagihan terkait.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|string|max:4',
            'meter_awal' => 'required|numeric|min:0',
            'meter_akhir' => 'required|numeric|min:' . $request->meter_awal, // Meter akhir harus lebih besar atau sama dengan meter awal
        ]);

        // Cek apakah sudah ada catatan penggunaan untuk pelanggan di bulan dan tahun yang sama
        $existingPenggunaan = Penggunaan::where('id_pelanggan', $request->id_pelanggan)
                                        ->where('bulan', $request->bulan)
                                        ->where('tahun', $request->tahun)
                                        ->first();

        if ($existingPenggunaan) {
            return redirect()->back()->with('error', 'Penggunaan untuk pelanggan ini di bulan ' . $request->bulan . ' tahun ' . $request->tahun . ' sudah ada.');
        }

        // Memulai transaksi database untuk memastikan kedua operasi (penggunaan & tagihan) berhasil atau gagal bersama
        DB::beginTransaction();

        try {
            // 1. Buat catatan penggunaan baru
            $penggunaan = Penggunaan::create([
                'id_pelanggan' => $request->id_pelanggan,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
            ]);

            // Hitung jumlah meter yang digunakan
            $jumlahMeter = $penggunaan->meter_akhir - $penggunaan->meter_awal;

            // Ambil data pelanggan beserta informasi tarifnya
            $pelanggan = Pelanggan::with('tarif')->find($request->id_pelanggan);
            $tarifPerKwh = $pelanggan->tarif->tarifperkwh;
            $totalBayar = $jumlahMeter * $tarifPerKwh; // Hitung total yang harus dibayar

            // 2. Buat catatan tagihan terkait
            Tagihan::create([
                'id_penggunaan' => $penggunaan->id_penggunaan,
                'id_pelanggan' => $request->id_pelanggan,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'jumlah_meter' => $jumlahMeter,
                'status' => 'Belum Bayar', // Status awal tagihan
                'total_bayar' => $totalBayar, // Mengisi kolom total_bayar di tabel tagihans
            ]);

            // Commit transaksi jika kedua operasi berhasil
            DB::commit();

            return redirect()->route('admin.penggunaan.index')
                             ->with('success', 'Data penggunaan dan tagihan berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan penggunaan dan tagihan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengedit data penggunaan tertentu.
     */
    public function edit(Penggunaan $penggunaan)
    {
        // Mengambil semua data pelanggan untuk dropdown pilihan di form
        $pelanggans = Pelanggan::all();
        return view('admin.penggunaan.edit', compact('penggunaan', 'pelanggans'));
    }

    /**
     * Memperbarui data penggunaan dan tagihan terkait.
     */
    public function update(Request $request, Penggunaan $penggunaan)
    {
        // Validasi input dari form
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|string|max:4',
            'meter_awal' => 'required|numeric|min:0',
            'meter_akhir' => 'required|numeric|min:' . $request->meter_awal,
        ]);

        // Cek apakah ada penggunaan lain untuk pelanggan di bulan dan tahun yang sama,
        // kecuali penggunaan yang sedang diedit
        $existingPenggunaan = Penggunaan::where('id_pelanggan', $request->id_pelanggan)
                                        ->where('bulan', $request->bulan)
                                        ->where('tahun', $request->tahun)
                                        ->where('id_penggunaan', '!=', $penggunaan->id_penggunaan)
                                        ->first();

        if ($existingPenggunaan) {
            return redirect()->back()->with('error', 'Penggunaan untuk pelanggan ini di bulan ' . $request->bulan . ' tahun ' . $request->tahun . ' sudah ada.');
        }

        DB::beginTransaction();

        try {
            // 1. Perbarui catatan penggunaan
            $penggunaan->update([
                'id_pelanggan' => $request->id_pelanggan,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
            ]);

            // Hitung ulang jumlah meter yang digunakan
            $jumlahMeter = $penggunaan->meter_akhir - $penggunaan->meter_awal;

            // Ambil data pelanggan beserta informasi tarifnya
            $pelanggan = Pelanggan::with('tarif')->find($request->id_pelanggan);
            $tarifPerKwh = $pelanggan->tarif->tarifperkwh;
            $totalBayar = $jumlahMeter * $tarifPerKwh; // Hitung ulang total yang harus dibayar

            // 2. Perbarui catatan tagihan terkait (jika ada)
            // Pastikan tagihan terkait ada sebelum mencoba memperbaruinya
            if ($penggunaan->tagihan) {
                $penggunaan->tagihan->update([
                    'id_pelanggan' => $request->id_pelanggan, // Perbarui juga id_pelanggan di tagihan jika berubah
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'jumlah_meter' => $jumlahMeter,
                    'total_bayar' => $totalBayar,
                ]);
            } else {
                // Jika tagihan belum ada (kasus jarang, tapi untuk jaga-jaga)
                Tagihan::create([
                    'id_penggunaan' => $penggunaan->id_penggunaan,
                    'id_pelanggan' => $request->id_pelanggan,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'jumlah_meter' => $jumlahMeter,
                    'status' => 'Belum Bayar', // Status awal, bisa disesuaikan
                    'total_bayar' => $totalBayar,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.penggunaan.index')
                             ->with('success', 'Data penggunaan dan tagihan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui penggunaan dan tagihan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data penggunaan dan tagihan terkait.
     */
    public function destroy(Penggunaan $penggunaan)
    {
        DB::beginTransaction();

        try {
            // Hapus tagihan terkait terlebih dahulu untuk menghindari masalah foreign key
            if ($penggunaan->tagihan) {
                $penggunaan->tagihan->delete();
            }

            // Kemudian hapus penggunaan
            $penggunaan->delete();

            DB::commit();

            return redirect()->route('admin.penggunaan.index')
                             ->with('success', 'Data penggunaan dan tagihan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus penggunaan dan tagihan: ' . $e->getMessage());
        }
    }
}
