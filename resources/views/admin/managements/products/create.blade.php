@extends('layouts.master')
@section('title', 'Tambah Produk Baru')
@section('content')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)] overflow-y-auto">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 mb-6 pb-4" data-aos="fade-up">
            <a href="{{ route('managements.products.index') }}"
                class="text-sm text-blue-500 hover:underline mb-2 flex items-center gap-2"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Daftar Produk</a>
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Tambah Produk Baru</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Isi data-data di bawah ini untuk menambahkan produk baru. Semua field wajib diisi.</p>
        </div>

        {{-- Form input create for products --}}
        <form action="{{ route('managements.products.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-grow" data-aos="fade-up">
            @csrf
            <div class="flex-grow overflow-y-auto pr-4 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Mobile Legends" autofocus>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Kategori</label>
                        <select name="category_id" id="category_id" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-3">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="md:col-span-1" x-data="{ previewUrl: '' }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-2">Thumbnail (Rasio 1:1)</label>
                        <input type="file" name="thumbnail_url" class="hidden" x-ref="thumbnail" @change="previewUrl = URL.createObjectURL($event.target.files[0])">
                        <div class="mt-2">
                            <template x-if="!previewUrl">
                                <div @click="$refs.thumbnail.click()" class="cursor-pointer flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-slate-600 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        <p class="text-sm text-gray-500 dark:text-slate-400">Klik untuk upload (300x300)</p>
                                    </div>
                                </div>
                            </template>
                            <template x-if="previewUrl">
                                <div class="relative">
                                    <img :src="previewUrl" class="w-full h-auto rounded-md object-cover aspect-square">
                                    <button type="button" @click="$refs.thumbnail.click()" class="absolute top-2 right-2 bg-white/70 hover:bg-white text-black rounded-full p-2 text-sm font-semibold transition">Ganti</button>
                                </div>
                            </template>
                        </div>
                        @error('thumbnail_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="md:col-span-2" x-data="{ previewUrl: '' }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-2">Banner (Rasio 2:1)</label>
                        <input type="file" name="banner_url" class="hidden" x-ref="banner" @change="previewUrl = URL.createObjectURL($event.target.files[0])">
                        <div class="mt-2">
                             <template x-if="!previewUrl">
                                <div @click="$refs.banner.click()" class="cursor-pointer flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-slate-600 border-dashed rounded-md">
                                   <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                        <p class="text-sm text-gray-500 dark:text-slate-400">Klik untuk upload (600x300)</p>
                                    </div>
                                </div>
                            </template>
                            <template x-if="previewUrl">
                                 <div class="relative">
                                    <img :src="previewUrl" class="w-full h-auto rounded-md object-cover aspect-[2/1]">
                                    <button type="button" @click="$refs.banner.click()" class="absolute top-2 right-2 bg-white/70 hover:bg-white text-black rounded-full p-2 text-sm font-semibold transition">Ganti</button>
                                </div>
                            </template>
                        </div>
                        @error('banner_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4 mt-6">
                    <a href="{{ route('managements.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">Batal</a>
                    <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">Simpan Produk</button>
                </div>
            </div>
        </form>
    </div>
@endsection

