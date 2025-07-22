<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id('id_tagihan'); // Primary key
            $table->unsignedBigInteger('id_penggunaan'); // Foreign key
            $table->unsignedBigInteger('id_pelanggan'); // Foreign key
            $table->string('bulan');
            $table->string('tahun');
            $table->float('jumlah_meter');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_penggunaan')->references('id_penggunaan')->on('penggunaans');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};