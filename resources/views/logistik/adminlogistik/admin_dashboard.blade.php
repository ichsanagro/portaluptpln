@extends('layouts.app')

@section('title', 'Dashboard Admin Logistik')

@push('header-items')
    @include('components.hse-stats-small')
@endpush

@section('content')
<div class="space-y-6">
    {{-- Welcome Header --}}
    <x-card class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-blue-800">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="mt-1 text-gray-700">Berikut adalah ringkasan aktivitas logistik terkini di sistem Anda.</p>
            </div>
        </div>
    </x-card>
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat-card title="Total Material" value="{{ $totalMaterial }}" icon_bg_color="bg-blue-100" icon_text_color="text-blue-800">
            <x-slot name="icon">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </x-slot>
        </x-stat-card>
        <x-stat-card title="Permintaan Pending" value="{{ $permintaanPending }}" icon_bg_color="bg-yellow-100" icon_text_color="text-yellow-800">
            <x-slot name="icon">
                 <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot>
        </x-stat-card>
        <x-stat-card title="Permintaan Disetujui" value="{{ $permintaanDisetujui }}" icon_bg_color="bg-green-100" icon_text_color="text-green-600">
            <x-slot name="icon">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot>
        </x-stat-card>
        <x-stat-card title="Stok Hampir Habis" value="{{ $stokHampirHabis }}" icon_bg_color="bg-red-100" icon_text_color="text-red-600">
            <x-slot name="icon">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-3.75-3.75M14.25 12l-3.75-3.75" />
                </svg>
            </x-slot>
        </x-stat-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-card class="lg:col-span-2">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-800">Material Paling Sering Diminta/Dipinjam</h3>
                <div class="relative h-96 mt-4">
                    <canvas id="materialUsageChart"></canvas>
                </div>
            </div>
        </x-card>

        {{-- Recent Activities --}}
        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-800">Aktivitas Terkini</h3>
                <ul class="mt-4 space-y-4">
                    @forelse ($recentActivities as $activity)
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full {{ $activity->status === 'approved' ? 'bg-green-100' : ($activity->status === 'pending' ? 'bg-yellow-100' : 'bg-red-100') }}">
                                    @if ($activity->status === 'approved')
                                        <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                                    @elseif ($activity->status === 'pending')
                                        <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v4.25h-3.5a.75.75 0 000 1.5h4.25a.75.75 0 00.75-.75V5z" clip-rule="evenodd" /></svg>
                                    @else {{-- rejected --}}
                                        <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg>
                                    @endif
                                </span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-800">
                                    <span class="font-medium">{{ $activity->user->name }}</span>
                                    membuat permintaan peminjaman
                                    <span class="font-medium">{{ $activity->details->sum('jumlah') }} item</span>.
                                </p>
                                <p class="text-xs text-slate-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-center text-slate-500">Tidak ada aktivitas terkini.</li>
                    @endforelse
                </ul>
            </div>
        </x-card>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('materialUsageChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Jumlah',
                        data: @json($chartData),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(199, 199, 199, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(199, 199, 199, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    });
</script>
@endpush