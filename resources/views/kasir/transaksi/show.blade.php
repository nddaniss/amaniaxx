<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Proses Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Detail Pesanan: {{ $transaction->transaction_code }}</h3>
                    <p class="text-sm text-gray-500 mb-4">Customer: <span class="font-bold text-gray-800">{{ $transaction->user->name ?? 'Umum' }}</span></p>

                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 font-bold uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2">Menu</th>
                                <th class="px-4 py-2 text-center">Qty</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transaction->details as $detail)
                            <tr>
                                <td class="px-4 py-3">{{ $detail->menu->name }}</td>
                                <td class="px-4 py-3 text-center">{{ $detail->quantity }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($detail->price_per_item * $detail->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- RINCIAN PEMBAYARAN & VOUCHER --}}
                    <div class="mt-6 border-t pt-4 space-y-2">
                        <div class="flex justify-between items-center text-sm text-gray-600 font-medium">
                            <span>Subtotal Harga</span>
                            <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($transaction->discount_amount > 0)
                        <div class="flex justify-between items-center text-sm text-green-600 font-bold italic">
                            <span>Potongan Voucher</span>
                            <span>- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between items-center pt-2 border-t-2 border-dashed border-pink-100">
                            <span class="text-lg font-black text-[#8C6239] uppercase tracking-tighter">Total Tagihan</span>
                            <span class="text-3xl font-black text-[#e75480]">Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 h-fit">
                    <h3 class="text-lg font-bold text-[#8C6239] mb-4">
                        {{ $transaction->status == 'pending' ? 'Input Pembayaran' : 'Status Transaksi' }}
                    </h3>
                    
                    @if($transaction->status == 'pending')
                        <form action="{{ route('kasir.transaksi.pay', $transaction->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Harus Dibayar</label>
                                <input type="text" value="Rp {{ number_format($transaction->final_price, 0, ',', '.') }}" class="w-full bg-gray-50 text-gray-800 border-none rounded-xl py-4 px-4 font-black text-2xl leading-tight focus:outline-none" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[#8C6239] text-sm font-bold mb-2 uppercase tracking-wide">Uang Tunai Diterima (Rp)</label>
                                <input type="number" name="cash_received" id="cash_received" min="{{ $transaction->final_price }}" class="w-full border-2 border-[#8C6239] rounded-xl py-4 px-4 text-gray-700 leading-tight focus:outline-none focus:border-pink-500 font-black text-2xl shadow-inner" placeholder="0" required autofocus>
                            </div>

                            <div class="mb-6 bg-pink-50/50 p-5 rounded-2xl border border-pink-100">
                                <label class="block text-[#8C6239] text-[10px] font-black uppercase tracking-widest mb-1">Kembalian</label>
                                <span id="change_display" class="text-4xl font-black text-gray-800">Rp 0</span>
                            </div>

                            <button type="submit" id="btn-pay" class="w-full bg-[#8C6239] hover:bg-[#6d4c2d] text-white font-black py-5 px-4 rounded-2xl shadow-lg transition duration-300 transform hover:-translate-y-1 opacity-50 cursor-not-allowed uppercase tracking-widest text-sm" disabled>
                                <i class="fa-solid fa-cash-register mr-2"></i> Konfirmasi Pembayaran
                            </button>
                        </form>
                    @else
                        {{-- STATUS LUNAS --}}
                        <div class="text-center py-6">
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-500 rounded-full mb-4">
                                    <i class="fa-solid fa-check text-4xl"></i>
                                </div>
                                <h4 class="text-2xl font-black text-green-600 uppercase tracking-tighter">Pembayaran Lunas</h4>
                            </div>
                            
                            <div class="space-y-3">
                                <a href="{{ route('kasir.struk', $transaction->id) }}" target="_blank" class="flex items-center justify-center w-full bg-gray-800 hover:bg-gray-700 text-white font-black py-4 px-4 rounded-2xl shadow-lg transition-all">
                                    <i class="fa-solid fa-print mr-3"></i> CETAK STRUK
                                </a>
                                <a href="{{ route('kasir.dashboard') }}" class="flex items-center justify-center w-full bg-white border-2 border-gray-200 text-gray-500 font-black py-4 px-4 rounded-2xl hover:bg-gray-50 transition-all">
                                    KEMBALI KE DASHBOARD
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const totalAmount = Number("{{ $transaction->final_price }}");
        const cashInput = document.getElementById('cash_received');
        const changeDisplay = document.getElementById('change_display');
        const btnPay = document.getElementById('btn-pay');

        if(cashInput) {
            cashInput.addEventListener('input', function() {
                const cash = parseFloat(this.value) || 0;
                const change = cash - totalAmount;

                if(change >= 0) {
                    changeDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);
                    changeDisplay.classList.remove('text-red-500');
                    changeDisplay.classList.add('text-gray-800');
                    
                    btnPay.disabled = false;
                    btnPay.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    changeDisplay.textContent = 'Uang Kurang!';
                    changeDisplay.classList.add('text-red-500');
                    changeDisplay.classList.remove('text-gray-800');
                    
                    btnPay.disabled = true;
                    btnPay.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        }
    </script>
</x-app-layout>