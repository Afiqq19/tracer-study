@extends('layouts.admin')

@section('title', 'Detail Kuesioner')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Info Kuesioner --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $kuesioner->judul }}</h3>
                @if($kuesioner->status == 'aktif')
                    <span class="inline-flex px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Aktif</span>
                @elseif($kuesioner->status == 'draft')
                    <span class="inline-flex px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Draft</span>
                @else
                    <span class="inline-flex px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Selesai</span>
                @endif
            </div>
            
            <p class="text-sm text-gray-600 mb-6">{{ $kuesioner->deskripsi ?: 'Tidak ada deskripsi' }}</p>
            
            <div class="space-y-3 mb-6">
                <div class="flex items-center text-sm">
                    <span class="w-8 text-center text-gray-400">📅</span>
                    <span class="text-gray-700">{{ $kuesioner->tanggal_mulai->format('d M Y') }} - {{ $kuesioner->tanggal_selesai->format('d M Y') }}</span>
                </div>
                <div class="flex items-center text-sm">
                    <span class="w-8 text-center text-gray-400">📝</span>
                    <span class="text-gray-700">{{ $kuesioner->pertanyaan->count() }} Pertanyaan</span>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4 flex gap-2">
                <a href="{{ route('admin.kuesioner.edit', $kuesioner->id) }}" class="flex-1 text-center py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Edit Data</a>
                <a href="{{ route('admin.kuesioner.index') }}" class="flex-1 text-center py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Kembali</a>
            </div>
        </div>
    </div>

    {{-- Daftar Pertanyaan --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Form Tambah Pertanyaan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6" x-data="{ tipe: 'isian_singkat' }">
            <h4 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Tambah Pertanyaan</h4>
            <form action="{{ route('admin.kuesioner.pertanyaan.store', $kuesioner->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan</label>
                        <textarea name="pertanyaan" rows="2" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Jawaban</label>
                            <select name="tipe" x-model="tipe" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="isian_singkat">Isian Singkat</option>
                                <option value="esai">Esai Panjang</option>
                                <option value="pilihan_ganda">Pilihan Ganda (Radio)</option>
                            </select>
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_required" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Wajib Diisi</span>
                            </label>
                        </div>
                    </div>

                    {{-- Dynamic Options for Multiple Choice --}}
                    <div x-show="tipe === 'pilihan_ganda'" x-transition class="bg-gray-50 p-4 rounded-xl border border-gray-200" x-data="{ options: ['', ''] }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Jawaban</label>
                        <template x-for="(option, index) in options" :key="index">
                            <div class="flex gap-2 mb-2">
                                <input type="text" x-model="options[index]" :name="'opsi['+index+']'" class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Teks opsi...">
                                <button type="button" @click="options.splice(index, 1)" x-show="options.length > 2" class="px-3 py-1 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">×</button>
                            </div>
                        </template>
                        <button type="button" @click="options.push('')" class="mt-2 text-sm text-blue-600 hover:text-blue-700 font-medium">+ Tambah Opsi</button>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                            Simpan Pertanyaan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- List Pertanyaan --}}
        <div class="space-y-4">
            <h4 class="font-bold text-gray-900 border-b border-gray-200 pb-2">Daftar Pertanyaan ({{ $kuesioner->pertanyaan->count() }})</h4>
            
            @forelse($kuesioner->pertanyaan as $index => $tanya)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative group">
                <div class="absolute top-4 right-4">
                    <form action="{{ route('admin.kuesioner.pertanyaan.destroy', $tanya->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Hapus">🗑️</button>
                    </form>
                </div>
                
                <div class="flex gap-3 pr-8">
                    <span class="font-bold text-gray-400">{{ $index + 1 }}.</span>
                    <div>
                        <p class="font-medium text-gray-900 mb-1">
                            {{ $tanya->pertanyaan }}
                            @if($tanya->is_required) <span class="text-red-500">*</span> @endif
                        </p>
                        
                        <div class="mt-3">
                            @if($tanya->tipe == 'isian_singkat')
                                <input type="text" disabled class="w-full bg-gray-50 border-dashed border-gray-300 rounded-lg text-sm text-gray-400" placeholder="Jawaban singkat...">
                            @elseif($tanya->tipe == 'esai')
                                <textarea disabled rows="2" class="w-full bg-gray-50 border-dashed border-gray-300 rounded-lg text-sm text-gray-400" placeholder="Jawaban panjang..."></textarea>
                            @elseif($tanya->tipe == 'pilihan_ganda')
                                <div class="space-y-2">
                                    @foreach($tanya->opsi as $opsi)
                                    <label class="flex items-center gap-2 text-sm text-gray-600">
                                        <input type="radio" disabled class="text-blue-500">
                                        {{ $opsi->opsi }}
                                    </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-dashed border-gray-300 p-8 text-center text-gray-500">
                Belum ada pertanyaan. Tambahkan pertanyaan di form atas.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
