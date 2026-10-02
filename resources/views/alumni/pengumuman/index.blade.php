@extends('layouts.alumni')

@section('title', 'Pengumuman')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-900">Pengumuman & Informasi</h3>
        <p class="text-sm text-gray-500 mt-1">Informasi terbaru dari pihak sekolah terkait tracer study dan bursa kerja.</p>
    </div>

    <div class="p-6">
        @if($pengumuman->isEmpty())
            <div class="text-center py-10">
                <div class="text-5xl mb-4">📭</div>
                <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengumuman</h4>
                <p class="text-gray-500 max-w-sm mx-auto">Saat ini belum ada pengumuman terbaru dari pihak sekolah.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($pengumuman as $item)
                <div class="bg-white rounded-xl border border-gray-100 hover:border-indigo-300 hover:shadow-md transition p-5 flex flex-col h-full group">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-medium">📢 Info</span>
                        <span class="text-xs text-gray-400 font-medium">{{ $item->published_at->format('d M Y') }}</span>
                    </div>
                    
                    <h4 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition">{{ $item->judul }}</h4>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4 flex-1">
                        {{ Str::limit(strip_tags($item->isi), 150) }}
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-50">
                        <a href="{{ route('alumni.pengumuman.show', $item->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                            Baca Selengkapnya <span>→</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($pengumuman->hasPages())
            <div class="mt-8 pt-4 border-t border-gray-100">
                {{ $pengumuman->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
