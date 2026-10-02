@extends('layouts.admin')

@section('title', 'Buat Pengumuman')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Buat Pengumuman Baru</h3>
        <a href="{{ route('admin.pengumuman.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">← Kembali</a>
    </div>

    <form action="{{ route('admin.pengumuman.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('judul') border-red-500 @enderror">
                @error('judul') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="isi" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="isi" id="isi" rows="10" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('isi') border-red-500 @enderror">{{ old('isi') }}</textarea>
                @error('isi') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                <p class="text-xs text-gray-500 mt-2">Mendukung format paragraf sederhana. Gunakan baris baru untuk memisahkan paragraf.</p>
            </div>

            <div class="flex items-center pt-2">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700 font-medium">Langsung Publikasikan (Bisa dilihat oleh alumni)</span>
                </label>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2">
                💾 Simpan Pengumuman
            </button>
        </div>
    </form>
</div>
@endsection
