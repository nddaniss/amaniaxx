<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> {{-- Lebarkan dikit jadi max-w-4xl --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                {{-- Error Message (Opsional: Buat jaga-jaga kalau ada validasi gagal) --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama Menu --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Menu</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800" required placeholder="Contoh: Nasi Goreng Spesial">
                    </div>

                    {{-- Grid 3 Kolom: Kategori, Harga, Stok --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        
                        {{-- Kategori --}}
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                            <select name="category" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800">
                                <option value="food">Makanan (Food)</option>
                                <option value="drink">Minuman (Drink)</option>
                                <option value="snack">Camilan (Snack)</option>
                                <option value="dessert">Pencuci Mulut (Dessert)</option>
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                            <input type="number" name="price" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800" required placeholder="15000">
                        </div>

                        {{-- Stok (INI YANG DITAMBAHKAN) --}}
                        {{-- Status Ketersediaan --}}
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status Menu</label>
                            <select name="is_available" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800">
                                <option value="1">Tersedia (Ready)</option>
                                <option value="0">Habis (Sold Out)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800" rows="3" placeholder="Jelaskan detail menu..."></textarea>
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Foto Menu</label>
                        <input type="file" name="image" class="w-full text-sm text-gray-500 
                            file:mr-4 file:py-2 file:px-4 
                            file:rounded-full file:border-0 
                            file:text-sm file:font-semibold 
                            file:bg-gray-100 file:text-gray-700 
                            hover:file:bg-gray-200" required>
                        <p class="text-xs text-gray-500 mt-1">*Format: JPG, PNG. Maks 2MB.</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.menus.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Batal</a>
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 transition">Simpan Menu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>