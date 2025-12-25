<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white/90 backdrop-blur-sm overflow-hidden shadow-xl rounded-3xl border border-white/20">
                <div class="p-6">
                    
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-separate border-spacing-y-2">
                                <thead class="text-[#8C6239] uppercase text-xs font-black tracking-widest">
                                    <tr>
                                        <th class="px-6 py-4">Waktu Pesan</th>
                                        <th class="px-6 py-4">Kode Transaksi</th>
                                        <th class="px-6 py-4 text-center">Total Bayar</th>
                                        <th class="px-6 py-4 text-center">Status</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-pink-50">
                                    @foreach($orders as $order)
                                    <tr class="hover:bg-pink-50/50 transition-all duration-300">
                                        {{-- KOLOM WAKTU --}}
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-800 font-bold">
                                                {{ $order->created_at->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="text-[10px] text-pink-500 font-black uppercase tracking-tighter">
                                                Pukul {{ $order->created_at->translatedFormat('H:i') }} WITA
                                            </div>
                                        </td>

                                        {{-- KOLOM KODE --}}
                                        <td class="px-6 py-4 font-mono font-bold text-gray-600">
                                            {{ $order->transaction_code }}
                                        </td>

                                        {{-- KOLOM HARGA --}}
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-black text-[#e75480] text-lg">
                                                Rp {{ number_format($order->final_price, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        {{-- KOLOM STATUS --}}
                                        <td class="px-6 py-4 text-center">
                                            @if($order->status == 'paid')
                                                <span class="bg-green-100 text-green-700 text-[10px] font-black px-4 py-1.5 rounded-full shadow-sm tracking-widest uppercase">
                                                    <i class="fa-solid fa-check mr-1"></i> Lunas
                                                </span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-700 text-[10px] font-black px-4 py-1.5 rounded-full shadow-sm tracking-widest uppercase animate-pulse">
                                                    <i class="fa-solid fa-clock mr-1"></i> Menunggu
                                                </span>
                                            @endif
                                        </td>

                                        {{-- KOLOM AKSI --}}
                                        <td class="px-6 py-4 text-center">
                                            @if($order->status == 'paid')
                                                <a href="{{ route('customer.struk', $order->id) }}" target="_blank" class="inline-flex items-center bg-[#8C6239] text-white hover:bg-[#6d4c2d] px-4 py-2 rounded-xl text-xs font-bold transition-all active:scale-95 shadow-md">
                                                    <i class="fa-solid fa-file-invoice mr-2"></i> Struk
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-[10px] font-bold italic">
                                                    Bayar di Kasir
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6 px-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        {{-- EMPTY STATE --}}
                        <div class="text-center py-20">
                            <div class="relative inline-block mb-6">
                                <i class="fa-solid fa-box-open text-8xl text-pink-100"></i>
                                <i class="fa-solid fa-heart absolute -top-2 -right-2 text-2xl text-[#e75480] animate-ping"></i>
                            </div>
                            <h3 class="text-[#8C6239] font-['Playfair_Display'] text-2xl font-bold">Belum ada pesanan</h3>
                            <p class="text-gray-400 mt-2 mb-8 uppercase text-xs font-bold tracking-widest">Ayo buat kenangan manis pertamamu!</p>
                            <a href="{{ route('customer.menus.index') }}" class="inline-flex items-center bg-[#8C6239] text-white px-8 py-3 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-[#6d4c2d] transition-all shadow-lg active:scale-95">
                                Pesan Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>