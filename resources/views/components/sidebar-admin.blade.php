{{-- Sidebar Admin --}}
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
                ['route' => 'admin.dashboard', 'icon' => '📊', 'label' => 'Dashboard'],
                ['route' => 'admin.user.index', 'icon' => '👥', 'label' => 'Kelola User'],
                ['route' => 'admin.alumni.index', 'icon' => '🎓', 'label' => 'Data Alumni'],
                ['route' => 'admin.kuesioner.index', 'icon' => '📋', 'label' => 'Kuesioner'],
                ['route' => 'admin.verifikasi.index', 'icon' => '✅', 'label' => 'Verifikasi Alumni'],
                ['route' => 'admin.statistik.index', 'icon' => '📉', 'label' => 'Grafik Statistik'],
                ['route' => 'admin.laporan.index', 'icon' => '📄', 'label' => 'Laporan'],
                ['route' => 'admin.pengumuman.index', 'icon' => '📢', 'label' => 'Pengumuman'],
                ['route' => 'admin.master.jurusan.index', 'icon' => '⚙️', 'label' => 'Master Data'],
                ['route' => 'admin.profil.index', 'icon' => '👤', 'label' => 'Profil'],
            ];
        @endphp

        @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                {{ request()->routeIs($menu['route'] . '*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <span class="text-base {{ request()->routeIs($menu['route'] . '*') ? 'opacity-100' : 'opacity-70' }}">{{ $menu['icon'] }}</span>
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
