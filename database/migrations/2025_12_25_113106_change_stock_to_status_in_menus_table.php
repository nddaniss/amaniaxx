<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up()
{
    Schema::table('menus', function (Blueprint $table) {
        // Hapus kolom stock yang tadi
        $table->dropColumn('stock'); 
        // Tambah kolom is_available (Default: true/tersedia)
        $table->boolean('is_available')->default(true)->after('price'); 
    });
}

public function down()
{
    Schema::table('menus', function (Blueprint $table) {
        $table->dropColumn('is_available');
        $table->integer('stock')->default(0);
    });
}
};
