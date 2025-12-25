<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- IMPORT CONTROLLER ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MenuController as AdminMenu;
use App\Http\Controllers\Admin\VoucherController as AdminVoucher;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\Kasir\TransactionController as KasirTransaction;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\MenuController as CustomerMenu;
use App\Http\Controllers\Customer\VoucherController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HOMEPAGE REDIRECT
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        // Gunakan redirect ke rute dashboard masing-masing role agar aman
        return redirect()->route($role . '.dashboard');
    }
    return view('welcome');
})->name('homepage');

// 2. DASHBOARD REDIRECTOR (Mencegah Error 404/403 saat akses /dashboard)
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    return redirect()->route($role . '.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {

    // --- ADMIN ROUTES ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('menus', AdminMenu::class);
        Route::resource('vouchers', AdminVoucher::class);
        // Tambahkan ini agar Admin bisa melihat struk dari dashboard admin
        Route::get('/struk/{id}', [KasirTransaction::class, 'downloadStruk'])->name('struk');
    });

    // --- KASIR ROUTES ---
    Route::middleware('role:kasir')->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [KasirDashboard::class, 'index'])->name('dashboard');
        Route::get('/transaksi/{id}', [KasirTransaction::class, 'show'])->name('transaksi.show');
        Route::post('/transaksi/{id}/pay', [KasirTransaction::class, 'markAsPaid'])->name('transaksi.pay');
        Route::get('/struk/{id}', [KasirTransaction::class, 'downloadStruk'])->name('struk');
    });

    
    // --- CUSTOMER ROUTES ---
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
        Route::get('/menus', [CustomerMenu::class, 'index'])->name('menus.index');
    
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    
    // --- FITUR VOUCHER BARU ---
    Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.apply_voucher');
    Route::post('/cart/remove-voucher', [CartController::class, 'removeVoucher'])->name('cart.remove_voucher');
    // --------------------------

    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/riwayat', [OrderController::class, 'index'])->name('history');
    Route::get('/riwayat/struk/{id}', [OrderController::class, 'downloadStruk'])->name('struk');
    Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers.index');
});

    // --- PROFILE MANAGEMENT ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';