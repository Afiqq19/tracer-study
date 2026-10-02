@extends('layouts.admin')

@section('title', 'Hasil Kuesioner')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-900">Hasil Kuesioner</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Judul Kuesioner</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Total Responden</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kuesioner as $item)
                <tr class="border-b border-gray-50">
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $item->judul }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700 text-center"><span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-bold">{{ $item->pengisian_count }}</span></td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('admin.hasil.show', $item->id) }}" class="text-blue-600 hover:underline">Lihat Responden</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="py-6 px-6 text-center text-gray-500">Belum ada kuesioner.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
