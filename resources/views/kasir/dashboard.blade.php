<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Dashboard Kasir') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-md border-l-8 border-[#8C6239]">
                    <p class="text-sm text-gray-500 uppercase font-bold">Pemasukan Hari Ini</p>
                    <p class="text-3xl font-black text-[#8C6239]">Rp {{ number_format($todayIncome) }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md border-l-8 border-[#e75480]">
                    <p class="text-sm text-gray-500 uppercase font-bold">Transaksi Selesai</p>
                    <p class="text-3xl font-black text-[#e75480]">{{ $completedCount }} Pesanan</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl rounded-2xl mb-10">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-[#8C6239] mb-4 flex items-center">
                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> Daftar Antrian Pesanan
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-pink-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-[#8C6239] uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-[#8C6239] uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-[#8C6239] uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-[#8C6239] uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendingTransactions as $trx)
                                <tr class="hover:bg-pink-50/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-mono text-sm">{{ $trx->transaction_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-700">{{ $trx->user->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase">
                                            Masuk: {{ $trx->created_at->translatedFormat('H:i') }} WITA
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-[#e75480]">Rp {{ number_format($trx->final_price) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('kasir.transaksi.show', $trx->id) }}" class="bg-[#8C6239] text-white px-4 py-2 rounded-lg hover:bg-[#6d4c2d] transition shadow-md inline-block">
                                            Proses Bayar
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Tidak ada antrian pesanan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $pendingTransactions->links() }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-[#8C6239] mb-4 flex items-center">
                        <i class="fa-solid fa-history mr-2"></i> Riwayat Semua Pelanggan
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Struk</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($allTransactions as $trx)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $trx->transaction_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-800">{{ $trx->user->name }}</div>
                                        <div class="text-[10px] text-gray-500 italic">
                                             {{ $trx->created_at->translatedFormat('d M, H:i') }} WITA
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs">
                                        <span class="px-2 py-1 rounded-full {{ $trx->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ strtoupper($trx->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($trx->status == 'paid')
                                            <a href="{{ route('kasir.struk', $trx->id) }}" target="_blank" class="text-[#8C6239] hover:text-[#e75480] font-bold text-sm underline">
                                                Lihat Struk
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $allTransactions->appends(['pending_page' => $pendingTransactions->currentPage()])->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>