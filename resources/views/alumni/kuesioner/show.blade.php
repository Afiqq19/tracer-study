@extends('layouts.alumni')

@section('title', 'Isi Kuesioner')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('alumni.kuesioner.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-1">
            <span>←</span> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-white">
            <h2 class="text-2xl font-bold mb-2">{{ $kuesioner->judul }}</h2>
            <p class="text-indigo-100">{{ $kuesioner->deskripsi }}</p>
        </div>
        
        <form action="{{ route('alumni.kuesioner.store', $kuesioner->id) }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-8">
                @foreach($kuesioner->pertanyaan as $index => $tanya)
                <div class="p-6 rounded-xl border border-gray-100 bg-gray-50/50 relative {{ $errors->has('jawaban.'.$tanya->id) ? 'ring-2 ring-red-300 border-red-300 bg-red-50' : '' }}">
                    
                    {{-- Pertanyaan --}}
                    <div class="mb-4">
                        <p class="font-semibold text-gray-900 text-lg">
                            <span class="text-gray-400 mr-2">{{ $index + 1 }}.</span>
                            {{ $tanya->pertanyaan }}
                            @if($tanya->is_required)
                                <span class="text-red-500" title="Wajib diisi">*</span>
                            @endif
                        </p>
                        @error('jawaban.'.$tanya->id)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Jawaban --}}
                    <div class="pl-7">
                        @if($tanya->tipe == 'isian_singkat')
                            <input type="text" name="jawaban[{{ $tanya->id }}]" value="{{ old('jawaban.'.$tanya->id) }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white" placeholder="Jawaban singkat Anda..." {{ $tanya->is_required ? 'required' : '' }}>
                        
                        @elseif($tanya->tipe == 'esai')
                            <textarea name="jawaban[{{ $tanya->id }}]" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white" placeholder="Tulis jawaban secara lengkap..." {{ $tanya->is_required ? 'required' : '' }}>{{ old('jawaban.'.$tanya->id) }}</textarea>
                        
                        @elseif($tanya->tipe == 'pilihan_ganda')
                            <div class="space-y-3">
                                @foreach($tanya->opsi as $opsi)
                                <label class="flex items-start p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition">
                                    <div class="flex items-center h-5">
                                        <input type="radio" name="jawaban[{{ $tanya->id }}]" value="{{ $opsi->opsi }}" {{ old('jawaban.'.$tanya->id) == $opsi->opsi ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" {{ $tanya->is_required ? 'required' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700">{{ $opsi->opsi }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold text-lg hover:bg-indigo-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Kirim Jawaban
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
