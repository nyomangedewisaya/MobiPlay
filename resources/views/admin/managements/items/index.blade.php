@extends('layouts.master')
@section('title', 'Item Produk')
@section('content')
    @include('partials.alert')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]"
        x-data="{
            updateStatusModal: false,
            updateDiscountModal: false,
            deleteModal: false,
        
            itemToUpdateStatus: {},
            itemToUpdateDiscount: {},
            itemToDelete: {},
        
            openUpdateStatusModal(item) {
                this.itemToUpdateStatus = item;
                this.updateStatusModal = true
            },
            openDiscountModal(item) {
                this.itemToUpdateDiscount = item;
                this.updateDiscountModal = true
            },
            openDeleteModal(item) {
                this.itemToDelete = item;
                this.deleteModal = true
            },

            reopenFailedModal() {
                @if ($errors->has('discount_percentage') && old('item_slug'))
                    let failedItem = {{ Js::from($items) }}.find(item => item.slug === '{{ old('item_slug') }}');
                    if (failedItem) {
                        this.openDiscountModal(failedItem);
                    }
                @endif
            }
        }"
        x-init="reopenFailedModal()">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4 pb-4"
            data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Item untuk: {{ $product->name }}</h2>
            </div>
            <a href="{{ route('managements.items.create', $product) }}"
                class="blue-gradient-wh rounded-lg px-5 py-2.5 text-md text-white font-medium flex items-center justify-center gap-3 w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Tambah Item</span>
            </a>
        </div>

        {{-- Filtering data items --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4" data-aos="fade-up">
            <a href="{{ route('managements.items.productList') }}"
                class="text-sm font-medium text-blue-500 dark:text-blue-400 hover:underline flex items-center gap-2 whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <span>Kembali ke Daftar Produk</span>
            </a>
            @if ($items->isNotEmpty())
                <form action="" method="GET"
                    class="flex lg:flex-row sm:flex-col sm:items-center gap-2 w-full sm:w-auto">
                    <select name="order_by" onchange="this.form.submit()"
                        class="w-full md:w-auto sm:w-48 bg-gray-100 dark:bg-slate-700 border border-gray-300 
                       dark:border-slate-600 text-gray-700 dark:text-slate-200 rounded-lg px-4 py-2 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="name" {{ request('order_by') == 'name' ? 'selected' : '' }}>Nama</option>
                        <option value="price" {{ request('order_by') == 'price' ? 'selected' : '' }}>Harga</option>
                        <option value="status" {{ request('order_by') == 'status' ? 'selected' : '' }}>Status</option>
                    </select>
                    <select name="order_direction" onchange="this.form.submit()"
                        class="w-full md:w-auto sm:w-48 bg-gray-100 dark:bg-slate-700 border border-gray-300 
                       dark:border-slate-600 text-gray-700 dark:text-slate-200 rounded-lg px-4 py-2 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="desc" {{ request('order_direction', 'desc') == 'desc' ? 'selected' : '' }}>
                            Descending
                        </option>
                        <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>Ascending
                        </option>
                    </select>
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        @if ($isFilterActive)
                            <a href="{{ route('managements.items.index', $product) }}"
                                class="px-5 py-2 red-gradient-wh text-white rounded-lg sm:w-full font-semibold text-center flex items-center gap-2">
                                Reset Filter
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            @endif
        </div>

        {{-- Table data --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg flex-1 overflow-y-auto" data-aos="fade-up">
            <table
                class="w-full text-md text-left text-gray-500 dark:text-gray-400 divide divide-gray-200 dark:divide-slate-60/50">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-slate-700 dark:text-slate-300 sticky top-0">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-16">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Gambar Item
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Item
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKU
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Harga
                        </th>
                        <th scope="col" class="px-6 py-3">
                            % Diskon
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700"">
                    @forelse ($items as $item)
                        <tr class="bg-white/15 dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-800/5">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                    class="w-16 h-16 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->name }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->sku }}
                            </td>
                            <td class="px-6 py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap text-center">
                                @if ($item->discount_percentage == 0)
                                    <button @click="openDiscountModal({{ json_encode($item) }})"
                                        class="text-gray-800 dark:text-white hover:-translate-y-0.5 transition-all duration-300">
                                        0%
                                    </button>
                                @else
                                    <button @click="openDiscountModal({{ json_encode($item) }})"
                                        class="blue-gradient-wh text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded hover:-translate-y-0.5 transition-all duration-300">
                                        {{ $item->discount_percentage }}%
                                    </button>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'active')
                                    <button @click="openUpdateStatusModal({{ json_encode($item) }})"
                                        class="green-gradient-wh text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded hover:-translate-y-0.5 transition-all duration-300">
                                        Active
                                    </button>
                                @else
                                    <button @click="openUpdateStatusModal({{ json_encode($item) }})"
                                        class="red-gradient-wh text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded hover:-translate-y-0.5 transition-all duration-300">
                                        Inactive
                                    </button>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('managements.items.edit', $item) }}"
                                        class="blue-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    @if ($item->items_count == 0)
                                        <button @click="openDeleteModal({{ json_encode($item) }})"
                                            class="red-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan=8" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Tidak ada data item.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal for update status item --}}
        <div x-show="updateStatusModal" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="updateStatusModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="updateStatusModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Update Status</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-2">
                    Pilih status baru untuk item "<strong x-text="itemToUpdateStatus.name"></strong>":
                </p>
                <form :action="`/managements/items/${itemToUpdateStatus.slug}/status`" method="POST"
                    class="grid grid-cols-2 gap-4 mt-6">
                    @csrf
                    @method('PATCH')
                    <button type="submit" name="status" value="active"
                        :class="{ 'ring-2 ring-green-500 font-bold': itemToUpdateStatus.status === 'active' }"
                        class="w-full px-4 py-3 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 dark:bg-green-800/50 dark:text-green-200 dark:hover:bg-green-600/50 transition-all duration-200">
                        Active
                    </button>
                    <button type="submit" name="status" value="inactive"
                        :class="{ 'ring-2 ring-red-500 font-bold': itemToUpdateStatus.status === 'inactive' }"
                        class="w-full px-4 py-3 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 dark:bg-red-800/50 dark:text-red-200 dark:hover:bg-red-600/50 transition-all duration-200">
                        Inactive
                    </button>
                </form>

                <div class="text-center mt-4">
                    <button type="button" @click="updateStatusModal = false"
                        class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Batal</button>
                </div>
            </div>
        </div>

        {{-- Modal for manage discount --}}
        <div x-show="updateDiscountModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="updateDiscountModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="updateDiscountModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Atur Diskon</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-2">
                    Atur persentase diskon untuk item "<strong x-text="itemToUpdateDiscount.name"></strong>".
                </p>
                <form :action="`/managements/items/${itemToUpdateDiscount.slug}/discount`" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="item_slug" :value="itemToUpdateDiscount.slug">
                    <div>
                        <label for="discount_percentage"
                            class="block text-sm font-medium text-gray-700 dark:text-slate-200 mb-1">
                            Persentase Diskon (%)
                        </label>
                        <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage') }}"
                            :value="itemToUpdateDiscount.discount_percentage"
                            class="w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: 10">
                        @error('discount_percentage')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-end gap-4 mt-6">
                        <button type="button" @click="updateDiscountModal = false"
                            class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-slate-600 dark:text-white dark:hover:bg-slate-500 transition-colors duration-300">
                            Batal
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 blue-gradient-wh text-white rounded-lg font-semibold">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal for delete item --}}
        <div x-show="deleteModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="deleteModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="deleteModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Konfirmasi Hapus</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-4">
                    Apakah Anda yakin ingin menghapus item "<strong class="font-bold"
                        x-text="itemToDelete.name"></strong>"?
                </p>
                <form :action="`/managements/items/${itemToDelete.slug}`" method="POST"
                    class="flex justify-end gap-4 mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="red-gradient-wh text-white rounded-lg px-4 py-2">Ya, Hapus</button>
                </form>
            </div>
        </div>

    </div>
@endsection
