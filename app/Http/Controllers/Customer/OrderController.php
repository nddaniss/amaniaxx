<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('customer.history', compact('transactions'));
    }

    public function checkout(Request $request)
    {
        $cart = session('cart');

        if(!$cart || count($cart) <= 0) {
            return redirect()->route('customer.menus.index')->with('error', 'Keranjang belanja kosong!');
        }

        // 1. Hitung Total Item
        $total = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // 2. Cek Voucher dari Session
        $discount = 0;
        $voucherId = null;

        if(session()->has('voucher')) {
            $voucherData = session()->get('voucher');
            $discount = $voucherData['amount']; 
            $voucherId = $voucherData['id'];

            // VALIDASI: Cek double usage
            $sudahPakai = Transaction::where('user_id', Auth::id())
                            ->where('voucher_id', $voucherId)
                            ->where('status', '!=', 'cancelled')
                            ->exists();
            
            if ($sudahPakai) {
                session()->forget('voucher');
                return back()->with('error', 'Voucher tidak valid atau sudah digunakan.');
            }
        }

        // 3. Simpan Transaksi
        $trx = Transaction::create([
            'user_id' => Auth::id(),
            'transaction_code' => 'TRX-' . time() . rand(100, 999),
            'voucher_id' => $voucherId,
            'total_price' => $total,      
            'discount_amount' => $discount, 
            'final_price' => max($total - $discount, 0),
            'status' => 'pending', // <--- SUDAH DIGANTI JADI PENDING (AMAN)
            'cash_received' => 0,
            'cash_change' => 0
        ]);

        // 4. Simpan Detail Item
        foreach($cart as $id => $details) {
            TransactionDetail::create([
                'transaction_id' => $trx->id,
                'menu_id' => $id,
                'quantity' => $details['quantity'],
                'price_per_item' => $details['price'] // Menggunakan harga saat checkout
            ]);
        }

        // 5. Bersihkan Session
        session()->forget(['cart', 'voucher']);

        return redirect()->route('customer.history')->with('success', 'Pesanan berhasil dibuat! Silakan bayar di kasir.');
    }
    // Fungsi Download Struk (Versi HTML View)
    public function downloadStruk($id)
    {
        // Gunakan with(['details.menu']) agar nama menu & harga terbaca di struk
        $transaction = Transaction::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->with(['details.menu']) 
                        ->firstOrFail();
        
        // Return view HTML agar bisa langsung diprint browser (sesuai kode struk tadi)
        // Pastikan file struk ada di resources/views/customer/transaksi/struk.blade.php
        return view('customer.orders.struk', compact('transaction'));
    }
}