@extends('layouts.app')

@section('title', 'Top Up ' . $product->name)

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-8"
        x-data="{
            selectedItem: null,
            selectedPayment: '',
            isProcessing: false,
            taxRate: {{ $taxRate }},
            subtotal: 0,
            taxAmount: 0,
            total: 0,

            selectItem(item) {
                this.selectedItem = item;
                this.calculatePrice();
            },

            calculatePrice() {
                if (!this.selectedItem) return;
                
                let price = this.selectedItem.price;
                if (this.selectedItem.discount_percentage > 0) {
                    price = price - (price * (this.selectedItem.discount_percentage / 100));
                }

                this.subtotal = price;
                this.taxAmount = this.subtotal * this.taxRate;
                this.total = this.subtotal + this.taxAmount;
            },

            formatCurrency(value) {
                return `Rp ${Math.round(value).toLocaleString('id-ID')}`;
            }
        }">
        
        <form action="{{ route('transaction.checkout', $product) }}" method="POST" @submit="isProcessing = true">
            @csrf
            <input type="hidden" name="item_id" :value="selectedItem ? selectedItem.id : ''">
            <input type="hidden" name="payment_method" x-model="selectedPayment">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left container: product info --}}
                <div class="lg:col-span-1 space-y-6" data-aos="fade-right">
                    <div class="relative">
                        <img src="{{ asset($product->banner_url) }}" alt="{{ $product->name }}" class="rounded-xl shadow-lg w-full aspect-video object-cover">
                        <img src="{{ asset($product->thumbnail_url) }}" alt="{{ $product->name }}" class="w-24 h-24 rounded-lg object-cover absolute -bottom-8 left-6 border-4 border-slate-800 shadow-md">
                    </div>
                    <div class="pt-10">
                        <h1 class="text-3xl font-bold text-white">{{ $product->name }}</h1>
                         <div class="mt-2 inline-flex items-center gap-2 bg-blue-500/10 text-blue-400 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                            <span>Pembayaran Aman</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $product->description }}</p>
                </div>

                {{-- Right container: user action --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Input fields --}}
                    <div class="bg-slate-800 rounded-lg p-6 shadow-lg border border-slate-700" data-aos="fade-up">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2"><span class="bg-blue-500 text-white rounded-full h-7 w-7 flex items-center justify-center font-bold">1</span> Lengkapi Data Anda</h3>
                        <div class="grid grid-cols-1 {{ count($product->inputFields) > 1 ? 'sm:grid-cols-2' : '' }} gap-4">
                            @foreach ($product->inputFields as $field)
                                <div class="{{ count($product->inputFields) == 1 ? 'sm:col-span-2' : '' }}">
                                    <label for="{{ $field->field_name }}" class="block text-sm font-medium text-slate-200 mb-1">{{ $field->field_label }}</label>
                                    @if($field->field_type === 'select')
                                        <select name="{{ $field->field_name }}" id="{{ $field->field_name }}" class="w-full bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                            <option value="">{{ $field->placeholder ?? 'Pilih Opsi' }}</option>
                                            @foreach ($field->field_options ?? [] as $option)
                                                <option value="{{ $option }}" {{ old($field->field_name) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="{{ $field->field_type }}" name="{{ $field->field_name }}" id="{{ $field->field_name }}" value="{{ old($field->field_name) }}" placeholder="{{ $field->placeholder }}" class="w-full bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    @endif
                                    <p class="text-xs text-slate-400 mt-1">{{ $field->field_desc }}</p>
                                    @error($field->field_name)<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            @endforeach
                            @guest
                                <div class="sm:col-span-2">
                                    <label for="customer_email" class="block text-sm font-medium text-slate-200 mb-1">Alamat Email (untuk bukti pembayaran)</label>
                                    <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" placeholder="youremail@gmail.com" class="w-full bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    @error('customer_email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            @endguest
                        </div>
                    </div>

                    {{-- Select item --}}
                    <div class="bg-slate-800 rounded-lg p-6 shadow-lg border border-slate-700" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2"><span class="bg-blue-500 text-white rounded-full h-7 w-7 flex items-center justify-center font-bold">2</span> Pilih Nominal</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @forelse ($product->items as $item)
                                <button type="button" @click="selectItem({{ json_encode($item) }})"
                                        :class="{ 'border-blue-500 ring-2 ring-blue-500': selectedItem && selectedItem.id === {{ $item->id }} }"
                                        class="relative bg-white dark:bg-slate-700/50 rounded-lg p-3 text-center border-2 border-transparent hover:border-blue-500 transition-all duration-200 flex flex-col items-center justify-center group">
                                    @if ($item->discount_percentage > 0)
                                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-bl-lg rounded-tr-lg">-{{ $item->discount_percentage }}%</span>
                                    @endif
                                    <img src="{{ asset($item->image_url ?? 'https://placehold.co/80x80/475569/E2E8F0?text=Mobi') }}" alt="{{ $item->name }}" class="w-16 h-16 sm:w-20 sm:h-20 mx-auto object-contain transition-transform duration-300 group-hover:scale-110">
                                    <p class="font-semibold text-gray-800 dark:text-white text-sm mt-2 whitespace-normal leading-tight">{{ $item->name }}</p>
                                    @if($item->discount_percentage > 0)
                                        <p class="text-xs text-slate-500 dark:text-slate-400 line-through">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        <p class="text-sm font-bold text-green-500 dark:text-green-400">Rp {{ number_format($item->price - ($item->price * ($item->discount_percentage / 100)), 0, ',', '.') }}</p>
                                    @else
                                        <p class="text-sm font-bold text-gray-700 dark:text-slate-300 mt-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    @endif
                                </button>
                            @empty
                                <p class="col-span-full text-center text-slate-400 py-4">Item untuk produk ini belum tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Payment methods --}}
                    <div class="bg-slate-800 rounded-lg p-6 shadow-lg border border-slate-700" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2"><span class="bg-blue-500 text-white rounded-full h-7 w-7 flex items-center justify-center font-bold">3</span> Pilih Pembayaran</h3>
                        <div class="space-y-4">
                            @foreach ($paymentMethods as $type => $methods)
                                <div>
                                    <p class="text-sm font-semibold text-slate-300 mb-2">{{ $type }}</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                        @foreach ($methods as $method)
                                            <button type="button" @click="selectedPayment = '{{ $method }}'"
                                                    :class="{ 'border-blue-500 ring-2 ring-blue-500': selectedPayment === '{{ $method }}' }"
                                                    class="w-full text-left bg-slate-700/50 p-3 rounded-lg border-2 border-transparent hover:border-blue-500 transition-colors">
                                                <span class="font-semibold text-white text-sm">{{ $method }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Detail payment --}}
                    <div x-show="selectedItem" x-transition class="bg-slate-800 rounded-lg p-6 shadow-lg border border-slate-700" data-aos="fade-up">
                        <h3 class="text-xl font-bold text-white mb-4">Detail Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-slate-400">Harga Item:</span><span class="font-medium text-white" x-text="formatCurrency(subtotal)"></span></div>
                            <div class="flex justify-between"><span class="text-slate-400">Pajak ({{ $taxRate * 100 }}%):</span><span class="font-medium text-white" x-text="formatCurrency(taxAmount)"></span></div>
                            <hr class="border-slate-700 !my-3">
                            <div class="flex justify-between items-center"><span class="text-slate-400 font-semibold">Total Pembayaran:</span><span class="font-bold text-2xl text-blue-400" x-text="formatCurrency(total)"></span></div>
                        </div>
                         <button type="submit" :disabled="!selectedItem || !selectedPayment || isProcessing" class="mt-6 w-full blue-gradient-wh text-white rounded-lg py-3 font-semibold text-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isProcessing">Beli Sekarang</span>
                            <span x-show="isProcessing">Memproses...</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
        {{-- Benefit parts --}}
        <div class="mt-16 sm:mt-24 py-12 border-t border-slate-800" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-white text-center">Kenapa Top Up di MobiPlay?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-blue-500/10 flex items-center justify-center border-2 border-blue-500/30">
                        <svg class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-white text-lg">Proses Kilat</h3>
                    <p class="mt-2 text-sm text-slate-400">Hanya dalam hitungan detik, item Anda langsung masuk ke akun setelah pembayaran berhasil.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-violet-500/10 flex items-center justify-center border-2 border-violet-500/30">
                         <svg class="w-8 h-8 text-violet-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3M3.75 21h15a2.25 2.25 0 002.25-2.25V5.25A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-white text-lg">Pembayaran Lengkap</h3>
                    <p class="mt-2 text-sm text-slate-400">Kami menyediakan semua metode pembayaran favorit Anda, mulai dari e-wallet, bank, hingga pulsa.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-green-500/10 flex items-center justify-center border-2 border-green-500/30">
                        <svg class="w-8 h-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-white text-lg">Layanan 24/7</h3>
                    <p class="mt-2 text-sm text-slate-400">Tim customer service kami selalu siap membantu Anda menyelesaikan masalah kapanpun, 24 jam sehari.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

