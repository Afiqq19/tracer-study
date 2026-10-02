@extends('layouts.admin')

@section('title', 'Tambah Data Alumni')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Tambah Data Alumni (Manual)</h3>
        <a href="{{ route('admin.alumni.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center gap-1">
            <span>←</span> Kembali
        </a>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6 text-sm text-blue-800">
        <p class="font-semibold mb-1">Informasi:</p>
        <p>Anda menambahkan data awal (NISN dan Nama). Alumni nantinya akan menggunakan NISN ini untuk mendaftar dan melengkapi sisa biodata mereka secara mandiri.</p>
    </div>

    <form action="{{ route('admin.alumni.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- NISN --}}
            <div class="md:col-span-2">
                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN <span class="text-red-500">*</span></label>
                <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}" required pattern="\d{10}" title="NISN harus 10 digit angka" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nisn') border-red-500 @enderror" placeholder="10 Digit Angka NISN">
                <p class="text-xs text-gray-500 mt-1">NISN akan digunakan sebagai identitas unik alumni saat mendaftar.</p>
                @error('nisn') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Nama --}}
            <div class="md:col-span-2">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Alumni <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nama') border-red-500 @enderror" placeholder="Sesuai ijazah">
                @error('nama') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Tahun Lulus --}}
            <div>
                <label for="tahun_lulus_id" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                <select name="tahun_lulus_id" id="tahun_lulus_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('tahun_lulus_id') border-red-500 @enderror">
                    <option value="" selected>Pilih Tahun Lulus (Opsional)...</option>
                    @foreach($tahunLulus as $tl)
                        <option value="{{ $tl->id }}" {{ old('tahun_lulus_id') == $tl->id ? 'selected' : '' }}>{{ $tl->tahun }}</option>
                    @endforeach
                </select>
                @error('tahun_lulus_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Jurusan --}}
            <div>
                <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan (Kompetensi Keahlian) <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                <select name="jurusan_id" id="jurusan_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('jurusan_id') border-red-500 @enderror">
                    <option value="" selected>Pilih Jurusan (Opsional)...</option>
                    @foreach($jurusan as $j)
                        <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->kode }} - {{ $j->nama }}</option>
                    @endforeach
                </select>
                @error('jurusan_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2">
                💾 Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
