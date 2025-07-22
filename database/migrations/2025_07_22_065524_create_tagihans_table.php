<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id('id_tagihan'); // Primary key
            $table->unsignedBigInteger('id_penggunaan'); // Foreign key
            $table->unsignedBigInteger('id_pelanggan'); // Foreign key
            $table->string('bulan');
            $table->string('tahun');
            $table->float('jumlah_meter');
            $table->decimal('total_bayar', 10, 2)->nullable(); // <== BARIS INI YANG HARUS DITAMBAHKAN
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_penggunaan')->references('id_penggunaan')->on('penggunaans');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
