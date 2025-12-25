<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu; // Pastikan Model Menu di-import

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 3 menu secara acak yang statusnya tersedia (is_available = true)
        // Kita ambil 3 agar pas dengan layout 3 kolom di dashboard
        $favorites = Menu::where('is_available', true)
                        ->inRandomOrder()
                        ->limit(3)
                        ->get();

        // Kembalikan ke view customer/dashboard.blade.php
        return view('customer.dashboard', compact('favorites'));
    }
}