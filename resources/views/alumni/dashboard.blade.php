@extends('layouts.alumni')

@section('title', 'Dashboard')

@section('content')
{{-- Selamat Datang --}}
<div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white mb-8 shadow-md border border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
    <div class="flex items-center gap-5">
        @if($alumni->foto_url)
            <img src="{{ $alumni->foto_url }}" alt="{{ $alumni->nama }}" class="w-16 h-16 rounded-2xl object-cover ring-4 ring-white/10 shadow-lg shrink-0">
        @else
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-extrabold text-2xl shadow-lg ring-4 ring-white/10 shrink-0">
                {{ substr($alumni->nama, 0, 1) }}
            </div>
        @endif
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $alumni->nama }}! 👋</h2>
            </div>
            <p class="text-slate-300 font-medium text-xs sm:text-sm mt-1">
                NISN: <span class="font-mono font-semibold text-white">{{ $alumni->nisn }}</span> 
                <span class="mx-2 text-slate-600">|</span> {{ $alumni->jurusan->nama ?? '-' }} 
                <span class="mx-2 text-slate-600">|</span> Lulus Tahun {{ $alumni->tahunLulus->tahun ?? '-' }}
            </p>
        </div>
    </div>
    <a href="{{ route('alumni.data-diri.index') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-bold transition border border-white/10 flex items-center gap-2 self-start sm:self-center">
        <span>✏️</span>
        <span>Edit Profil & Data Diri</span>
    </a>
</div>

{{-- Status Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    {{-- Data Diri --}}
    <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-800">Biodata Diri</h3>
                @if($dataLengkap)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">✅ Lengkap</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">⚠️ Belum Lengkap</span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mb-4">Pastikan data pribadi, kontak, dan sosial media Anda terisi.</p>
        </div>
        <a href="{{ route('alumni.data-diri.index', ['tab' => 'biodata']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
            <span>Kelola Biodata Diri</span>
            <span>&rarr;</span>
        </a>
    </div>

    {{-- Status Kegiatan --}}
    <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-800">Status Aktivitas</h3>
                @if($statusKegiatan)
                    @php
                        $jenisLabel = ['kuliah' => 'Kuliah', 'bekerja' => 'Bekerja', 'wirausaha' => 'Wirausaha', 'belum_bekerja' => 'Mencari Kerja'];
                        $jenisColor = [
                            'kuliah' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'bekerja' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'wirausaha' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'belum_bekerja' => 'bg-slate-100 text-slate-700 border-slate-200'
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $jenisColor[$statusKegiatan->jenis] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        {{ $jenisLabel[$statusKegiatan->jenis] ?? ucfirst($statusKegiatan->jenis) }}
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">Belum Diisi</span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mb-4">
                @if($statusKegiatan && $statusKegiatan->nama_instansi)
                    <strong class="text-slate-700">{{ $statusKegiatan->nama_instansi }}</strong>
                    @if($statusKegiatan->posisi)
                        - {{ $statusKegiatan->posisi }}
                    @endif
                @else
                    Perbarui riwayat karier / kuliah Anda saat ini.
                @endif
            </p>
        </div>
        <a href="{{ route('alumni.data-diri.index', ['tab' => 'status']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
            <span>Kelola Status Aktivitas</span>
            <span>&rarr;</span>
        </a>
    </div>

    {{-- Kuesioner --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-800">Kuesioner</h3>
            @if($kuesionerAktif > 0)
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">{{ $kuesionerAktif }} belum diisi</span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">✅ Semua terisi</span>
            @endif
        </div>
        <p class="text-sm text-gray-500 mb-4">Isi kuesioner tracer study yang tersedia.</p>
        <a href="{{ route('alumni.kuesioner.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Kuesioner →</a>
    </div>
</div>

{{-- Pengumuman Terbaru --}}
@if($pengumuman->isNotEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-900 mb-4">📢 Pengumuman Terbaru</h3>
    <div class="space-y-4">
        @foreach($pengumuman as $item)
        <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
            <div class="flex-1">
                <h4 class="font-semibold text-gray-800">{{ $item->judul }}</h4>
                <p class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                <span class="text-xs text-gray-400 mt-2 block">{{ $item->published_at->diffForHumans() }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
