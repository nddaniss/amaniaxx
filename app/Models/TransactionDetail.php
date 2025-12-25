<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'menu_id',
        'quantity',
        'price_per_item',
    ];

    // Relasi: Detail ini merujuk ke menu apa?
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    
    // Relasi: Detail ini punya transaksi yang mana?
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}