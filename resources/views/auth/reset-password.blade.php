@extends('layouts.guest')

@section('title', 'Buat Password Baru')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50/60" x-data="{ showPass: false, showConfirm: false }">
    {{-- Ambient Background Glows --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Main Card --}}
    <div class="w-full max-w-md bg-white/95 backdrop-blur-2xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(30,41,59,0.12)] border border-slate-200/80 p-8 sm:p-10 relative z-10 transition-all">
        {{-- Top Accent Bar --}}
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-500 rounded-t-3xl"></div>

        {{-- Card Header & School Logo --}}
        <div class="text-center mb-6 pt-2">
            <div class="inline-flex p-3 bg-gradient-to-b from-white to-slate-50 rounded-2xl shadow-md border border-slate-100 ring-4 ring-blue-50/80 mb-4 transition-transform hover:scale-105 duration-300">
                <img src="{{ asset('images/logo.png') }}?v=4" alt="Logo SMK Swasta Dwitunggal 2 Tanjung Morawa" class="w-14 h-14 object-contain">
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">
                Buat Password Baru
            </h2>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Silakan buat kombinasi kata sandi baru yang aman dan mudah Anda ingat.
            </p>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="mb-6 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs leading-relaxed flex items-start gap-2">
                <svg class="w-4 h-4 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email Address --}}
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Alamat Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                    class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-600 cursor-not-allowed">
            </div>

            {{-- New Password --}}
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Password Baru
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <input id="password" :type="showPass ? 'text' : 'password'" name="password" required autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="block w-full pl-4 pr-11 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all">
                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <span x-show="!showPass" class="text-xs">👁️</span>
                        <span x-show="showPass" class="text-xs" style="display: none;">🔒</span>
                    </button>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Konfirmasi Password Baru
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Ketik ulang password baru"
                        class="block w-full pl-4 pr-11 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all">
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <span x-show="!showConfirm" class="text-xs">👁️</span>
                        <span x-show="showConfirm" class="text-xs" style="display: none;">🔒</span>
                    </button>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-2">
                <button type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transform active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Password Baru & Masuk</span>
                </button>
            </div>
        </form>

        {{-- Back to Login Link --}}
        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors">
                <span>← Batal & Kembali ke Halaman Masuk</span>
            </a>
        </div>
    </div>
</div>
@endsection
