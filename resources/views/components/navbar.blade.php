{{-- Navbar untuk halaman publik (landing, login, register) --}}
<nav class="bg-white/80 backdrop-blur-xl border-b border-slate-200/80 sticky top-0 z-50 transition-all" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="p-1.5 bg-slate-100 rounded-xl group-hover:scale-105 transition-transform" style="width: 42px; height: 42px;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SMK" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="font-extrabold text-lg text-slate-900 tracking-tight block leading-tight group-hover:text-indigo-600 transition-colors">
                            Tracer Study
                        </span>
                        <span class="text-[10px] text-slate-500 font-medium tracking-wide block">
                            SMK Swasta Budhi darma Indrapura
                        </span>
                    </div>
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('landing') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Beranda</a>
                <a href="{{ route('landing') }}#statistik" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Statistik</a>
                <a href="{{ route('landing') }}#tentang" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Tentang</a>
                <a href="{{ route('landing') }}#alur" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Alur</a>
                <a href="{{ route('landing') }}#pengumuman" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Berita</a>
                
                @if(request()->routeIs('login'))
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 text-white text-sm rounded-xl font-bold shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span>Daftar Akun</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @elseif(request()->routeIs('register'))
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 text-white text-sm rounded-xl font-bold shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span>Masuk ke Akun</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 text-white text-sm rounded-xl font-bold shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span>Masuk</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    </a>
                @endif
            </div>

            {{-- Mobile Menu Button --}}
            <div class="flex items-center md:hidden">
                <button @click="open = !open" class="p-2 rounded-lg text-slate-600 hover:text-indigo-600 hover:bg-slate-100 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="md:hidden bg-white/95 backdrop-blur-xl border-t border-slate-100">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('landing') }}" class="block px-3 py-2.5 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-semibold text-sm">Beranda</a>
            <a href="{{ route('landing') }}#statistik" class="block px-3 py-2.5 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-semibold text-sm">Statistik</a>
            <a href="{{ route('landing') }}#tentang" class="block px-3 py-2.5 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-semibold text-sm">Tentang</a>
            <a href="{{ route('landing') }}#alur" class="block px-3 py-2.5 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-semibold text-sm">Alur</a>
            <a href="{{ route('landing') }}#pengumuman" class="block px-3 py-2.5 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 font-semibold text-sm">Berita</a>
            <a href="{{ route('login') }}" class="block px-4 py-3 mt-3 rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 text-white font-bold text-sm text-center shadow-md">Masuk ke Akun &rarr;</a>
        </div>
    </div>
</nav>
