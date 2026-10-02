{{-- Kartu statistik untuk dashboard --}}
@props(['judul', 'nilai', 'ikon' => '📊', 'warna' => 'blue'])

@php
    $bgClass = [
        'blue' => 'bg-blue-50 text-blue-600',
        'green' => 'bg-emerald-50 text-emerald-600',
        'yellow' => 'bg-amber-50 text-amber-600',
        'red' => 'bg-red-50 text-red-600',
        'purple' => 'bg-purple-50 text-purple-600',
        'indigo' => 'bg-indigo-50 text-indigo-600',
    ][$warna] ?? 'bg-gray-50 text-gray-600';
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-300">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">{{ $judul }}</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $nilai }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl {{ $bgClass }}">
            {{ $ikon }}
        </div>
    </div>
    @if(isset($slot) && $slot->isNotEmpty())
        <div class="mt-3 pt-3 border-t border-gray-100">
            {{ $slot }}
        </div>
    @endif
</div>
