<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#8C6239] leading-tight font-['Playfair_Display']">
                {{ __('Manajemen Menu Cafe') }}
            </h2>
            <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center bg-[#8C6239] hover:bg-[#6d4c2d] text-white font-black py-2.5 px-5 rounded-xl shadow-sm transition-all duration-200 active:scale-95 text-xs uppercase tracking-widest">
                <i class="fa-solid fa-plus mr-2 text-sm"></i> Tambah Menu
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
                <div class="p-0 text-gray-900">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 uppercase text-[10px] font-black tracking-[0.15em]">
                                    <th class="px-6 py-5 text-left rounded-tl-2xl">Visual</th>
                                    <th class="px-6 py-5 text-left">Informasi Menu</th>
                                    <th class="px-6 py-5 text-left">Kategori</th>
                                    <th class="px-6 py-5 text-left">Harga Satuan</th>
                                    <th class="px-6 py-5 text-left">Status</th>
                                    <th class="px-6 py-5 text-center rounded-tr-2xl">Manajemen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($menus as $menu)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        {{-- GAMBAR --}}
                                        <td class="px-6 py-4">
                                            @if($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" class="h-16 w-16 object-cover rounded-2xl shadow-sm ring-2 ring-gray-100 group-hover:ring-[#8C6239]/20 transition-all">
                                            @else
                                                <div class="h-16 w-16 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-300">
                                                    <i class="fa-solid fa-image text-xl"></i>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-black text-gray-800">{{ $menu->name }}</div>
                                            <div class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">ID: #MNU-{{ $menu->id }}</div>
                                        </td>

                                        {{-- KATEGORI --}}
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-[9px] font-black rounded-lg bg-blue-50 text-blue-600 uppercase tracking-widest border border-blue-100">
                                                {{ $menu->category }}
                                            </span>
                                        </td>

                                        {{-- HARGA --}}
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-bold text-gray-700">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                        </td>
                                        
                                        {{-- STATUS --}}
                                        <td class="px-6 py-4">
                                            @if($menu->is_available)
                                                <span class="inline-flex items-center text-[10px] font-black text-green-600 uppercase tracking-tighter">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                                    Tersedia
                                                </span>
                                            @else
                                                <span class="inline-flex items-center text-[10px] font-black text-red-400 uppercase tracking-tighter">
                                                    <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                                    Habis
                                                </span>
                                            @endif
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center items-center gap-3">
                                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-indigo-500 hover:text-indigo-700 p-2 hover:bg-indigo-50 rounded-xl transition-all">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-xl transition-all">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center">
                                                <i class="fa-solid fa-utensils text-5xl text-gray-100 mb-4"></i>
                                                <p class="text-gray-400 text-xs font-black uppercase tracking-[0.2em]">Belum ada data menu.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-6 border-t border-gray-50">
                        {{ $menus->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>