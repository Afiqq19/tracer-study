@extends('layouts.alumni')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('alumni.pengumuman.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-1">
            <span>←</span> Kembali ke Daftar Pengumuman
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 md:p-10">
            <div class="flex items-center gap-3 mb-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-medium">📢 Informasi</span>
                <span class="text-sm text-gray-500 font-medium flex items-center gap-1">
                    <span>📅</span> {{ $pengumuman->published_at->format('d F Y, H:i') }} WIB
                </span>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8 leading-tight">{{ $pengumuman->judul }}</h1>

            <div class="prose prose-indigo max-w-none text-gray-700 leading-relaxed space-y-4">
                {!! nl2br(e($pengumuman->isi)) !!}
            </div>
            
            <div class="mt-10 pt-6 border-t border-gray-100 flex items-center gap-3 text-sm text-gray-500">
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                    {{ substr($pengumuman->penulis->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="font-medium text-gray-900">Dipublikasikan oleh:</p>
                    <p>{{ $pengumuman->penulis->name ?? 'Admin Sekolah' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
