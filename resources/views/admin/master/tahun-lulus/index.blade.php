@extends('layouts.admin')

@section('title', 'Tahun Lulus')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900">Daftar Tahun Lulus</h3>
        <a href="{{ route('admin.master.tahun-lulus.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
            + Tambah Tahun Lulus
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">No</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Tahun Lulus</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $data->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $item->tahun }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.master.tahun-lulus.edit', $item->id) }}" class="text-blue-600 hover:bg-blue-100 p-2 rounded-lg transition">✏️</a>
                            <form action="{{ route('admin.master.tahun-lulus.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:bg-red-100 p-2 rounded-lg transition">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-6 px-6 text-center text-gray-500">Belum ada data tahun lulus.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $data->links() }}
    </div>
    @endif
</div>
@endsection
