@extends('layouts.admin')

@section('title', 'Grafik Statistik')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Keterserapan Alumni</h3>
        <p class="text-gray-600">Grafik dan persentase keterserapan alumni akan ditampilkan di sini.</p>
        {{-- Nanti bisa ditambahkan chart JS yang lebih detail --}}
    </div>
</div>
@endsection
