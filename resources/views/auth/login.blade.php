@extends('layouts.guest')

@section('title', 'Masuk ke Akun')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50/60">
    {{-- Ambient Background Glows --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Subtle Grid Pattern --}}
    <svg class="absolute inset-0 h-full w-full opacity-40 pointer-events-none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="login-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                <path d="M0 32V0h32" fill="none" stroke="#6366f1" stroke-opacity="0.06" stroke-width="1"></path>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#login-grid)"></rect>
    </svg>

    {{-- Main Login Card --}}
    <div class="w-full max-w-md bg-white/95 backdrop-blur-2xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(30,41,59,0.12)] border border-slate-200/80 p-8 sm:p-10 relative z-10 transition-all">
        {{-- Top Accent Gradient Bar --}}
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 rounded-t-3xl"></div>

        {{-- Card Header & School Logo --}}
        <div class="text-center mb-8 pt-2">
            <div class="inline-flex p-2 bg-white rounded-full shadow-lg shadow-indigo-500/10 border border-slate-100 ring-4 ring-indigo-50/80 mb-4 transition-transform hover:scale-105 duration-300 w-20 h-20 items-center justify-center overflow-hidden">
                <img src="{{ asset('images/logo.png') }}?v=6" alt="Logo SMK Swasta Dwitunggal 2 Tanjung Morawa" class="w-full h-full object-cover rounded-full">
            </div>

            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-2 shadow-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                    Portal Tracer Study
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">SMK Swasta Dwitunggal 2 Tanjung Morawa</p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-xs text-green-700 font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700 font-medium flex items-start gap-2">
                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Kolom Email --}}
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="w-full pl-11 pr-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-xs @error('email') border-red-500 @enderror" 
                        placeholder="nama@email.com">
                </div>
            </div>

            {{-- Kolom Kata Sandi --}}
            <div x-data="{ show: false }">
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Kata Sandi
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                            Lupa sandi?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input id="password" :type="show ? 'text' : 'password'" name="password" required 
                        class="w-full pl-11 pr-11 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-xs @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    
                    {{-- Toggle Show/Hide Password Eye Button --}}
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="show" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition">
                    <span class="text-xs text-slate-600">Ingat sesi saya di perangkat ini</span>
                </label>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" 
                class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer">
                <span>Masuk ke Akun</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>

            {{-- Pembatas --}}
            <div class="relative my-6 flex items-center justify-center">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-xs text-slate-400 uppercase tracking-wider font-semibold relative z-10">atau</span>
            </div>

            {{-- Link Daftar Alumni --}}
            <a href="{{ route('register') }}" 
                class="w-full py-3 px-4 rounded-xl border border-slate-200 hover:border-indigo-300 bg-slate-50/50 hover:bg-indigo-50/40 text-slate-700 hover:text-indigo-700 font-semibold text-sm transition-all duration-200 flex items-center justify-center gap-1.5 text-center group">
                <span>Belum punya akun?</span>
                <span class="text-indigo-600 font-bold group-hover:underline">Daftar sekarang &rarr;</span>
            </a>
        </form>

        {{-- Footer Info --}}
        <div class="mt-8 pt-4 border-t border-slate-100 text-center">
            <p class="text-[11px] text-slate-400 flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>Akses aman terenkripsi untuk Alumni & Admin</span>
            </p>
        </div>
    </div>
</div>
@endsection
