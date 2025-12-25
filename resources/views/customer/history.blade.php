<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Riwayat Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-2xl mb-6 text-center font-bold shadow-sm border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white/90 overflow-hidden shadow-sm rounded-3xl backdrop-blur-sm">
                <div class="p-8">
                    @if($transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-pink-50 text-[#8C6239] uppercase text-[10px] font-black tracking-widest">
                                    <tr>
                                        <th class="px-6 py-5">Kode Transaksi</th>
                                        <th class="px-6 py-5">Waktu Pesanan</th>
                                        <th class="px-6 py-5">Rincian Pembayaran</th>
                                        <th class="px-6 py-5">Status</th>
                                        <th class="px-6 py-5 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($transactions as $trx)
                                    <tr class="hover:bg-white transition group">
                                        <td class="px-6 py-6">
                                            <span class="font-black text-gray-800 tracking-tighter group-hover:text-pink-600 transition">{{ $trx->transaction_code }}</span>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="text-sm text-gray-800 font-bold">
                                                {{ $trx->created_at->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="text-[10px] text-pink-500 font-black uppercase tracking-wider">
                                                Pukul {{ $trx->created_at->translatedFormat('H:i') }} WITA
                                            </div>
                                        </td>
                                        <td class="px-6 py-6">
                                            {{-- Logika Tampilan Voucher --}}
                                            @if($trx->discount_amount > 0)
                                                <div class="text-[10px] text-gray-400 line-through font-bold">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</div>
                                            @endif
                                            
                                            <div class="font-black text-[#e75480] text-lg">Rp {{ number_format($trx->final_price, 0, ',', '.') }}</div>
                                            
                                            @if($trx->discount_amount > 0)
                                                <div class="inline-flex items-center text-[9px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black mt-1 uppercase tracking-tighter">
                                                    <i class="fa-solid fa-tag mr-1"></i> Hemat Rp {{ number_format($trx->discount_amount, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-6">
                                            @if($trx->status == 'paid')
                                                <span class="bg-green-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full shadow-sm shadow-green-200 uppercase">
                                                    <i class="fa-solid fa-check-circle mr-1"></i> Lunas
                                                </span>
                                            @else
                                                <span class="bg-yellow-400 text-white text-[10px] font-black px-4 py-1.5 rounded-full animate-pulse shadow-sm shadow-yellow-100 uppercase">
                                                    <i class="fa-solid fa-clock mr-1"></i> Menunggu Kasir
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            @if($trx->status == 'paid')
                                                <a href="{{ route('customer.struk', $trx->id) }}" class="inline-flex items-center text-[#8C6239] border-2 border-[#8C6239] hover:bg-[#8C6239] hover:text-white px-4 py-2 rounded-xl text-xs font-black transition-all duration-300 hover:shadow-lg active:scale-95">
                                                    <i class="fa-solid fa-file-invoice-dollar mr-2 text-sm"></i> STRUK PDF
                                                </a>
                                            @else
                                                <div class="flex flex-col items-center">
                                                    <span class="text-[10px] text-gray-400 italic font-bold">Segera ke kasir</span>
                                                    <span class="text-[9px] text-[#8C6239] font-black uppercase mt-1">Sebutkan Kode Transaksi</span>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination --}}
                        <div class="mt-8">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="bg-pink-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-receipt text-5xl text-pink-200"></i>
                            </div>
                            <h3 class="text-lg font-black text-gray-700">Belum ada riwayat transaksi</h3>
                            <p class="text-gray-400 text-sm mt-1">Ayo mulai pesan menu favoritmu sekarang!</p>
                            <a href="{{ route('customer.menus.index') }}" class="inline-block mt-6 bg-[#8C6239] text-white px-8 py-3 rounded-2xl font-black text-sm hover:bg-[#6d4c2d] transition shadow-lg">
                                LIHAT MENU
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>