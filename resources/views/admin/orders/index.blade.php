@extends('layouts.master')
@section('title', 'Kelola Pesanan')
@section('content')
    @include('partials.alert')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]"
        x-data="{ searchQuery: '{{ request('search', '') }}' }">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 flex flex-col sm:flex-row items-start sm:items-center sm:justify-between gap-4 mb-4 pb-4" data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Kelola Pesanan</h2>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Lihat semua riwayat transaksi yang masuk.</p>
            </div>
            <div class="w-full sm:w-auto">
                <form action="{{ route('orders.index') }}" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="search" x-model="searchQuery"
                        class="w-full bg-gray-200 dark:bg-slate-600/50 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 rounded-full pl-4 pr-10 py-3 focus:outline-none"
                        placeholder="Cari berdasarkan invoice...">

                    <button type="button" x-show="searchQuery"
                        @click="searchQuery = ''; window.location.href = '{{ route('orders.index') }}'" x-cloak
                        class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-400 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 transcolor">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>

                    <button type="submit" x-show="!searchQuery"
                        class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-400 hover:text-gray-500 dark:text-gray-200 dark:hover:text-gray-400 transcolor">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- Filter --}}
        <form action="{{ route('orders.index') }}" method="GET" class="mb-4" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row items-center gap-4">
                {{-- Year --}}
                <div class="w-full sm:w-auto">
                    <label for="year" class="sr-only">Tahun</label>
                    <select name="year" id="year" onchange="this.form.submit()"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 
                       dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">
                        @forelse ($years as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>Tahun
                                {{ $year }}</option>
                        @empty
                            <option value="{{ date('Y') }}">Tahun {{ date('Y') }}</option>
                        @endforelse
                    </select>
                </div>

                {{-- Month --}}
                <div class="w-full sm:w-auto">
                    <label for="month" class="sr-only">Bulan</label>
                    <select name="month" id="month" onchange="this.form.submit()"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 
                       dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">
                        <option value="all">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Status --}}
                <div class="w-full sm:w-auto">
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" onchange="this.form.submit()"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 
                       dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">
                        <option value="all">Semua Status</option>
                        @foreach (['pending', 'success', 'failed'] as $status)
                            <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($isFilterActive)
                    <a href="{{ route('orders.index') }}"
                        class="w-full sm:w-auto px-5 py-2 red-gradient-wh text-white rounded-lg font-semibold text-center flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- Main content --}}
        <div class="flex-grow overflow-y-auto pr-2 -mr-2 space-y-4" data-aos="fade-up">
            @forelse ($orders as $order)
                <div x-data="{ open: false }"
                    class="bg-gray-50 dark:bg-slate-800 border border-gray-300 dark:border-slate-600/50 rounded-lg shadow-md transition-all duration-300">
                    {{-- Order cards --}}
                    <div @click="open = !open" class="p-4 flex items-center justify-between cursor-pointer gap-4">
                        {{-- Left card content --}}
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="text-center w-16 flex-shrink-0">
                                <p class="text-sm text-gray-500 dark:text-slate-400">{{ $order->created_at->format('M') }}
                                </p>
                                <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                    {{ $order->created_at->format('d') }}</p>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 dark:text-white sm:text-xs lg:text-lg"
                                    title="{{ $order->order_code }}">{{ $order->order_code }}</p>
                                <p class="text-sm text-gray-500 dark:text-slate-400 truncate">{{ $order->customer_email }}
                                </p>
                            </div>
                        </div>
                        {{-- Right card content --}}
                        <div class="flex items-center gap-4 flex-shrink-0">
                            <span class="font-semibold text-gray-800 dark:text-white min-w-[120px] text-right">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            <span
                                class="w-24 text-center text-xs font-medium px-2.5 py-1 rounded-full text-white
                                @switch($order->status)
                                    @case('success') green-gradient @break
                                    @case('pending') yellow-gradient @break
                                    @default red-gradient @break
                                @endswitch
                            ">{{ ucfirst($order->status) }}</span>
                            <svg class="h-5 w-5 text-gray-500 dark:text-slate-400 transition-transform duration-300"
                                :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    {{-- Detail card content --}}
                    <div x-show="open" x-transition
                        class="p-4 bg-white dark:bg-slate-800/50 rounded-b-lg border-t border-gray-200 dark:border-slate-700">
                        {{-- Info user and payment --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="bg-gray-100 dark:bg-slate-700/50 rounded-lg border border-gray-200 dark:border-slate-600 p-3 flex flex-col">
                                <p class="text-md font-semibold text-gray-800 dark:text-white mb-2">Info Pelanggan</p>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between"><span
                                            class="text-gray-600 dark:text-slate-400">Email:</span><span
                                            class="font-medium text-gray-800 dark:text-slate-200">{{ $order->user_email }}</span>
                                    </div>
                                    <div class="flex justify-between"><span
                                            class="text-gray-600 dark:text-slate-400">User:</span><span
                                            class="font-medium text-gray-800 dark:text-slate-200">{{ $order->user->name ?? 'Guest' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gray-100 dark:bg-slate-700/50 rounded-lg border border-gray-200 dark:border-slate-600 p-3 flex flex-col">
                                <p class="text-md font-semibold text-gray-800 dark:text-white mb-2">Info Pembayaran</p>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between"><span
                                            class="text-gray-600 dark:text-slate-400">Invoice:</span><span
                                            class="font-medium text-gray-800 dark:text-slate-200">{{ $order->order_code }}</span>
                                    </div>
                                    <div class="flex justify-between"><span
                                            class="text-gray-600 dark:text-slate-400">Midtrans ID:</span><span
                                            class="font-medium text-gray-800 dark:text-slate-200">{{ $order->midtrans_transaction_id ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Detail item --}}
                        <div
                            class="bg-gray-100 dark:bg-slate-700/50 rounded-lg border border-gray-200 dark:border-slate-600 p-4 mt-4">
                            <h4 class="text-md font-bold text-gray-800 dark:text-white mb-3">Detail Pesanan</h4>
                            <div class="space-y-3">
                                @foreach ($order->orderItems as $orderItem)
                                    <div
                                        class="flex items-center bg-white dark:bg-slate-800 p-2 rounded-md border border-gray-200 dark:border-slate-600">
                                        <div class="flex items-center gap-x-3 min-w-0">
                                            <img src="{{ asset($orderItem->item->image_url ?? 'https://placehold.co/64x64/E2E8F0/475569?text=Mobi') }}"
                                                alt="{{ $orderItem->item->name ?? 'Item Dihapus' }}"
                                                class="w-12 h-12 object-cover rounded flex-shrink-0">
                                            <div class="min-w-0">
                                                <p class="font-semibold text-gray-800 dark:text-white truncate">
                                                    {{ $orderItem->item->name ?? 'Item Dihapus' }}</p>
                                                <p class="text-xs text-gray-500 dark:text-slate-400">Rp
                                                    {{ number_format($orderItem->price_purchase, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Update status button --}}
                        @if ($order->status == 'pending')
                            <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg border border-yellow-300 dark:border-yellow-700">
                                <h4 class="text-md font-bold text-yellow-800 dark:text-yellow-300 mb-3">Aksi Admin</h4>
                                <p class="text-sm text-yellow-700 dark:text-yellow-400 mb-4">Anda dapat menyetujui (Success) atau menolak (Failed) pesanan ini secara manual.</p>
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
                                    @csrf
                                    <button type="submit" name="status" value="success" class="w-full sm:w-auto green-gradient-wh text-white rounded-lg px-4 py-2 font-semibold flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        Setujui
                                    </button>
                                    <button type="submit" name="status" value="failed" class="w-full sm:w-auto red-gradient-wh text-white rounded-lg px-4 py-2 font-semibold flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-gray-500 dark:text-slate-400">Tidak ada pesanan yang cocok dengan filter Anda.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4 border-t border-gray-200 dark:border-slate-700 pt-4" data-aos="fade-up">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
