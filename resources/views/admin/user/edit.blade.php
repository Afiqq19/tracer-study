@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Edit User</h3>
        <a href="{{ route('admin.user.index') }}" class="text-gray-500 hover:text-gray-700">← Kembali</a>
    </div>
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="mt-1 w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="mt-1 w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="mt-1 w-full rounded-lg border-gray-300">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="alumni" {{ $user->role == 'alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                    <span class="ml-2">Akun Aktif</span>
                </label>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
