@extends('layouts.guest')

@section('title', 'Daftar Akun Alumni')

@section('content')
<div class="min-h-screen flex items-start justify-center bg-slate-50/60 pt-10 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden" x-data="registerForm()">
    {{-- Ambient Background Glows --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Subtle Grid Pattern --}}
    <svg class="absolute inset-0 h-full w-full opacity-40 pointer-events-none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="register-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                <path d="M0 32V0h32" fill="none" stroke="#6366f1" stroke-opacity="0.06" stroke-width="1"></path>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#register-grid)"></rect>
    </svg>

    <div class="w-full bg-white/95 backdrop-blur-2xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(30,41,59,0.12)] border border-slate-200/80 p-8 sm:p-10 relative z-10 transition-all duration-500"
         :class="step === 1 ? 'max-w-md' : 'max-w-4xl'">
        
        {{-- Top Accent Gradient Bar --}}
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 rounded-t-3xl"></div>

        <div class="mb-8 text-center pt-2">
            <div class="inline-flex p-3 bg-gradient-to-b from-white to-slate-50 rounded-2xl shadow-md border border-slate-100 ring-4 ring-indigo-50/80 mb-4 transition-transform hover:scale-105 duration-300">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMK Swasta Budhi darma Indrapura" class="w-12 h-12 object-contain">
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-2 shadow-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                    Tracer Study Alumni
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Registrasi Alumni</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1" x-text="stepTitle"></p>
            </div>
        </div>

        {{-- Pesan Error Global / Validasi Laravel --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mx-auto max-w-2xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Utama yang akan di-submit ke backend Laravel --}}
        <form id="registerFormElement" method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Step 1: Validasi NISN --}}
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="space-y-5">
                    <div>
                        <label for="check_nisn" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Masukkan NISN</label>
                        <div class="flex gap-3">
                            <input x-model="nisn" type="text" id="check_nisn" pattern="\d{10}" 
                                class="flex-1 px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-xs" 
                                placeholder="Contoh: 0012345678"
                                @keydown.enter.prevent="verifyNisn()">
                            <button type="button" @click="verifyNisn()" :disabled="isLoading || nisn.length !== 10" 
                                class="px-5 py-3 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 hover:shadow-indigo-600/30 hover:-translate-y-0.5 active:translate-y-0 focus:ring-4 focus:ring-indigo-500/20 transition-all disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center min-w-[130px] cursor-pointer">
                                <span x-show="!isLoading">Verifikasi</span>
                                <span x-show="isLoading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Proses...
                                </span>
                            </button>
                        </div>
                        <p x-show="errorMessage" x-text="errorMessage" class="text-xs text-red-500 mt-2 font-medium" x-transition></p>
                    </div>
                    <div class="pt-4 text-center">
                        <p class="text-xs text-slate-500">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 hover:underline">Masuk di sini &rarr;</a>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Hidden Fields untuk dikirim ke backend --}}
            <input type="hidden" name="nisn" :value="nisn">
            <input type="hidden" name="name" :value="nama">

            {{-- Step 2: Lengkapi Data Diri (Layout Lebar 2 Kolom) --}}
            <div id="step2Container" x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
                    <div class="mt-0.5 text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-green-800">NISN Tersedia!</h4>
                        <p class="text-xs text-green-700 mt-0.5">Hai <strong x-text="nama"></strong>, silakan lengkapi biodata Anda di bawah ini.</p>
                    </div>
                </div>

                <div class="space-y-8">
                    {{-- Blok Data Sekolah --}}
                    <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Data Sekolah
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="tahun_lulus_id" class="block text-sm font-medium text-gray-700 mb-1.5">Tahun Lulus *</label>
                                <select name="tahun_lulus_id" id="tahun_lulus_id" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors">
                                    <option value="">Pilih Tahun Lulus</option>
                                    @foreach($tahunLulus as $tahun)
                                        <option value="{{ $tahun->id }}" {{ old('tahun_lulus_id') == $tahun->id ? 'selected' : '' }}>{{ $tahun->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="jurusan_id" class="block text-sm font-medium text-gray-700 mb-1.5">Jurusan *</label>
                                <select name="jurusan_id" id="jurusan_id" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors">
                                    <option value="">Pilih Jurusan</option>
                                    @foreach($jurusan as $jur)
                                        <option value="{{ $jur->id }}" {{ old('jurusan_id') == $jur->id ? 'selected' : '' }}>{{ $jur->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Blok Informasi Pribadi --}}
                    <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Informasi Pribadi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">NISN</label>
                                <input type="text" :value="nisn" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed font-medium">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" :value="nama" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed font-medium">
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin *</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700 mb-1.5">Agama *</label>
                                <select name="agama" id="agama" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors">
                                    <option value="">Pilih Agama</option>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                        <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Lahir *</label>
                                <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors" placeholder="Contoh: Medan">
                            </div>

                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir *</label>
                                <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors">
                            </div>
                        </div>
                    </div>

                    {{-- Blok Alamat --}}
                    <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Alamat Tempat Tinggal
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap (Jalan / Dusun) *</label>
                                <textarea id="alamat" name="alamat" required rows="2" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors" placeholder="Nama Jalan, RT/RW, Kelurahan">{{ old('alamat') }}</textarea>
                            </div>

                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1.5">Provinsi *</label>
                                <select id="provinsi" x-model="selectedProvinsi" @change="handleProvinsiChange($event)" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <option value="">Pilih Provinsi</option>
                                    <template x-for="prov in provinces" :key="prov.id">
                                        <option :value="prov.name" :data-id="prov.id" x-text="prov.name"></option>
                                    </template>
                                </select>
                                <input type="hidden" name="provinsi" :value="selectedProvinsi">
                            </div>

                            <div>
                                <label for="kabupaten_kota" class="block text-sm font-medium text-gray-700 mb-1.5">Kabupaten / Kota *</label>
                                <select id="kabupaten_kota" x-model="selectedRegency" @change="handleRegencyChange($event)" :disabled="!selectedProvinsi || isLoadingRegencies" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <option value="">Pilih Kabupaten / Kota</option>
                                    <template x-for="reg in regencies" :key="reg.id">
                                        <option :value="reg.name" :data-id="reg.id" x-text="reg.name"></option>
                                    </template>
                                </select>
                                <input type="hidden" name="kabupaten_kota" :value="selectedRegency">
                            </div>

                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1.5">Kecamatan *</label>
                                <select id="kecamatan" x-model="selectedDistrict" @change="handleDistrictChange($event)" :disabled="!selectedRegency || isLoadingDistricts" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <option value="">Pilih Kecamatan</option>
                                    <template x-for="dist in districts" :key="dist.id">
                                        <option :value="dist.name" :data-id="dist.id" x-text="dist.name"></option>
                                    </template>
                                </select>
                                <input type="hidden" name="kecamatan" :value="selectedDistrict">
                            </div>

                            <div>
                                <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1.5">Kelurahan / Desa *</label>
                                <select id="kelurahan" x-model="selectedVillage" :disabled="!selectedDistrict || isLoadingVillages" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <option value="">Pilih Kelurahan / Desa</option>
                                    <template x-for="vil in villages" :key="vil.id">
                                        <option :value="vil.name" x-text="vil.name"></option>
                                    </template>
                                </select>
                                <input type="hidden" name="kelurahan" :value="selectedVillage">
                            </div>
                        </div>
                    </div>

                    {{-- Blok Kontak & Akun --}}
                    <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Kontak & Keamanan Akun
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1.5">Nomor WhatsApp / HP *</label>
                                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors" placeholder="Contoh: 081234567890">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email *</label>
                                <input id="email" x-model="email" @input="emailError = ''; generalError = ''" type="email" name="email" value="{{ old('email') }}" required 
                                    class="w-full px-4 py-3 bg-white border rounded-xl focus:ring-2 focus:border-transparent transition-colors" 
                                    :class="emailError ? 'border-red-500 bg-red-50/20 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-600'"
                                    placeholder="nama@email.com">
                                <div x-show="emailError" x-transition class="mt-2 p-3 bg-red-50 border border-red-200 rounded-xl flex items-start gap-2.5 text-xs text-red-700">
                                    <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <div>
                                        <span class="font-semibold block" x-text="emailError"></span>
                                        <span class="mt-1 block text-gray-600">Jika ini akun Anda, Anda dapat <a href="{{ route('login') }}" class="font-bold underline text-indigo-600 hover:text-indigo-800">Masuk / Login di sini &rarr;</a></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi Baru *</label>
                                <input id="password" @input="passwordError = ''; generalError = ''" type="password" name="password" required 
                                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-colors"
                                    placeholder="Minimal 8 karakter">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Sandi *</label>
                                <input id="password_confirmation" @input="passwordError = ''; generalError = ''" type="password" name="password_confirmation" required 
                                    class="w-full px-4 py-3 bg-white border rounded-xl focus:ring-2 focus:border-transparent transition-colors"
                                    :class="passwordError ? 'border-red-500 bg-red-50/20 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-600'"
                                    placeholder="Ulangi kata sandi">
                                <p x-show="passwordError" x-text="passwordError" class="text-xs text-red-600 mt-1.5 font-medium"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Banner Error Global Step 2 --}}
                <div x-show="generalError" x-transition class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div class="text-sm text-red-700 font-medium" x-text="generalError"></div>
                </div>

                <div class="mt-8 flex gap-4 pt-6 border-t border-slate-200/80">
                    <button type="button" @click="step = 1" class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors cursor-pointer">
                        &larr; Kembali
                    </button>
                    <button type="button" @click="submitRegistration()" :disabled="isSubmitting" class="flex-1 px-6 py-3.5 bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/35 hover:-translate-y-0.5 active:translate-y-0 focus:ring-4 focus:ring-indigo-500/20 transition-all flex justify-center items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none cursor-pointer">
                        <span x-show="!isSubmitting" class="flex items-center gap-2">
                            <span>Daftar Akun & Kirim Link Verifikasi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                        <span x-show="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Mendaftarkan Akun...
                        </span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    function registerForm() {
        return {
            step: {{ old('nisn') ? 2 : 1 }},
            nisn: '{{ old('nisn') }}',
            nama: '{{ old('name') }}',
            email: '{{ old('email') }}',
            
            // Data Wilayah
            provinces: [],
            regencies: [],
            districts: [],
            villages: [],
            
            selectedProvinsi: '{{ old('provinsi') }}',
            selectedRegency: '{{ old('kabupaten_kota') }}',
            selectedDistrict: '{{ old('kecamatan') }}',
            selectedVillage: '{{ old('kelurahan') }}',
            
            isLoadingRegencies: false,
            isLoadingDistricts: false,
            isLoadingVillages: false,

            isLoading: false,
            isSubmitting: false,
            errorMessage: '',
            emailError: '{{ $errors->first('email') }}',
            passwordError: '{{ $errors->first('password') }}',
            generalError: '{{ $errors->first('nisn') ?: ($errors->first('name') ?: '') }}',
            
            get stepTitle() {
                if (this.step === 1) return 'Langkah 1: Verifikasi NISN';
                if (this.step === 2) return 'Langkah 2: Lengkapi Biodata Diri & Akun';
                return '';
            },

            toTitleCase(str) {
                return str.toLowerCase().replace(/\b\w/g, s => s.toUpperCase());
            },

            init() {
                this.fetchProvinces().then(() => {
                    // Recovery old data jika ada
                    if (this.selectedProvinsi) {
                        const prov = this.provinces.find(p => p.name === this.selectedProvinsi);
                        if (prov) {
                            this.fetchRegenciesById(prov.id).then(() => {
                                if (this.selectedRegency) {
                                    const reg = this.regencies.find(r => r.name === this.selectedRegency);
                                    if (reg) {
                                        this.fetchDistrictsById(reg.id).then(() => {
                                            if (this.selectedDistrict) {
                                                const dist = this.districts.find(d => d.name === this.selectedDistrict);
                                                if (dist) {
                                                    this.fetchVillagesById(dist.id);
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
            },

            async fetchProvinces() {
                try {
                    const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    let data = await res.json();
                    data = data.map(item => ({ ...item, name: this.toTitleCase(item.name) }));
                    this.provinces = data.sort((a, b) => a.name.localeCompare(b.name));
                } catch (e) {
                    console.error('Gagal mengambil data provinsi', e);
                }
            },

            handleProvinsiChange(e) {
                this.regencies = [];
                this.districts = [];
                this.villages = [];
                this.selectedRegency = '';
                this.selectedDistrict = '';
                this.selectedVillage = '';
                
                const option = e.target.options[e.target.selectedIndex];
                const provId = option.getAttribute('data-id');
                if (provId) {
                    this.fetchRegenciesById(provId);
                }
            },

            async fetchRegenciesById(provId) {
                this.isLoadingRegencies = true;
                try {
                    const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`);
                    let data = await res.json();
                    data = data.map(item => ({ ...item, name: this.toTitleCase(item.name) }));
                    this.regencies = data.sort((a, b) => a.name.localeCompare(b.name));
                } catch (e) {
                    console.error('Gagal mengambil data kabupaten', e);
                } finally {
                    this.isLoadingRegencies = false;
                }
            },

            handleRegencyChange(e) {
                this.districts = [];
                this.villages = [];
                this.selectedDistrict = '';
                this.selectedVillage = '';
                
                const option = e.target.options[e.target.selectedIndex];
                const regId = option.getAttribute('data-id');
                if (regId) {
                    this.fetchDistrictsById(regId);
                }
            },

            async fetchDistrictsById(regId) {
                this.isLoadingDistricts = true;
                try {
                    const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regId}.json`);
                    let data = await res.json();
                    data = data.map(item => ({ ...item, name: this.toTitleCase(item.name) }));
                    this.districts = data.sort((a, b) => a.name.localeCompare(b.name));
                } catch (e) {
                    console.error('Gagal mengambil data kecamatan', e);
                } finally {
                    this.isLoadingDistricts = false;
                }
            },

            handleDistrictChange(e) {
                this.villages = [];
                this.selectedVillage = '';
                
                const option = e.target.options[e.target.selectedIndex];
                const distId = option.getAttribute('data-id');
                if (distId) {
                    this.fetchVillagesById(distId);
                }
            },

            async fetchVillagesById(distId) {
                this.isLoadingVillages = true;
                try {
                    const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${distId}.json`);
                    let data = await res.json();
                    data = data.map(item => ({ ...item, name: this.toTitleCase(item.name) }));
                    this.villages = data.sort((a, b) => a.name.localeCompare(b.name));
                } catch (e) {
                    console.error('Gagal mengambil data kelurahan', e);
                } finally {
                    this.isLoadingVillages = false;
                }
            },

            async verifyNisn() {
                if(this.nisn.length !== 10) return;
                
                this.isLoading = true;
                this.errorMessage = '';

                try {
                    const response = await fetch('/check-nisn', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ nisn: this.nisn })
                    });
                    
                    const data = await response.json().catch(() => null);
                    
                    if (!response.ok) {
                        if (data && data.message) {
                            this.errorMessage = data.message;
                        } else if (response.status === 419) {
                            this.errorMessage = 'Sesi telah kedaluwarsa. Silakan refresh halaman dan coba lagi.';
                        } else {
                            this.errorMessage = 'Gagal memproses permintaan (Status: ' + response.status + ').';
                        }
                        return;
                    }
                    
                    if (data && data.success) {
                        this.nama = data.nama;
                        this.step = 2;
                    } else {
                        this.errorMessage = (data && data.message) ? data.message : 'NISN tidak terdaftar.';
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    this.errorMessage = 'Terjadi kesalahan jaringan. Silakan refresh halaman dan coba lagi.';
                } finally {
                    this.isLoading = false;
                }
            },

            submitRegistration() {
                this.emailError = '';
                this.passwordError = '';
                this.generalError = '';

                // Validasi semua elemen wajib di Langkah 2
                const step2 = document.getElementById('step2Container');
                if (step2) {
                    const requiredElements = step2.querySelectorAll('[required]');
                    for (const el of requiredElements) {
                        // Jika elemen select/input/textarea kosong
                        if (!el.value || el.value.trim() === '') {
                            const label = step2.querySelector(`label[for="${el.id}"]`);
                            const fieldName = label ? label.innerText.replace('*', '').trim() : (el.name || 'Data');
                            
                            this.generalError = `Silakan lengkapi kolom "${fieldName}" terlebih dahulu! Semua kolom bertanda bintang (*) wajib diisi.`;
                            el.focus();
                            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            return;
                        }
                    }
                }

                // Validasi format email
                const emailInput = document.getElementById('email');
                if (emailInput && !emailInput.checkValidity()) {
                    this.emailError = 'Format alamat email tidak valid.';
                    this.generalError = 'Format alamat email tidak valid. Contoh: nama@gmail.com';
                    emailInput.focus();
                    return;
                }

                // Validasi kata sandi minimal 8 karakter dan konfirmasi cocok
                const password = document.getElementById('password')?.value || '';
                const passwordConfirmation = document.getElementById('password_confirmation')?.value || '';

                if (password.length < 8) {
                    this.passwordError = 'Kata sandi minimal harus 8 karakter.';
                    this.generalError = 'Kata sandi baru minimal harus 8 karakter.';
                    document.getElementById('password')?.focus();
                    return;
                }

                if (password !== passwordConfirmation) {
                    this.passwordError = 'Konfirmasi sandi tidak sesuai dengan kata sandi baru.';
                    this.generalError = 'Konfirmasi kata sandi tidak cocok dengan kata sandi baru.';
                    document.getElementById('password_confirmation')?.focus();
                    return;
                }

                this.isSubmitting = true;
                document.getElementById('registerFormElement').submit();
            }
        }
    }
</script>
@endsection
