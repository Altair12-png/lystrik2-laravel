<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Untuk menyimpan file
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class PembayaranController extends Controller
{
    /**
     * Menampilkan daftar riwayat pembayaran pelanggan.
     */
    public function index()
    {
        $idPelanggan = Auth::guard('pelanggan')->user()->id_pelanggan;
        $pembayarans = Pembayaran::with('tagihan')
                                ->where('id_pelanggan', $idPelanggan)
                                ->latest()
                                ->paginate(10);

        return view('pelanggan.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Menampilkan form untuk melakukan pembayaran tagihan tertentu.
     */
    public function create(Tagihan $tagihan)
    {
        // Pastikan tagihan ini milik pelanggan yang sedang login dan statusnya 'Belum Bayar'
        $idPelanggan = Auth::guard('pelanggan')->user()->id_pelanggan;

        if ($tagihan->id_pelanggan !== $idPelanggan || $tagihan->status !== 'Belum Bayar') {
            return redirect()->route('pelanggan.tagihan.index')->with('error', 'Tagihan tidak valid atau sudah dibayar.');
        }

        return view('pelanggan.pembayaran.create', compact('tagihan'));
    }

    /**
     * Menyimpan data pembayaran dan bukti transfer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tagihan' => 'required|exists:tagihans,id_tagihan',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi file gambar
        ]);

        $idPelanggan = Auth::guard('pelanggan')->user()->id_pelanggan;
        $tagihan = Tagihan::find($request->id_tagihan);

        // Pastikan tagihan ini milik pelanggan yang sedang login dan statusnya 'Belum Bayar'
        if (!$tagihan || $tagihan->id_pelanggan !== $idPelanggan || $tagihan->status !== 'Belum Bayar') {
            return redirect()->back()->with('error', 'Tagihan tidak valid atau sudah dibayar.');
        }

        DB::beginTransaction();

        try {
            // Upload bukti pembayaran
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            Pembayaran::create([
                'id_tagihan' => $tagihan->id_tagihan,
                'id_pelanggan' => $idPelanggan,
                'tanggal_pembayaran' => now(), // Waktu pembayaran saat ini
                'bulan_bayar' => $tagihan->bulan,
                'tahun_bayar' => $tagihan->tahun,
                'biaya_admin' => 2500, // Contoh biaya admin
                'total_bayar' => $tagihan->total_bayar + 2500, // Total bayar + biaya admin
                'bukti_pembayaran' => $path, // Simpan path file
                'status' => 'Menunggu Konfirmasi', // Status awal setelah pembayaran
            ]);

            // Perbarui status tagihan menjadi 'Menunggu Konfirmasi'
            $tagihan->update(['status' => 'Menunggu Konfirmasi']);

            DB::commit();

            return redirect()->route('pelanggan.tagihan.index')
                             ->with('success', 'Pembayaran berhasil dikirim. Menunggu konfirmasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file yang mungkin sudah terupload jika terjadi error lain
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    // Metode show, edit, update, destroy tidak diperlukan untuk pembayaran pelanggan
    // karena pembayaran biasanya hanya dibuat dan dikonfirmasi oleh admin.
    // Jika ada kebutuhan untuk melihat detail pembayaran, Anda bisa menambahkan metode show.
    public function show(Pembayaran $pembayaran)
    {
        // Pastikan pembayaran ini milik pelanggan yang sedang login
        $idPelanggan = Auth::guard('pelanggan')->user()->id_pelanggan;
        if ($pembayaran->id_pelanggan !== $idPelanggan) {
            return redirect()->route('pelanggan.pembayaran.index')->with('error', 'Anda tidak memiliki akses ke pembayaran ini.');
        }
        return view('pelanggan.pembayaran.show', compact('pembayaran'));
    }
}
