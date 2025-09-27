@extends('layouts.master')
@section('title', 'Produk')
@section('content')
    @include('partials.alert')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]"
        x-data="{
            searchQuery: '{{ request('search', '') }}',
            viewProductModal: false,
            updateStatusModal: false,
            deleteModal: false,
        
            productToView: {},
            productToUpdateStatus: {},
            productToDelete: {},
        
            openViewProductModal(product) {
                this.productToView = product;
                this.viewProductModal = true
            },
            openUpdateStatusModal(product) {
                this.productToUpdateStatus = product;
                this.updateStatusModal = true
            },
            openDeleteModal(product) {
                this.productToDelete = product;
                this.deleteModal = true
            }
        }">
        {{-- Header --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 flex flex-col gap-y-2 md:flex-row md:items-center md:justify-between mb-4 pb-4 gap-0"
            data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Produk</h2>
            <div class="flex items-stretch gap-4 w-full md:w-auto">
                <form action="{{ route('managements.products.index') }}" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="search" x-model="searchQuery"
                        class="w-full bg-gray-200 dark:bg-slate-600/50 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 rounded-full pl-4 pr-10 py-3 focus:outline-none"
                        placeholder="Cari nama produk...">

                    <button type="button" x-show="searchQuery"
                        @click="searchQuery = ''; window.location.href = '{{ route('managements.products.index') }}'"
                        x-cloak
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
                <a href="{{ route('managements.products.create') }}"
                    class="blue-gradient-wh rounded-lg px-6 py-3 text-md text-white font-medium flex items-center justify-end gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Tambah
                </a>
            </div>
        </div>

        {{-- Filtering data products --}}
        <div class="flex items-center justify-end mb-4" data-aos="fade-up">
            <form action="{{ route('managements.products.index') }}" method="GET"
                class="flex flex-wrap items-center gap-4 w-full">
                <div class="w-full sm:w-auto">
                    <select name="category" onchange="this.form.submit()"
                        class="w-full sm:w-48 bg-gray-100 dark:bg-slate-700 border border-gray-300 
                       dark:border-slate-600 text-gray-700 dark:text-slate-200 rounded-lg px-4 py-2 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}"
                                {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full sm:w-auto">
                    <select name="order_by" onchange="this.form.submit()"
                        class="w-full sm:w-50 bg-gray-100 dark:bg-slate-700 border border-gray-300 
                       dark:border-slate-600 text-gray-700 dark:text-slate-200 rounded-lg px-4 py-2 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="created_at"
                            {{ request('order_by', 'created_at') == 'created_at' ? 'selected' : '' }}>
                            Baru Ditambahkan
                        </option>
                        <option value="name" {{ request('order_by') == 'name' ? 'selected' : '' }}>Nama</option>
                        <option value="status" {{ request('order_by') == 'status' ? 'selected' : '' }}>Status</option>
                    </select>
                </div>

                <div class="w-full sm:w-auto">
                    <select name="order_direction" onchange="this.form.submit()"
                        class="w-full sm:w-40 bg-gray-100 dark:bg-slate-700 border border-gray-300 
                       dark:border-slate-600 text-gray-700 dark:text-slate-200 rounded-lg px-4 py-2 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="desc" {{ request('order_direction', 'desc') == 'desc' ? 'selected' : '' }}>
                            Descending</option>
                        <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>Ascending
                        </option>
                    </select>
                </div>

                <div class="w-full sm:w-auto">
                    <select name="per_page" onchange="this.form.submit()"
                        class="w-full sm:w-40 bg-gray-100 dark:bg-slate-700 border border-gray-300 
                       dark:border-slate-600 text-gray-700 dark:text-slate-200 rounded-lg px-4 py-2 
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / Halaman</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / Halaman</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / Halaman</option>
                    </select>
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto">
                    @if ($isFilterActive)
                        <a href="{{ route('managements.products.index') }}"
                            class="px-5 py-2 red-gradient-wh text-white rounded-lg sm:w-full font-semibold text-center flex items-center gap-2">
                            Reset Filter
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
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
                            Thumbnail
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Produk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Dibuat pada
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700"">
                    @forelse ($products as $product)
                        <tr class="bg-white/15 dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-800/5">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product->category->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($product->status == 'active')
                                    <button @click="openUpdateStatusModal({{ json_encode($product) }})"
                                        class="green-gradient-wh text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded hover:-translate-y-0.5 transition-all duration-300">
                                        Active
                                    </button>
                                @else
                                    <button @click="openUpdateStatusModal({{ json_encode($product) }})"
                                        class="red-gradient-wh text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded hover:-translate-y-0.5 transition-all duration-300">
                                        Inactive
                                    </button>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white text-center">
                                <p>{{ \Carbon\Carbon::parse($product->created_at)->format('d M Y') }}</p>
                                <p class="text-xs">Pukul {{ \Carbon\Carbon::parse($product->created_at)->format('H:i') }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <button @click="openViewProductModal({{ json_encode($product) }})"
                                        class="violet-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('managements.products.edit', $product) }}"
                                        class="blue-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    @if ($product->products_count == 0)
                                        <button @click="openDeleteModal({{ json_encode($product) }})"
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
                            <td colspan=7" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Tidak ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $products->links() }}</div>
        </div>


        {{-- Modal for delete product --}}
        <div x-show="deleteModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="deleteModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="deleteModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Konfirmasi Hapus</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-4">
                    Apakah Anda yakin ingin menghapus produk "<strong class="font-bold"
                        x-text="productToDelete.name"></strong>"?
                </p>
                <form :action="`/managements/products/${productToDelete.slug}`" method="POST"
                    class="flex justify-end gap-4 mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="red-gradient-wh text-white rounded-lg px-4 py-2">Ya, Hapus</button>
                </form>
            </div>
        </div>

        {{-- Modal for view detail product --}}
        <div x-show="viewProductModal" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="viewProductModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="viewProductModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                <div class="p-4 border-b dark:border-slate-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white" x-text="productToView.name"></h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400" x-text="productToView.category.name"></p>
                    </div>
                    <button @click="viewProductModal = false"
                        class="text-gray-500 hover:text-gray-800 dark:hover:text-white"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4 overflow-y-auto">
                    <img :src="`${productToView.banner_url}`" :alt="productToView.name"
                        class="w-full rounded-lg aspect-[2/1] object-cover mb-4 bg-gray-200 dark:bg-slate-700">
                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        <img :src="`${productToView.thumbnail_url}`" :alt="productToView.name"
                            class="w-full sm:w-24 h-auto sm:h-24 rounded-lg object-cover aspect-square bg-gray-200 dark:bg-slate-700">
                        <p class="text-gray-600 dark:text-slate-300" x-text="productToView.description"></p>
                    </div>
                </div>
                <div class="p-4 border-t dark:border-slate-700 text-right">
                    <a :href="`/managements/products/${productToView.slug}/edit`"
                        class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">
                        Edit Produk Ini
                    </a>
                </div>
            </div>
        </div>

        {{-- Modal for update status product --}}
        <div x-show="updateStatusModal" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="updateStatusModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="updateStatusModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Update Status</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-2">
                    Pilih status baru untuk produk "<strong x-text="productToUpdateStatus.name"></strong>":
                </p>
                <form :action="`/managements/products/${productToUpdateStatus.slug}/status`" method="POST"
                    class="grid grid-cols-2 gap-4 mt-6">
                    @csrf
                    @method('PATCH')
                    <button type="submit" name="status" value="active"
                        :class="{ 'ring-2 ring-green-500 font-bold': productToUpdateStatus.status === 'active' }"
                        class="w-full px-4 py-3 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 dark:bg-green-800/50 dark:text-green-200 dark:hover:bg-green-600/50 transition-all duration-200">
                        Active
                    </button>
                    <button type="submit" name="status" value="inactive"
                        :class="{ 'ring-2 ring-red-500 font-bold': productToUpdateStatus.status === 'inactive' }"
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
    </div>
@endsection
