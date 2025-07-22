<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('id_pelanggan'); // Primary key
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nomor_kwh');
            $table->string('nama_pelanggan');
            $table->text('alamat');
            $table->unsignedBigInteger('id_tarif'); // Foreign key
            $table->timestamps();

            $table->foreign('id_tarif')->references('id_tarif')->on('tarifs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};