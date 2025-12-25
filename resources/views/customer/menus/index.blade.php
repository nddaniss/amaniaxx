<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
            {{ __('Daftar Menu') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F7C8E0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- FILTER KATEGORI (Style Update) --}}
            <div class="flex justify-center flex-wrap gap-3 mb-10">
                @php
                    $categories = [
                        null => 'Semua',
                        'food' => 'Makanan',
                        'drink' => 'Minuman',
                        'snack' => 'Snack',
                        'dessert' => 'Dessert'
                    ];
                @endphp

                @foreach($categories as $key => $label)
                    <a href="{{ route('customer.menus.index', $key ? ['category' => $key] : []) }}" 
                       class="px-6 py-2 rounded-full font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-sm
                       {{ request('category') == $key ? 'bg-[#8C6239] text-white scale-105 shadow-md' : 'bg-white/80 text-[#8C6239] hover:bg-[#8C6239] hover:text-white' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- GRID MENU --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($menus as $menu)
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 flex flex-col h-full group border border-white/20">
                        
                        {{-- GAMBAR --}}
                        <div class="relative h-52 w-full overflow-hidden">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-pink-100 flex flex-col items-center justify-center text-pink-300">
                                    <i class="fa-solid fa-utensils text-4xl mb-2"></i>
                                    <span class="text-xs font-bold uppercase">No Photo</span>
                                </div>
                            @endif

                            {{-- Badge Kategori --}}
                            <div class="absolute top-3 right-3">
                                <span class="bg-white/90 text-[#8C6239] text-[10px] font-black px-3 py-1 rounded-full shadow-sm uppercase tracking-tighter">
                                    {{ $menu->category }}
                                </span>
                            </div>
                        </div>

                        {{-- KONTEN --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-[#e75480] transition-colors leading-tight">
                                    {{ $menu->name }}
                                </h3>
                                <p class="text-gray-500 text-xs line-clamp-2 mb-4 italic leading-relaxed">
                                    {{ $menu->description }}
                                </p>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="flex justify-between items-end mb-4">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-gray-400 font-bold uppercase">Harga</span>
                                        <span class="text-xl font-black text-[#e75480]">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    
                                    @if($menu->is_available)
                                        <span class="text-[9px] text-green-600 font-black bg-green-100 px-2 py-1 rounded-lg uppercase tracking-widest">Ready</span>
                                    @else
                                        <span class="text-[9px] text-red-600 font-black bg-red-100 px-2 py-1 rounded-lg uppercase tracking-widest">Habis</span>
                                    @endif
                                </div>

                                {{-- TOMBOL PESAN --}}
                                @if($menu->is_available)
                                    <form action="{{ route('customer.cart.add', $menu->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-[#8C6239] hover:bg-[#6d4c2d] text-white font-black py-3 px-4 rounded-2xl transition-all duration-300 flex justify-center items-center gap-2 shadow-md active:scale-95 text-xs uppercase tracking-widest">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            <span>Tambah</span>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-200 text-gray-400 font-black py-3 px-4 rounded-2xl cursor-not-allowed text-xs uppercase tracking-widest">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <i class="fa-solid fa-mug-hot text-8xl text-white/50 mb-4"></i>
                        <p class="text-[#8C6239] font-['Playfair_Display'] text-2xl font-bold">Oops! Menu belum tersedia.</p>
                        <p class="text-gray-500 mt-2">Coba pilih kategori lain yang tersedia di atas.</p>
                    </div>
                @endforelse
            </div>
            
            {{-- Pagination --}}
            <div class="mt-12">
                {{-- $menus->appends(request()->query())->links() --}}
            </div>
        </div>
    </div>
</x-app-layout>