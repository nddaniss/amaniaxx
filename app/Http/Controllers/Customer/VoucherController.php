<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Transaction; // <-- WAJIB IMPORT MODEL TRANSACTION
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    // 1. Menampilkan daftar voucher
    public function index()
    {
        $vouchers = Voucher::where('status', 'active')->get();
        return view('customer.vouchers.index', compact('vouchers'));
    }

    // 2. LOGIKA PENGECEKAN & PASANG VOUCHER (Tambahan Baru)
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        // Cari voucher berdasarkan kode
        $voucher = Voucher::where('code', $request->code)
                          ->where('status', 'active')
                          ->first();

        // Cek 1: Apakah voucher ada?
        if (!$voucher) {
            return back()->with('error', 'Kode voucher tidak valid atau sudah tidak aktif.');
        }

        // Cek 2: APAKAH USER SUDAH PERNAH PAKAI VOUCHER INI? (Logika 1 Akun = 1x Pakai)
        $sudahPakai = Transaction::where('user_id', Auth::id())
                        ->where('voucher_id', $voucher->id)
                        ->where('status', '!=', 'cancelled') // Transaksi batal tidak dihitung
                        ->exists();

        if ($sudahPakai) {
            return back()->with('error', 'Maaf, Voucher ini hanya berlaku untuk 1x pemakaian per akun.');
        }

        // Cek 3: (Opsional) Apakah ada minimal pembelian?
        $cartTotal = $this->getCartTotal(); // Fungsi bantuan di bawah
        if ($cartTotal < $voucher->min_purchase) {
             return back()->with('error', 'Minimal pembelian untuk voucher ini adalah Rp ' . number_format($voucher->min_purchase));
        }

        // Jika lolos semua cek, Simpan Voucher ke Session
        session()->put('voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'amount' => $voucher->discount_amount, // Pastikan nama kolom diskon di db sesuai
            'type' => 'fixed', // atau percentage
        ]);

        return back()->with('success', 'Voucher berhasil digunakan! Potongan Rp ' . number_format($voucher->discount_amount));
    }

    // Fungsi Pembantu: Menghitung total keranjang saat ini (Simulasi)
    private function getCartTotal()
    {
        // Sesuaikan dengan logic keranjang kamu.
        // Biasanya diambil dari session cart atau database cart
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}