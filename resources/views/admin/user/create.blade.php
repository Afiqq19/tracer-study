@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Tambah User Baru</h3>
        <a href="{{ route('admin.user.index') }}" class="text-gray-500 hover:text-gray-700">← Kembali</a>
    </div>
    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" class="mt-1 w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="mt-1 w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="mt-1 w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="mt-1 w-full rounded-lg border-gray-300">
                    <option value="admin">Admin</option>
                    <option value="alumni">Alumni</option>
                </select>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">Simpan User</button>
        </div>
    </form>
</div>
@endsection
