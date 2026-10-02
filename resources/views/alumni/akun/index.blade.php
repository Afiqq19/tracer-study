@extends('layouts.alumni')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Akun</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-500">Email Akun</label>
                <p class="font-medium text-gray-900">{{ $user->email }}</p>
                <p class="text-xs text-gray-400 mt-1">Email digunakan untuk login. Jika ingin mengubah email, silakan hubungi Admin Sekolah.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Ubah Password</h3>
        <form action="{{ route('alumni.akun.password') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                    <input type="password" name="current_password" class="mt-1 w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" name="password" class="mt-1 w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="mt-1 w-full rounded-lg border-gray-300">
                </div>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700">Ubah Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
