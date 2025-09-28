@extends('layouts.master')
@section('title', 'Input Fields untuk ' . $product->name)
@section('content')
    @include('partials.alert')
    <div class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)]"
        x-data="{
            viewInputFieldModal: false,
            deleteModal: false,
        
            inputFieldToView: {},
            inputFieldToDelete: {},
        
            openViewInputFieldModal(inputField) {
                this.inputFieldToView = inputField;
                this.viewInputFieldModal = true
            },
            openDeleteModal(inputField) {
                this.inputFieldToDelete = inputField;
                this.deleteModal = true
            } 
        }">
        {{-- Header with add input field button --}}
        <div class="border-b border-gray-200 dark:border-slate-600/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 pb-4" data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-white">Kelola Input Fields untuk: {{ $product->name }}
                </h2>
            </div>
            <a href="{{ route('managements.input-fields.create', $product) }}"
                class="blue-gradient-wh rounded-lg px-5 py-2.5 text-md text-white font-medium flex items-center justify-center gap-3 w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Tambah Field</span>
            </a>
        </div>

        {{-- Route back to list products --}}
        <a href="{{ route('managements.input-fields.productList') }}"
            class="text-sm font-medium text-blue-500 dark:text-blue-400 hover:underline flex items-center gap-2 whitespace-nowrap" data-aos="fade-up">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Kembali ke Daftar Produk</span>
        </a>

        {{-- Table of content for input fields --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg flex-1 overflow-y-auto mt-4" data-aos="fade-up">
            <table class="w-full text-md text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-slate-700 dark:text-slate-300 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 w-16">No</th>
                        <th class="px-6 py-3">Label</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Tipe</th>
                        <th class="px-6 py-3">Aturan Validasi</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($inputFields as $field)
                        <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700/50">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $field->field_label }}</td>
                            <td class="px-6 py-4 font-mono text-sm text-gray-500 dark:text-slate-400">
                                {{ $field->field_name }}</td>
                            <td class="px-6 py-4"><span
                                    class="violet-gradient text-white text-xs font-medium px-2.5 py-0.5 rounded">{{ $field->field_type }}</span>
                            </td>
                            <td class="px-6 py-4 font-mono text-sm text-gray-500 dark:text-slate-400">
                                {{ $field->validation_rules }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <button @click="openViewInputFieldModal({{ json_encode($field) }})"
                                        class="violet-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('managements.input-fields.edit', $field) }}"
                                        class="blue-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>
                                    <button @click="openDeleteModal({{ json_encode($field) }})"
                                        class="red-gradient-wh text-white rounded-lg p-2 hover:-translate-y-0.5 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500 dark:text-slate-400">Belum ada input
                                field untuk produk ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal for delete input fields --}}
        <div x-show="deleteModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="deleteModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="deleteModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Konfirmasi Hapus</h3>
                <p class="text-gray-600 dark:text-slate-300 mt-4">
                    Apakah Anda yakin ingin menghapus input field "<strong class="font-bold"
                        x-text="inputFieldToDelete.field_name"></strong>"?
                </p>
                <form :action="`/managements/input-fields/${inputFieldToDelete.slug}`" method="POST"
                    class="flex justify-end gap-4 mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="red-gradient-wh text-white rounded-lg px-4 py-2">Ya, Hapus</button>
                </form>
            </div>
        </div>

        {{-- Modal for view detail input fields --}}
        <div x-show="viewInputFieldModal" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50"></div>
        <div x-show="viewInputFieldModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="viewInputFieldModal = false"
                class="bg-white dark:bg-slate-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                <div class="p-4 border-b dark:border-slate-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white" x-text="inputFieldToView.field_label">
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-slate-400">
                            Produk: <span x-text="inputFieldToView.product.name"></span>
                        </p>
                    </div>
                    <button @click="viewInputFieldModal = false"
                        class="text-gray-500 hover:text-gray-800 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4 overflow-y-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Field Name</p>
                            <p class="text-gray-600 dark:text-slate-400" x-text="inputFieldToView.field_name"></p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Field Type</p>
                            <p class="text-gray-600 dark:text-slate-400" x-text="inputFieldToView.field_type"></p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Placeholder</p>
                            <p class="text-gray-600 dark:text-slate-400" x-text="inputFieldToView.placeholder ?? '-'"></p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Validation Rules</p>
                            <p class="text-gray-600 dark:text-slate-400" x-text="inputFieldToView.validation_rules"></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Deskripsi</p>
                        <p class="text-gray-600 dark:text-slate-400" x-text="inputFieldToView.field_desc"></p>
                    </div>
                    <template x-if="inputFieldToView.field_type === 'select' && inputFieldToView.field_options">
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Pilihan Options</p>
                            <ul class="list-disc list-inside text-gray-600 dark:text-slate-400">
                                <template x-for="opt in JSON.parse(inputFieldToView.field_options)" :key="opt">
                                    <li x-text="opt"></li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>
                <div class="p-4 border-t dark:border-slate-700 text-right">
                    <a :href="`/managements/input-fields/${inputFieldToView.id}/edit`"
                        class="blue-gradient-wh text-white rounded-lg px-4 py-2 font-semibold">
                        Edit Input Field Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
