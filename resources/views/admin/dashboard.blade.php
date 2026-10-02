@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- Cards Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1 --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Alumni</h3>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xl">🎓</div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-extrabold text-gray-900">{{ $ringkasan['total_alumni'] }}</span>
                <span class="text-gray-500 font-medium">orang</span>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Belum Verifikasi</h3>
                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600 text-xl">⏳</div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-extrabold text-gray-900">{{ $ringkasan['menunggu_verifikasi'] }}</span>
                <span class="text-gray-500 font-medium">orang</span>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Sudah Verifikasi</h3>
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl">✅</div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-extrabold text-gray-900">{{ $ringkasan['sudah_diverifikasi'] }}</span>
                <span class="text-gray-500 font-medium">orang</span>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Responden</h3>
                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-xl">📋</div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-extrabold text-indigo-600">{{ $ringkasan['sudah_mengisi'] }}</span>
                <span class="text-gray-500 font-medium">orang</span>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        {{-- Bar Chart --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 text-center">Grafik Alumni per Tahun Lulus</h3>
            <div class="relative h-72">
                <canvas id="chartTahunLulus"></canvas>
            </div>
        </div>

        {{-- Pie Chart --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 flex flex-col items-center">
            <h3 class="text-lg font-bold text-gray-900 mb-6 text-center">Status Pekerjaan</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="chartStatusPekerjaan"></canvas>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="mt-12 pt-6 border-t border-gray-200 text-sm text-gray-500 flex items-center justify-center gap-2">
        <span>© 2026 Tracer Study Alumni SMK Swasta Dwitunggal 2 Tanjung Morawa</span>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.js"></script>
<script>
    // Konfigurasi umum Chart.js untuk tampilan minimalis
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6B7280';
    
    // Bar Chart: Grafik Alumni per Tahun Lulus
    const tahunData = @json($alumniPerTahun);
    new Chart(document.getElementById('chartTahunLulus'), {
        type: 'bar',
        data: {
            labels: Object.keys(tahunData),
            datasets: [{
                label: 'Jumlah Alumni',
                data: Object.values(tahunData),
                backgroundColor: 'rgba(79, 70, 229, 0.8)', // Indigo 600
                hoverBackgroundColor: 'rgba(67, 56, 202, 1)', // Indigo 700
                borderRadius: 6,
                barPercentage: 0.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#F3F4F6', drawBorder: false },
                    border: { display: false },
                },
                x: {
                    grid: { display: false },
                    border: { display: false },
                }
            }
        }
    });

    // Pie Chart: Status Pekerjaan
    const statusData = @json($statusAlumni);
    const statusLabels = {
        'kuliah': 'Kuliah',
        'bekerja': 'Bekerja',
        'wirausaha': 'Wirausaha',
        'belum_bekerja': 'Belum Bekerja'
    };
    
    new Chart(document.getElementById('chartStatusPekerjaan'), {
        type: 'pie',
        data: {
            labels: Object.keys(statusData).map(k => statusLabels[k] || k),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: ['#3B82F6', '#10B981', '#8B5CF6', '#F43F5E'], // Blue, Emerald, Violet, Rose
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let value = context.raw;
                            let percentage = Math.round((value / total) * 100) + '%';
                            return ' ' + context.label + ': ' + percentage + ' (' + value + ')';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
