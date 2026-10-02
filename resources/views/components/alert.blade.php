{{-- Flash message alerts --}}
@if(session('success'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg" role="alert" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
        </div>
    </div>
</div>
@endif

@if(session('import_gagal_list') && count(session('import_gagal_list')) > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg overflow-hidden" x-data="{ show: true }" x-show="show" x-transition>
        <div class="p-4 flex justify-between items-start">
            <div>
                <div class="flex items-center text-red-800 font-bold mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <span>Terdapat {{ count(session('import_gagal_list')) }} data yang gagal diimpor:</span>
                </div>
                <div class="mt-2 max-h-60 overflow-y-auto pr-2">
                    <table class="min-w-full text-sm text-left text-red-900 bg-white rounded-lg shadow-sm">
                        <thead class="text-xs uppercase bg-red-100 font-semibold border-b border-red-200">
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">NISN</th>
                                <th class="px-4 py-2">Nama</th>
                                <th class="px-4 py-2">Alasan Gagal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-100">
                            @foreach(session('import_gagal_list') as $index => $gagal)
                            <tr class="hover:bg-red-50 transition">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-medium">{{ $gagal['nisn'] }}</td>
                                <td class="px-4 py-2">{{ $gagal['nama'] }}</td>
                                <td class="px-4 py-2 text-red-600">{{ $gagal['alasan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-3 text-xs text-red-700 italic">*Silakan foto atau catat daftar ini, lalu perbaiki datanya dan upload ulang khusus untuk data yang gagal.</p>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-700 ml-4">&times;</button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg" role="alert" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-700">&times;</button>
        </div>
    </div>
</div>
@endif

@if(session('warning'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-r-lg" role="alert" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>{{ session('warning') }}</span>
            </div>
            <button @click="show = false" class="text-yellow-500 hover:text-yellow-700">&times;</button>
        </div>
    </div>
</div>
@endif

@if(session('info'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-r-lg" role="alert" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                <span>{{ session('info') }}</span>
            </div>
            <button @click="show = false" class="text-blue-500 hover:text-blue-700">&times;</button>
        </div>
    </div>
</div>
@endif
