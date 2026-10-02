@extends('layouts.admin')

@section('title', 'Edit Tahun Lulus')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Edit Data Tahun Lulus</h3>
        <a href="{{ route('admin.master.tahun-lulus.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">← Kembali</a>
    </div>

    <form action="{{ route('admin.master.tahun-lulus.update', $tahunLulus->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-5">
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
                <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $tahunLulus->tahun) }}" required min="1990" max="2100" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('tahun') border-red-500 @enderror">
                @error('tahun') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
