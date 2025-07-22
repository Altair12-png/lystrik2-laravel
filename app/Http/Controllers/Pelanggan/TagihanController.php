<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index()
    {
        $idPelanggan = Auth::guard('pelanggan')->user()->id_pelanggan;

        $tagihans = Tagihan::where('id_pelanggan', $idPelanggan)
                            ->orderBy('tahun', 'desc')
                            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember') DESC")
                            ->paginate(10);

        // --- TAMBAHKAN BARIS DEBUGGING INI ---
        // dd($tagihans->toArray());
        // --- HAPUS BARIS INI SETELAH DEBUGGING SELESAI ---

        return view('pelanggan.tagihan.index', compact('tagihans'));
    }
}