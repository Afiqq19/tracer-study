@extends('layouts.admin')

@section('title', 'Cetak Laporan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-2xl">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Export Laporan Tracer Study</h3>
    <form action="{{ route('admin.laporan.pdf') }}" method="GET" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
            <select name="tahun_lulus_id" class="w-full rounded-lg border-gray-300">
                <option value="">Semua Tahun</option>
                @foreach($tahunLulus as $tahun)
                    <option value="{{ $tahun->id }}">{{ $tahun->tahun }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
            <select name="jurusan_id" class="w-full rounded-lg border-gray-300">
                <option value="">Semua Jurusan</option>
                @foreach($jurusan as $j)
                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-4 pt-2">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700">📄 Export PDF</button>
            <button type="submit" formaction="{{ route('admin.laporan.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700">📊 Export Excel</button>
        </div>
    </form>
</div>
@endsection
