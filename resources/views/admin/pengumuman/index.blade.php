@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900">Daftar Pengumuman</h3>
        <a href="{{ route('admin.pengumuman.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
            + Buat Pengumuman
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 w-16">No</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Judul Pengumuman</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Tanggal Publikasi</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengumuman as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $pengumuman->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $item->judul }}</td>
                    <td class="py-3 px-6 text-sm">
                        @if($item->is_published)
                            <span class="inline-flex px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Dipublikasi</span>
                        @else
                            <span class="inline-flex px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Draft</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-700">
                        {{ $item->published_at ? $item->published_at->format('d M Y, H:i') : '-' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.pengumuman.edit', $item->id) }}" class="text-blue-600 hover:bg-blue-100 p-2 rounded-lg transition" title="Edit">✏️</a>
                            <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:bg-red-100 p-2 rounded-lg transition" title="Hapus">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 px-6 text-center text-gray-500">Belum ada pengumuman yang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pengumuman->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $pengumuman->links() }}
    </div>
    @endif
</div>
@endsection
