@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')
{{-- Hero Section --}}
<section class="relative bg-slate-50/60 pt-20 pb-20 lg:pt-28 lg:pb-32 overflow-hidden">
    {{-- Ambient Background Glows --}}
    <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -right-40 w-[500px] h-[500px] bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 left-1/3 w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Subtle Grid Pattern --}}
    <svg class="absolute inset-0 h-full w-full opacity-40 pointer-events-none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="hero-grid" width="36" height="36" patternUnits="userSpaceOnUse">
                <path d="M0 36V0h36" fill="none" stroke="#6366f1" stroke-opacity="0.07" stroke-width="1"></path>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#hero-grid)"></rect>
    </svg>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        {{-- Logo Sekolah dengan Efek Elevated Glow --}}
        <div class="inline-flex p-4 bg-white/95 backdrop-blur-md rounded-3xl shadow-xl shadow-indigo-500/10 border border-slate-200/80 ring-8 ring-indigo-50/70 mb-8 transition-transform hover:scale-105 duration-300">
            <img src="{{ asset('images/logo.png') }}?v=3" alt="Logo SMK Swasta Dwitunggal 2 Tanjung Morawa" class="w-20 h-20 sm:w-24 sm:h-24 object-contain">
        </div>

        {{-- Badge Status --}}
        <div>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/90 backdrop-blur-md border border-indigo-100 shadow-xs text-indigo-700 text-xs sm:text-sm font-semibold mb-6">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span>Portal Tracer Study Resmi &bull; SMK Swasta Dwitunggal 2 Tanjung Morawa</span>
            </div>
        </div>

        {{-- Main Headline --}}
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-slate-900 tracking-tight leading-[1.15] mb-6">
            Jejak Karir Gemilang <br class="hidden sm:inline">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600">Alumni Dwitunggal 2 Tanjung Morawa</span>
        </h1>

        {{-- Subtitle --}}
        <p class="text-base sm:text-xl text-slate-600 max-w-3xl mx-auto mb-10 leading-relaxed font-normal">
            Sistem pelacakan karir terpadu untuk memetakan keterserapan kerja, mengukur relevansi pendidikan vokasi dengan industri, serta mempererat jejaring antar alumni SMK Swasta Dwitunggal 2 Tanjung Morawa.
        </p>

        {{-- Tombol Aksi Utama --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
            <a href="{{ route('login') }}" 
                class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white rounded-2xl font-bold text-base shadow-xl shadow-indigo-600/25 hover:shadow-indigo-600/35 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 group cursor-pointer">
                <span>Mulai Kuesioner</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
            <a href="{{ route('register') }}" 
                class="w-full sm:w-auto px-8 py-4 bg-white/95 hover:bg-slate-50 text-slate-800 hover:text-indigo-700 border border-slate-200 hover:border-indigo-300 rounded-2xl font-bold text-base shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>Daftar Akun Alumni</span>
            </a>
        </div>

        {{-- Baris Keunggulan / Trust Highlights --}}
        <div class="mt-14 pt-8 border-t border-slate-200/70 max-w-3xl mx-auto flex flex-wrap justify-center items-center gap-6 sm:gap-10 text-xs sm:text-sm text-slate-500 font-medium">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Terintegrasi Database Sekolah
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Verifikasi Cepat Tanpa OTP Rumit
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Laporan Akurat & Terenkripsi
            </span>
        </div>
    </div>
</section>

{{-- Statistik Section --}}
<section id="statistik" class="py-16 sm:py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-3">
                📊 Data & Partisipasi
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Statistik Tracer Study</h2>
            <p class="text-slate-500 text-sm sm:text-base mt-2">Gambaran terkini partisipasi alumni SMK Swasta Dwitunggal 2 Tanjung Morawa dalam pengisian kuesioner.</p>
        </div>

        {{-- 3 Elevated Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Card 1: Total Alumni --}}
            <div class="bg-gradient-to-b from-white to-slate-50/60 rounded-3xl p-8 border border-slate-200/80 shadow-[0_10px_30px_-10px_rgba(30,41,59,0.06)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                        Total Master
                    </span>
                </div>
                <h3 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight mb-2">{{ number_format($totalAlumni) }}</h3>
                <p class="text-sm font-bold text-slate-700">Alumni Terdaftar</p>
                <p class="text-xs text-slate-400 mt-1">Data lulusan yang tercatat di pangkalan data sekolah.</p>
            </div>

            {{-- Card 2: Sudah Mengisi --}}
            <div class="bg-gradient-to-b from-white to-slate-50/60 rounded-3xl p-8 border border-slate-200/80 shadow-[0_10px_30px_-10px_rgba(30,41,59,0.06)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                        Berpartisipasi
                    </span>
                </div>
                <h3 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight mb-2">{{ number_format($sudahMengisi) }}</h3>
                <p class="text-sm font-bold text-slate-700">Kuesioner Terisi</p>
                <p class="text-xs text-slate-400 mt-1">Alumni yang telah melengkapi survei karir.</p>
            </div>

            {{-- Card 3: Persentase --}}
            <div class="bg-gradient-to-b from-white to-slate-50/60 rounded-3xl p-8 border border-slate-200/80 shadow-[0_10px_30px_-10px_rgba(30,41,59,0.06)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                        Rasio Respon
                    </span>
                </div>
                <h3 class="text-4xl sm:text-5xl font-black text-indigo-600 tracking-tight mb-2">{{ $persentase }}%</h3>
                <p class="text-sm font-bold text-slate-700">Tingkat Partisipasi</p>
                <div class="w-full bg-slate-100 h-2.5 rounded-full mt-3 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-1000" style="width: {{ min(100, max(5, $persentase)) }}%"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Tentang Section --}}
<section id="tentang" class="py-20 sm:py-28 bg-slate-50/70 border-t border-slate-200/80 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-3">
                🎯 Nilai & Manfaat
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Mengapa Partisipasi Anda Begitu Berarti?</h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Tracer study bukan sekadar survei administratif biasa, melainkan jembatan emas yang menghubungkan capaian alumni dengan masa depan almamater dan adik-adik kelas Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Fitur 1 --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-1.5 border border-slate-200/80 transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 shadow-xs border border-indigo-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Analisis Keterserapan DUDI</h3>
                <p class="text-slate-600 leading-relaxed text-sm">
                    Mengukur seberapa cepat dan relevan lulusan kami terserap di Dunia Usaha, Dunia Industri, maupun melanjutkan ke jenjang perguruan tinggi.
                </p>
            </div>

            {{-- Fitur 2 --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-1.5 border border-slate-200/80 transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6 shadow-xs border border-purple-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Penyelarasan Kurikulum Vokasi</h3>
                <p class="text-slate-600 leading-relaxed text-sm">
                    Feedback alumni menjadi bahan evaluasi agar materi pembelajaran kejuruan di sekolah selalu sesuai dengan perkembangan teknologi dan standar industri modern.
                </p>
            </div>

            {{-- Fitur 3 --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-1.5 border border-slate-200/80 transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 shadow-xs border border-blue-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Jejaring & Komunitas Alumni</h3>
                <p class="text-slate-600 leading-relaxed text-sm">
                    Membangun ekosistem profesional antar alumni dari berbagai angkatan dan profesi untuk saling berbagi peluang kerja, kemitraan, dan karir.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Alur Pendaftaran Section --}}
<section id="alur" class="py-20 sm:py-28 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-3">
                    🚀 Cepat & Sederhana
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">3 Langkah Mudah Berpartisipasi</h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8">
                    Hanya butuh 3 menit. Pendaftaran dibuat praktis tanpa verifikasi OTP yang merepotkan.
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 transition-colors hover:bg-indigo-50/40">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-sm shadow-md shadow-indigo-600/20">
                            01
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900">Verifikasi NISN</h4>
                            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Masukkan 10 digit NISN Anda untuk memastikan data alumni terdaftar di sekolah.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 transition-colors hover:bg-indigo-50/40">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-purple-600 text-white font-bold flex items-center justify-center text-sm shadow-md shadow-purple-600/20">
                            02
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900">Aktivasi Link Email Instan</h4>
                            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Buka email Anda dan klik satu tombol tautan verifikasi tanpa perlu mengetik kode OTP.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 transition-colors hover:bg-indigo-50/40">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow-md shadow-blue-600/20">
                            03
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900">Isi Kuesioner & Selesai</h4>
                            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Setelah admin memvalidasi akun Anda, login dan jawab pertanyaan kuesioner singkat.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 font-bold text-sm text-indigo-600 hover:text-indigo-700 group">
                        <span>Daftar Sekarang Secara Mandiri</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
            
            {{-- Interactive Preview Card --}}
            <div class="bg-gradient-to-br from-indigo-50/70 via-slate-50 to-blue-50/50 rounded-3xl p-6 sm:p-8 border border-indigo-100/80 shadow-lg relative">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                    {{-- Window Header --}}
                    <div class="bg-slate-100/80 px-4 py-3 flex items-center justify-between border-b border-slate-200">
                        <div class="flex gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-500">tracer-study.smkdwitunggal2.sch.id</span>
                        <div class="w-8"></div>
                    </div>

                    {{-- Window Content --}}
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h5 class="text-sm font-bold text-slate-800">Kuesioner Tracer Study Alumni</h5>
                                <p class="text-xs text-slate-400">Status Saat Ini: Bekerja / Kuliah / Wirausaha</p>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[11px] font-bold">
                                Terverifikasi ✓
                            </span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-xs text-slate-600 font-medium">
                                <span>Progres Pengisian</span>
                                <span class="text-indigo-600 font-bold">100% Selesai</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-emerald-500 h-full w-full rounded-full"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Waktu Tunggu</span>
                                <span class="text-xs font-bold text-slate-800">&lt; 3 Bulan</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Kesesuaian Bidang</span>
                                <span class="text-xs font-bold text-slate-800">Sangat Sesuai</span>
                            </div>
                        </div>

                        <div class="p-3 bg-indigo-50/70 border border-indigo-100 rounded-xl flex items-center gap-2.5 text-xs text-indigo-700 font-medium">
                            <svg class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Terima kasih! Kontribusi data Anda telah tersimpan dengan aman.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Pengumuman Section --}}
@if($pengumuman->isNotEmpty())
<section id="pengumuman" class="py-20 sm:py-28 bg-slate-50/70 border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-3">
                    📢 Informasi Sekolah
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kabar & Pengumuman Terbaru</h2>
                <p class="text-slate-500 text-sm mt-1">Informasi terkini seputar karir, reuni, dan kegiatan alumni.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($pengumuman as $item)
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 border border-slate-200/80 transition-all duration-300 flex flex-col h-full group">
                <div class="mb-4">
                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-lg">
                        {{ $item->published_at ? $item->published_at->format('d M Y') : date('d M Y') }}
                    </span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-2">
                    {{ $item->judul }}
                </h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed line-clamp-3 mb-6 flex-1">
                    {!! Str::limit(strip_tags($item->isi), 140) !!}
                </p>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-indigo-600 group-hover:text-indigo-700">
                    <span>Baca Pengumuman</span>
                    <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
