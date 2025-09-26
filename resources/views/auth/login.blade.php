@extends('layouts.auth')
@section('title', 'Login Mobiplay')
@section('content')
    <div class="sm:w-full sm:max-w-lg sm:mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl text-white font-bold">Mobi<span class="text-blue-500">Play</span></h1>
            <p class="text-gray-500 mt-2">Top Up Aman dan Terpercaya</p>
        </div>
        <div class="bg-slate-800 rounded-lg shadow-xl p-8">
            <h2 class="text-2xl text-gray-200 font-semibold text-center mb-1">Selamat datang kembali</h2>
            <p class="text-gray-400 text-center mb-6">Masuk untuk melanjutkan</p>
            <form action="{{ route('login_action') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="text-sm font-medium text-gray-300">Email</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M2.003 5.884L10 2.5l7.997 3.384A2 2 0 0019.5 7.5v.5a2 2 0 01-2 2H2.5a2 2 0 01-2-2v-.5a2 2 0 001.503-1.616zM17.5 10.5h.008v5.5a2 2 0 01-2 2H4.5a2 2 0 01-2-2v-5.5h.008l.002-.001.002-.001.006-.002a1 1 0 01.983.985V15h12v-4.5a1 1 0 01.983-.985l.006.002.002.001.002.001z" />
                                </svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="youremail@gmail.com"
                                class="w-full bg-slate-600/50 border border-gray-600 text-gray-200 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="text-sm font-medium text-gray-300">Password</label>
                        <div x-data="{ show: false }" class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password" value="{{ old('password') }}"
                                placeholder="..........."
                                class="w-full bg-slate-600/50 border border-gray-600 text-gray-200 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            {{-- Toggle button for hide/show password --}}
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <!-- icon eye -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274
                        4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <!-- icon eye-off -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478
                        0-8.268-2.943-9.542-7a10.05 10.05 0 012.102-3.592m3.174-2.474A9.969
                        9.969 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.043
                        5.362M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-2">
                    <a href="#" class="text-sm text-blue-400 hover:underline">Lupa password?</a>
                </div>
                <button type="submit"
                    class="mt-6 w-full rounded-lg text-white font-semibold py-2.5 bg-gradient-to-r from-blue-700 via-blue-400 to-blue-700 shadow-[0_0_10px_rgba(59,130,246,0.7)] hover:shadow-[0_0_13px_rgba(59,130,246,0.9)] transition-all duration-300">Login</button>
            </form>
            <p class="text-center text-sm text-gray-400 mt-6">
                Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-blue-400 hove:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
@endsection
