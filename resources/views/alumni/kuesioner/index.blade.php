@extends('layouts.alumni')

@section('title', 'Kuesioner Tracer Study')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{ 
    activeTab: '{{ $activeTab ?? 'aktif' }}'
}">

    {{-- Section Header --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Kuesioner Tracer Study</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Survei pelacakan jejak alumni untuk peningkatan mutu kurikulum dan akreditasi sekolah.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-indigo-50/60 rounded-xl border border-indigo-100/60 text-center">
                <span class="text-[11px] font-semibold text-indigo-400 block uppercase tracking-wider">Perlu Diisi</span>
                <span class="text-base font-extrabold text-indigo-700">{{ $kuesionerAktif->count() }} Kuesioner</span>
            </div>
            <div class="px-4 py-2 bg-emerald-50/60 rounded-xl border border-emerald-100/60 text-center">
                <span class="text-[11px] font-semibold text-emerald-500 block uppercase tracking-wider">Telah Diisi</span>
                <span class="text-base font-extrabold text-emerald-700">{{ $riwayatPengisian->count() }} Riwayat</span>
            </div>
        </div>
    </div>

    {{-- Unified Navigation Tabs --}}
    <div class="bg-white rounded-2xl p-1.5 shadow-xs border border-slate-100 flex items-center gap-1.5">
        <button type="button" @click="activeTab = 'aktif'"
            class="flex-1 py-3 px-4 rounded-xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2"
            :class="activeTab === 'aktif' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
            <span class="text-base">📋</span>
            <span>Kuesioner Aktif</span>
            <span class="ml-1 px-2 py-0.5 text-xs rounded-full"
                :class="activeTab === 'aktif' ? 'bg-white/20 text-white font-bold' : 'bg-indigo-100 text-indigo-700 font-bold'">
                {{ $kuesionerAktif->count() }}
            </span>
        </button>

        <button type="button" @click="activeTab = 'riwayat'"
            class="flex-1 py-3 px-4 rounded-xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2"
            :class="activeTab === 'riwayat' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
            <span class="text-base">📜</span>
            <span>Riwayat Pengisian</span>
            <span class="ml-1 px-2 py-0.5 text-xs rounded-full"
                :class="activeTab === 'riwayat' ? 'bg-white/20 text-white font-bold' : 'bg-slate-100 text-slate-700 font-bold'">
                {{ $riwayatPengisian->count() }}
            </span>
        </button>
    </div>

    {{-- TAB 1: KUESIONER AKTIF --}}
    <div x-show="activeTab === 'aktif'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
        @if($kuesionerAktif->isEmpty())
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl shadow-xs">
                    🎉
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-1">Semua Kuesioner Telah Diisi!</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-6">
                    Luar biasa! Tidak ada kuesioner aktif yang menunggu respon dari Anda saat ini. Terima kasih atas partisipasi Anda dalam Tracer Study.
                </p>
                <button type="button" @click="activeTab = 'riwayat'" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition cursor-pointer inline-flex items-center gap-1.5">
                    <span>Lihat Riwayat Pengisian Saya</span>
                    <span>&rarr;</span>
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($kuesionerAktif as $item)
                    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 hover:border-indigo-300 hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden relative group">
                        {{-- Top Accent Line --}}
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500"></div>

                        <div class="p-6 sm:p-7 flex-1">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold tracking-wider uppercase bg-amber-50 text-amber-700 border border-amber-200">
                                    ⭐ Wajib Diisi
                                </span>
                                <span class="text-xs font-semibold text-slate-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Batas: {{ $item->tanggal_selesai->format('d M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-indigo-600 transition leading-snug mb-2">
                                {{ $item->judul }}
                            </h3>

                            <p class="text-xs sm:text-sm text-slate-600 line-clamp-3 mb-5 leading-relaxed">
                                {{ $item->deskripsi }}
                            </p>

                            <div class="flex items-center gap-4 text-xs font-medium text-slate-400 pt-3 border-t border-slate-100">
                                <span class="flex items-center gap-1.5">
                                    <span>📅</span>
                                    <span>Mulai: {{ $item->tanggal_mulai->format('d M Y') }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="p-4 sm:px-7 sm:pb-6 bg-slate-50/60 border-t border-slate-100">
                            <a href="{{ route('alumni.kuesioner.show', $item->id) }}"
                                class="w-full py-3 px-5 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 transition flex items-center justify-center gap-2">
                                <span>Mulai Mengisi Kuesioner</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- TAB 2: RIWAYAT PENGISIAN KUESIONER --}}
    <div x-show="activeTab === 'riwayat'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
        @if($riwayatPengisian->isEmpty())
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl shadow-xs">
                    📝
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-1">Belum Ada Riwayat Pengisian</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-6">
                    Anda belum pernah mengisi atau mensubmit kuesioner tracer study. Silakan cek kuesioner aktif yang tersedia untuk memulai.
                </p>
                <button type="button" @click="activeTab = 'aktif'" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-sm transition cursor-pointer inline-flex items-center gap-1.5">
                    <span>Lihat Kuesioner Aktif</span>
                    <span>&rarr;</span>
                </button>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 sm:p-8 space-y-4">
                <div class="pb-3 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h4 class="text-base font-extrabold text-slate-900">Daftar Kuesioner yang Telah Anda Selesaikan</h4>
                        <p class="text-xs text-slate-500">Terima kasih atas kontribusi Anda dalam pengisian data tracer study.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($riwayatPengisian as $item)
                        <div class="p-5 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start sm:items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center text-xl shrink-0 shadow-2xs">
                                    ✓
                                </div>
                                <div>
                                    <h5 class="text-base font-extrabold text-slate-900 mb-1">
                                        {{ $item->kuesioner->judul ?? 'Kuesioner Tracer Study' }}
                                    </h5>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                        <span class="flex items-center gap-1 font-medium text-slate-600">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Disubmit pada: <strong class="text-slate-800">{{ $item->created_at->format('d M Y, H:i') }} WIB</strong>
                                        </span>
                                        @if($item->jawaban && $item->jawaban->count() > 0)
                                            <span>•</span>
                                            <span class="text-indigo-600 font-semibold">{{ $item->jawaban->count() }} Pertanyaan Dijawab</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center sm:self-center self-start">
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    Selesai Diisi
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
