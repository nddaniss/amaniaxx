<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // 2. Ambil Diskon dari Session (Sinkron dengan CartController)
        $discount = 0;
        if(session()->has('voucher')) {
            $discount = session()->get('voucher')['discount'];
        }

        // 3. Hitung Harga Akhir
        $finalPrice = max($total - $discount, 0);

        // 4. Buat Transaksi (Data masuk ke kolom yang sudah kamu buat di migrasi)
        $trx = Transaction::create([
            'user_id' => Auth::id(),
            'transaction_code' => 'TRX-' . time() . rand(100, 999),
            'total_price' => $total,          // Harga asli
            'discount_amount' => $discount,   // Diskon dari session
            'final_price' => $total - $discount,     // Harga bayar
            'status' => 'pending' 
        ]);

        foreach($cart as $id => $details) {
            TransactionDetail::create([
                'transaction_id' => $trx->id,
                'menu_id' => $id,
                'quantity' => $details['quantity'],
                'price_per_item' => $details['price']
            ]);
        }

        // 5. Bersihkan Session (Penting: hapus juga session voucher)
        session()->forget(['cart', 'voucher']);

        return redirect()->route('customer.history')->with('success', 'Pesanan berhasil dibuat! Silakan bayar di kasir.');
    }

    public function downloadStruk($id)
    {
        $trx = Transaction::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->with('details.menu')
                            ->firstOrFail();
        
        $pdf = Pdf::loadView('customer.orders.struk', compact('trx'));
        return $pdf->download('struk-'.$trx->transaction_code.'.pdf');
    }
}