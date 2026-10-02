<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - Alumni | @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=3">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        @include('components.sidebar-alumni')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen lg:ml-64">
            {{-- Top Bar --}}
            <header class="bg-white/80 backdrop-blur-sm sticky top-0 z-30 border-b border-gray-100">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 class="text-xl font-bold text-gray-900 tracking-tight">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-5">
                        <a href="{{ route('alumni.data-diri.index') }}" class="flex items-center gap-3 group">
                            @if(Auth::user()->alumni && Auth::user()->alumni->foto_url)
                                <img src="{{ Auth::user()->alumni->foto_url }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-indigo-500/20 group-hover:ring-indigo-500 transition shadow-xs">
                            @else
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:shadow-md transition">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="hidden sm:block text-left">
                                <span class="text-sm font-semibold text-slate-800 block group-hover:text-indigo-600 transition">{{ Auth::user()->name }}</span>
                                <span class="text-[11px] font-medium text-slate-400 block -mt-0.5">Alumni</span>
                            </div>
                        </a>
                        <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 font-medium transition-colors">Log out</button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @include('components.alert')
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Sidebar Overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-transition.opacity></div>

    @stack('scripts')
</body>
</html>
