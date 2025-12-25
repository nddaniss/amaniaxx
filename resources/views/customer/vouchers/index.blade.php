<x-app-layout>
    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-['Playfair_Display'] text-3xl font-black text-[#8C6239] mb-8">Promo Spesial Untukmu</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($vouchers as $v)
                @php
                    $isUsed = DB::table('voucher_usages')
                                ->where('user_id', auth()->id())
                                ->where('voucher_id', $v->id)
                                ->exists();
                @endphp

                <div class="bg-white rounded-3xl overflow-hidden shadow-xl border-2 {{ $isUsed ? 'border-gray-200 grayscale' : 'border-pink-200' }} relative">
                    {{-- Guntingan Tiket (Style) --}}
                    <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-[#F7C8E0] rounded-full"></div>
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-[#F7C8E0] rounded-full"></div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="bg-pink-100 text-pink-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
                                    {{ $v->category ?? 'All Menu' }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-800 mt-2">Potongan Rp {{ number_format($v->discount_amount) }}</h3>
                            </div>
                            <i class="fa-solid fa-ticket text-3xl text-pink-200"></i>
                        </div>

                        <div class="bg-dashed border-t-2 border-dashed border-pink-100 my-4"></div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Kode Promo</p>
                                <p class="text-lg font-black text-[#8C6239] tracking-widest">{{ $v->code }}</p>
                            </div>
                            
                            @if($isUsed)
                                <span class="bg-gray-100 text-gray-400 px-4 py-2 rounded-xl text-xs font-bold uppercase">Sudah Digunakan</span>
                            @else
                                <button onclick="copyToClipboard('{{ $v->code }}')" class="bg-[#e75480] hover:bg-[#8C6239] text-white px-4 py-2 rounded-xl text-xs font-bold transition-all active:scale-95">
                                    SALIN KODE
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            alert("Kode voucher " + text + " berhasil disalin! Gunakan di keranjang belanja.");
        }
    </script>
</x-app-layout>