<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Menampilkan daftar semua pembayaran yang perlu diverifikasi.
     */
    public function index()
    {
        // Mengambil pembayaran dengan status 'Menunggu Konfirmasi' atau 'Lunas'
        // dan memuat relasi tagihan serta pelanggan
        $pembayarans = Pembayaran::with('tagihan.pelanggan')
                                ->orderBy('status', 'asc') // Menunggu Konfirmasi di atas
                                ->latest()
                                ->paginate(10);

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Menampilkan detail pembayaran untuk verifikasi.
     */
    public function show(Pembayaran $pembayaran)
    {
        // Memuat relasi tagihan dan pelanggan untuk detail
        $pembayaran->load('tagihan.pelanggan');
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Memperbarui status pembayaran dan tagihan terkait.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:Lunas,Ditolak', // Admin bisa mengubah ke Lunas atau Ditolak
        ]);

        DB::beginTransaction();

        try {
            // Perbarui status pembayaran
            $pembayaran->update([
                'status' => $request->status,
            ]);

            // Perbarui status tagihan terkait
            $tagihan = $pembayaran->tagihan;
            if ($tagihan) {
                $tagihan->update([
                    'status' => $request->status, // Status tagihan mengikuti status pembayaran
                ]);
            }

            DB::commit();

            return redirect()->route('admin.pembayaran.index')
                             ->with('success', 'Status pembayaran dan tagihan berhasil diperbarui menjadi ' . $request->status . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus catatan pembayaran (opsional, mungkin hanya jika status Ditolak).
     */
    public function destroy(Pembayaran $pembayaran)
    {
        DB::beginTransaction();
        try {
            // Hapus bukti pembayaran dari storage jika ada
            if ($pembayaran->bukti_pembayaran && Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
                Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
            }

            // Hapus pembayaran
            $pembayaran->delete();

            DB::commit();
            return redirect()->route('admin.pembayaran.index')
                             ->with('success', 'Pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pembayaran: ' . $e->getMessage());
        }
    }
}
