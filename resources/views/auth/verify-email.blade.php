@extends('layouts.guest')

@section('title', 'Verifikasi Alamat Email')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50/60">
    {{-- Ambient Background Glows --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Subtle Grid Pattern --}}
    <svg class="absolute inset-0 h-full w-full opacity-40 pointer-events-none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="verify-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                <path d="M0 32V0h32" fill="none" stroke="#6366f1" stroke-opacity="0.06" stroke-width="1"></path>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#verify-grid)"></rect>
    </svg>

    <div class="max-w-md w-full bg-white/95 backdrop-blur-2xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(30,41,59,0.12)] border border-slate-200/80 p-8 sm:p-10 text-center relative z-10">
        {{-- Top Accent Gradient Bar --}}
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 rounded-t-3xl"></div>

        {{-- Ikon Amplop / Email --}}
        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-indigo-50 to-blue-50 text-indigo-600 rounded-3xl flex items-center justify-center mb-6 shadow-sm border border-indigo-100 ring-4 ring-indigo-50/60">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-3 shadow-xs">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
            Verifikasi Email
        </span>

        <h2 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Periksa Email Anda</h2>
        
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
            Terima kasih telah mendaftar! Tautan (link) verifikasi telah kami kirimkan ke:
        </p>

        <div class="inline-block px-4 py-2 bg-indigo-50/80 border border-indigo-100 rounded-xl text-indigo-700 font-bold text-sm mb-6">
            {{ auth()->user()->email ?? 'email Anda' }}
        </div>

        <p class="text-xs text-slate-500 mb-8 leading-relaxed">
            Silakan buka email Anda (cek juga folder <em>Spam</em> jika tidak ada di kotak masuk), lalu klik tombol <strong>Verifikasi Alamat Email</strong> di dalam pesan. Tidak perlu repot mengetik kode OTP!
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-xs text-green-700 font-medium text-left">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Tautan verifikasi baru telah berhasil dikirimkan ke email Anda!</span>
            </div>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-3.5 px-6 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/35 hover:-translate-y-0.5 active:translate-y-0 focus:ring-4 focus:ring-indigo-500/20 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Kirim Ulang Tautan Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-xs transition-colors cursor-pointer">
                    Keluar / Ganti Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
