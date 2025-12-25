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

    // 2. Proses Pembayaran (Update jadi PAID)
    public function markAsPaid(Request $request, $id)
    {
        $request->validate([
            'cash_received' => 'required|numeric',
        ]);

        $transaction = Transaction::findOrFail($id);

        if ($request->cash_received < $transaction->final_price) {
            return back()->with('error', 'Uang tunai kurang!');
        }

        // Update Status
        $transaction->update([
            'status' => 'paid',
            // Jika di database ada kolom 'payment_method' atau 'cash_received', bisa simpan disini
            // 'payment_method' => 'cash'
        ]);

        // Kita simpan info kembalian di session flash untuk ditampilkan sekali saja
        $kembalian = $request->cash_received - $transaction->final_price;

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