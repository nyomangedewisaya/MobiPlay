@extends('layouts.master')
@section('title', 'Pilih Produk')
@section('content')
    <div
        class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 mb-6 pb-4" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Pilih Produk</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Pilih produk di bawah ini untuk mengelola input field nya.
            </p>
        </div>

        {{-- Cards of list products --}}
        <div class="flex-grow overflow-y-auto pr-4" data-aos="fade-up">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($products as $product)
                    <a href="{{ route('managements.input-fields.index', $product) }}"
                        class="bg-gray-50 dark:bg-slate-900/50 rounded-lg shadow-md p-4 flex items-center gap-4 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($product->thumbnail_url) }}" alt="{{ $product->name }}"
                                class="w-24 h-24 rounded-lg object-cover">
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ $product->category->name ?? 'N/A' }}</p>
                            @if ($product->input_fields_count == 0)
                                <span
                                    class="mt-2 inline-block red-gradient text-white text-xs font-medium px-2.5 py-0.5 rounded">
                                    0 Input
                                </span>
                            @else
                                <span
                                    class="mt-2 inline-block blue-gradient text-white text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $product->input_fields_count }} Input
                                </span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-2 text-center py-10">
                        <p class="text-gray-500 dark:text-slate-400">Belum ada produk yang ditambahkan.</p>
                        <a href="{{ route('managements.products.create') }}"
                            class="mt-4 inline-block blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">
                            Tambah Produk Sekarang
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
