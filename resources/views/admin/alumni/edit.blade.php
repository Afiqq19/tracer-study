@extends('layouts.admin')

@section('title', 'Edit Data Alumni')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Edit Biodata Lengkap Alumni</h3>
        <a href="{{ route('admin.alumni.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center gap-1">
            <span>←</span> Kembali
        </a>
    </div>

    @if($alumni->user_id)
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6 text-sm text-blue-800">
            <p class="font-semibold mb-1">Status Akun: Terdaftar (Aktif)</p>
            <p>Alumni ini sudah mendaftarkan akun. Perubahan pada NISN tidak akan mempengaruhi email login mereka, tapi akan mengubah data utama.</p>
        </div>
    @endif

    <form action="{{ route('admin.alumni.update', $alumni->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-8">
            {{-- Bagian 1: Data Akademik (Utama) --}}
            <div>
                <h4 class="text-base font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100">Data Akademik (Utama)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN <span class="text-red-500">*</span></label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $alumni->nisn) }}" required pattern="\d{10}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nisn') border-red-500 @enderror">
                        @error('nisn') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $alumni->nama) }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                        @error('nama') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tahun_lulus_id" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                        <select name="tahun_lulus_id" id="tahun_lulus_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Belum Dipilih / Kosong --</option>
                            @foreach($tahunLulus as $tl)
                                <option value="{{ $tl->id }}" {{ old('tahun_lulus_id', $alumni->tahun_lulus_id) == $tl->id ? 'selected' : '' }}>{{ $tl->tahun }}</option>
                            @endforeach
                        </select>
                        @error('tahun_lulus_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                        <select name="jurusan_id" id="jurusan_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Belum Dipilih / Kosong --</option>
                            @foreach($jurusan as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id', $alumni->jurusan_id) == $j->id ? 'selected' : '' }}>{{ $j->kode }} - {{ $j->nama }}</option>
                            @endforeach
                        </select>
                        @error('jurusan_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Bagian 2: Data Pribadi (Opsional bagi admin, diisi mandiri oleh alumni) --}}
            <div>
                <h4 class="text-base font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    Data Pribadi & Kontak
                    <span class="text-xs font-normal text-gray-400 bg-gray-100 px-2 py-1 rounded">Bisa dikosongkan</span>
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $alumni->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $alumni->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('no_hp') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $alumni->tempat_lahir) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('tempat_lahir') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', optional($alumni->tanggal_lahir)->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('tanggal_lahir') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="2" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('alamat', $alumni->alamat) }}</textarea>
                        @error('alamat') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
