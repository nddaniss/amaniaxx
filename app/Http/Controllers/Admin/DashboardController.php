<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction; 
use App\Models\Menu;        
use App\Models\User;        
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_income = Transaction::where('status', 'paid')->sum('final_price');
        $total_transactions = Transaction::where('status', 'paid')->count();
        $total_menus = Menu::count();
        $total_customers = User::where('role', 'customer')->count();

        // TAMBAHKAN INI: Ambil 10 transaksi terbaru untuk ditampilkan di tabel
        $recent_transactions = Transaction::with('user')
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();

        return view('admin.dashboard', compact(
            'total_income', 
            'total_transactions', 
            'total_menus', 
            'total_customers',
            'recent_transactions' // Kirim ke view
        ));
    }
}