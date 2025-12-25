<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Menampilkan daftar voucher
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    // Menampilkan FORM tambah voucher (INI YANG TADI HILANG)
    public function create()
    {
        return view('admin.vouchers.create');
    }

    // Menyimpan voucher baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'discount_amount' => 'required|numeric',
        ]);

        Voucher::create($request->all());

        // Ubah return back() jadi redirect ke index agar setelah simpan kembali ke list
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dibuat');
    }

    // Menghapus voucher
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return back()->with('success', 'Voucher dihapus');
    }
}