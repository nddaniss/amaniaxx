<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
                {{ __('Manajemen Voucher Promo') }}
            </h2>
            <a href="{{ route('admin.vouchers.create') }}" class="inline-flex items-center bg-[#8C6239] hover:bg-[#6d4c2d] text-white font-black py-2.5 px-5 rounded-xl shadow-sm transition-all duration-200 active:scale-95 text-xs uppercase tracking-widest">
                <i class="fa-solid fa-ticket mr-2"></i> Tambah Voucher
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-2xl shadow-sm mb-6 flex items-center" role="alert">
                    <i class="fa-solid fa-circle-check mr-3 text-xl"></i>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-0">
                    
                    @if($vouchers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-separate border-spacing-0">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-400 uppercase text-[10px] font-black tracking-[0.15em]">
                                        <th class="px-6 py-5 text-left rounded-tl-2xl">Kode Kupon</th>
                                        <th class="px-6 py-5 text-left">Nilai Potongan</th>
                                        <th class="px-6 py-5 text-center">Status</th>
                                        <th class="px-6 py-5 text-center rounded-tr-2xl">Opsi Manajemen</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($vouchers as $voucher)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        {{-- KODE VOUCHER --}}
                                        <td class="px-6 py-5">
                                            <div class="inline-block bg-indigo-50 border-2 border-dashed border-indigo-200 px-4 py-1.5 rounded-lg">
                                                <span class="font-mono font-black text-indigo-600 tracking-wider text-sm">
                                                    {{ $voucher->code }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- POTONGAN --}}
                                        <td class="px-6 py-5">
                                            <div class="text-sm font-black text-gray-800">
                                                Rp {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Potongan Langsung</div>
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black tracking-widest bg-green-100 text-green-700 uppercase">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                                Aktif
                                            </span>
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-5 text-center">
                                            <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini? Pelanggan tidak akan bisa menggunakannya lagi.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center text-red-400 hover:text-red-600 font-black text-[10px] uppercase tracking-widest transition-all p-2 hover:bg-red-50 rounded-xl">
                                                    <i class="fa-solid fa-trash-can mr-1.5 text-xs"></i> Nonaktifkan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- EMPTY STATE --}}
                        <div class="text-center py-20">
                            <div class="relative inline-block mb-4">
                                <i class="fa-solid fa-ticket text-7xl text-gray-100"></i>
                                <i class="fa-solid fa-xmark absolute -bottom-1 -right-1 text-2xl text-red-200"></i>
                            </div>
                            <h3 class="text-gray-400 text-xs font-black uppercase tracking-[0.2em]">Belum ada voucher tersedia</h3>
                            <p class="text-gray-300 text-[10px] mt-1 italic">Klik tombol "Tambah Voucher" untuk memulai promo baru.</p>
                        </div>
                    @endif

                </div>
            </div>
            
            <p class="mt-6 text-center text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">
                Amaniax Admin System
            </p>
        </div>
    </div>
</x-app-layout>