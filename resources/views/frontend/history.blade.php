@extends('layouts.app')
@section('title', 'Histori Transaksi')
@section('content')
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-8" x-data="{
        visibleCount: 3,
        totalOrders: {{ count($orders) }}
    }">
        {{-- Header and filter --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8" data-aos="fade-up">
            <div>
                <h1 class="text-3xl font-bold text-white">Histori Transaksi</h1>
                <p class="text-slate-400 mt-1">Semua pesanan Anda tercatat di sini.</p>
            </div>
            @if ($orders->isNotEmpty())
                <form action="{{ route('history') }}" method="GET"
                    class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                    <select name="range" onchange="this.form.submit()"
                        class="w-full sm:w-auto bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-sm focus:outline-none">
                        <option value="all" {{ request('range', 'all') == 'all' ? 'selected' : '' }}>Filter Transaksi
                        </option>
                        <option value="7" {{ request('range') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30" {{ request('range') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                        <option value="90" {{ request('range') == '90' ? 'selected' : '' }}>90 Hari Terakhir</option>
                    </select>
                    <div class="relative w-full sm:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice..."
                            class="w-full sm:w-64 bg-slate-800 border border-slate-700 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </form>
            @endif
        </div>

        {{-- List card of history transaction --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up">
            @forelse ($orders as $order)
                <div x-show="$el.dataset.index < visibleCount" x-transition data-index="{{ $loop->index }}"
                    class="bg-slate-800 rounded-lg shadow-lg border border-slate-700 flex flex-col">
                    <div class="p-4 border-b border-slate-700">
                        <h3 class="font-bold text-lg text-white truncate">
                            {{ $order->orderItems->first()->item->product->name ?? 'Produk Tidak Ditemukan' }}</h3>
                    </div>
                    <div class="p-4 space-y-3 text-sm flex-grow">
                        <div class="flex justify-between"><span class="text-slate-400">Tanggal Transaksi:</span><span
                                class="font-medium text-white">{{ $order->created_at->format('d M Y, H:i') }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Status Pesanan:</span>
                            <span
                                class="font-semibold px-2 py-0.5 rounded-full text-xs
                                @switch($order->status)
                                    @case('success') bg-green-500/20 text-green-400 @break
                                    @case('pending') bg-yellow-500/20 text-yellow-400 @break
                                    @default bg-red-500/20 text-red-400 @break
                                @endswitch
                            ">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="flex justify-between"><span class="text-slate-400">ID Pesanan:</span><span
                                class="font-mono text-white">{{ $order->order_code }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">ID Transaksi:</span><span
                                class="font-mono text-white">{{ $order->midtrans_transaction_id ?? '-' }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Item dibeli:</span><span
                                class="text-white">{{ $order->orderItems->first()->item->name ?? 'Item dihapus.' }}</span>
                        </div>
                    </div>
                    <div class="p-4 border-t border-slate-700">
                        @if (in_array($order->status, ['success', 'pending']))
                            <div class="flex justify-between items-baseline">
                                <span class="text-slate-400">Total Pembayaran:</span>
                                <span class="font-bold text-xl text-blue-400">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <p class="text-center text-red-400 text-sm font-semibold">Tidak ada transaksi yang dibuat</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-slate-800 rounded-lg">
                    @if (request()->has('search') || request()->has('range'))
                        <svg class="mx-auto h-12 w-12 text-slate-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-white">Transaksi Tidak Ditemukan</h3>
                        <p class="mt-1 text-sm text-slate-400">Tidak ada transaksi yang cocok dengan filter atau pencarian
                            Anda.</p>
                    @else
                        <h3 class="mt-2 text-lg font-medium text-white">Belum Ada Transaksi</h3>
                        <p class="mt-1 text-sm text-slate-400">Anda belum pernah melakukan transaksi. Mari mulai berbelanja!
                        </p>
                        <a href="{{ route('home') }}"
                            class="mt-6 inline-block blue-gradient-wh text-white rounded-lg px-6 py-2.5 font-semibold">
                            Mulai Belanja
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Show more button --}}
        <div x-show="visibleCount < totalOrders" class="text-center mt-8" data-aos="fade-up">
            <button @click="visibleCount += 6"
                class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                Tampilkan Lebih Banyak
            </button>
        </div>
    </div>
@endsection
