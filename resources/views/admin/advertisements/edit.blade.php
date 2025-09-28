@extends('layouts.master')
@section('title', 'Edit Iklan')
@section('content')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)] overflow-y-auto">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 mb-6 pb-4" data-aos="fade-up">
            <a href="{{ route('advertisements.index') }}"
                class="text-sm text-blue-500 hover:underline mb-2 flex items-center gap-2"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Daftar Iklan</a>
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Edit Iklan</h2>
        </div>

        {{-- Form input edit for advertisments --}}
        <form action="{{ route('advertisements.update', $advertisement) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-grow" data-aos="fade-up">
            @csrf
            @method('PUT')
            <div class="flex-grow overflow-y-auto pr-4 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">Judul Iklan</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $advertisement->title) }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">URL Target</label>
                    <input type="text" name="target_url" id="target_url" value="{{ old('target_url', $advertisement->target_url) }}" class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('target_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div x-data="{ previewUrl: '{{ asset($advertisement->banner_url) }}' }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-2">Banner</label>
                    <input type="file" name="banner_url" class="hidden" x-ref="banner" @change="previewUrl = URL.createObjectURL($event.target.files[0])">
                    <div class="mt-2">
                        <template x-if="!previewUrl">
                            <div @click="$refs.banner.click()" class="cursor-pointer flex justify-center ... border-dashed">
                            </div>
                        </template>
                        <template x-if="previewUrl">
                             <div class="relative">
                                <img :src="previewUrl" class="w-full h-auto rounded-md object-cover aspect-video">
                                <button type="button" @click="$refs.banner.click()" class="absolute top-2 right-2 bg-white/70 hover:bg-white text-black rounded-full p-2 text-sm font-semibold transition">Ganti</button>
                            </div>
                        </template>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah banner.</p>
                    @error('banner_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-end gap-4 mt-6 pb-4">
                    <a href="{{ route('advertisements.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">Batal</a>
                    <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
