<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar saya tambah sedikit jadi max-w-4xl agar muat 3 kolom --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Menu --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Menu</label>
                        <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    {{-- GRID 3 KOLOM: Kategori, Harga, Status --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        
                        {{-- Kategori --}}
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                            <select name="category" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="food" {{ $menu->category == 'food' ? 'selected' : '' }}>Makanan</option>
                                <option value="drink" {{ $menu->category == 'drink' ? 'selected' : '' }}>Minuman</option>
                                <option value="snack" {{ $menu->category == 'snack' ? 'selected' : '' }}>Snack</option>
                                <option value="dessert" {{ $menu->category == 'dessert' ? 'selected' : '' }}>Dessert</option>
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $menu->price) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        {{-- STATUS MENU (INI YANG BARU) --}}
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status Menu</label>
                            <select name="is_available" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="1" {{ $menu->is_available == 1 ? 'selected' : '' }}>Tersedia (Ready)</option>
                                <option value="0" {{ $menu->is_available == 0 ? 'selected' : '' }}>Habis (Sold Out)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="3">{{ old('description', $menu->description) }}</textarea>
                    </div>

                    {{-- Foto Lama --}}
                    @if($menu->image)
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $menu->image) }}" class="h-24 w-24 rounded object-cover border p-1 bg-gray-50">
                    </div>
                    @endif

                    {{-- Ganti Foto --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.menus.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>