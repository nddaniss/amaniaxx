<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest; // Kita pakai validasi bawaan Breeze biar aman
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * 1. Halaman Login Customer (Tema: Pink/Ceria)
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * 2. Halaman Login Staff (Tema: Formal/Gelap)
     */
    public function staffLogin(): View
    {
        return view('auth.staff-login');
    }

    /**
     * 3. Proses Login (POST)
     * Menangani autentikasi untuk Customer maupun Staff
     */
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        // Validasi & Cek Kredensial (Username/Password)
        $request->authenticate();

        // Buat ulang session ID (keamanan)
        $request->session()->regenerate();

        // LOGIC REDIRECT BERDASARKAN ROLE
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } 
        elseif ($role === 'kasir') {
            return redirect()->intended(route('kasir.dashboard'));
        } 
        
        // Default: Customer masuk ke Menu
        return redirect()->intended(route('customer.dashboard'));
    }

    /**
     * 4. Proses Logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Kembali ke home/login
    }
}