<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT VOUCHER --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-2xl shadow-sm mb-6 flex items-center animate-pulse" role="alert">
                    <i class="fa-solid fa-circle-check mr-3"></i>
                    <span class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl shadow-sm mb-6 flex items-center" role="alert">
                    <i class="fa-solid fa-circle-xmark mr-3"></i>
                    <span class="text-xs font-black uppercase tracking-widest">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-xl rounded-3xl border border-white/20">
                <div class="p-8">
                    @if(count($cart) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-separate border-spacing-y-3">
                                <thead class="text-[#8C6239] uppercase text-xs font-black tracking-widest">
                                    <tr>
                                        <th class="px-6 py-2">Menu</th>
                                        <th class="px-6 py-2">Harga</th>
                                        <th class="px-6 py-2 text-center">Jumlah</th>
                                        <th class="px-6 py-2">Subtotal</th>
                                        <th class="px-6 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-pink-50">
                                    @php $total = 0; @endphp
                                    @foreach($cart as $id => $details)
                                        @php $total += $details['price'] * $details['quantity']; @endphp
                                        <tr class="bg-white/50 hover:bg-pink-50/50 transition-colors duration-300">
                                            <td class="px-6 py-4 font-bold text-gray-800">{{ $details['name'] }}</td>
                                            <td class="px-6 py-4 text-gray-600 font-medium">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center font-black text-[#8C6239]">{{ $details['quantity'] }}x</td>
                                            <td class="px-6 py-4 font-black text-[#e75480]">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('customer.cart.remove', $id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-colors p-2 hover:bg-red-50 rounded-full">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- SEKSI VOUCHER --}}
                        <div class="mt-8 bg-white p-6 rounded-2xl border-2 border-dashed border-pink-200">
                            <h4 class="text-[10px] font-black text-[#8C6239] uppercase tracking-[0.2em] mb-3">Gunakan Kode Promo</h4>
                            
                            <div class="flex flex-col sm:flex-row gap-3">
                                <form action="{{ route('customer.cart.apply_voucher') }}" method="POST" class="flex-1 flex gap-3">
                                    @csrf
                                    <input type="text" name="voucher_code" placeholder="Ketik kode voucher di sini..." 
                                        class="flex-1 bg-pink-50/50 border-pink-100 rounded-xl text-sm focus:ring-[#e75480] focus:border-[#e75480] placeholder-pink-300 font-bold"
                                        {{ session('voucher') ? 'readonly' : '' }} value="{{ session('voucher')['code'] ?? '' }}">
                                    
                                    @if(!session('voucher'))
                                        <button type="submit" class="bg-[#e75480] text-white px-8 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#c93d66] transition-all shadow-md shadow-pink-200">
                                            Terapkan
                                        </button>
                                    @endif
                                </form>

                                @if(session('voucher'))
                                    <form action="{{ route('customer.cart.remove_voucher') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-400 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-red-500 transition-all w-full sm:w-auto">
                                            Hapus Voucher
                                        </button>
                                    </form>
                                @endif
                            </div>

                            @if(session('voucher'))
                                <p class="mt-2 text-[10px] font-bold text-green-600 uppercase tracking-widest">
                                    <i class="fa-solid fa-check-double mr-1"></i> Voucher "{{ session('voucher')['code'] }}" Berhasil Dipasang!
                                </p>
                            @endif
                        </div>

                        {{-- TOTAL & CHECKOUT --}}
                        <div class="mt-6 flex flex-col md:flex-row justify-between items-center bg-pink-50/50 p-6 rounded-2xl border border-pink-100">
                            <div class="mb-4 md:mb-0 text-center md:text-left">
                                @if(session('voucher'))
                                    <p class="text-[10px] text-gray-400 line-through font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                                    <p class="text-[10px] text-green-600 font-black uppercase tracking-widest">Diskon: - Rp {{ number_format(session('voucher')['discount'], 0, ',', '.') }}</p>
                                    <h3 class="text-3xl font-black text-[#e75480]">
                                        Rp {{ number_format($total - session('voucher')['discount'], 0, ',', '.') }}
                                    </h3>
                                @else
                                    <p class="text-[10px] text-[#8C6239] font-black uppercase tracking-widest">Total Bayar</p>
                                    <h3 class="text-3xl font-black text-[#e75480]">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </h3>
                                @endif
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                                <a href="{{ route('customer.menus.index') }}" class="text-center px-6 py-3 rounded-2xl text-[#8C6239] font-black text-xs uppercase tracking-widest hover:bg-white transition-all">
                                    <i class="fa-solid fa-plus mr-2"></i>Tambah Menu
                                </a>
                                
                                <form action="{{ route('customer.checkout') }}" method="POST" class="w-full">
                                    @csrf
                                    {{-- Kirim kode voucher yang aktif ke controller checkout --}}
                                    @if(session('voucher'))
                                        <input type="hidden" name="voucher_code" value="{{ session('voucher')['code'] }}">
                                    @endif
                                    
                                    <button type="submit" class="w-full bg-[#8C6239] hover:bg-[#6d4c2d] text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-coklat/20 transition-all active:scale-95 flex justify-center items-center gap-2">
                                        <i class="fa-solid fa-bag-shopping"></i>
                                        Checkout Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- EMPTY STATE (Sama seperti sebelumnya) --}}
                        <div class="text-center py-20">
                            <div class="relative inline-block mb-6">
                                <i class="fa-solid fa-cart-shopping text-8xl text-pink-100"></i>
                                <i class="fa-solid fa-question absolute bottom-0 right-0 text-3xl text-[#e75480] animate-bounce"></i>
                            </div>
                            <h3 class="text-[#8C6239] font-['Playfair_Display'] text-2xl font-bold">Keranjangmu Kosong</h3>
                            <p class="text-gray-400 mt-2 mb-8 uppercase text-xs font-bold tracking-widest">Sepertinya kamu belum memilih menu hari ini</p>
                            <a href="{{ route('customer.menus.index') }}" class="inline-flex items-center bg-[#8C6239] text-white px-8 py-3 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-[#6d4c2d] transition-all shadow-lg">
                                Lihat Menu <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>