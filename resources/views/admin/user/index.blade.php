@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900">Daftar Pengguna Sistem</h3>
        <a href="{{ route('admin.user.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
            + Tambah User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Nama Lengkap</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Email</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Role</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-gray-50 hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $user->email }}</td>
                    <td class="py-3 px-6 text-sm">
                        @if($user->role == 'admin')
                            <span class="inline-flex px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">Admin</span>
                        @else
                            <span class="inline-flex px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Alumni</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-sm">
                        @if($user->role === 'alumni' && !$user->hasVerifiedEmail())
                            <span class="inline-flex px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-semibold">
                                ⏳ Belum Verifikasi Email
                            </span>
                        @elseif($user->is_active)
                            <span class="inline-flex px-2.5 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-semibold">
                                ✓ Aktif
                            </span>
                        @else
                            <span class="inline-flex px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-semibold">
                                ✕ Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="text-blue-600 hover:bg-blue-100 p-2 rounded-lg">✏️</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:bg-red-100 p-2 rounded-lg">🗑️</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-4 border-t border-gray-100">{{ $users->links() }}</div>
    @endif
</div>
@endsection
