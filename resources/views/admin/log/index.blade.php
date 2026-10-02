@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-900">Log Aktivitas Sistem</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Waktu</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">User</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                    <th class="py-3 px-6 text-sm font-semibold text-gray-600">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-b border-gray-50">
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $log->user->name ?? 'Sistem' }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700"><span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs">{{ $log->aksi }}</span></td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $log->keterangan }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-6 px-6 text-center text-gray-500">Belum ada log.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="p-4 border-t border-gray-100">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
