@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Profil</h3>
        <form action="{{ route('admin.profil.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full rounded-lg border-gray-300">
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">Simpan Profil</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Ubah Password</h3>
        <form action="{{ route('admin.profil.password') }}" method="POST">
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
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">Ubah Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
