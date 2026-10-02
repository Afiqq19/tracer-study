{{-- Sidebar Alumni --}}
<aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 z-40 transform transition-transform duration-300"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-gray-100">
        <div class="flex items-center justify-center" style="width: 32px; height: 32px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
        </div>
        <span class="font-bold text-lg text-gray-900 truncate">Tracer Study</span>
    </div>

    {{-- Navigation --}}
    <nav class="px-4 py-6 space-y-1 overflow-y-auto max-h-[calc(100vh-4rem)]">
        @php
            $menus = [
                [
                    'route' => 'alumni.dashboard',
                    'active' => request()->routeIs('alumni.dashboard'),
                    'icon' => '📊',
                    'label' => 'Dashboard'
                ],
                [
                    'route' => 'alumni.data-diri.index',
                    'active' => request()->routeIs('alumni.data-diri.*') || request()->routeIs('alumni.status-kegiatan.*'),
                    'icon' => '👤',
                    'label' => 'Data Diri & Status'
                ],
                [
                    'route' => 'alumni.kuesioner.index',
                    'active' => request()->routeIs('alumni.kuesioner.*') || request()->routeIs('alumni.riwayat.*'),
                    'icon' => '📋',
                    'label' => 'Kuesioner Tracer'
                ],
                [
                    'route' => 'alumni.pengumuman.index',
                    'active' => request()->routeIs('alumni.pengumuman.*'),
                    'icon' => '📢',
                    'label' => 'Pengumuman'
                ],
                [
                    'route' => 'alumni.akun.index',
                    'active' => request()->routeIs('alumni.akun.*'),
                    'icon' => '🔐',
                    'label' => 'Pengaturan Akun'
                ],
            ];
        @endphp

        @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                {{ $menu['active'] ? 'bg-indigo-50 text-indigo-700 shadow-xs border border-indigo-100/60' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <span class="text-base {{ $menu['active'] ? 'opacity-100' : 'opacity-70' }}">{{ $menu['icon'] }}</span>
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
