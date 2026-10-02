@extends('layouts.admin')

@section('title', 'Import Data Alumni')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900">Import Data Alumni (Excel)</h3>
        <a href="{{ route('admin.alumni.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center gap-1">
            <span>←</span> Kembali
        </a>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-8 text-sm text-blue-800">
        <p class="font-semibold mb-2">Panduan Import:</p>
        <ol class="list-decimal ml-4 space-y-1">
            <li>Pastikan Anda menggunakan template Excel yang disediakan.</li>
            <li>Kolom <strong>NISN</strong> dan <strong>Nama</strong> wajib diisi. (Kolom lain akan dilengkapi mandiri oleh alumni saat registrasi).</li>
            <li>Pastikan NISN belum pernah terdaftar di sistem.</li>
        </ol>
        <div class="mt-4">
            <a href="{{ route('admin.alumni.template') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition gap-2 text-xs shadow-sm">
                <span>⬇️</span> Download Template Excel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.alumni.import.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="text-4xl mb-4">📄</div>
            <h4 class="text-gray-700 font-medium mb-2">Upload File Excel</h4>
            <p class="text-gray-500 text-sm mb-4">Format yang didukung: .xlsx, .xls, .csv (Maksimal 2MB)</p>
            
            <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            @error('file') <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 shadow-sm transition flex items-center gap-2">
                <span>🚀</span> Mulai Import
            </button>
        </div>
    </form>
</div>
@endsection
