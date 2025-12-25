<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth; // Perbaikan: Tambahkan ini agar Auth::id() dikenali

class CartController extends Controller
{
    // Halaman lihat isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart.index', compact('cart'));
    }

    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // Fungsi Update: Klaim Voucher dengan validasi "Sekali Pakai"
    public function applyVoucher(Request $request)
    {
        $voucher = Voucher::where('code', $request->voucher_code)
                          ->where('status', 'active') 
                          ->first();

        // 1. Validasi jika voucher tidak ditemukan
        if (!$voucher) {
            return redirect()->back()->with('error', 'Waduh, kode vouchernya salah atau sudah tidak aktif!');
        }

        // 2. Validasi "Sekali Pakai"
        // Perbaikan: Gunakan Auth::id() yang lebih stabil
        $sudahPakai = DB::table('voucher_usages')
            ->where('user_id', Auth::id()) 
            ->where('voucher_id', $voucher->id)
            ->exists();

        if ($sudahPakai) {
            return redirect()->back()->with('error', 'Maaf ya, voucher ini hanya bisa digunakan satu kali per pelanggan.');
        }

        // 3. Simpan ke session
        session()->put('voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'discount' => $voucher->discount_amount
        ]);

        return redirect()->back()->with('success', 'Voucher ' . $voucher->code . ' berhasil dipasang! Hemat Rp ' . number_format($voucher->discount_amount, 0, ',', '.'));
    }

    // Fungsi: Hapus Voucher dari session
    public function removeVoucher()
    {
        session()->forget('voucher');
        return redirect()->back()->with('success', 'Voucher telah dilepas.');
    }

    public function destroy($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        if(empty($cart)) {
            session()->forget('voucher');
        }

        return redirect()->back()->with('success', 'Menu dihapus dari keranjang');
    }
}