@extends('layouts.admin')

@section('title', 'Tambah Jurusan')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Tambah Data Jurusan</h3>
        <a href="{{ route('admin.master.jurusan.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">← Kembali</a>
    </div>

    <form action="{{ route('admin.master.jurusan.store') }}" method="POST">
        @csrf
        <div class="space-y-5">
            <div>
                <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">Kode Jurusan</label>
                <input type="text" name="kode" id="kode" value="{{ old('kode') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('kode') border-red-500 @enderror" placeholder="Contoh: TKJ">
                @error('kode') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Jurusan (Kompetensi Keahlian)</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nama') border-red-500 @enderror" placeholder="Contoh: Teknik Komputer dan Jaringan">
                @error('nama') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
