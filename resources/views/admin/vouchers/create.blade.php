<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Voucher Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                {{-- Form Create Voucher --}}
                <form action="{{ route('admin.vouchers.store') }}" method="POST">
                    @csrf

                    {{-- Kode Voucher --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kode Voucher</label>
                        <input type="text" name="code" placeholder="Contoh: DISKON50" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800 uppercase" required>
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah Diskon --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Diskon (Rp)</label>
                        <input type="number" name="discount_amount" placeholder="Contoh: 5000" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-800 focus:border-gray-800" required>
                        <p class="text-xs text-gray-500 mt-1">Masukkan angka saja tanpa titik.</p>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.vouchers.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Batal</a>
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 transition">Simpan Voucher</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>