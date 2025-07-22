<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('total_bayar');
            $table->string('status')->default('Menunggu Konfirmasi')->after('bukti_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('bukti_pembayaran');
            $table->dropColumn('status');
        });
    }
};