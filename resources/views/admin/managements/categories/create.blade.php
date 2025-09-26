@extends('layouts.master')
@section('title', 'Tambah Kategori')
@section('content')
    <div
        class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]">
        <div class="border-b border-gray-200 dark:border-slate-600/50 mb-6 pb-4">
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Tambah Kategori Baru</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Isi input di bawah ini untuk menambahkan kategori
                baru.</p>
        </div>
        <form action="{{ route('managements.categories.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">
                        Nama Kategori
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Game Mobile" autofocus>
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-6">
                <a href="{{ route('managements.categories.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">
                    Batal
                </a>
                <button type="submit" class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
