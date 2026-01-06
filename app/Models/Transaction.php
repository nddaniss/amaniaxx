<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_code',
        'voucher_id',
        'total_price',
        'discount_amount',
        'final_price',
        'status',
        'cash_received',
        'cash_change',
    ];

    // Relasi: Transaksi ini milik siapa? (User/Customer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi ini isinya menu apa aja?
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}