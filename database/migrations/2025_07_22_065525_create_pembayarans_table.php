<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran'); // Primary key
            $table->unsignedBigInteger('id_tagihan'); // Foreign key
            $table->unsignedBigInteger('id_pelanggan'); // Foreign key
            $table->date('tanggal_pembayaran');
            $table->string('bulan_bayar');
            $table->decimal('biaya_admin', 10, 2);
            $table->decimal('total_bayar', 10, 2);
            $table->unsignedBigInteger('id_user'); // Foreign key
            $table->timestamps();

            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihans');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans');
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};