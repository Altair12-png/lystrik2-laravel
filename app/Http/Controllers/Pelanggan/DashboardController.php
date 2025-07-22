<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk mendapatkan data user yang login
use App\Models\Tagihan;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk pelanggan.
     *
     * Halaman ini akan berisi daftar tagihan milik pelanggan yang sedang login.
     */
    public function index()
    {
        // 1. Dapatkan ID pelanggan yang sedang login
        $id_pelanggan = Auth::user()->id_pelanggan;

        // 2. Ambil semua data tagihan yang sesuai dengan ID pelanggan tersebut
        // Urutkan dari yang terbaru (latest)
        $tagihans = Tagihan::where('id_pelanggan', $id_pelanggan)
                            ->latest()
                            ->paginate(10); // Gunakan paginate untuk data yang banyak

        // 3. Kirim data tagihan ke view
        return view('pelanggan.dashboard', compact('tagihans'));
    }
}