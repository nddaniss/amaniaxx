<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon; 

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Antrian (Hanya Pending) untuk tabel atas
        $pendingTransactions = Transaction::with('user')
                                ->where('status', 'pending')
                                ->orderBy('created_at', 'asc')
                                ->paginate(10, ['*'], 'pending_page'); 

        // 2. Tambahan: Ambil Seluruh Riwayat Pelanggan untuk tabel bawah
        $allTransactions = Transaction::with('user')
                                ->orderBy('created_at', 'desc')
                                ->paginate(10, ['*'], 'history_page');

        // 3. Hitung Statistik Hari Ini (Status 'paid')
        $todayIncome = Transaction::where('status', 'paid')
                                ->whereDate('created_at', Carbon::today())
                                ->sum('final_price');

        $completedCount = Transaction::where('status', 'paid')
                                ->whereDate('created_at', Carbon::today())
                                ->count();

        // Kirim semua variabel ke View
        return view('kasir.dashboard', compact(
            'pendingTransactions', 
            'allTransactions', 
            'todayIncome', 
            'completedCount'
        ));
    }
}