<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel users (Customer)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->string('transaction_code')->unique(); // Kode TRX-12345
        $table->integer('total_price'); // Total harga kasar
        $table->integer('discount_amount')->default(0); // Potongan voucher
        $table->integer('final_price'); // Total yang harus dibayar
        
        // Status pembayaran
        $table->enum('status', ['pending', 'paid'])->default('pending');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
