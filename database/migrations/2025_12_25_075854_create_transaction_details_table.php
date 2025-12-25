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
    Schema::create('transaction_details', function (Blueprint $table) {
        $table->id();
        
        // Terhubung ke Transaksi
        $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
        
        // Terhubung ke Menu
        $table->foreignId('menu_id')->constrained('menus');
        
        $table->integer('quantity'); // Jumlah beli per menu
        $table->integer('price_per_item'); // Harga menu saat transaksi terjadi
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
