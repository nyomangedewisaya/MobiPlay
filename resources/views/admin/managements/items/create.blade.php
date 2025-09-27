@extends('layouts.master')
@section('title', 'Tambah Item untuk ' . $product->name)
@section('content')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 mb-6 pb-4" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Tambah Item Baru</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Anda menambahkan item untuk produk: <strong class="font-semibold">{{ $product->name }}</strong></p>
        </div>

        <form action="{{ route('managements.items.store', $product) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-grow" data-aos="fade-up">
            @csrf
            <div class="flex-grow overflow-y-auto pr-4 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Nama Item</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 86 Diamonds">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: MLBB_86D">
                        @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Harga Item</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 25000">
                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div x-data="{ previewUrl: '' }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Gambar Item</label>
                        <input type="file" name="image_url" class="hidden" x-ref="image" @change="previewUrl = URL.createObjectURL($event.target.files[0])">
                        <div class="mt-2 flex items-center gap-4">
                            <template x-if="!previewUrl">
                                <div @click="$refs.image.click()" class="w-16 h-16 flex-shrink-0 bg-gray-100 dark:bg-slate-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-slate-600 flex items-center justify-center cursor-pointer hover:bg-gray-200 dark:hover:bg-slate-600">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" /></svg>
                                </div>
                            </template>
                            <template x-if="previewUrl">
                                <div class="relative w-16 h-16 flex-shrink-0">
                                    <img :src="previewUrl" class="w-full h-full rounded-lg object-cover">
                                    <button type="button" @click="$refs.image.click()" class="absolute -top-2 -right-2 bg-white/80 hover:bg-white text-black rounded-full p-1 shadow-md transition" title="Ganti Gambar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                            </template>
                            <p class="text-xs text-gray-500 dark:text-slate-400">Klik kotak atau tombol untuk memilih gambar.</p>
                        </div>
                        @error('image_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4 mt-6">
                    <a href="{{ route('managements.items.index', $product) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">Batal</a>
                    <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">Simpan Item</button>
                </div>
            </div>
        </form>
    </div>
@endsection

