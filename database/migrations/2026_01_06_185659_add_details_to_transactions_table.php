<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('transactions', function (Blueprint $table) {
        // Kolom untuk pembayaran (biar struk gak nol)
        $table->decimal('cash_received', 12, 2)->nullable()->after('final_price');
        $table->decimal('cash_change', 12, 2)->nullable()->after('cash_received');
        
        // Kolom untuk fitur Voucher Sekali Pakai (menyimpan voucher apa yang dipakai)
        $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->onDelete('set null')->after('user_id');
    });
}

public function down()
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropForeign(['voucher_id']);
        $table->dropColumn(['voucher_id', 'cash_received', 'cash_change']);
    });
}
};
