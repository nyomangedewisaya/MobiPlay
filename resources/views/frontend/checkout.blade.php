@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 my-12" x-data="{
        copy(text) {
                let tempInput = document.createElement('input');
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
    
                let button = event.currentTarget;
                let originalText = button.innerHTML;
                button.innerHTML = 'Tersalin!';
                setTimeout(() => { button.innerHTML = originalText; }, 2000);
            },
            download() {
                let content = `Detail Transaksi MobiPlay\n\n`;
                content += `ID Pesanan: {{ $order->order_code }}\n`;
                content += `ID Transaksi: {{ $order->midtrans_transaction_id }}\n`;
                content += `Tanggal: {{ $order->created_at->format('d M Y, H:i') }}\n`;
                content += `Status: {{ ucfirst($order->status) }}\n`;
                content += `-------------------------\n`;
                content += `Item Dibeli:\n`;
                @foreach($order -> orderItems as $orderItem)
                content += `- {{ $orderItem->item->name ?? 'N/A' }}\n`;
                @endforeach
                content += `-------------------------\n`;
                content += `Total Pembayaran: Rp {{ number_format($order->total_amount, 0, ',', '.') }}\n`;
    
                const blob = new Blob([content], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'invoice-{{ $order->order_code }}.txt';
                a.click();
                URL.revokeObjectURL(url);
            }
    }">
        {{-- Main card --}}
        <div class="bg-slate-800 rounded-lg shadow-xl border border-slate-700 text-center p-6 sm:p-8" data-aos="fade-up">
            <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="mt-4 text-2xl font-bold text-white">Menunggu Pembayaran</h1>
            <p class="mt-2 text-sm text-slate-400">Pesanan Anda telah dibuat dan menunggu pembayaran.</p>

            {{-- Info --}}
            <div class="text-left space-y-4 my-6 pt-6 border-t border-slate-700">
                <div class="flex justify-between items-center"><span class="text-slate-400">ID Pesanan:</span>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-white">{{ $order->order_code }}</span>
                        <button @click="copy('{{ $order->order_code }}')" class="text-slate-400 hover:text-white"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between items-center"><span class="text-slate-400">ID Transaksi:</span>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-white">{{ $order->midtrans_transaction_id }}</span>
                        <button @click="copy('{{ $order->midtrans_transaction_id }}')"
                            class="text-slate-400 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="text-left p-4 rounded-lg bg-slate-700/50 border border-slate-700">
                    @php
                        $orderItem = $order->orderItems->first();
                    @endphp
                    <div class="flex items-center gap-4">
                        <img src="{{ asset($orderItem->item->image_url ?? '') }}"
                            alt="{{ $orderItem->item->name ?? 'Item' }}"
                            class="w-16 h-16 object-contain rounded-md bg-white/10 p-1">
                        <div>
                            <p class="font-bold text-white">{{ $orderItem->item->product->name ?? 'Produk' }}</p>
                            <p class="text-sm text-slate-300">{{ $orderItem->item->name ?? 'Item' }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-600 space-y-2 text-sm">
                        @foreach (json_decode($orderItem->user_data) as $label => $value)
                            <div class="flex justify-between"><span class="text-slate-400">{{ $label }}:</span><span
                                    class="font-semibold text-white">{{ $value }}</span></div>
                        @endforeach
                    </div>
                </div>

                <div class="text-left space-y-2 my-6 pt-6 border-t border-slate-700">
                    <div class="flex justify-between text-lg font-bold"><span class="text-slate-400">Total Harga:</span><span
                            class="text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('home') }}"
                    class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 font-semibold">Kembali ke
                    Beranda</a>
                @auth
                    <a href="{{ route('history') }}"
                        class="w-full px-4 py-2 blue-gradient-wh text-white rounded-lg font-semibold">Lihat Histori
                        Transaksi</a>
                @endauth
                @guest
                    <button @click="download()"
                        class="w-full px-4 py-2 blue-gradient-wh text-white rounded-lg font-semibold">Download Invoice</button>
                @endguest
            </div>
        </div>
    </div>
@endsection
