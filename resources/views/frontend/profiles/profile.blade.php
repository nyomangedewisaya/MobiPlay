@extends('layouts.auth')
@section('title', 'Profil Saya')
@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1" data-aos="fade-up">
            <div class="bg-slate-800 rounded-lg shadow-xl p-8">
                <div class="text-center">
                    <img src="{{ Auth::user()->avatar ?? 'https://placehold.co/96x96/E2E8F0/475569?text=M' }}"
                        alt="{{ Auth::user()->name }}"
                        class="w-24 h-24 rounded-full mx-auto border-4 border-white dark:border-slate-600 shadow-lg">
                    <h3 class="mt-4 text-xl font-bold text-white">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-200">{{ Auth::user()->email }}</p>
                    <p class="text-xs text-gray-400 mt-2">Bergabung pada {{ Auth::user()->created_at->format('d F Y') }}</p>
                </div>
                <nav class="mt-6 space-y-2">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 rounded-lg transition-colors duration-200 {{ Request::is('profile') ? 'text-white blue-gradient' : 'text-gray-400 hover:bg-slate-600/50' }}">
                        Edit Profil
                    </a>
                    <a href="{{ route('profile.password.edit') }}"
                        class="block px-4 py-2 rounded-lg transition-colors duration-200 {{ Request::is('profile/password') ? 'text-white blue-gradient' : 'text-gray-400 hover:bg-slate-600/50' }}">
                        Ganti Password
                    </a>
                    <hr class="border-slate-600/50 !my-4">

                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors duration-200 text-gray-400 hover:hover:bg-slate-600/50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            <span>Kembali ke Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('home') }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors duration-200 text-gray-400 hover:hover:bg-slate-600/50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            <span>Kembali ke Beranda</span>
                        </a>
                    @endif
                </nav>
            </div>
        </div>
        <div class="lg:col-span-3">
            @include('partials.alert')
            @yield('profile-content')
        </div>
    </div>
@endsection
