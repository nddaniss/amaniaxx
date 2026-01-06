<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Tambahkan 'is_available' ke dalam array ini
    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'image',
        'is_available', // <-- WAJIB ADA agar status bisa tersimpan ke database
    ];

    // Opsional: Memastikan data is_available dibaca sebagai boolean (true/false)
    protected $casts = [
        'is_available' => 'boolean',
    ];
}