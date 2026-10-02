@extends('layouts.admin')

@section('title', 'Daftar Responden')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900">Responden: {{ $kuesioner->judul }}</h3>
        <a href="{{ route('admin.kuesioner.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 bg-gray-50 px-4 py-2 rounded-lg transition-colors">← Kembali ke Kuesioner</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">NISN</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Nama Alumni</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Jurusan</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Waktu Submit</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengisian as $item)
                <tr class="border-b border-gray-50">
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $item->alumni->nisn }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $item->alumni->nama }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $item->alumni->jurusan->nama ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('admin.hasil.detail', [$kuesioner->id, $item->id]) }}" class="text-blue-600 hover:underline">Lihat Jawaban</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-6 px-6 text-center text-gray-500">Belum ada responden.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
