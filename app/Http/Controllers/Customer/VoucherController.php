<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index()
    {
        // Mengambil semua voucher yang aktif
        $vouchers = Voucher::where('status', 'active')->get();
        
        return view('customer.vouchers.index', compact('vouchers'));
    }
}