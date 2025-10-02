@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div
        class="bg-white dark:bg-slate-700/50 rounded-l-xl dark:border-l dark:border-slate-700 shadow-xl px-6 py-4 flex flex-col h-[calc(100vh)] overflow-y-auto">
        <div class="border-b border-gray-200 dark:border-slate-600/50 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-4 pb-2 relative z-20"
            data-aos="fade-up">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-700 dark:text-white">Selamat datang, Admin</h1>
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <form action="{{ route('dashboard') }}" method="GET" class="w-full sm:w-auto">
                    <select name="year"
                        class="w-auto sm:w-full bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="this.form.submit()">
                        @forelse ($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>Tahun
                                {{ $year }}</option>
                        @empty
                            <option value="{{ date('Y') }}">Tahun {{ date('Y') }}</option>
                        @endforelse
                    </select>
                </form>
                <div x-data="{ dropdownOpen: false }" class="relative hidden lg:inline-flex">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-3">
                        <p class="text-gray-700 dark:text-white font-medium">{{ Auth::user()->name }}</p>
                        <img src="{{ Auth::user()->avatar ?? 'https://placehold.co/96x96/E2E8F0/475569?text=M' }}"
                            alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full mx-auto">
                    </button>
                    <div x-show="dropdownOpen" @click.outside="dropdownOpen = false" x-transition x-cloak
                        class="absolute top-full right-0 mt-2 w-48 bg-white dark:bg-slate-700 rounded-lg shadow-xl border dark:border-slate-600 py-1 z-50">
                        <button type="button" @click="profileModal = true; mobileDropdownOpen = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600">Profil</button>
                        <button type="button" @click="logoutModal = true; mobileDropdownOpen = false"
                            class="w-full text-left block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-slate-600">Logout</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid untuk stats card --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up">
            {{-- Card 1: Products --}}
            <div
                class="bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700 flex flex-col justify-between cursor-pointer hover:-translate-y-1 transition-transform duration-300">
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-slate-400">Produk Aktif</h3>
                        <div class="text-blue-500 bg-blue-100 dark:bg-blue-900/50 p-2 rounded-full"><svg class="size-6"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg></div>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-800 dark:text-white" x-data="countUp({{ $productStats['active'] }})"
                        x-text="Math.round(currentValue).toLocaleString()"></div>
                    <p class="text-xs text-gray-500 dark:text-slate-400">{{ $productStats['active'] }} dari
                        {{ $productStats['total'] }} produk</p>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $productStats['percentage'] }}%;"></div>
                    </div>
                    <p class="text-right text-xs mt-1 font-semibold text-blue-500">{{ $productStats['percentage'] }}%</p>
                </div>
            </div>

            {{-- Card 2: Items --}}
            <div
                class="bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700 flex flex-col justify-between cursor-pointer hover:-translate-y-1 transition-transform duration-300">
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-slate-400">Item Aktif</h3>
                        <div class="text-violet-500 bg-violet-100 dark:bg-violet-900/50 p-2 rounded-full"><svg
                                class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
                            </svg></div>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-800 dark:text-white" x-data="countUp({{ $itemStats['active'] }})"
                        x-text="Math.round(currentValue).toLocaleString()"></div>
                    <p class="text-xs text-gray-500 dark:text-slate-400">{{ $itemStats['active'] }} dari
                        {{ $itemStats['total'] }} item</p>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                        <div class="bg-violet-500 h-2 rounded-full" style="width: {{ $itemStats['percentage'] }}%;"></div>
                    </div>
                    <p class="text-right text-xs mt-1 font-semibold text-violet-500">{{ $itemStats['percentage'] }}%</p>
                </div>
            </div>

            {{-- Card 3: Success orders --}}
            <div
                class="bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700 flex flex-col justify-between cursor-pointer hover:-translate-y-1 transition-transform duration-300">
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-slate-400">Transaksi Sukses (Bulan Ini)</h3>
                        <div class="text-green-500 bg-green-100 dark:bg-green-900/50 p-2 rounded-full"><svg class="size-6"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                            </svg></div>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-800 dark:text-white" x-data="countUp({{ $orderStats['count'] }})"
                        x-text="Math.round(currentValue).toLocaleString()"></div>
                </div>
                <div class="mt-4">
                    <p
                        class="text-xs flex items-center gap-1 {{ $orderStats['percentageChange'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        @if ($orderStats['percentageChange'] >= 0)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.28 9.68a.75.75 0 0 1-1.06-1.06l5.25-5.25a.75.75 0 0 1 1.06 0l5.25 5.25a.75.75 0 1 1-1.06 1.06L10.75 5.612V16.25A.75.75 0 0 1 10 17z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>+{{ $orderStats['percentageChange'] }}%</span>
                        @else
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a.75.75 0 0 1 .75.75v10.638l3.97-3.968a.75.75 0 1 1 1.06 1.06l-5.25 5.25a.75.75 0 0 1-1.06 0l-5.25-5.25a.75.75 0 1 1 1.06-1.06l3.97 3.968V3.75A.75.75 0 0 1 10 3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $orderStats['percentageChange'] }}%</span>
                        @endif
                        dari bulan lalu
                    </p>
                </div>
            </div>

            {{-- Card 4: Revenue --}}
            <div
                class="bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700 flex flex-col justify-between cursor-pointer hover:-translate-y-1 transition-transform duration-300">
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-slate-400">Pendapatan (Bulan Ini)</h3>
                        <div class="text-amber-500 bg-amber-100 dark:bg-amber-900/50 p-2 rounded-full"><svg class="size-6"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg></div>
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-800 dark:text-white" x-data="countUp({{ $revenueStats['total'] }}, 1, 'Rp ')"
                        x-text="prefix + Math.round(currentValue).toLocaleString('id-ID')"></div>
                </div>
                <div class="mt-4">
                    <p
                        class="text-xs flex items-center gap-1 {{ $revenueStats['percentageChange'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        @if ($revenueStats['percentageChange'] >= 0)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.28 9.68a.75.75 0 0 1-1.06-1.06l5.25-5.25a.75.75 0 0 1 1.06 0l5.25 5.25a.75.75 0 1 1-1.06 1.06L10.75 5.612V16.25A.75.75 0 0 1 10 17z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>+{{ $revenueStats['percentageChange'] }}%</span>
                        @else
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a.75.75 0 0 1 .75.75v10.638l3.97-3.968a.75.75 0 1 1 1.06 1.06l-5.25 5.25a.75.75 0 0 1-1.06 0l-5.25-5.25a.75.75 0 1 1 1.06-1.06l3.97 3.968V3.75A.75.75 0 0 1 10 3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $revenueStats['percentageChange'] }}%</span>
                        @endif
                        dari bulan lalu
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-between pt-6" data-aos="fade-up">
            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6"
                x-data='chartsComponent(@json($lineChartData), @json($doughnutChartData))'
                x-init="initCharts()" @dark-mode-toggled.window="updateChartColors($event.detail.isDark)">
                <div
                    class="lg:col-span-2 bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Laporan Bulanan ({{ $selectedYear }})</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Pendapatan vs Jumlah Pesanan Sukses</p>
                    <div class="mt-4 h-72"><canvas id="monthlyReportChart"></canvas></div>
                </div>
                <div class="bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Distribusi Status Pesanan</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Total pesanan di tahun {{ $selectedYear }}</p>
                    <div class="mt-4 h-72 flex items-center justify-center"><canvas id="orderStatusChart"></canvas></div>
                </div>
            </div>

            {{-- Popular products dan best selling items card --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <div
                    class="bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700 cursor-pointer hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="size-6 text-gray-700 dark:text-slate-200" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-3.152a.563.563 0 00-.652 0l-4.725 3.152a.562.562 0 01-.84-.61l1.285-5.385a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Produk Terpopuler
                            ({{ $selectedYear }})
                        </h3>
                    </div>
                    <div class="space-y-4">
                        @forelse ($popularProducts as $product)
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <span
                                        class="text-lg font-bold text-gray-400 dark:text-slate-500 w-5 text-center">{{ $loop->iteration }}</span>
                                    <img src="{{ asset($product->thumbnail_url) }}" alt="{{ $product->name }}"
                                        class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-800 dark:text-white truncate">
                                            {{ $product->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $product->total_orders }}
                                            pesanan sukses</p>
                                    </div>
                                </div>
                                <a href="{{ route('managements.products.edit', $product) }}"
                                    class="p-2 rounded-lg text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <p class="text-sm text-center py-4 text-gray-500 dark:text-slate-400">Data tidak cukup untuk
                                menampilkan produk terpopuler.</p>
                        @endforelse
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-900/40 p-6 rounded-lg shadow-md border dark:border-slate-700 cursor-pointer hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <svg class="size-6 text-gray-700 dark:text-slate-200" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Item Terlaris ({{ $selectedYear }})
                        </h3>
                    </div>
                    <div class="space-y-4">
                        @forelse ($bestSellingItems as $item)
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <span
                                        class="text-lg font-bold text-gray-400 dark:text-slate-500 w-5 text-center">{{ $loop->iteration }}</span>
                                    <img src="{{ asset($item->image_url ?? 'https://placehold.co/48x48/E2E8F0/475569?text=M') }}"
                                        alt="{{ $item->name }}"
                                        class="w-12 h-12 object-cover rounded-md flex-shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-800 dark:text-white truncate">
                                            {{ $item->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400">Dibeli sebanyak
                                            {{ $item->total_sales_count }} kali</p>
                                    </div>
                                </div>
                                @if ($item->product)
                                    <a href="{{ route('managements.items.index', $item->product) }}"
                                        title="Lihat Item Produk"
                                        class="p-2 rounded-lg text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-center py-4 text-gray-500 dark:text-slate-400">Data tidak cukup untuk
                                menampilkan item terlaris.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- Script JS --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countUp', (target, duration = 2, prefix = '') => ({
                currentValue: 0,
                targetValue: target,
                duration: duration * 1000,
                prefix: prefix,
                init() {
                    if (isNaN(this.targetValue)) {
                        this.targetValue = 0;
                    }
                    let start = 0;
                    const increment = this.targetValue / (this.duration / 16);
                    const updateCounter = () => {
                        start += increment;
                        if (start < this.targetValue) {
                            this.currentValue = Math.ceil(start);
                            requestAnimationFrame(updateCounter);
                        } else {
                            this.currentValue = this.targetValue;
                        }
                    };
                    updateCounter();
                }
            }));
        });

        function chartsComponent(lineData, doughnutData) {
            return {
                lineChart: null,
                doughnutChart: null,
                initCharts() {
                    Chart.register(ChartDataLabels);
                    const isDark = document.documentElement.classList.contains('dark');

                    const monthlyReportCtx = document.getElementById('monthlyReportChart')?.getContext('2d');
                    if (monthlyReportCtx) {
                        this.lineChart = new Chart(monthlyReportCtx, {
                            type: 'line',
                            data: {
                                labels: lineData.labels,
                                datasets: [{
                                        label: 'Pendapatan (Rp)',
                                        data: lineData.revenues,
                                        borderColor: 'rgba(96, 165, 250, 1)',
                                        backgroundColor: 'rgba(96, 165, 250, 0.2)',
                                        fill: true,
                                        tension: 0.4,
                                        yAxisID: 'yRevenue'
                                    },
                                    {
                                        label: 'Pesanan Sukses',
                                        data: lineData.orders,
                                        borderColor: 'rgba(167, 139, 250, 1)',
                                        backgroundColor: 'rgba(167, 139, 250, 0.2)',
                                        fill: true,
                                        tension: 0.4,
                                        yAxisID: 'yOrders'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                interaction: {
                                    mode: 'index',
                                    intersect: false
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            color: isDark ? '#e2e8f0' : '#475569'
                                        },
                                        grid: {
                                            color: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                        }
                                    },
                                    yRevenue: {
                                        type: 'linear',
                                        position: 'left',
                                        ticks: {
                                            color: 'rgba(96, 165, 250, 1)',
                                            callback: value => {
                                                if (value >= 1e6) return `Rp ${value / 1e6} Jt`;
                                                if (value >= 1e3) return `Rp ${value / 1e3} Rb`;
                                                return `Rp ${value}`;
                                            }
                                        },
                                        grid: {
                                            color: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                        }
                                    },
                                    yOrders: {
                                        type: 'linear',
                                        position: 'right',
                                        grid: {
                                            drawOnChartArea: false
                                        },
                                        ticks: {
                                            color: 'rgba(167, 139, 250, 1)',
                                            stepSize: 1
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: isDark ? '#e2e8f0' : '#475569'
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: context =>
                                                `${context.dataset.label}: ${context.dataset.yAxisID === 'yRevenue' ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.raw) : context.raw}`
                                        }
                                    }
                                }
                            }
                        });
                    }

                    const orderStatusCtx = document.getElementById('orderStatusChart')?.getContext('2d');
                    if (orderStatusCtx && doughnutData.labels.length > 0) {
                        this.doughnutChart = new Chart(orderStatusCtx, {
                            type: 'doughnut',
                            data: {
                                labels: doughnutData.labels,
                                datasets: [{
                                    data: doughnutData.counts,
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 0.9)', 
                                        'rgba(239, 68, 68, 0.9)', 
                                        'rgba(251, 191, 36, 0.9)', 
                                    ],
                                    borderColor: isDark ? '#1f2937' : '#ffffff',
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: isDark ? '#e2e8f0' : '#334155',
                                            boxWidth: 12,
                                            padding: 20
                                        }
                                    },
                                    datalabels: {
                                        formatter: (value, ctx) => {
                                            let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b,
                                            0);
                                            if (sum === 0) return '0%';
                                            return `${(value * 100 / sum).toFixed(1)}%`;
                                        },
                                        color: '#ffffff',
                                        font: {
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        });
                    }
                },
                updateChartColors(isDark) {
                    if (this.lineChart) {
                        this.lineChart.options.scales.x.ticks.color = isDark ? '#e2e8f0' : '#475569';
                        this.lineChart.options.plugins.legend.labels.color = isDark ? '#e2e8f0' : '#334155';
                        this.lineChart.options.scales.x.grid.color = isDark ? 'rgba(255, 255, 255, 0.1)' :
                            'rgba(0, 0, 0, 0.1)';
                        this.lineChart.options.scales.yRevenue.grid.color = isDark ? 'rgba(255, 255, 255, 0.1)' :
                            'rgba(0, 0, 0, 0.1)';
                        this.lineChart.update('none');
                    }

                    if (this.doughnutChart) {
                        this.doughnutChart.data.datasets[0].borderColor = isDark ? '#1f2937' : '#ffffff';
                        this.doughnutChart.options.plugins.legend.labels.color = isDark ? '#e2e8f0' : '#334155';
                        this.doughnutChart.update('none');
                    }
                }
            }
        }
    </script>
@endsection
