@extends('layouts.alumni')

@section('title', 'Riwayat Pengisian Kuesioner')

@section('content')
<script>
    window.location.href = "{{ route('alumni.kuesioner.index', ['tab' => 'riwayat']) }}";
</script>
<div class="p-8 text-center bg-white rounded-2xl border border-slate-100 shadow-xs">
    <p class="text-sm text-slate-500">Mengalihkan ke riwayat kuesioner...</p>
    <a href="{{ route('alumni.kuesioner.index', ['tab' => 'riwayat']) }}" class="text-indigo-600 font-bold text-xs mt-2 inline-block">Klik di sini jika tidak beralih otomatis</a>
</div>
@endsection
