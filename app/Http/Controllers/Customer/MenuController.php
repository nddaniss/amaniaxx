<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();

        // LOGIC FILTER KATEGORI
        // Jika ada request 'category', kita filter. Jika tidak, tampilkan semua.
        if ($request->has('category') && $request->category != null) {
            $query->where('category', $request->category);
        }

        // TETAP PAKAI PAGINATE (Supaya tidak error 'links does not exist')
        $menus = $query->latest()->paginate(9);

        // Kita kirim data menus ke view
        return view('customer.menus.index', compact('menus'));
    }
}