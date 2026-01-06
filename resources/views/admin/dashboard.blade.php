<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- WELCOME CARD --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-8 border border-gray-100">
                <div class="p-8 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 font-['Playfair_Display']">Selamat Datang, Admin!</h3>
                        <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan performa <span class="text-[#8C6239] font-bold">Amaniax Cafe</span>.</p>
                    </div>
                    <div class="hidden md:block">
                        <i class="fa-solid fa-chart-line text-4xl text-gray-100"></i>
                    </div>
                </div>
            </div>

            {{-- STATS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 border-l-4 border-indigo-500 transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Total Pendapatan</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">Rp {{ number_format($total_income) }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 border-l-4 border-blue-500 transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Total Transaksi</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">{{ $total_transactions }} <span class="text-xs font-bold text-gray-400 uppercase">Order</span></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 border-l-4 border-green-500 transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Koleksi Menu</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">{{ $total_menus }} <span class="text-xs font-bold text-gray-400 uppercase">Item</span></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 border-l-4 border-yellow-500 transition-all hover:shadow-lg hover:-translate-y-1">
                    <div class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Total Pelanggan</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">{{ $total_customers }} <span class="text-xs font-bold text-gray-400 uppercase">User</span></div>
                </div>
            </div>

            {{-- RECENT TRANSACTIONS TABLE --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Pesanan Terbaru</h3>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest italic">*10 Transaksi Terakhir</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 text-gray-400 uppercase text-[10px] font-black tracking-widest">
                            <tr>
                                <th class="px-6 py-4">Kode</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recent_transactions as $trx)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono text-sm font-bold text-gray-500">{{ $trx->transaction_code }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800">{{ $trx->user->name ?? 'Guest' }}</div>
                                    <div class="text-[10px] text-indigo-500 font-bold">
                                        {{ $trx->created_at->translatedFormat('d M Y, H:i') }} WITA
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black tracking-[0.15em] uppercase {{ $trx->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $trx->status == 'paid' ? 'LUNAS' : 'PENDING' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.struk', $trx->id) }}" target="_blank" class="inline-flex items-center text-[#8C6239] hover:text-[#6d4c2d] font-black text-[10px] uppercase tracking-widest transition-colors">
                                        <i class="fa-solid fa-receipt mr-1.5"></i> Lihat Struk
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-inbox text-4xl text-gray-100 mb-2"></i>
                                        <p class="text-gray-400 text-xs italic font-bold uppercase tracking-widest">Belum ada transaksi masuk.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>