@extends('layouts.guest')

@section('title', 'Tautan Kedaluwarsa')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-slate-50/60">
    <div class="w-full max-w-md bg-white/95 backdrop-blur-2xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(30,41,59,0.12)] border border-slate-200/80 p-8 sm:p-10 relative z-10 text-center">
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-amber-500 via-rose-500 to-amber-500 rounded-t-3xl"></div>

        <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-5 text-2xl shadow-sm">
            ⏳
        </div>

        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">
            Tautan Telah Kedaluwarsa
        </h2>

        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
            Demi keamanan akun Anda, tautan verifikasi ini hanya berlaku selama <strong>10 menit</strong> dan kini sudah tidak dapat digunakan.
        </p>

        <div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 text-xs text-amber-800 mb-6 text-left leading-relaxed">
            <strong>Solusi:</strong> Silakan login ke akun Anda, lalu klik tombol <em>"Kirim Ulang Tautan Verifikasi"</em> untuk mendapatkan tautan baru.
        </div>

        <a href="{{ route('login') }}" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/25 transition-all inline-flex items-center justify-center gap-2">
            <span>Masuk & Kirim Ulang Verifikasi</span>
            <span>&rarr;</span>
        </a>

        <div class="mt-6">
            <a href="{{ route('landing') }}" class="text-xs text-slate-500 hover:text-slate-700 font-semibold">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
