@extends('layouts.master')
@section('title', 'Edit Item')
@section('content')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 mb-6 pb-4" data-aos="fade-up">
            <a href="{{ route('managements.items.index', $product) }}"
                class="text-sm text-blue-500 hover:underline mb-2 flex items-center gap-2"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Daftar Item</a>
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Edit Item: {{ $item->name }}</h2>
        </div>

        {{-- Form input update for items --}}
        <form action="{{ route('managements.items.update', $item) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-grow" data-aos="fade-up">
            @csrf
            @method('PUT')
            <div class="flex-grow overflow-y-auto pr-4 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Nama Item</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $item->sku) }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Harga Item</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $item->price) }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div x-data="{ previewUrl: '{{ $item->image_url ? asset($item->image_url) : '' }}' }">
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
                            <div class="text-xs text-gray-500 dark:text-slate-400">
                                <p>Klik kotak atau tombol untuk memilih gambar.</p>
                                <p class="font-semibold">Kosongkan jika tidak ingin mengubah.</p>
                            </div>
                        </div>
                        @error('image_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4 mt-6">
                    <a href="{{ route('managements.items.index', $item->product) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">Batal</a>
                    <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

