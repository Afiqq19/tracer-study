@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftaran Alumni')

@section('content')
<div x-data="{ 
    showModal: false, 
    selected: null, 
    setujuiUrl: '', 
    tolakUrl: '',
    openDetail(item, setujui, tolak) {
        this.selected = item;
        this.setujuiUrl = setujui;
        this.tolakUrl = tolak;
        this.showModal = true;
    }
}">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Menunggu Verifikasi</h3>
                <p class="text-sm text-gray-500 mt-1">Daftar alumni yang telah mendaftar dan menunggu persetujuan Anda.</p>
            </div>
            <div class="bg-yellow-50 text-yellow-700 px-4 py-2 rounded-lg font-medium text-sm flex items-center gap-2">
                <span>⏳</span> {{ $alumni->total() }} Menunggu
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-3 px-6 text-sm font-semibold text-gray-600">Tanggal Daftar</th>
                        <th class="py-3 px-6 text-sm font-semibold text-gray-600">NISN</th>
                        <th class="py-3 px-6 text-sm font-semibold text-gray-600">Nama Alumni</th>
                        <th class="py-3 px-6 text-sm font-semibold text-gray-600">Jurusan & Tahun</th>
                        <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($alumni as $item)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="py-3 px-6 text-sm text-gray-700">
                            {{ $item->updated_at->format('d M Y H:i') }}
                            <span class="block text-xs text-gray-400">{{ $item->updated_at->diffForHumans() }}</span>
                        </td>
                        <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $item->nisn }}</td>
                        <td class="py-3 px-6 text-sm text-gray-800">
                            <span class="font-semibold">{{ $item->nama }}</span>
                            @if($item->user)
                                <span class="block text-xs text-gray-500">{{ $item->user->email }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-sm text-gray-600">
                            {{ $item->jurusan->kode ?? '-' }} <span class="text-gray-400 mx-1">•</span> {{ $item->tahunLulus->tahun ?? '-' }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex justify-center items-center gap-2">
                                {{-- Tombol Lihat Biodata --}}
                                <button type="button" 
                                    @click="openDetail(
                                        {{ json_encode($item) }}, 
                                        '{{ route('admin.verifikasi.setujui', $item->id) }}', 
                                        '{{ route('admin.verifikasi.tolak', $item->id) }}'
                                    )"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-sm font-medium transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Biodata
                                </button>

                                {{-- Tombol Cepat Setujui --}}
                                <form action="{{ route('admin.verifikasi.setujui', $item->id) }}" method="POST" onsubmit="return confirm('Setujui pendaftaran alumni ini? Email notifikasi akan dikirimkan ke alumni.');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg text-sm font-medium transition" title="Setujui Langsung">
                                        ✅ Setujui
                                    </button>
                                </form>

                                {{-- Tombol Cepat Tolak --}}
                                <form action="{{ route('admin.verifikasi.tolak', $item->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran alumni ini?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-medium transition" title="Tolak">
                                        ❌ Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 px-6 text-center text-gray-500">
                            <div class="text-4xl mb-3">🎉</div>
                            <p class="font-medium text-gray-700">Semua pendaftaran sudah diverifikasi!</p>
                            <p class="text-sm mt-1">Tidak ada alumni yang menunggu verifikasi saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($alumni->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $alumni->links() }}
        </div>
        @endif
    </div>

    {{-- MODAL DETAIL BIODATA ALUMNI --}}
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Backdrop --}}
            <div x-show="showModal" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="showModal = false" 
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal Content Box --}}
            <div x-show="showModal" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-gray-100">
                
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5 text-white flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <template x-if="selected?.foto_url">
                            <img :src="selected.foto_url" alt="Foto Profil" class="w-12 h-12 rounded-full object-cover ring-2 ring-white/40 shadow-sm">
                        </template>
                        <template x-if="!selected?.foto_url">
                            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center font-bold text-xl text-white">
                                <span x-text="selected?.nama ? selected.nama.charAt(0).toUpperCase() : 'A'"></span>
                            </div>
                        </template>
                        <div>
                            <h3 class="text-lg font-bold leading-6" x-text="selected?.nama"></h3>
                            <p class="text-xs text-indigo-100 mt-0.5">NISN: <span class="font-mono font-bold" x-text="selected?.nisn"></span></p>
                        </div>
                    </div>
                    <button type="button" @click="showModal = false" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    {{-- Blok 1: Data Sekolah --}}
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Data Sekolah
                        </h4>
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl text-sm">
                            <div>
                                <span class="text-xs text-gray-500 block">Jurusan</span>
                                <span class="font-medium text-gray-900" x-text="selected?.jurusan?.nama || selected?.jurusan?.kode || '-'"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Tahun Lulus</span>
                                <span class="font-medium text-gray-900" x-text="selected?.tahun_lulus?.tahun || '-'"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Blok 2: Informasi Pribadi --}}
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Informasi Pribadi
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl text-sm">
                            <div>
                                <span class="text-xs text-gray-500 block">Jenis Kelamin</span>
                                <span class="font-medium text-gray-900" x-text="selected?.jenis_kelamin || '-'"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Agama</span>
                                <span class="font-medium text-gray-900" x-text="selected?.agama || '-'"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Tempat Lahir</span>
                                <span class="font-medium text-gray-900" x-text="selected?.tempat_lahir || '-'"></span>
                            </div>
                            <div class="sm:col-span-3">
                                <span class="text-xs text-gray-500 block">Tanggal Lahir</span>
                                <span class="font-medium text-gray-900" x-text="selected?.tanggal_lahir ? new Date(selected.tanggal_lahir).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Blok 3: Alamat Tempat Tinggal --}}
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Alamat Tempat Tinggal
                        </h4>
                        <div class="bg-gray-50 p-4 rounded-xl text-sm space-y-3">
                            <div>
                                <span class="text-xs text-gray-500 block">Alamat Lengkap</span>
                                <span class="font-medium text-gray-900" x-text="selected?.alamat || '-'"></span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2 border-t border-gray-200/60">
                                <div>
                                    <span class="text-xs text-gray-500 block">Kelurahan / Desa</span>
                                    <span class="font-medium text-gray-900" x-text="selected?.kelurahan || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">Kecamatan</span>
                                    <span class="font-medium text-gray-900" x-text="selected?.kecamatan || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">Kabupaten / Kota</span>
                                    <span class="font-medium text-gray-900" x-text="selected?.kabupaten_kota || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 block">Provinsi</span>
                                    <span class="font-medium text-gray-900" x-text="selected?.provinsi || '-'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Blok 4: Kontak & Akun --}}
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Kontak & Keamanan Akun
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl text-sm">
                            <div>
                                <span class="text-xs text-gray-500 block">WhatsApp / Nomor HP</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="font-semibold text-gray-900" x-text="selected?.no_hp || '-'"></span>
                                    <template x-if="selected?.no_hp">
                                        <a :href="'https://wa.me/' + selected.no_hp.replace(/^0/, '62').replace(/\D/g, '')" target="_blank" class="text-xs px-2 py-0.5 bg-green-100 text-green-700 rounded hover:bg-green-200 transition font-medium">
                                            Chat WA &rarr;
                                        </a>
                                    </template>
                                </div>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Alamat Email</span>
                                <span class="font-semibold text-indigo-600" x-text="selected?.user?.email || '-'"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Blok 5: Media Sosial --}}
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-3 flex items-center gap-2">
                            <span>🌐</span>
                            <span>Media Sosial Alumni</span>
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-gray-50 p-4 rounded-xl text-sm">
                            <div>
                                <span class="text-xs text-gray-500 block">Instagram</span>
                                <span class="font-medium text-gray-900" x-text="selected?.instagram ? '@' + selected.instagram : '-'"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Twitter / X</span>
                                <span class="font-medium text-gray-900" x-text="selected?.twitter ? '@' + selected.twitter : '-'"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">TikTok</span>
                                <span class="font-medium text-gray-900" x-text="selected?.tiktok ? '@' + selected.tiktok : '-'"></span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">LinkedIn</span>
                                <span class="font-medium text-gray-900 truncate block" x-text="selected?.linkedin || '-'"></span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-xs text-gray-500 block">Facebook</span>
                                <span class="font-medium text-gray-900 truncate block" x-text="selected?.facebook || '-'"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row justify-end items-center gap-3">
                    <button type="button" @click="showModal = false" class="w-full sm:w-auto px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Tutup
                    </button>
                    
                    <form :action="tolakUrl" method="POST" onsubmit="return confirm('Tolak pendaftaran alumni ini?');" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition flex items-center justify-center gap-1.5 shadow-sm">
                            ❌ Tolak Pendaftaran
                        </button>
                    </form>

                    <form :action="setujuiUrl" method="POST" onsubmit="return confirm('Setujui pendaftaran alumni ini? Email notifikasi persetujuan akan langsung dikirimkan ke alumni.');" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition flex items-center justify-center gap-1.5 shadow-sm">
                            ✅ Setujui & Kirim Email
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
