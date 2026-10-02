@extends('layouts.admin')

@section('title', 'Kuesioner Tracer Study')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900">Kelola Kuesioner</h3>
        <a href="{{ route('admin.kuesioner.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
            + Buat Kuesioner
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Judul Kuesioner</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Periode</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Pertanyaan</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kuesioner as $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm font-medium text-gray-900">
                        <a href="{{ route('admin.kuesioner.show', $item->id) }}" class="text-blue-600 hover:underline">{{ $item->judul }}</a>
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-700">
                        {{ $item->tanggal_mulai->format('d/m/Y') }} - {{ $item->tanggal_selesai->format('d/m/Y') }}
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-700 text-center">
                        <span class="bg-gray-100 px-2 py-1 rounded text-xs font-medium">{{ $item->pertanyaan_count }} butir</span>
                    </td>
                    <td class="py-3 px-6 text-sm">
                        @if($item->status == 'aktif')
                            <span class="inline-flex px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Aktif</span>
                        @elseif($item->status == 'draft')
                            <span class="inline-flex px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Draft</span>
                        @else
                            <span class="inline-flex px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Selesai</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.hasil.show', $item->id) }}" class="text-xs bg-emerald-50 text-emerald-600 hover:bg-emerald-100 px-3 py-1.5 rounded-lg font-medium transition" title="Lihat Hasil/Responden">📊 Hasil</a>
                            <a href="{{ route('admin.kuesioner.show', $item->id) }}" class="text-xs bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg font-medium transition" title="Kelola Pertanyaan">⚙️ Soal</a>
                            <a href="{{ route('admin.kuesioner.edit', $item->id) }}" class="text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg font-medium transition" title="Edit Data">✏️ Edit</a>
                            <form action="{{ route('admin.kuesioner.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kuesioner ini beserta seluruh pertanyaannya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg font-medium transition" title="Hapus">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 px-6 text-center text-gray-500">Belum ada kuesioner yang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
