<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // 1. Tampilkan detail pesanan untuk dibayar
    public function show($id)
    {
        $transaction = Transaction::with(['details.menu', 'user'])->findOrFail($id);
        return view('kasir.transaksi.show', compact('transaction'));
    }

    // 2. Proses Pembayaran (Update jadi PAID & Simpan Data Uang)
    public function markAsPaid(Request $request, $id)
    {
        $request->validate([
            'cash_received' => 'required|numeric',
        ]);

        $transaction = Transaction::findOrFail($id);

        // Cek apakah uang tunai kurang dari total tagihan
        if ($request->cash_received < $transaction->final_price) {
            return back()->with('error', 'Uang tunai kurang!');
        }

        // Hitung Kembalian
        $kembalian = $request->cash_received - $transaction->final_price;

        // UPDATE STATUS & SIMPAN DATA PEMBAYARAN
        // Ini kuncinya agar di struk tidak muncul 0
        $transaction->update([
            'status' => 'paid',
            'cash_received' => $request->cash_received, // Simpan Nominal Bayar
            'cash_change' => $kembalian,                // Simpan Nominal Kembalian
        ]);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('kasir.dashboard')
            ->with('success', 'Pembayaran Berhasil! Kembalian: Rp ' . number_format($kembalian));
    }

    // 3. Tampilan Cetak Struk
    public function downloadStruk($id)
    {
        $transaction = Transaction::with(['details.menu', 'user'])->findOrFail($id);
        
        // Pastikan hanya yang sudah bayar bisa cetak struk
        if($transaction->status !== 'paid') {
            return back()->with('error', 'Transaksi belum dibayar!');
        }

        return view('kasir.struk', compact('transaction'));
    }
}