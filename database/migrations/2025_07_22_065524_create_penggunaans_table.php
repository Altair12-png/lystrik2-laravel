<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggunaans', function (Blueprint $table) {
            $table->id('id_penggunaan'); // Primary key
            $table->unsignedBigInteger('id_pelanggan'); // Foreign key
            $table->string('bulan');
            $table->string('tahun');
            $table->float('meter_awal');
            $table->float('meter_akhir');
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggunaans');
    }
};