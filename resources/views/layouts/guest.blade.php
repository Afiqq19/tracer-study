<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Tracer Study Alumni SMK - Melacak jejak alumni untuk peningkatan kualitas pendidikan">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tracer Study') }} - @yield('title', 'Beranda')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=3">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Flash Messages --}}
    @include('components.alert')

    {{-- Main Content --}}
    <main>
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    {{-- Footer --}}
    @if(request()->routeIs(['login', 'register', 'verification.*', 'menunggu.*', 'password.*']))
        <footer class="py-6 text-center text-xs text-slate-400 border-t border-slate-200/60 bg-white/60 backdrop-blur-md">
            <p>&copy; {{ date('Y') }} SMK Swasta Dwitunggal 2 Tanjung Morawa &bull; Sistem Tracer Study Alumni</p>
        </footer>
    @else
        <footer class="bg-slate-950 text-slate-400 border-t border-slate-800/80 relative overflow-hidden">
            {{-- Top glow accent --}}
            <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-3 mb-5">
                            <div class="p-2 bg-slate-900 rounded-xl border border-slate-800" style="width: 44px; height: 44px;">
                                <img src="{{ asset('images/logo.png') }}?v=3" alt="Logo SMK" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <span class="font-extrabold text-lg text-white tracking-tight block">
                                    Tracer Study
                                </span>
                                <span class="text-xs text-indigo-400 font-semibold tracking-wide block">
                                    SMK Swasta Dwitunggal 2 Tanjung Morawa
                                </span>
                            </div>
                        </div>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-md mb-6">
                            Sistem pelacakan karir alumni resmi untuk pemetaan mutu lulusan, evaluasi relevansi kurikulum dengan industri, dan penguatan jejaring almamater.
                        </p>
                        <div class="flex items-center gap-3 text-xs text-slate-400">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-slate-300">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Sistem Terverifikasi & Terintegrasi
                            </span>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Navigasi Utama</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="{{ route('landing') }}" class="hover:text-indigo-400 transition-colors flex items-center gap-1.5"><span>&bull;</span> Beranda</a></li>
                            <li><a href="{{ route('landing') }}#statistik" class="hover:text-indigo-400 transition-colors flex items-center gap-1.5"><span>&bull;</span> Data Statistik</a></li>
                            <li><a href="{{ route('landing') }}#tentang" class="hover:text-indigo-400 transition-colors flex items-center gap-1.5"><span>&bull;</span> Tentang Program</a></li>
                            <li><a href="{{ route('landing') }}#alur" class="hover:text-indigo-400 transition-colors flex items-center gap-1.5"><span>&bull;</span> Alur Partisipasi</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-indigo-400 transition-colors flex items-center gap-1.5"><span>&bull;</span> Masuk ke Akun</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Hubungi Sekolah</h4>
                        <ul class="space-y-3.5 text-xs text-slate-400 leading-relaxed">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-indigo-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Tanjung Morawa, Kab. Deli Serdang, Sumatera Utara</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>smkdwitunggal2@gmail.com</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>(061) 7940 338</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-slate-800/80 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                    <p>&copy; {{ date('Y') }} SMK Swasta Dwitunggal 2 Tanjung Morawa &bull; Hak Cipta Dilindungi.</p>
                    <div class="flex items-center gap-4 text-xs text-slate-500">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Koneksi Aman SSL
                        </span>
                        <span>&bull;</span>
                        <span>Portal Tracer Study Vokasi</span>
                    </div>
                </div>
            </div>
        </footer>
    @endif

    @stack('scripts')
</body>
</html>
