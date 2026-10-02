@extends('layouts.admin')

@section('title', 'Data Alumni')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header & Actions --}}
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h3 class="text-lg font-bold text-gray-900">Kelola Data Alumni</h3>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.alumni.import') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center gap-2 text-sm">
                <span>📥</span> Import Excel
            </a>
            <a href="{{ route('admin.alumni.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2 text-sm">
                <span>➕</span> Tambah Manual
            </a>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form action="{{ route('admin.alumni.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari NISN / Nama</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Ketik NISN atau nama alumni...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400">🔍</span>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="tahun_lulus_id" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
                <select name="tahun_lulus_id" id="tahun_lulus_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunLulus as $tl)
                        <option value="{{ $tl->id }}" {{ request('tahun_lulus_id') == $tl->id ? 'selected' : '' }}>{{ $tl->tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <select name="jurusan_id" id="jurusan_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $j)
                        <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->kode }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="md:col-span-4 flex justify-end gap-2">
                @if(request()->anyFilled(['search', 'tahun_lulus_id', 'jurusan_id']))
                    <a href="{{ route('admin.alumni.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition text-sm">Reset</a>
                @endif
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-medium hover:bg-gray-900 transition text-sm">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">No</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">NISN</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Nama Alumni</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Jurusan & Tahun</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($alumni as $index => $item)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $alumni->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $item->nisn }}</td>
                    <td class="py-3 px-6 text-sm text-gray-800">
                        {{ $item->nama }}
                        @if($item->user_id)
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800" title="Akun User Terkait">User</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-600">
                        {{ $item->jurusan->kode ?? '-' }} <span class="text-gray-400 mx-1">•</span> {{ $item->tahunLulus->tahun ?? '-' }}
                    </td>
                    <td class="py-3 px-6 text-sm">
                        @php
                            $statusConfig = [
                                'belum_daftar' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Belum Daftar'],
                                'menunggu_verifikasi' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Menunggu Verifikasi'],
                                'disetujui' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Aktif'],
                                'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Ditolak'],
                            ];
                            $cfg = $statusConfig[$item->status_registrasi] ?? $statusConfig['belum_daftar'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cfg['bg'] }} {{ $cfg['text'] }}">
                            {{ $cfg['label'] }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.alumni.edit', $item->id) }}" class="text-blue-600 hover:bg-blue-100 p-1.5 rounded-lg transition" title="Edit">✏️</a>
                            <form action="{{ route('admin.alumni.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data alumni ini? Tindakan ini dapat di-restore nanti (soft delete).');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:bg-red-100 p-1.5 rounded-lg transition" title="Hapus">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 px-6 text-center text-gray-500">
                        <div class="text-4xl mb-3">📭</div>
                        <p>Tidak ada data alumni yang ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($alumni->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $alumni->links() }}
    </div>
    @endif
</div>
@endsection
