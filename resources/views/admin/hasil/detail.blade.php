@extends('layouts.admin')

@section('title', 'Detail Jawaban')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Detail Jawaban: {{ $kuesioner->judul }}</h3>
            <p class="text-sm text-gray-500 mt-1">Responden: {{ $pengisian->alumni->nama }} ({{ $pengisian->alumni->nisn }})</p>
        </div>
        <a href="{{ route('admin.hasil.show', $kuesioner->id) }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">← Kembali</a>
    </div>

    <div class="space-y-6">
        @forelse($pengisian->jawaban as $index => $jawaban)
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="font-medium text-gray-900 mb-2">{{ $index + 1 }}. {{ $jawaban->pertanyaan->pertanyaan ?? 'Pertanyaan telah dihapus' }}</p>
            <p class="text-gray-700 bg-white p-3 rounded-lg border border-gray-200">{{ $jawaban->jawaban_teks }}</p>
        </div>
        @empty
        <div class="text-center py-6 text-gray-500">Tidak ada data jawaban.</div>
        @endforelse
    </div>
</div>
@endsection
