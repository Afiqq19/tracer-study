@extends('layouts.guest')

@section('title', 'Menunggu Verifikasi')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50/60">
    {{-- Ambient Background Glows --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Subtle Grid Pattern --}}
    <svg class="absolute inset-0 h-full w-full opacity-40 pointer-events-none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="menunggu-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                <path d="M0 32V0h32" fill="none" stroke="#6366f1" stroke-opacity="0.06" stroke-width="1"></path>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#menunggu-grid)"></rect>
    </svg>

    <div class="max-w-md w-full bg-white/95 backdrop-blur-2xl rounded-3xl border border-slate-200/80 shadow-[0_20px_60px_-15px_rgba(30,41,59,0.12)] p-8 sm:p-10 text-center relative z-10">
        {{-- Top Accent Gradient Bar --}}
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 rounded-t-3xl"></div>

        @if(request()->has('verified') || session('verified'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-left flex items-start gap-3 shadow-xs">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 text-green-600 font-bold mt-0.5">
                    ✓
                </div>
                <div>
                    <h4 class="text-sm font-bold text-green-900">Email Berhasil Diverifikasi!</h4>
                    <p class="text-xs text-green-700 mt-0.5 leading-relaxed">Alamat email Anda telah aktif. Saat ini akun Anda sedang menunggu persetujuan dari Administrator sekolah.</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="w-16 h-16 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-3xl mx-auto mb-5 shadow-xs ring-4 ring-red-50/50">
                ❌
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 mb-2">Registrasi Ditolak</h2>
            <p class="text-xs sm:text-sm text-slate-600 mb-6 leading-relaxed">{{ session('error') }}</p>
        @else
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-3xl mx-auto mb-5 shadow-xs ring-4 ring-indigo-50/50 animate-pulse">
                ⏳
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 mb-3 shadow-xs">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                Status: Menunggu Persetujuan
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Menunggu Verifikasi</h2>
            <p class="text-xs sm:text-sm text-slate-600 mb-6 leading-relaxed">
                Akun Anda sedang ditinjau oleh pihak sekolah. Anda akan menerima notifikasi email setelah pendaftaran Anda disetujui.
            </p>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors cursor-pointer">
                    Keluar / Ganti Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
