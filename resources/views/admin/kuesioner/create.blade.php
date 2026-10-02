@extends('layouts.admin')

@section('title', 'Buat Kuesioner')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Buat Kuesioner Baru</h3>
        <a href="{{ route('admin.kuesioner.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">← Kembali</a>
    </div>

    <form action="{{ route('admin.kuesioner.store') }}" method="POST">
        @csrf
        <div class="space-y-5">
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Kuesioner <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('judul') border-red-500 @enderror">
                @error('judul') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('tanggal_mulai') border-red-500 @enderror">
                    @error('tanggal_mulai') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('tanggal_selesai') border-red-500 @enderror">
                    @error('tanggal_selesai') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Kuesioner <span class="text-red-500">*</span></label>
                <select name="status" id="status" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Belum dipublikasi)</option>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif (Bisa diisi alumni)</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai (Ditutup)</option>
                </select>
                @error('status') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                Simpan Kuesioner
            </button>
        </div>
    </form>
</div>
@endsection
