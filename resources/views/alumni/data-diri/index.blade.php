@extends('layouts.alumni')

@section('title', 'Data Diri & Status Kegiatan')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{ 
    activeTab: '{{ $activeTab ?? 'biodata' }}',
    photoPreview: '{{ $alumni->foto_url ?? '' }}',
    showAddStatus: {{ $errors->has('jenis') || $errors->has('nama_instansi') || $errors->has('posisi') || $errors->has('tanggal_mulai') ? 'true' : 'false' }},
    statusJenis: '{{ old('jenis', 'bekerja') }}',
    hapusFoto: false,
    handlePhotoChange(e) {
        const file = e.target.files[0];
        if (file) {
            this.hapusFoto = false;
            const reader = new FileReader();
            reader.onload = (event) => {
                this.photoPreview = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    removePhoto() {
        this.photoPreview = '';
        this.hapusFoto = true;
        const fileInput = document.getElementById('foto_input');
        if (fileInput) fileInput.value = '';
    }
}">

    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="relative">
                <template x-if="photoPreview && !hapusFoto">
                    <img :src="photoPreview" alt="Foto Profil" class="w-16 h-16 rounded-2xl object-cover ring-4 ring-indigo-50 shadow-md">
                </template>
                <template x-if="!photoPreview || hapusFoto">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white flex items-center justify-center font-extrabold text-2xl shadow-md ring-4 ring-indigo-50">
                        {{ substr($alumni->nama, 0, 1) }}
                    </div>
                </template>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">{{ $alumni->nama }}</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Alumni Aktif
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    NISN: <span class="font-mono font-semibold text-slate-700">{{ $alumni->nisn }}</span> • 
                    Jurusan: <span class="font-medium text-slate-700">{{ $alumni->jurusan->nama ?? '-' }}</span> • 
                    Lulus Tahun: <span class="font-semibold text-slate-700">{{ $alumni->tahunLulus->tahun ?? '-' }}</span>
                </p>
            </div>
        </div>

        {{-- Quick Stats / Info --}}
        <div class="flex items-center gap-2">
            <div class="px-4 py-2 bg-slate-50 rounded-xl border border-slate-100 text-center">
                <span class="text-[11px] font-semibold text-slate-400 block uppercase tracking-wider">Status Terakhir</span>
                <span class="text-xs font-bold text-indigo-600 capitalize">
                    {{ $statusKegiatan->first() ? str_replace('_', ' ', $statusKegiatan->first()->jenis) : 'Belum Diisi' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="bg-white rounded-2xl p-1.5 shadow-xs border border-slate-100 flex items-center gap-1.5">
        <button type="button" @click="activeTab = 'biodata'"
            class="flex-1 py-3 px-4 rounded-xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2"
            :class="activeTab === 'biodata' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
            <span class="text-base">👤</span>
            <span>Biodata & Profil</span>
        </button>

        <button type="button" @click="activeTab = 'status'"
            class="flex-1 py-3 px-4 rounded-xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2 relative"
            :class="activeTab === 'status' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'">
            <span class="text-base">💼</span>
            <span>Status Kegiatan Saat Ini</span>
            @if($statusKegiatan->isNotEmpty())
                <span class="ml-1 px-2 py-0.5 text-xs rounded-full"
                    :class="activeTab === 'status' ? 'bg-white/20 text-white font-bold' : 'bg-indigo-100 text-indigo-700 font-bold'">
                    {{ $statusKegiatan->count() }}
                </span>
            @endif
        </button>
    </div>

    {{-- TAB 1: BIODATA, FOTO PROFIL & SOSIAL MEDIA --}}
    <div x-show="activeTab === 'biodata'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
        <form action="{{ route('alumni.data-diri.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Hidden input jika user memilih hapus foto --}}
            <input type="hidden" name="hapus_foto" :value="hapusFoto ? '1' : '0'">

            {{-- Card Foto Profil --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 sm:p-8">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-6">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                        📸
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Foto Profil Alumni</h3>
                        <p class="text-xs text-slate-500">Unggah foto profil formal atau santai untuk mempermudah identifikasi.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="relative group">
                        <template x-if="photoPreview && !hapusFoto">
                            <img :src="photoPreview" alt="Foto Profil" class="w-28 h-28 rounded-2xl object-cover ring-4 ring-slate-100 shadow-md transition group-hover:opacity-90">
                        </template>
                        <template x-if="!photoPreview || hapusFoto">
                            <div class="w-28 h-28 rounded-2xl bg-gradient-to-tr from-slate-100 to-slate-200 text-slate-400 flex flex-col items-center justify-center font-bold text-sm border-2 border-dashed border-slate-300">
                                <svg class="w-8 h-8 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[11px] text-slate-500">Belum ada foto</span>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-3 flex-1 text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                            <label for="foto_input" class="px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl font-bold text-xs cursor-pointer transition flex items-center gap-2 border border-indigo-200/60 shadow-2xs">
                                <span>📁</span>
                                <span>Pilih Foto Baru</span>
                            </label>
                            <input type="file" id="foto_input" name="foto" accept="image/png, image/jpeg, image/jpg, image/webp" class="hidden" @change="handlePhotoChange($event)">

                            <template x-if="photoPreview && !hapusFoto">
                                <button type="button" @click="removePhoto()" class="px-3.5 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-bold text-xs transition flex items-center gap-1.5 border border-red-200/60">
                                    <span>🗑️</span>
                                    <span>Hapus Foto</span>
                                </button>
                            </template>
                        </div>
                        <p class="text-xs text-slate-400">
                            Format yang didukung: <strong>JPG, JPEG, PNG, WEBP</strong>. Ukuran file maksimal <strong>2 MB</strong>.
                        </p>
                        @error('foto')
                            <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Card 1: Data Akademik Bawaan Sekolah (Readonly) --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 sm:p-8">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-6">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        🎓
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Data Akademik (Resmi Sekolah)</h3>
                        <p class="text-xs text-slate-500">Data ini tersinkronisasi otomatis dari database sekolah dan bersifat permanen.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50/70 p-5 rounded-2xl border border-slate-100">
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">NISN</span>
                        <p class="font-mono font-bold text-sm text-slate-800">{{ $alumni->nisn }}</p>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</span>
                        <p class="font-bold text-sm text-slate-800">{{ $alumni->nama }}</p>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Konsentrasi Jurusan</span>
                        <p class="font-semibold text-sm text-slate-800">{{ $alumni->jurusan->nama ?? '-' }} ({{ $alumni->jurusan->kode ?? '' }})</p>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tahun Lulus</span>
                        <p class="font-bold text-sm text-indigo-700">{{ $alumni->tahunLulus->tahun ?? '-' }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-3 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    <span>Jika terdapat ketidaksesuaian data sekolah di atas, harap hubungi administrator Tracer Study SMK.</span>
                </p>
            </div>

            {{-- Card 2: Informasi Pribadi & Kontak --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 sm:p-8">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-6">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                        📝
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Informasi Pribadi & Kontak</h3>
                        <p class="text-xs text-slate-500">Pastikan informasi di bawah ini selalu akurat agar pihak sekolah mudah menghubungi Anda.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $alumni->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $alumni->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="agama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Agama <span class="text-red-500">*</span></label>
                        <select name="agama" id="agama" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama', $alumni->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                        @error('agama') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tempat_lahir" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $alumni->tempat_lahir) }}" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Contoh: Medan">
                        @error('tempat_lahir') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', optional($alumni->tanggal_lahir)->format('Y-m-d')) }}" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        @error('tanggal_lahir') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="08xxxxxxxxxx">
                        @error('no_hp') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="provinsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Provinsi <span class="text-red-500">*</span></label>
                        <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $alumni->provinsi) }}" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Contoh: Sumatera Utara">
                        @error('provinsi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="kabupaten_kota" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kabupaten / Kota <span class="text-red-500">*</span></label>
                        <input type="text" name="kabupaten_kota" id="kabupaten_kota" value="{{ old('kabupaten_kota', $alumni->kabupaten_kota) }}" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Contoh: Batu Bara">
                        @error('kabupaten_kota') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="kecamatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kecamatan (Opsional)</label>
                        <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $alumni->kecamatan) }}" class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Contoh: Air Putih">
                        @error('kecamatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Alamat Lengkap (Jalan / Dusun / RT / RW) <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="2" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Nama Jalan, Blok, Nomor Rumah, RT/RW">{{ old('alamat', $alumni->alamat) }}</textarea>
                        @error('alamat') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Card 3: Media Sosial (Fleksibel & Opsional) --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 sm:p-8">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-lg">
                            🌐
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Media Sosial Alumni</h3>
                            <p class="text-xs text-slate-500">Semua kolom di bawah ini bersifat <strong>opsional (bebas diisi)</strong> sesuai akun yang Anda miliki.</p>
                        </div>
                    </div>
                    <span class="inline-flex px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-semibold">
                        Opsional
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Instagram --}}
                    <div>
                        <label for="instagram" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <span class="text-pink-600 font-bold">📸</span>
                            <span>Instagram</span>
                        </label>
                        <div class="flex rounded-xl shadow-2xs">
                            <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 font-semibold text-sm">@</span>
                            <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $alumni->instagram) }}" placeholder="username" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-xl border border-slate-200 text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        </div>
                    </div>

                    {{-- Twitter / X --}}
                    <div>
                        <label for="twitter" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <span class="text-slate-900 font-bold">𝕏</span>
                            <span>Twitter / X</span>
                        </label>
                        <div class="flex rounded-xl shadow-2xs">
                            <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 font-semibold text-sm">@</span>
                            <input type="text" name="twitter" id="twitter" value="{{ old('twitter', $alumni->twitter) }}" placeholder="username" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-xl border border-slate-200 text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        </div>
                    </div>

                    {{-- LinkedIn --}}
                    <div>
                        <label for="linkedin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <span class="text-blue-600 font-bold">💼</span>
                            <span>LinkedIn</span>
                        </label>
                        <div class="flex rounded-xl shadow-2xs">
                            <input type="text" name="linkedin" id="linkedin" value="{{ old('linkedin', $alumni->linkedin) }}" placeholder="https://linkedin.com/in/username atau username" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        </div>
                    </div>

                    {{-- TikTok --}}
                    <div>
                        <label for="tiktok" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <span class="text-slate-800 font-bold">🎵</span>
                            <span>TikTok</span>
                        </label>
                        <div class="flex rounded-xl shadow-2xs">
                            <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 font-semibold text-sm">@</span>
                            <input type="text" name="tiktok" id="tiktok" value="{{ old('tiktok', $alumni->tiktok) }}" placeholder="username" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-none rounded-r-xl border border-slate-200 text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        </div>
                    </div>

                    {{-- Facebook --}}
                    <div class="md:col-span-2">
                        <label for="facebook" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <span class="text-blue-700 font-bold">👥</span>
                            <span>Facebook</span>
                        </label>
                        <div class="flex rounded-xl shadow-2xs">
                            <input type="text" name="facebook" id="facebook" value="{{ old('facebook', $alumni->facebook) }}" placeholder="https://facebook.com/namakamu atau nama akun Facebook" class="flex-1 min-w-0 block w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Action Bar --}}
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
                <span class="text-xs text-slate-400">
                    Pastikan informasi yang diisi sudah benar sebelum menyimpan.
                </span>
                <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 hover:-translate-y-0.5 active:translate-y-0 transition cursor-pointer flex items-center gap-2">
                    <span>💾</span>
                    <span>Simpan Perubahan Biodata</span>
                </button>
            </div>
        </form>
    </div>

    {{-- TAB 2: STATUS KEGIATAN SAAT INI (KULIAH / BEKERJA / WIRAUSAHA / BELUM BEKERJA) --}}
    <div x-show="activeTab === 'status'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
        
        {{-- Section Header & Add Toggle --}}
        <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Riwayat Status Kegiatan & Karier</h3>
                <p class="text-xs text-slate-500 mt-1">Perbarui aktivitas Anda saat ini setelah lulus (bekerja, kuliah, wirausaha, atau mencari kerja).</p>
            </div>
            <button type="button" @click="showAddStatus = !showAddStatus"
                class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white rounded-xl font-bold text-xs shadow-sm transition flex items-center gap-2 cursor-pointer">
                <span x-text="showAddStatus ? '✕ Tutup Form' : '➕ Tambah Status Kegiatan'"></span>
            </button>
        </div>

        {{-- FORM TAMBAH STATUS KEGIATAN (Inline Collapsible) --}}
        <div x-show="showAddStatus" x-transition class="bg-white rounded-2xl shadow-xs border border-indigo-100 p-6 sm:p-8 mb-6 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
            
            <div class="mb-6 pb-3 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h4 class="text-base font-extrabold text-slate-900">Form Tambah Status Kegiatan Baru</h4>
                    <p class="text-xs text-slate-500">Pilih jenis kegiatan yang sedang atau pernah Anda jalani.</p>
                </div>
            </div>

            <form action="{{ route('alumni.status-kegiatan.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    {{-- Pilihan Jenis Kegiatan --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Pilih Jenis Aktivitas <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            {{-- Bekerja --}}
                            <label class="relative flex flex-col items-center justify-center p-4 cursor-pointer rounded-2xl border-2 transition text-center"
                                :class="statusJenis === 'bekerja' ? 'bg-indigo-50/80 border-indigo-600 shadow-xs' : 'border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="jenis" value="bekerja" x-model="statusJenis" class="sr-only">
                                <span class="text-2xl mb-1.5">💼</span>
                                <span class="font-bold text-xs text-slate-900">Bekerja</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Karyawan / Pegawai</span>
                            </label>

                            {{-- Kuliah --}}
                            <label class="relative flex flex-col items-center justify-center p-4 cursor-pointer rounded-2xl border-2 transition text-center"
                                :class="statusJenis === 'kuliah' ? 'bg-indigo-50/80 border-indigo-600 shadow-xs' : 'border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="jenis" value="kuliah" x-model="statusJenis" class="sr-only">
                                <span class="text-2xl mb-1.5">🎓</span>
                                <span class="font-bold text-xs text-slate-900">Kuliah</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Pendidikan Tinggi</span>
                            </label>

                            {{-- Wirausaha --}}
                            <label class="relative flex flex-col items-center justify-center p-4 cursor-pointer rounded-2xl border-2 transition text-center"
                                :class="statusJenis === 'wirausaha' ? 'bg-indigo-50/80 border-indigo-600 shadow-xs' : 'border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="jenis" value="wirausaha" x-model="statusJenis" class="sr-only">
                                <span class="text-2xl mb-1.5">🏪</span>
                                <span class="font-bold text-xs text-slate-900">Wirausaha</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Membangun Bisnis</span>
                            </label>

                            {{-- Belum Bekerja --}}
                            <label class="relative flex flex-col items-center justify-center p-4 cursor-pointer rounded-2xl border-2 transition text-center"
                                :class="statusJenis === 'belum_bekerja' ? 'bg-indigo-50/80 border-indigo-600 shadow-xs' : 'border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="jenis" value="belum_bekerja" x-model="statusJenis" class="sr-only">
                                <span class="text-2xl mb-1.5">⏳</span>
                                <span class="font-bold text-xs text-slate-900">Mencari Kerja</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Sedang Mencari</span>
                            </label>
                        </div>
                        @error('jenis') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Form Dinamis: Instansi & Posisi --}}
                    <div x-show="statusJenis !== 'belum_bekerja'" x-transition class="space-y-4 bg-slate-50/70 p-5 rounded-2xl border border-slate-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="status_nama_instansi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    <span x-text="statusJenis === 'kuliah' ? 'Nama Perguruan Tinggi / Universitas' : (statusJenis === 'wirausaha' ? 'Nama Usaha / Brand Bisnis' : 'Nama Perusahaan / Tempat Bekerja')"></span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_instansi" id="status_nama_instansi" value="{{ old('nama_instansi') }}" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Contoh: PT Telkom Indonesia">
                                @error('nama_instansi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="status_posisi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    <span x-text="statusJenis === 'kuliah' ? 'Program Studi / Fakultas' : (statusJenis === 'wirausaha' ? 'Bidang Usaha / Jenis Produk' : 'Posisi / Jabatan Pekerjaan')"></span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="posisi" id="status_posisi" value="{{ old('posisi') }}" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Contoh: Staff IT Support">
                                @error('posisi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Rentang Pendapatan (Hanya Bekerja & Wirausaha) --}}
                        <div x-show="statusJenis === 'bekerja' || statusJenis === 'wirausaha'">
                            <label for="status_pendapatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Rentang Pendapatan Bulanan (Opsional)</label>
                            <select name="pendapatan" id="status_pendapatan" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                                <option value="">-- Pilih Rentang Pendapatan --</option>
                                <option value="1000000" {{ old('pendapatan') == '1000000' ? 'selected' : '' }}>< Rp 2.000.000</option>
                                <option value="3000000" {{ old('pendapatan') == '3000000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 4.000.000</option>
                                <option value="5000000" {{ old('pendapatan') == '5000000' ? 'selected' : '' }}>Rp 4.000.000 - Rp 6.000.000</option>
                                <option value="7000000" {{ old('pendapatan') == '7000000' ? 'selected' : '' }}>> Rp 6.000.000</option>
                            </select>
                        </div>
                    </div>

                    {{-- Periode Tanggal --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status_tanggal_mulai" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_mulai" id="status_tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                            @error('tanggal_mulai') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="status_tanggal_selesai" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Berakhir Pada 
                                <span class="text-slate-400 font-normal lowercase">(kosongkan jika masih berlangsung)</span>
                            </label>
                            <input type="date" name="tanggal_selesai" id="status_tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition">
                            @error('tanggal_selesai') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="status_keterangan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" id="status_keterangan" rows="2" class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition" placeholder="Contoh: Bekerja sebagai desainer grafis purnawaktu">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="showAddStatus = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-600/20 transition cursor-pointer flex items-center gap-1.5">
                            <span>💾</span>
                            <span>Simpan Status Kegiatan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- DAFTAR TIMELINE STATUS KEGIATAN --}}
        <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 sm:p-8">
            <h4 class="text-base font-extrabold text-slate-900 mb-6 flex items-center gap-2">
                <span>⏱️</span>
                <span>Riwayat Perjalanan Karier / Aktivitas</span>
            </h4>

            @if($statusKegiatan->isEmpty())
                <div class="text-center py-12 px-4">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl shadow-xs">
                        💼
                    </div>
                    <h5 class="text-base font-extrabold text-slate-900 mb-1">Belum Ada Status Kegiatan Tercatat</h5>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-6">
                        Bagikan status Anda saat ini (apakah sedang kuliah, bekerja di perusahaan, membuka usaha, atau sedang mencari pekerjaan) untuk mendukung tracer study sekolah.
                    </p>
                    <button type="button" @click="showAddStatus = true" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-md shadow-indigo-600/20 transition inline-flex items-center gap-2 cursor-pointer">
                        <span>➕</span>
                        <span>Tambah Status Pertama Sekarang</span>
                    </button>
                </div>
            @else
                <div class="space-y-4">
                    @php
                        $iconMap = [
                            'bekerja' => '💼',
                            'kuliah' => '🎓',
                            'wirausaha' => '🏪',
                            'belum_bekerja' => '⏳'
                        ];
                        $badgeMap = [
                            'bekerja' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'kuliah' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'wirausaha' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'belum_bekerja' => 'bg-slate-100 text-slate-700 border-slate-200'
                        ];
                        $labelMap = [
                            'bekerja' => 'Bekerja',
                            'kuliah' => 'Kuliah',
                            'wirausaha' => 'Wirausaha',
                            'belum_bekerja' => 'Sedang Mencari Kerja'
                        ];
                    @endphp

                    @foreach($statusKegiatan as $status)
                        <div class="p-5 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-slate-100 flex items-center justify-center text-xl shrink-0 mt-0.5">
                                    {{ $iconMap[$status->jenis] ?? '📌' }}
                                </div>
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeMap[$status->jenis] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                            {{ $labelMap[$status->jenis] ?? ucfirst($status->jenis) }}
                                        </span>
                                        <span class="text-xs text-slate-400 font-medium">
                                            {{ $status->tanggal_mulai->format('d M Y') }} — 
                                            @if($status->tanggal_selesai)
                                                {{ $status->tanggal_selesai->format('d M Y') }}
                                            @else
                                                <span class="text-emerald-600 font-bold">Saat Ini</span>
                                            @endif
                                        </span>
                                    </div>

                                    @if($status->jenis != 'belum_bekerja')
                                        <h5 class="text-base font-extrabold text-slate-900">{{ $status->nama_instansi }}</h5>
                                        <p class="text-xs font-semibold text-indigo-600">{{ $status->posisi }}</p>
                                    @else
                                        <h5 class="text-base font-extrabold text-slate-900">Sedang Mencari Peluang / Pekerjaan</h5>
                                    @endif

                                    @if($status->keterangan)
                                        <p class="text-xs text-slate-500 mt-2 p-2.5 bg-white rounded-xl border border-slate-100 inline-block">
                                            {{ $status->keterangan }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center sm:self-center self-end">
                                <form action="{{ route('alumni.status-kegiatan.destroy', $status->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data status kegiatan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3.5 py-2 text-xs font-bold text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl border border-transparent hover:border-red-100 transition cursor-pointer flex items-center gap-1.5" title="Hapus Riwayat">
                                        <span>🗑️</span>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
