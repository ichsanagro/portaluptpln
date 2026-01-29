@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Super Admin</h1>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Statistics & Chart -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Statistics Cards -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Statistik Sistem</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Total Users -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase">Total Pengguna</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                            </div>
                            <div class="text-blue-500 opacity-70">
                                <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.282-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.282.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Materials -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Material</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalMaterial }}</p>
                    </div>

                    <!-- Low Stock -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                        <p class="text-sm font-medium text-gray-500 uppercase">Stok Hampir Habis</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stokHampirHabis }}</p>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-500">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Pemesanan</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalPemesanan }}</p>
                    </div>

                    <!-- Total Accidents -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Kecelakaan</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalAccidentLogs }}</p>
                    </div>

                    <!-- Accident Count (from HSE Stat) -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-700">
                        <p class="text-sm font-medium text-gray-500 uppercase">Hitungan Kecelakaan</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $accidentCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Aktivitas Pemesanan Material (30 Hari Terakhir)</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="pemesananChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Right Column: Recent Activity -->
        <div class="lg:col-span-1">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Log Audit Sistem</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <ul class="divide-y divide-gray-200">
                    @forelse($recentActivities as $activity)
                        <li class="py-4 flex">
                            <div class="mr-4">
                                <span class="bg-gray-100 p-2 rounded-full flex items-center justify-center h-10 w-10">
                                    @switch($activity['icon'])
                                        @case('shopping-cart')
                                            <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                            @break
                                        @case('exclamation-triangle')
                                            <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                            @break
                                        @case('first-aid')
                                            <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 10h.01M15 10h.01M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                            @break
                                        @case('user-plus')
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                            @break
                                    @endswitch
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-800">{{ $activity['description'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($activity['timestamp'])->diffForHumans() }} oleh {{ $activity['user_name'] }}
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-gray-500">
                            Tidak ada aktivitas terbaru.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('pemesananChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($pemesananChart['labels']),
                    datasets: [{
                        label: 'Jumlah Pemesanan',
                        data: @json($pemesananChart['data']),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
