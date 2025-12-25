<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Beranda') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- WELCOME BANNER --}}
            <div class="bg-gradient-to-r from-[#8C6239] to-[#a07040] rounded-3xl p-8 mb-8 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2 font-['Playfair_Display']">
                        Halo, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="text-white/90 text-lg mb-6 max-w-xl">
                        Sudah siap memanjakan lidahmu hari ini? Ada menu spesial yang menunggu.
                    </p>
                    <a href="{{ route('customer.menus.index') }}" class="inline-block bg-white text-[#8C6239] font-bold py-3 px-8 rounded-full shadow-md hover:bg-gray-100 transition transform hover:scale-105">
                        Lihat Menu Sekarang &rarr;
                    </a>
                </div>
                
                {{-- Decorative Icon Background --}}
                <div class="absolute right-0 bottom-0 opacity-20 transform translate-x-10 translate-y-10">
                    <i class="fa-solid fa-utensils text-9xl"></i>
                </div>
            </div>

            {{-- GRID MENU UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- CARD 1: BELANJA --}}
                <a href="{{ route('customer.menus.index') }}" class="group block">
                    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border-b-4 border-transparent hover:border-[#8C6239]">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-100 rounded-full text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition">
                                <i class="fa-solid fa-burger text-2xl"></i>
                            </div>
                            <span class="text-gray-400 text-sm">Belanja</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Daftar Menu</h3>
                        <p class="text-gray-500 text-sm">Pilih makanan & minuman favoritmu.</p>
                    </div>
                </a>

                {{-- CARD 2: KERANJANG --}}
                {{-- Saya pasang '#' dulu jika route cart belum dibuat agar tidak error --}}
                <a href="#" class="group block">
                    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border-b-4 border-transparent hover:border-pink-500">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-pink-100 rounded-full text-pink-600 group-hover:bg-pink-500 group-hover:text-white transition">
                                <i class="fa-solid fa-cart-shopping text-2xl"></i>
                            </div>
                            <span class="text-gray-400 text-sm">Pesanan</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Keranjang</h3>
                        <p class="text-gray-500 text-sm">
                            @if(session('cart'))
                                {{ count(session('cart')) }} item menunggu dibayar.
                            @else
                                Keranjang masih kosong.
                            @endif
                        </p>
                    </div>
                </a>

                {{-- CARD 3: RIWAYAT --}}
                <a href="#" class="group block"> 
                    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border-b-4 border-transparent hover:border-blue-500">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-100 rounded-full text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition">
                                <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                            </div>
                            <span class="text-gray-400 text-sm">Arsip</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Riwayat</h3>
                        <p class="text-gray-500 text-sm">Lihat pesananmu sebelumnya.</p>
                    </div>
                </a>

            </div>

            {{-- PROMO BANNER --}}
            <div class="mt-8 bg-white/60 rounded-xl p-4 flex items-center justify-center text-gray-600 text-sm">
                <i class="fa-solid fa-gift mr-2 text-pink-500"></i>
                <span>Gunakan kode <strong>JAGONYACAFE</strong> untuk potongan harga Rp20.000 hari ini!</span>
            </div>

        </div>
    </div>
</x-app-layout>