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
    Schema::create('vouchers', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Kode unik, misal "DISKON10"
        $table->integer('discount_amount'); // Nominal diskon
        $table->boolean('is_active')->default(true); // Status aktif/tidak
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
